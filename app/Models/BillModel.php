<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Bill Model
 * 
 * Handles database operations for the bill table including
 * order management, billing, and relationship handling
 * 
 * @package App\Models
 */
class BillModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'bill';

    /**
     * Primary key field
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Return type for queries
     * 
     * @var string
     */
    protected $returnType = 'array';

    /**
     * Use soft deletes
     * 
     * @var bool
     */
    protected $useSoftDeletes = true;

    /**
     * Soft delete field
     * 
     * @var string
     */
    protected $deletedField = 'deleted_at';

    /**
     * Use timestamps
     * 
     * @var bool
     */
    protected $useTimestamps = true;

    /**
     * Created field
     * 
     * @var string
     */
    protected $createdField = 'created_at';

    /**
     * Updated field
     * 
     * @var string
     */
    protected $updatedField = 'updated_at';

    /**
     * Allowed fields for mass assignment
     * 
     * @var array
     */
    protected $allowedFields = [
        'code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_note',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'shipping_amount',
        'final_amount',
        'payment_method',
        'payment_status',
        'shipping_status',
        'order_status',
        'member_id',
        'userid_created',
        'userid_updated'
    ];

    /**
     * Validation rules
     * 
     * @var array
     */
    protected $validationRules = [
        'code' => 'required|min_length[5]|max_length[50]|is_unique[bill.code,id,{id}]',
        'customer_name' => 'required|min_length[2]|max_length[255]',
        'customer_email' => 'required|valid_email',
        'customer_phone' => 'required|min_length[10]|max_length[15]',
        'customer_address' => 'required|min_length[10]|max_length[500]',
        'customer_note' => 'permit_empty|max_length[1000]',
        'total_amount' => 'required|numeric',
        'discount_amount' => 'permit_empty|numeric',
        'tax_amount' => 'permit_empty|numeric',
        'shipping_amount' => 'permit_empty|numeric',
        'final_amount' => 'required|numeric',
        'payment_method' => 'required|in_list[cash,bank_transfer,credit_card,online_payment]',
        'payment_status' => 'required|in_list[pending,paid,failed,refunded]',
        'shipping_status' => 'required|in_list[pending,processing,shipped,delivered,cancelled]',
        'order_status' => 'required|in_list[pending,confirmed,processing,completed,cancelled]'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'code' => [
            'required' => 'Bill code is required',
            'min_length' => 'Bill code must be at least 5 characters long',
            'max_length' => 'Bill code cannot exceed 50 characters',
            'is_unique' => 'Bill code must be unique'
        ],
        'customer_name' => [
            'required' => 'Customer name is required',
            'min_length' => 'Customer name must be at least 2 characters long',
            'max_length' => 'Customer name cannot exceed 255 characters'
        ],
        'customer_email' => [
            'required' => 'Customer email is required',
            'valid_email' => 'Please enter a valid email address'
        ],
        'customer_phone' => [
            'required' => 'Customer phone is required',
            'min_length' => 'Phone number must be at least 10 digits',
            'max_length' => 'Phone number cannot exceed 15 digits'
        ],
        'customer_address' => [
            'required' => 'Customer address is required',
            'min_length' => 'Address must be at least 10 characters long',
            'max_length' => 'Address cannot exceed 500 characters'
        ],
        'customer_note' => [
            'max_length' => 'Customer note cannot exceed 1000 characters'
        ],
        'total_amount' => [
            'required' => 'Total amount is required',
            'numeric' => 'Total amount must be a valid number'
        ],
        'discount_amount' => [
            'numeric' => 'Discount amount must be a valid number'
        ],
        'tax_amount' => [
            'numeric' => 'Tax amount must be a valid number'
        ],
        'shipping_amount' => [
            'numeric' => 'Shipping amount must be a valid number'
        ],
        'final_amount' => [
            'required' => 'Final amount is required',
            'numeric' => 'Final amount must be a valid number'
        ],
        'payment_method' => [
            'required' => 'Payment method is required',
            'in_list' => 'Payment method must be cash, bank_transfer, credit_card, or online_payment'
        ],
        'payment_status' => [
            'required' => 'Payment status is required',
            'in_list' => 'Payment status must be pending, paid, failed, or refunded'
        ],
        'shipping_status' => [
            'required' => 'Shipping status is required',
            'in_list' => 'Shipping status must be pending, processing, shipped, delivered, or cancelled'
        ],
        'order_status' => [
            'required' => 'Order status is required',
            'in_list' => 'Order status must be pending, confirmed, processing, completed, or cancelled'
        ]
    ];

    /**
     * Skip validation flag
     * 
     * @var bool
     */
    protected $skipValidation = false;

    /**
     * Get bill by code
     * 
     * @param string $code Bill code
     * @return array|null Bill data
     */
    public function getBillByCode(string $code): ?array
    {
        return $this->where('code', $code)->first();
    }

    /**
     * Get bills by member
     * 
     * @param int $memberId Member ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Bills by member
     */
    public function getBillsByMember(int $memberId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('member_id', $memberId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get bills by payment status
     * 
     * @param string $paymentStatus Payment status
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Bills by payment status
     */
    public function getBillsByPaymentStatus(string $paymentStatus, int $limit = 10, int $offset = 0): array
    {
        return $this->where('payment_status', $paymentStatus)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get bills by order status
     * 
     * @param string $orderStatus Order status
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Bills by order status
     */
    public function getBillsByOrderStatus(string $orderStatus, int $limit = 10, int $offset = 0): array
    {
        return $this->where('order_status', $orderStatus)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get bills by date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Bills in date range
     */
    public function getBillsByDateRange(string $startDate, string $endDate, int $limit = 10, int $offset = 0): array
    {
        return $this->where('DATE(created_at) >=', $startDate)
                    ->where('DATE(created_at) <=', $endDate)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get bills by amount range
     * 
     * @param float $minAmount Minimum amount
     * @param float $maxAmount Maximum amount
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Bills in amount range
     */
    public function getBillsByAmountRange(float $minAmount, float $maxAmount, int $limit = 10, int $offset = 0): array
    {
        return $this->where('final_amount >=', $minAmount)
                    ->where('final_amount <=', $maxAmount)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search bills
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchBills(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('code', $keyword)
                ->orLike('customer_name', $keyword)
                ->orLike('customer_email', $keyword)
                ->orLike('customer_phone', $keyword);
        
        $builder->orderBy('created_at', 'DESC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Update bill status
     * 
     * @param int $billId Bill ID
     * @param array $statusData Status data to update
     * @return bool Update success
     */
    public function updateBillStatus(int $billId, array $statusData): bool
    {
        return $this->update($billId, $statusData);
    }

    /**
     * Get bills count by payment status
     * 
     * @param string $paymentStatus Payment status
     * @return int Count of bills
     */
    public function getBillsCountByPaymentStatus(string $paymentStatus): int
    {
        return $this->where('payment_status', $paymentStatus)->countAllResults();
    }

    /**
     * Get bills count by order status
     * 
     * @param string $orderStatus Order status
     * @return int Count of bills
     */
    public function getBillsCountByOrderStatus(string $orderStatus): int
    {
        return $this->where('order_status', $orderStatus)->countAllResults();
    }

    /**
     * Get total revenue by date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return float Total revenue
     */
    public function getTotalRevenueByDateRange(string $startDate, string $endDate): float
    {
        $result = $this->select('SUM(final_amount) as total_revenue')
                       ->where('DATE(created_at) >=', $startDate)
                       ->where('DATE(created_at) <=', $endDate)
                       ->where('payment_status', 'paid')
                       ->first();
        
        return (float) ($result['total_revenue'] ?? 0);
    }

    /**
     * Get bills count by member
     * 
     * @param int $memberId Member ID
     * @return int Count of bills
     */
    public function getBillsCountByMember(int $memberId): int
    {
        return $this->where('member_id', $memberId)->countAllResults();
    }
}
