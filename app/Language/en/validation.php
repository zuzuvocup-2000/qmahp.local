<?php

// Common validation messages for English
return [
    'required' => 'The {field} field is required.',
    'min_length' => 'The {field} field must be at least {param} characters in length.',
    'max_length' => 'The {field} field cannot exceed {param} characters in length.',
    'valid_email' => 'The {field} field must contain a valid email address.',
    'numeric' => 'The {field} field must contain only numbers.',
    'alpha' => 'The {field} field may only contain alphabetical characters.',
    'alpha_numeric' => 'The {field} field may only contain alpha-numeric characters.',
    'alpha_numeric_space' => 'The {field} field may only contain alpha-numeric characters and spaces.',
    'decimal' => 'The {field} field must contain a decimal number.',
    'integer' => 'The {field} field must contain an integer.',
    'is_natural' => 'The {field} field must only contain digits.',
    'is_natural_no_zero' => 'The {field} field must only contain digits and must be greater than zero.',
    'valid_url' => 'The {field} field must contain a valid URL.',
    'valid_ip' => 'The {field} field must contain a valid IP.',
    'valid_base64' => 'The {field} field must contain a valid base64 string.',
    'valid_cc' => 'The {field} field must contain a valid credit card number.',
    'exact_length' => 'The {field} field must be exactly {param} characters in length.',
    'greater_than' => 'The {field} field must contain a number greater than {param}.',
    'greater_than_equal_to' => 'The {field} field must contain a number greater than or equal to {param}.',
    'less_than' => 'The {field} field must contain a number less than {param}.',
    'less_than_equal_to' => 'The {field} field must contain a number less than or equal to {param}.',
    'in_list' => 'The {field} field must be one of: {param}.',
    'matches' => 'The {field} field does not match the {param} field.',
    'differs' => 'The {field} field must differ from the {param} field.',
    'is_unique' => 'The {field} field must contain a unique value.',
    'regex_match' => 'The {field} field is not in the correct format.',
    'permit_empty' => 'The {field} field is required.',
    'uploaded_file' => 'The {field} field must contain a valid uploaded file.',
    'max_size' => 'The {field} field must be less than {param} kilobytes in size.',
    'max_dims' => 'The {field} field must be no larger than {param} pixels in width and height.',
    'mime_in' => 'The {field} field must contain a file with one of the following MIME types: {param}.',
    'ext_in' => 'The {field} field must contain a file with one of the following extensions: {param}.',
    
    // Custom validation messages for specific fields
    'fullname' => [
        'required' => 'You must enter your full name',
        'min_length' => 'Full name must be at least {param} characters',
        'max_length' => 'Full name cannot exceed {param} characters'
    ],
    'email' => [
        'required' => 'You must enter your email address',
        'valid_email' => 'Email address is not in correct format'
    ],
    'phone' => [
        'required' => 'You must enter your phone number',
        'min_length' => 'Phone number must be at least {param} characters',
        'max_length' => 'Phone number cannot exceed {param} characters'
    ],
    'message' => [
        'required' => 'You must enter a message',
        'min_length' => 'Message must be at least {param} characters',
        'max_length' => 'Message cannot exceed {param} characters'
    ],
    'address' => [
        'required' => 'You must enter your address',
        'min_length' => 'Address must be at least {param} characters',
        'max_length' => 'Address cannot exceed {param} characters'
    ],
    'title' => [
        'required' => 'You must enter a title',
        'min_length' => 'Title must be at least {param} characters',
        'max_length' => 'Title cannot exceed {param} characters'
    ],
    'content' => [
        'required' => 'You must enter content',
        'min_length' => 'Content must be at least {param} characters',
        'max_length' => 'Content cannot exceed {param} characters'
    ]
];
