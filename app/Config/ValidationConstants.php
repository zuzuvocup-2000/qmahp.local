<?php

namespace App\Config;

/**
 * Validation constants to avoid magic numbers and strings
 */
class ValidationConstants
{
    // Field length constants
    const FULLNAME_MIN_LENGTH = 3;
    const FULLNAME_MAX_LENGTH = 100;
    const PHONE_MIN_LENGTH = 10;
    const PHONE_MAX_LENGTH = 15;
    const MESSAGE_MIN_LENGTH = 10;
    const MESSAGE_MAX_LENGTH = 1000;
    const ADDRESS_MIN_LENGTH = 10;
    const ADDRESS_MAX_LENGTH = 200;
    const TITLE_MIN_LENGTH = 5;
    const TITLE_MAX_LENGTH = 200;
    const CONTENT_MIN_LENGTH = 10;
    const CONTENT_MAX_LENGTH = 5000;
    
    // Validation rules
    const VALIDATION_RULES = [
        'fullname' => 'required|min_length[' . self::FULLNAME_MIN_LENGTH . ']|max_length[' . self::FULLNAME_MAX_LENGTH . ']',
        'email' => 'required|valid_email',
        'phone' => 'required|min_length[' . self::PHONE_MIN_LENGTH . ']|max_length[' . self::PHONE_MAX_LENGTH . ']',
        'message' => 'min_length[' . self::MESSAGE_MIN_LENGTH . ']|max_length[' . self::MESSAGE_MAX_LENGTH . ']',
        'address' => 'min_length[' . self::ADDRESS_MIN_LENGTH . ']|max_length[' . self::ADDRESS_MAX_LENGTH . ']',
        'title' => 'required|min_length[' . self::TITLE_MIN_LENGTH . ']|max_length[' . self::TITLE_MAX_LENGTH . ']',
        'content' => 'required|min_length[' . self::CONTENT_MIN_LENGTH . ']|max_length[' . self::CONTENT_MAX_LENGTH . ']'
    ];
    
    // Common validation rules for different forms
    const CONTACT_FORM_RULES = [
        'fullname' => self::VALIDATION_RULES['fullname'],
        'email' => self::VALIDATION_RULES['email'],
        'phone' => self::VALIDATION_RULES['phone'],
        'message' => self::VALIDATION_RULES['message']
    ];
    
    const DONATION_FORM_RULES = [
        'fullname' => self::VALIDATION_RULES['fullname'],
        'email' => self::VALIDATION_RULES['email'],
        'phone' => self::VALIDATION_RULES['phone']
    ];
}
