<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * User Model
 * 
 * Handles database operations for the user table including
 * authentication, user management, and role-based access control
 * 
 * @package App\Models
 */
class UserModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'user';

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
        'username',
        'password',
        'email',
        'fullname',
        'phone',
        'address',
        'avatar',
        'status',
        'user_catalogue_id',
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
        'username' => 'required|min_length[3]|max_length[50]|is_unique[user.username,id,{id}]',
        'password' => 'required|min_length[6]',
        'email' => 'required|valid_email|is_unique[user.email,id,{id}]',
        'fullname' => 'required|min_length[2]|max_length[255]',
        'phone' => 'permit_empty|min_length[10]|max_length[15]',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 50 characters',
            'is_unique' => 'Username already exists'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'Email already exists'
        ],
        'fullname' => [
            'required' => 'Full name is required',
            'min_length' => 'Full name must be at least 2 characters long',
            'max_length' => 'Full name cannot exceed 255 characters'
        ],
        'phone' => [
            'min_length' => 'Phone number must be at least 10 digits',
            'max_length' => 'Phone number cannot exceed 15 digits'
        ],
        'status' => [
            'in_list' => 'Status must be either 0 or 1'
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
     * Get user by username
     * 
     * @param string $username Username to search for
     * @return array|null User data
     */
    public function getUserByUsername(string $username): ?array
    {
        return $this->where('username', $username)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get user by email
     * 
     * @param string $email Email to search for
     * @return array|null User data
     */
    public function getUserByEmail(string $email): ?array
    {
        return $this->where('email', $email)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get users by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Users in catalogue
     */
    public function getUsersByCatalogue(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('user_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get active users
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Active users
     */
    public function getActiveUsers(int $limit = 10, int $offset = 0): array
    {
        return $this->where('status', 1)
                    ->where('publish', 1)
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search users
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchUsers(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('username', $keyword)
                ->orLike('email', $keyword)
                ->orLike('fullname', $keyword)
                ->orLike('phone', $keyword);
        
        $builder->where('publish', 1);
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Update user status
     * 
     * @param int $userId User ID
     * @param int $status New status
     * @return bool Update success
     */
    public function updateUserStatus(int $userId, int $status): bool
    {
        return $this->update($userId, ['status' => $status]);
    }

    /**
     * Get users count by status
     * 
     * @param int $status Status to count
     * @return int Count of users
     */
    public function getUsersCountByStatus(int $status): int
    {
        return $this->where('status', $status)
                    ->where('publish', 1)
                    ->countAllResults();
    }
}
