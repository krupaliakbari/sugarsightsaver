<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwoFactorService
{
    protected $apiKey;
    protected $apiEndpoint;

    public function __construct()
    {
        // Get 2Factor.in configuration from settings or environment
        $this->apiKey = Setting::get('twofactor_api_key', env('TWOFACTOR_API_KEY', ''));
        $this->apiEndpoint = 'https://2factor.in/API/V1';
    }

    /**
     * Send SMS via 2Factor.in
     */
    public function sendSMS(string $to, string $message, string $templateId = null): array
    {
        if (empty($this->apiKey)) {
            Log::error('2Factor.in API key is missing');
            return [
                'success' => false,
                'message' => 'SMS service is not configured. Please contact administrator.'
            ];
        }

        try {
            $originalPhone = $to;
            Log::info('2FactorService::sendSMS called', [
                'original_phone' => $originalPhone,
                'api_key_present' => !empty($this->apiKey),
                'api_key_length' => strlen($this->apiKey ?? '')
            ]);
            
            // Format phone number (2Factor.in expects 10-digit Indian numbers)
            $to = $this->formatPhoneNumber($to);
            
            Log::info('Phone number formatted', [
                'original' => $originalPhone,
                'formatted' => $to
            ]);

            if (empty($to)) {
                Log::error('Invalid phone number format after formatting', [
                    'original_phone' => $originalPhone
                ]);
                return [
                    'success' => false,
                    'message' => 'Invalid phone number format'
                ];
            }

            // 2Factor.in API endpoint for sending SMS
            // Try ADDON_SERVICES/SEND/TSMS endpoint first
            // If account requires templates, try alternative endpoint
            $url = $this->apiEndpoint . '/' . $this->apiKey . '/ADDON_SERVICES/SEND/TSMS';

            $payload = [
                'From' => $this->getSenderId(),
                'To' => $to,
                'Msg' => $message
            ];

            // Add template-related fields if templateId is provided
            if ($templateId) {
                $payload['TemplateId'] = $templateId;
                $payload['TemplateName'] = $templateId;
            } else {
                // Check if a default template name is configured in settings
                // Some 2Factor.in accounts require TemplateName even for custom messages (DLT regulations)
                $defaultTemplateName = Setting::get('twofactor_template_name', env('TWOFACTOR_TEMPLATE_NAME', ''));
                if (!empty($defaultTemplateName)) {
                    $payload['TemplateName'] = $defaultTemplateName;
                    Log::info('Using default template name from settings', ['template_name' => $defaultTemplateName]);
                }
            }

            // Disable SSL verification for local development (Laragon/WAMP/XAMPP issue)
            // In production, SSL verification should be enabled
            $httpClient = Http::timeout(30);
            
            // Only disable SSL verification in local environment
            if (app()->environment('local')) {
                $httpClient->withoutVerifying();
            }
            
            $response = $httpClient->post($url, $payload);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['Status']) && $responseData['Status'] === 'Success') {
                Log::info('SMS sent successfully via 2Factor.in', [
                    'to' => $to,
                    'details' => $responseData['Details'] ?? null
                ]);

                return [
                    'success' => true,
                    'message' => 'SMS sent successfully',
                    'data' => $responseData
                ];
            } else {
                Log::error('Failed to send SMS via 2Factor.in', [
                    'to' => $to,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);

                return [
                    'success' => false,
                    'message' => $responseData['Details'] ?? 'Failed to send SMS',
                    'error' => $responseData
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending SMS via 2Factor.in', [
                'to' => $to,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Error sending SMS: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number for 2Factor.in (10-digit Indian number)
     */
    protected function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-numeric characters (this also removes suffixes like A, B, C)
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // If it has country code (91), remove it
        if (strlen($cleaned) === 12 && substr($cleaned, 0, 2) === '91') {
            $cleaned = substr($cleaned, 2);
        }
        
        // Return only if it's exactly 10 digits
        if (strlen($cleaned) === 10) {
            return $cleaned;
        }
        
        return '';
    }

    /**
     * Get sender ID from settings
     */
    protected function getSenderId(): string
    {
        return Setting::get('sms_sender_id', env('SMS_SENDER_ID', 'SUGAR'));
    }

    /**
     * Check if 2Factor.in is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }
}

