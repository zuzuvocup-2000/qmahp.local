<?php

/**
 * URL Language Helper
 * 
 * Provides helper functions for handling multilingual URLs
 * 
 * @package App\Helpers
 */

use App\Config\LanguageConstants;

if (!function_exists('get_language_from_url')) {
    /**
     * Get language code from current URL
     * 
     * @return string Language code (en, vi) or default 'vi'
     */
    function get_language_from_url(): string
    {
        $uri = service('uri');
        $segments = $uri->getSegments();
        
        // Check if first segment is a prefixed language
        if (!empty($segments) && in_array($segments[0], LanguageConstants::getPrefixed())) {
            return $segments[0];
        }
        
        // Default to default language (no prefix needed)
        return LanguageConstants::getDefault();
    }
}

if (!function_exists('is_english_url')) {
    /**
     * Check if current URL is English
     * 
     * @return bool True if current URL is English
     */
    function is_english_url(): bool
    {
        return get_language_from_url() === 'en';
    }
}

if (!function_exists('get_url_without_language')) {
    /**
     * Get current URL without language prefix
     * 
     * @return string URL without language prefix
     */
    function get_url_without_language(): string
    {
        $uri = service('uri');
        $segments = $uri->getSegments();
        
        // Remove prefixed language segment if it exists
        if (!empty($segments) && in_array($segments[0], LanguageConstants::getPrefixed())) {
            array_shift($segments);
        }
        
        return base_url(implode('/', $segments));
    }
}

if (!function_exists('create_language_url')) {
    /**
     * Create URL with language prefix
     * 
     * @param string $path URL path
     * @param string $language Language code (en, vi)
     * @return string URL with language prefix
     */
    function create_language_url(string $path = '', string $language = null): string
    {
        // Use default language if not specified
        if ($language === null) {
            $language = LanguageConstants::getDefault();
        }
        
        // Validate language
        if (!LanguageConstants::isSupported($language)) {
            $language = LanguageConstants::getDefault();
        }
        
        // Remove leading slash if exists
        $path = ltrim($path, '/');
        
        // For default languages, don't add prefix
        if (LanguageConstants::isDefault($language)) {
            if (empty($path)) {
                return base_url();
            }
            return base_url($path);
        }
        
        // For prefixed languages, add prefix
        if (empty($path)) {
            return base_url($language);
        }
        
        return base_url($language . '/' . $path);
    }
}

if (!function_exists('switch_language_url')) {
    /**
     * Switch language in current URL
     * 
     * @param string $target_language Target language code (en, vi)
     * @return string URL with switched language
     */
    function switch_language_url(string $target_language = null): string
    {
        // Use English as default target if not specified
        if ($target_language === null) {
            $target_language = 'en';
        }
        
        // Validate target language
        if (!LanguageConstants::isSupported($target_language)) {
            $target_language = LanguageConstants::getDefault();
        }
        
        $uri = service('uri');
        $segments = $uri->getSegments();
        
        // Remove current prefixed language if exists
        if (!empty($segments) && in_array($segments[0], LanguageConstants::getPrefixed())) {
            array_shift($segments);
        }
        
        // Create new URL with target language
        return create_language_url(implode('/', $segments), $target_language);
    }
}

if (!function_exists('get_current_language')) {
    /**
     * Get current language from URL or session
     * 
     * @return string Current language code
     */
    function get_current_language(): string
    {
        // First try to get from URL
        $url_language = get_language_from_url();
        
        // If URL has a prefixed language, use it and update session
        if (LanguageConstants::needsPrefix($url_language)) {
            session()->set('language', $url_language);
            return $url_language;
        }
        
        // Default to default language and update session
        $default_language = LanguageConstants::getDefault();
        session()->set('language', $default_language);
        return $default_language;
    }
}

if (!function_exists('set_language_session')) {
    /**
     * Set language in session
     * 
     * @param string $language Language code
     * @return void
     */
    function set_language_session(string $language): void
    {
        if (LanguageConstants::isSupported($language)) {
            session()->set('language', $language);
        }
    }
}

if (!function_exists('get_language_switcher_urls')) {
    /**
     * Get language switcher URLs for current page
     * 
     * @return array Array with 'vi' and 'en' URLs
     */
    function get_language_switcher_urls(): array
    {
        $current_url = get_url_without_language();
        $current_path = str_replace(base_url(), '', $current_url);
        
        $urls = [];
        foreach (LanguageConstants::getSupported() as $language) {
            $urls[$language] = create_language_url($current_path, $language);
        }
        
        return $urls;
    }
}

if (!function_exists('is_language_route')) {
    /**
     * Check if current route is a language route
     * 
     * @return bool True if current route has language prefix
     */
    function is_language_route(): bool
    {
        $uri = service('uri');
        $segments = $uri->getSegments();
        
        return !empty($segments) && in_array($segments[0], LanguageConstants::getPrefixed());
    }
}
