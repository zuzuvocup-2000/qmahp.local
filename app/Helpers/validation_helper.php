<?php

if (!function_exists('get_validation_messages')) {
    /**
     * Get validation messages for specific fields based on current language
     * 
     * @param array $fields Array of field names to get validation messages for
     * @param string $language Language code (default: current language)
     * @return array Validation messages array
     */
    function get_validation_messages(array $fields, string $language = null): array
    {
        if ($language === null) {
            $language = current_language();
        }
        
        $validationMessages = [];
        $lang = \Config\Services::language();
        $lang->setLocale($language);
        
        foreach ($fields as $field) {
            $validationMessages[$field] = [];
            
            // Get common validation rules for the field
            $rules = get_field_validation_rules($field);
            $ruleArray = explode('|', $rules);
            
            foreach ($ruleArray as $rule) {
                $ruleName = explode('[', $rule)[0];
                $param = null;
                
                // Extract parameter if exists
                if (preg_match('/\[(.*?)\]/', $rule, $matches)) {
                    $param = $matches[1];
                }
                
                // Get message for this rule
                $message = get_validation_message($field, $ruleName, $param, $language);
                if ($message) {
                    $validationMessages[$field][$ruleName] = $message;
                }
            }
        }
        
        return $validationMessages;
    }
}

if (!function_exists('get_validation_message')) {
    /**
     * Get validation message for specific field and rule
     * 
     * @param string $field Field name
     * @param string $rule Rule name
     * @param string|null $param Rule parameter
     * @param string $language Language code
     * @return string|null Validation message
     */
    function get_validation_message(string $field, string $rule, ?string $param = null, string $language = null): ?string
    {
        if ($language === null) {
            $language = current_language();
        }
        
        $lang = \Config\Services::language();
        $lang->setLocale($language);
        
        // Try to get field-specific message first
        $fieldMessage = $lang->getLine("validation.{$field}.{$rule}");
        if ($fieldMessage) {
            return $param ? str_replace('{param}', $param, $fieldMessage) : $fieldMessage;
        }
        
        // Fall back to generic message
        $genericMessage = $lang->getLine("validation.{$rule}");
        if ($genericMessage) {
            $message = str_replace('{field}', $field, $genericMessage);
            return $param ? str_replace('{param}', $param, $message) : $message;
        }
        
        return null;
    }
}

if (!function_exists('get_field_validation_rules')) {
    /**
     * Get validation rules for specific field
     * 
     * @param string $field Field name
     * @return string Validation rules string
     */
    function get_field_validation_rules(string $field): string
    {
        $constants = new \App\Config\ValidationConstants();
        return $constants::VALIDATION_RULES[$field] ?? '';
    }
}

if (!function_exists('get_form_validation_rules')) {
    /**
     * Get validation rules for specific form
     * 
     * @param string $formType Form type (e.g., 'contact_form', 'donation_form')
     * @return array Validation rules array
     */
    function get_form_validation_rules(string $formType): array
    {
        $constants = new \App\Config\ValidationConstants();
        
        switch ($formType) {
            case 'contact_form':
                return $constants::CONTACT_FORM_RULES;
            case 'donation_form':
                return $constants::DONATION_FORM_RULES;
            default:
                return [];
        }
    }
}

if (!function_exists('get_form_validation_messages')) {
    /**
     * Get validation messages for specific form
     * 
     * @param string $formType Form type
     * @param string $language Language code
     * @return array Validation messages array
     */
    function get_form_validation_messages(string $formType, string $language = null): array
    {
        $rules = get_form_validation_rules($formType);
        $fields = array_keys($rules);
        return get_validation_messages($fields, $language);
    }
}

if (!function_exists('current_language')) {
    /**
     * Get current language code
     * 
     * @return string Current language code
     */
    function current_language(): string
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();
        
        // Try to get from session first
        $language = $session->get('language');
        if ($language) {
            return $language;
        }
        
        // Try to get from request
        $language = $request->getLocale();
        if ($language) {
            return $language;
        }
        
        // Default to Vietnamese
        return 'vi';
    }
}
