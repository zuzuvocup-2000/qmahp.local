<?php

// Common validation messages for Vietnamese
return [
    'required' => 'Trường {field} là bắt buộc.',
    'min_length' => 'Trường {field} phải có ít nhất {param} ký tự.',
    'max_length' => 'Trường {field} không được vượt quá {param} ký tự.',
    'valid_email' => 'Trường {field} phải chứa địa chỉ email hợp lệ.',
    'numeric' => 'Trường {field} chỉ được chứa số.',
    'alpha' => 'Trường {field} chỉ được chứa ký tự chữ cái.',
    'alpha_numeric' => 'Trường {field} chỉ được chứa ký tự chữ cái và số.',
    'alpha_numeric_space' => 'Trường {field} chỉ được chứa ký tự chữ cái, số và khoảng trắng.',
    'decimal' => 'Trường {field} phải chứa số thập phân.',
    'integer' => 'Trường {field} phải chứa số nguyên.',
    'is_natural' => 'Trường {field} chỉ được chứa chữ số.',
    'is_natural_no_zero' => 'Trường {field} chỉ được chứa chữ số và phải lớn hơn 0.',
    'valid_url' => 'Trường {field} phải chứa URL hợp lệ.',
    'valid_ip' => 'Trường {field} phải chứa IP hợp lệ.',
    'valid_base64' => 'Trường {field} phải chứa chuỗi base64 hợp lệ.',
    'valid_cc' => 'Trường {field} phải chứa số thẻ tín dụng hợp lệ.',
    'exact_length' => 'Trường {field} phải có đúng {param} ký tự.',
    'greater_than' => 'Trường {field} phải chứa số lớn hơn {param}.',
    'greater_than_equal_to' => 'Trường {field} phải chứa số lớn hơn hoặc bằng {param}.',
    'less_than' => 'Trường {field} phải chứa số nhỏ hơn {param}.',
    'less_than_equal_to' => 'Trường {field} phải chứa số nhỏ hơn hoặc bằng {param}.',
    'in_list' => 'Trường {field} phải là một trong: {param}.',
    'matches' => 'Trường {field} không khớp với trường {param}.',
    'differs' => 'Trường {field} phải khác với trường {param}.',
    'is_unique' => 'Trường {field} phải chứa giá trị duy nhất.',
    'regex_match' => 'Trường {field} không đúng định dạng.',
    'permit_empty' => 'Trường {field} là bắt buộc.',
    'uploaded_file' => 'Trường {field} phải chứa file đã upload hợp lệ.',
    'max_size' => 'Trường {field} phải nhỏ hơn {param} kilobytes.',
    'max_dims' => 'Trường {field} không được lớn hơn {param} pixels về chiều rộng và chiều cao.',
    'mime_in' => 'Trường {field} phải chứa file có một trong các loại MIME sau: {param}.',
    'ext_in' => 'Trường {field} phải chứa file có một trong các phần mở rộng sau: {param}.',
    
    // Custom validation messages for specific fields
    'fullname' => [
        'required' => 'Bạn phải nhập vào trường họ và tên',
        'min_length' => 'Họ và tên phải có ít nhất {param} ký tự',
        'max_length' => 'Họ và tên không được quá {param} ký tự'
    ],
    'email' => [
        'required' => 'Bạn phải nhập vào trường email',
        'valid_email' => 'Email không đúng định dạng'
    ],
    'phone' => [
        'required' => 'Bạn phải nhập vào trường số điện thoại',
        'min_length' => 'Số điện thoại phải có ít nhất {param} ký tự',
        'max_length' => 'Số điện thoại không được quá {param} ký tự'
    ],
    'message' => [
        'required' => 'Bạn phải nhập tin nhắn',
        'min_length' => 'Tin nhắn phải có ít nhất {param} ký tự',
        'max_length' => 'Tin nhắn không được quá {param} ký tự'
    ],
    'address' => [
        'required' => 'Bạn phải nhập địa chỉ',
        'min_length' => 'Địa chỉ phải có ít nhất {param} ký tự',
        'max_length' => 'Địa chỉ không được quá {param} ký tự'
    ],
    'title' => [
        'required' => 'Bạn phải nhập tiêu đề',
        'min_length' => 'Tiêu đề phải có ít nhất {param} ký tự',
        'max_length' => 'Tiêu đề không được quá {param} ký tự'
    ],
    'content' => [
        'required' => 'Bạn phải nhập nội dung',
        'min_length' => 'Nội dung phải có ít nhất {param} ký tự',
        'max_length' => 'Nội dung không được quá {param} ký tự'
    ]
];
