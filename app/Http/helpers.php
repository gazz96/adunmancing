<?php

if (!function_exists('setting')) {
    /**
     * Get setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return \App\Models\Setting::getValue($key, $default);
    }
}

if (!function_exists('social_media_links')) {
    /**
     * Get all social media links
     * 
     * @return array
     */
    function social_media_links()
    {
        return [
            'facebook' => setting('social_facebook_url'),
            'instagram' => setting('social_instagram_url'),
            'twitter' => setting('social_twitter_url'),
            'youtube' => setting('social_youtube_url'),
            'tiktok' => setting('social_tiktok_url'),
            'linkedin' => setting('social_linkedin_url'),
            'whatsapp' => setting('social_whatsapp_number'),
            'telegram' => setting('social_telegram_url'),
        ];
    }
}

if (!function_exists('footer_quick_links')) {
    /**
     * Get footer quick links
     * 
     * @return array
     */
    function footer_quick_links()
    {
        return setting('footer_quick_links', []);
    }
}

if (!function_exists('footer_customer_service')) {
    /**
     * Get footer customer service links
     * 
     * @return array
     */
    function footer_customer_service()
    {
        return setting('footer_customer_service', []);
    }
}

if (!function_exists('footer_categories')) {
    /**
     * Get footer categories links
     * 
     * @return array
     */
    function footer_categories()
    {
        return setting('footer_categories', []);
    }
}

if (!function_exists('whatsapp_link')) {
    /**
     * Generate WhatsApp chat link
     * 
     * @param string $message
     * @return string
     */
    function whatsapp_link($message = '')
    {
        $number = setting('social_whatsapp_number');
        if (!$number) {
            return '#';
        }
        
        // Remove spaces and format number
        $number = str_replace([' ', '-', '(', ')'], '', $number);
        
        // Ensure number starts with country code
        if (!str_starts_with($number, '+')) {
            $number = '+' . $number;
        }
        
        $message = urlencode($message);
        return "https://wa.me/{$number}?text={$message}";
    }
}