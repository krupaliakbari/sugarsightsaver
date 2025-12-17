<?php

use Illuminate\Support\Facades\Auth;

function getYoutubeVideoId($url) {
    $videoId = '';

    // Patterns for different YouTube URL formats
    $patterns = [
        '/youtube\.com\/watch\?v=([^\&\?\/]+)/',
        '/youtube\.com\/embed\/([^\&\?\/]+)/',
        '/youtube\.com\/v\/([^\&\?\/]+)/',
        '/youtu\.be\/([^\&\?\/]+)/'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            $videoId = $matches[1];
            break;
        }
    }

    return $videoId;
}




if (! function_exists('layoutConfig')) {
    function layoutConfig() {

        if (Request::is('siteadmin/*') || Request::is('doctor/*') || Request::is('settings')) {

            $__getConfiguration = Config::get('app-config.layout.vlm');
            
        } else if (Request::is('modern-dark-menu/*')) {
            
            $__getConfiguration = Config::get('app-config.layout.vdm');
            
        } else if (Request::is('collapsible-menu/*')) {
            
            $__getConfiguration = Config::get('app-config.layout.cm');
            
        } else if (Request::is('horizontal-light-menu/*')) {
            
            $__getConfiguration = Config::get('app-config.layout.hlm');
            
        } else if (Request::is('horizontal-dark-menu/*')) {
            
            $__getConfiguration = Config::get('app-config.layout.hlm');
            
        } 
        
        // RTL

        else if (Request::is('rtl/siteadmin/*')) {

            $__getConfiguration = Config::get('app-config.layout.vlm-rtl');
            
        } else if (Request::is('rtl/modern-dark-menu/*')) {
            
            $__getConfiguration = Config::get('app-config.layout.vdm-rtl');
            
        } else if (Request::is('rtl/collapsible-menu/*')) {
            
            $__getConfiguration = Config::get('app-config.layout.cm-rtl');
            
        } else if (Request::is('rtl/horizontal-light-menu/*')) {
            
            $__getConfiguration = Config::get('app-config.layout.hlm-rtl');
            
        } else if (Request::is('rtl/horizontal-dark-menu/*')) {
            
            $__getConfiguration = Config::get('app-config.layout.hdm-rtl');
            
        } 



        // Login

        else if (Request::is('login')) {

            $__getConfiguration = Config::get('app-config.layout.vlm');
            
        } else {
            $__getConfiguration = Config::get('barebone-config.layout.bb');
        }

        return $__getConfiguration;
    }
}


if (!function_exists('getRouterValue')) {
    function getRouterValue() {
        
        if (Request::is('siteadmin/*')) {
            
            $__getRoutingValue = '/siteadmin';
            
        } else if (Request::is('modern-dark-menu/*')) {
            
            $__getRoutingValue = '/modern-dark-menu';

        } else if (Request::is('collapsible-menu/*')) {
            
            $__getRoutingValue = '/collapsible-menu';

        } else if (Request::is('horizontal-light-menu/*')) {
            
            $__getRoutingValue = '/horizontal-light-menu';
            
        } else if (Request::is('horizontal-dark-menu/*')) {
            
            $__getRoutingValue = '/horizontal-dark-menu';
            
        } 

        // RTL

        else if (Request::is('rtl/siteadmin/*')) {

            $__getRoutingValue = '/rtl/siteadmin';
            
        } else if (Request::is('rtl/modern-dark-menu/*')) {
            
            $__getRoutingValue = '/rtl/modern-dark-menu';
            
        } else if (Request::is('rtl/collapsible-menu/*')) {
            
            $__getRoutingValue = '/rtl/collapsible-menu';
            
        } else if (Request::is('rtl/horizontal-light-menu/*')) {
            
            $__getRoutingValue = '/rtl/horizontal-light-menu';
            
        } else if (Request::is('rtl/horizontal-dark-menu/*')) {
            
            $__getRoutingValue = '/rtl/horizontal-dark-menu';
            
        } 

        // Login

        else if (Request::is('login')) {

            $__getRoutingValue = '/siteadmin';
            
        } else {
            $__getRoutingValue = '';
        }
        
        
        return $__getRoutingValue;
    }
}



if (!function_exists('sendWhatsapp')) {
    function sendWhatsapp($toNumbers, $templateName, $components = [])
    {

        $url = "https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/";
        $authKey =config('cred.whatsapp.MSG91_AUTH_KEY'); // store in .env
        $integratedNumber = config('cred.whatsapp.MSG91_INTEGRATED_NUMBER');
      
        $payload = [
            "integrated_number" => $integratedNumber,
            "content_type" => "template",
            "payload" => [
                "messaging_product" => "whatsapp",
                "type" => "template",
                "template" => [
                    "name" => $templateName,
                    "language" => [
                        "code" => "en",
                        "policy" => "deterministic",
                    ],
                    "namespace" => "736b46bf_9c41_4f19_b128_85a4a5d4bfac",
                    "to_and_components" => [
                        [
                            "to" => (array) $toNumbers, // ensure it's an array
                            "components" => $components
                        ]
                    ],
                ],
            ],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "authkey: {$authKey}",
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['status' => false, 'error' => $error];
        }

        curl_close($ch);
        return json_decode($response, true);
    }










}