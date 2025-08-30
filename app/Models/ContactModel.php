<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Contact Model
 * 
 * Handles database operations for the contact table including
 * contact form submissions and management
 * 
 * @package App\Models
 */
class ContactModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'contact';

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
        'fullname',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'publish',
        'userid_created',
        'userid_updated'
    ];

    /**
     * Validation rules
     * 
     * @var array
     */
    protected $validationRules = [
        'fullname' => 'required|min_length[2]|max_length[255]',
        'email' => 'required|valid_email',
        'phone' => 'permit_empty|min_length[10]|max_length[15]',
        'subject' => 'required|min_length[5]|max_length[255]',
        'message' => 'required|min_length[10]|max_length[2000]',
        'status' => 'permit_empty|in_list[new,read,replied,closed]',
        'publish' => 'permit_empty|in_list[0,1]'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'fullname' => [
            'required' => 'Full name is required',
            'min_length' => 'Full name must be at least 2 characters long',
            'max_length' => 'Full name cannot exceed 255 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address'
        ],
        'phone' => [
            'min_length' => 'Phone number must be at least 10 digits',
            'max_length' => 'Phone number cannot exceed 15 digits'
        ],
        'subject' => [
            'required' => 'Subject is required',
            'min_length' => 'Subject must be at least 5 characters long',
            'max_length' => 'Subject cannot exceed 255 characters'
        ],
        'message' => [
            'required' => 'Message is required',
            'min_length' => 'Message must be at least 10 characters long',
            'max_length' => 'Message cannot exceed 2000 characters'
        ],
        'status' => [
            'in_list' => 'Status must be new, read, replied, or closed'
        ],
        'publish' => [
            'in_list' => 'Publish must be either 0 or 1'
        ]
    ];

    /**
     * Skip validation flag
     * 
     * @var bool
     */
    protected $skipValidation = false;

    /**
     * Get contact by email
     * 
     * @param string $email Email to search for
     * @return array|null Contact data
     */
    public function getContactByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get contacts by status
     * 
     * @param string $status Contact status
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Contacts by status
     */
    public function getContactsByStatus(string $status, int $limit = 10, int $offset = 0): array
    {
        return $this->where('status', $status)
                    ->where('publish', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get new contacts
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array New contacts
     */
    public function getNewContacts(int $limit = 10, int $offset = 0): array
    {
        return $this->where('status', 'new')
                    ->where('publish', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get unread contacts
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Unread contacts
     */
    public function getUnreadContacts(int $limit = 10, int $offset = 0): array
    {
        return $this->whereIn('status', ['new', 'read'])
                    ->where('publish', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get contacts by date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Contacts in date range
     */
    public function getContactsByDateRange(string $startDate, string $endDate, int $limit = 10, int $offset = 0): array
    {
        return $this->where('DATE(created_at) >=', $startDate)
                    ->where('DATE(created_at) <=', $endDate)
                    ->where('publish', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search contacts
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchContacts(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('fullname', $keyword)
                ->orLike('email', $keyword)
                ->orLike('phone', $keyword)
                ->orLike('subject', $keyword)
                ->orLike('message', $keyword);
        
        $builder->where('publish', 1);
        $builder->orderBy('created_at', 'DESC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Update contact status
     * 
     * @param int $contactId Contact ID
     * @param string $status New status
     * @return bool Update success
     */
    public function updateContactStatus(int $contactId, string $status): bool
    {
        return $this->update($contactId, ['status' => $status]);
    }

    /**
     * Mark contact as read
     * 
     * @param int $contactId Contact ID
     * @return bool Update success
     */
    public function markAsRead(int $contactId): bool
    {
        return $this->update($contactId, ['status' => 'read']);
    }

    /**
     * Mark contact as replied
     * 
     * @param int $contactId Contact ID
     * @return bool Update success
     */
    public function markAsReplied(int $contactId): bool
    {
        return $this->update($contactId, ['status' => 'replied']);
    }

    /**
     * Mark contact as closed
     * 
     * @param int $contactId Contact ID
     * @return bool Update success
     */
    public function markAsClosed(int $contactId): bool
    {
        return $this->update($contactId, ['status' => 'closed']);
    }

    /**
     * Get contacts count by status
     * 
     * @param string $status Contact status
     * @return int Count of contacts
     */
    public function getContactsCountByStatus(string $status): int
    {
        return $this->where('status', $status)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get total contacts count
     * 
     * @return int Total count of contacts
     */
    public function getTotalContactsCount(): int
    {
        return $this->where('publish', 1)->countAllResults();
    }

    /**
     * Get unread contacts count
     * 
     * @return int Count of unread contacts
     */
    public function getUnreadContactsCount(): int
    {
        return $this->whereIn('status', ['new', 'read'])
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get contacts by email domain
     * 
     * @param string $domain Email domain
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Contacts by email domain
     */
    public function getContactsByEmailDomain(string $domain, int $limit = 10, int $offset = 0): array
    {
        return $this->like('email', "@{$domain}")
                    ->where('publish', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }
}
