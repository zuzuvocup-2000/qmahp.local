<?php

/**
 * Language Helper
 * 
 * Provides helper functions for accessing language keywords and translations
 * 
 * @package App\Helpers
 */

if (!function_exists('lang_keyword')) {
    /**
     * Get translation for a keyword in the current language
     * 
     * @param string $keyword Keyword to translate
     * @param string $default Default text if translation not found
     * @param string|null $language Language code (en, vi) or null for current language
     * @return string Translation text or default text
     */
    function lang_keyword(string $keyword, string $default = '', ?string $language = null): string
    {
        // Get current language from session or config
        if ($language === null) {
            $language = session()->get('language') ?? 'en';
        }
        
        // Validate language code
        if (!in_array($language, ['en', 'vi'])) {
            $language = 'en';
        }
        
        // Try to get translation from database
        $model = new \App\Models\LanguageKeywordModel();
        $translation = $model->getTranslation($keyword, $language);
        
        if ($translation !== null) {
            return $translation;
        }
        
        // Fallback to default text
        return $default ?: $keyword;
    }
}

if (!function_exists('lang_keyword_exists')) {
    /**
     * Check if a keyword exists in the database
     * 
     * @param string $keyword Keyword to check
     * @return bool True if keyword exists
     */
    function lang_keyword_exists(string $keyword): bool
    {
        $model = new \App\Models\LanguageKeywordModel();
        return $model->isKeywordExists($keyword);
    }
}

if (!function_exists('lang_keyword_all')) {
    /**
     * Get all translations for a keyword
     * 
     * @param string $keyword Keyword to get translations for
     * @return array|null Translations array or null if not found
     */
    function lang_keyword_all(string $keyword): ?array
    {
        $model = new \App\Models\LanguageKeywordModel();
        return $model->getKeywordTranslations($keyword);
    }
}

if (!function_exists('lang_keyword_search')) {
    /**
     * Search for keywords
     * 
     * @param string $searchTerm Search term
     * @param string|null $module Filter by module
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    function lang_keyword_search(string $searchTerm, ?string $module = null, int $limit = 10, int $offset = 0): array
    {
        $model = new \App\Models\LanguageKeywordModel();
        return $model->searchKeywords($searchTerm, $module, $limit, $offset);
    }
}

if (!function_exists('lang_keyword_module')) {
    /**
     * Get all keywords for a specific module
     * 
     * @param string $module Module name
     * @param bool $publishedOnly Whether to get only published keywords
     * @return array Keywords for the module
     */
    function lang_keyword_module(string $module, bool $publishedOnly = true): array
    {
        $model = new \App\Models\LanguageKeywordModel();
        return $model->getKeywordsByModule($module, $publishedOnly);
    }
}

if (!function_exists('lang_keyword_count')) {
    /**
     * Get count of keywords
     * 
     * @param string|null $module Filter by module
     * @param int|null $publish Filter by publish status
     * @return int Count of keywords
     */
    function lang_keyword_count(?string $module = null, ?int $publish = null): int
    {
        $model = new \App\Models\LanguageKeywordModel();
        return $model->getKeywordsCount($module, $publish);
    }
}

if (!function_exists('lang_keyword_modules')) {
    /**
     * Get all available modules
     * 
     * @return array List of available modules
     */
    function lang_keyword_modules(): array
    {
        $model = new \App\Models\LanguageKeywordModel();
        return $model->getAvailableModules();
    }
}

if (!function_exists('lang_keyword_import')) {
    /**
     * Import keywords from language files
     * 
     * @param array $keywords Array of keywords with translations
     * @param string $module Module name
     * @return int Number of imported keywords
     */
    function lang_keyword_import(array $keywords, string $module): int
    {
        $model = new \App\Models\LanguageKeywordModel();
        return $model->bulkImportKeywords($keywords, $module);
    }
}

if (!function_exists('lang_keyword_export')) {
    /**
     * Export keywords to language file format
     * 
     * @param string $module Module name
     * @param string $language Language code (en, vi)
     * @return array Language file format array
     */
    function lang_keyword_export(string $module, string $language): array
    {
        $model = new \App\Models\LanguageKeywordModel();
        return $model->exportLanguageFile($module, $language);
    }
}

if (!function_exists('lang_keyword_sidebar')) {
    /**
     * Get sidebar translations
     * 
     * @param string $language Language code (en, vi)
     * @return array Sidebar translations
     */
    function lang_keyword_sidebar(string $language = 'en'): array
    {
        $model = new \App\Models\LanguageKeywordModel();
        $keywords = $model->getKeywordsByModule('cms', true);
        
        $translations = [];
        foreach ($keywords as $keyword) {
            if (strpos($keyword['keyword'], 'sidebar_') === 0) {
                $key = str_replace('sidebar_', '', $keyword['keyword']);
                $translations[$key] = $keyword[$language . '_translation'];
            }
        }
        
        return $translations;
    }
}

if (!function_exists('lang_keyword_nav')) {
    /**
     * Get navigation translations
     * 
     * @param string $language Language code (en, vi)
     * @return array Navigation translations
     */
    function lang_keyword_nav(string $language = 'en'): array
    {
        $model = new \App\Models\LanguageKeywordModel();
        $keywords = $model->getKeywordsByModule('cms', true);
        
        $translations = [];
        foreach ($keywords as $keyword) {
            if (strpos($keyword['keyword'], 'nav_') === 0) {
                $key = str_replace('nav_', '', $keyword['keyword']);
                $translations[$key] = $keyword[$language . '_translation'];
            }
        }
        
        return $translations;
    }
}

if (!function_exists('lang_keyword_tour')) {
    /**
     * Get tour module translations
     * 
     * @param string $language Language code (en, vi)
     * @return array Tour translations
     */
    function lang_keyword_tour(string $language = 'en'): array
    {
        $model = new \App\Models\LanguageKeywordModel();
        $keywords = $model->getKeywordsByModule('cms', true);
        
        $translations = [];
        foreach ($keywords as $keyword) {
            if (strpos($keyword['keyword'], 'tour_') === 0) {
                $key = str_replace('tour_', '', $keyword['keyword']);
                $translations[$key] = $keyword[$language . '_translation'];
            }
        }
        
        return $translations;
    }
}
