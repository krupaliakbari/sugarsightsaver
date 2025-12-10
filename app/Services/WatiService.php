<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WatiService
{
    protected $apiEndpoint;
    protected $apiToken;
    protected $whatsappNumber;

    public function __construct()
    {
        // Get Wati configuration from settings or environment
        $this->apiEndpoint = Setting::get('wati_api_endpoint', env('WATI_API_ENDPOINT', ''));
        $this->apiToken = Setting::get('wati_api_token', env('WATI_API_TOKEN', ''));
        $this->whatsappNumber = Setting::get('wati_whatsapp_number', env('WATI_WHATSAPP_NUMBER', ''));
    }

    /**
     * Send WhatsApp message with text only
     */
    public function sendMessage(string $to, string $message): array
    {
        if (empty($this->apiEndpoint) || empty($this->apiToken)) {
            Log::error('Wati API configuration is missing');
            return [
                'success' => false,
                'message' => 'WhatsApp service is not configured. Please contact administrator.'
            ];
        }

        try {
            // Format phone number (ensure it's in international format without +)
            $to = $this->formatPhoneNumber($to);

            // Wati API endpoint for sending messages
            $url = rtrim($this->apiEndpoint, '/') . '/api/v1/sendSessionMessage/' . $to;

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])->post($url, [
                'textMessage' => $message
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully via Wati', [
                    'to' => $to,
                    'response' => $response->json()
                ]);

                return [
                    'success' => true,
                    'message' => 'Message sent successfully',
                    'data' => $response->json()
                ];
            } else {
                Log::error('Failed to send WhatsApp message via Wati', [
                    'to' => $to,
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to send message: ' . ($response->json()['message'] ?? $response->body()),
                    'error' => $response->json()
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending WhatsApp message via Wati', [
                'to' => $to,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Error sending message: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send WhatsApp message with PDF attachment
     */
    public function sendMessageWithPdf(string $to, string $message, string $pdfPath, string $fileName = null): array
    {
        if (empty($this->apiEndpoint) || empty($this->apiToken)) {
            Log::error('Wati API configuration is missing');
            return [
                'success' => false,
                'message' => 'WhatsApp service is not configured. Please contact administrator.'
            ];
        }

        if (!file_exists($pdfPath)) {
            Log::error('PDF file not found', ['path' => $pdfPath]);
            return [
                'success' => false,
                'message' => 'PDF file not found'
            ];
        }

        try {
            // Format phone number (ensure it's in international format without +)
            $to = $this->formatPhoneNumber($to);

            // Read the PDF file
            $fileContent = file_get_contents($pdfPath);
            $base64Pdf = base64_encode($fileContent);

            // Use the provided filename or generate one
            $fileName = $fileName ?: 'Medical_Report_' . date('Y-m-d') . '.pdf';

            // Wati API endpoint for sending files with caption
            // Format: {api_endpoint}/api/v1/sendSessionFile/{whatsapp_number}
            $url = rtrim($this->apiEndpoint, '/') . '/api/v1/sendSessionFile/' . $to;

            // Wati API expects: fileName, caption (optional), and media (base64 encoded with data URI)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])->post($url, [
                'fileName' => $fileName,
                'caption' => $message, // Use message as caption for the PDF
                'media' => 'data:application/pdf;base64,' . $base64Pdf
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp PDF sent successfully via Wati', [
                    'to' => $to,
                    'filename' => $fileName,
                    'response' => $response->json()
                ]);

                return [
                    'success' => true,
                    'message' => 'Message and PDF sent successfully',
                    'data' => $response->json()
                ];
            } else {
                Log::error('Failed to send WhatsApp PDF via Wati', [
                    'to' => $to,
                    'status' => $response->status(),
                    'response' => $response->json() ?? $response->body()
                ]);

                // Try alternative: send message first, then file separately
                $messageResult = $this->sendMessage($to, $message);
                
                if (!$messageResult['success']) {
                    return [
                        'success' => false,
                        'message' => 'Failed to send message: ' . $messageResult['message']
                    ];
                }

                // Retry sending file without caption
                $response2 = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiToken,
                    'Content-Type' => 'application/json',
                ])->post($url, [
                    'fileName' => $fileName,
                    'media' => 'data:application/pdf;base64,' . $base64Pdf
                ]);

                if ($response2->successful()) {
                    return [
                        'success' => true,
                        'message' => 'Message and PDF sent successfully',
                        'data' => $response2->json()
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Message sent but PDF failed: ' . ($response2->json()['message'] ?? $response2->body()),
                    'error' => $response2->json(),
                    'message_sent' => true
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending WhatsApp PDF via Wati', [
                'to' => $to,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Error sending PDF: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number for Wati (international format without +)
     */
    protected function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-digit characters
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // If it's 10 digits (India), add country code 91
        if (strlen($cleaned) === 10) {
            $cleaned = '91' . $cleaned;
        }
        
        return $cleaned;
    }

    /**
     * Check if Wati is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiEndpoint) && !empty($this->apiToken);
    }
}

