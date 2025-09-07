<?php

/**
 * Language Switcher Helper
 * 
 * Provides helper functions for creating language switcher components
 * 
 * @package App\Helpers
 */

use App\Config\LanguageConstants;

if (!function_exists('language_switcher')) {
    /**
     * Generate language switcher HTML
     * 
     * @param array $options Options for the switcher
     * @return string HTML for language switcher
     */
    function language_switcher(array $options = []): string
    {
        $defaults = [
            'current_language' => get_current_language(),
            'show_flags' => true,
            'show_text' => true,
            'class' => 'language-switcher',
            'item_class' => 'language-item',
            'active_class' => 'active',
            'separator' => ' | '
        ];
        
        $options = array_merge($defaults, $options);
        $urls = get_language_switcher_urls();
        
        $html = '<div class="' . $options['class'] . '">';
        
        $languages = [];
        foreach (LanguageConstants::getSupported() as $code) {
            $languages[$code] = [
                'name' => LanguageConstants::getName($code),
                'flag' => LanguageConstants::getFlag($code),
                'url' => $urls[$code]
            ];
        }
        
        $items = [];
        foreach ($languages as $code => $lang) {
            $is_active = ($code === $options['current_language']);
            $class = $options['item_class'];
            
            if ($is_active) {
                $class .= ' ' . $options['active_class'];
            }
            
            $text = '';
            if ($options['show_flags']) {
                $text .= $lang['flag'] . ' ';
            }
            if ($options['show_text']) {
                $text .= $lang['name'];
            }
            
            $items[] = sprintf(
                '<a href="%s" class="%s">%s</a>',
                $lang['url'],
                $class,
                $text
            );
        }
        
        $html .= implode($options['separator'], $items);
        $html .= '</div>';
        
        return $html;
    }
}

if (!function_exists('language_switcher_dropdown')) {
    /**
     * Generate language switcher dropdown HTML
     * 
     * @param array $options Options for the dropdown
     * @return string HTML for language switcher dropdown
     */
    function language_switcher_dropdown(array $options = []): string
    {
        $defaults = [
            'current_language' => get_current_language(),
            'show_flags' => true,
            'show_text' => true,
            'class' => 'language-dropdown',
            'button_class' => 'language-button',
            'menu_class' => 'language-menu',
            'item_class' => 'language-item',
            'active_class' => 'active'
        ];
        
        $options = array_merge($defaults, $options);
        $urls = get_language_switcher_urls();
        
        $languages = [];
        foreach (LanguageConstants::getSupported() as $code) {
            $languages[$code] = [
                'name' => LanguageConstants::getName($code),
                'flag' => LanguageConstants::getFlag($code),
                'url' => $urls[$code]
            ];
        }
        
        $current = $languages[$options['current_language']];
        $current_text = '';
        if ($options['show_flags']) {
            $current_text .= $current['flag'] . ' ';
        }
        if ($options['show_text']) {
            $current_text .= $current['name'];
        }
        
        $html = '<div class="' . $options['class'] . '">';
        $html .= '<button class="' . $options['button_class'] . '">' . $current_text . ' ▼</button>';
        $html .= '<div class="' . $options['menu_class'] . '">';
        
        foreach ($languages as $code => $lang) {
            if ($code === $options['current_language']) {
                continue; // Skip current language
            }
            
            $text = '';
            if ($options['show_flags']) {
                $text .= $lang['flag'] . ' ';
            }
            if ($options['show_text']) {
                $text .= $lang['name'];
            }
            
            $html .= sprintf(
                '<a href="%s" class="%s">%s</a>',
                $lang['url'],
                $options['item_class'],
                $text
            );
        }
        
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}

if (!function_exists('get_language_name')) {
    /**
     * Get language name by code
     * 
     * @param string $code Language code
     * @return string Language name
     */
    function get_language_name(string $code): string
    {
        return LanguageConstants::getName($code);
    }
}

if (!function_exists('get_language_flag')) {
    /**
     * Get language flag by code
     * 
     * @param string $code Language code
     * @return string Language flag emoji
     */
    function get_language_flag(string $code): string
    {
        return LanguageConstants::getFlag($code);
    }
}

if (!function_exists('is_current_language')) {
    /**
     * Check if given language is current language
     * 
     * @param string $language Language code to check
     * @return bool True if it's current language
     */
    function is_current_language(string $language): bool
    {
        return get_current_language() === $language;
    }
}
