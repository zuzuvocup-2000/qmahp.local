<?php

namespace App\Config;

/**
 * Language Constants
 * 
 * Centralized constants for language management
 * 
 * @package App\Config
 */
class LanguageConstants
{
    /**
     * Supported languages
     */
    const SUPPORTED_LANGUAGES = ['vi', 'en'];
    
    /**
     * Default language
     */
    const DEFAULT_LANGUAGE = 'vi';
    
    /**
     * Language names
     */
    const LANGUAGE_NAMES = [
        'vi' => 'Tiếng Việt',
        'en' => 'English'
    ];
    
    /**
     * Language flags (emoji)
     */
    const LANGUAGE_FLAGS = [
        'vi' => '🇻🇳',
        'en' => '🇺🇸'
    ];
    
    /**
     * Language codes that require URL prefix
     * Only English needs /en/ prefix, Vietnamese is default
     */
    const PREFIXED_LANGUAGES = ['en'];
    
    /**
     * Language codes that don't need URL prefix
     * Vietnamese is default, no prefix needed
     */
    const DEFAULT_LANGUAGES = ['vi'];
    
    /**
     * Check if language is supported
     * 
     * @param string $language Language code
     * @return bool True if supported
     */
    public static function isSupported(string $language): bool
    {
        return in_array($language, self::SUPPORTED_LANGUAGES);
    }
    
    /**
     * Check if language needs URL prefix
     * 
     * @param string $language Language code
     * @return bool True if needs prefix
     */
    public static function needsPrefix(string $language): bool
    {
        return in_array($language, self::PREFIXED_LANGUAGES);
    }
    
    /**
     * Check if language is default (no prefix needed)
     * 
     * @param string $language Language code
     * @return bool True if is default
     */
    public static function isDefault(string $language): bool
    {
        return in_array($language, self::DEFAULT_LANGUAGES);
    }
    
    /**
     * Get language name
     * 
     * @param string $language Language code
     * @return string Language name
     */
    public static function getName(string $language): string
    {
        return self::LANGUAGE_NAMES[$language] ?? self::LANGUAGE_NAMES[self::DEFAULT_LANGUAGE];
    }
    
    /**
     * Get language flag
     * 
     * @param string $language Language code
     * @return string Language flag emoji
     */
    public static function getFlag(string $language): string
    {
        return self::LANGUAGE_FLAGS[$language] ?? self::LANGUAGE_FLAGS[self::DEFAULT_LANGUAGE];
    }
    
    /**
     * Get all language data
     * 
     * @return array Array of language data
     */
    public static function getAllLanguages(): array
    {
        $languages = [];
        foreach (self::SUPPORTED_LANGUAGES as $code) {
            $languages[$code] = [
                'code' => $code,
                'name' => self::getName($code),
                'flag' => self::getFlag($code),
                'needs_prefix' => self::needsPrefix($code),
                'is_default' => self::isDefault($code)
            ];
        }
        return $languages;
    }
    
    /**
     * Get default language code
     * 
     * @return string Default language code
     */
    public static function getDefault(): string
    {
        return self::DEFAULT_LANGUAGE;
    }
    
    /**
     * Get supported language codes
     * 
     * @return array Array of supported language codes
     */
    public static function getSupported(): array
    {
        return self::SUPPORTED_LANGUAGES;
    }
    
    /**
     * Get languages that need URL prefix
     * 
     * @return array Array of language codes that need prefix
     */
    public static function getPrefixed(): array
    {
        return self::PREFIXED_LANGUAGES;
    }
    
    /**
     * Get languages that don't need URL prefix
     * 
     * @return array Array of language codes that don't need prefix
     */
    public static function getDefaultLanguages(): array
    {
        return self::DEFAULT_LANGUAGES;
    }
}

