<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Brand Model
 * 
 * Handles database operations for the brand table including
 * brand management, search, and relationship handling
 * 
 * @package App\Models
 */
class BrandModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'brand';

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
        'title',
        'canonical',
        'image',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'brand_catalogue_id',
        'status',
        'publish',
        'featured',
        'order',
        'userid_created',
        'userid_updated'
    ];

    /**
     * Validation rules
     * 
     * @var array
     */
    protected $validationRules = [
        'title' => 'required|min_length[2]|max_length[255]',
        'canonical' => 'required|min_length[2]|max_length[255]|is_unique[brand.canonical,id,{id}]',
        'description' => 'permit_empty|max_length[500]',
        'meta_title' => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'meta_keyword' => 'permit_empty|max_length[500]',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'order' => 'permit_empty|integer'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'title' => [
            'required' => 'Brand title is required',
            'min_length' => 'Brand title must be at least 2 characters long',
            'max_length' => 'Brand title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Brand canonical is required',
            'min_length' => 'Brand canonical must be at least 2 characters long',
            'max_length' => 'Brand canonical cannot exceed 255 characters',
            'is_unique' => 'Brand canonical must be unique'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 500 characters'
        ],
        'meta_title' => [
            'max_length' => 'Meta title cannot exceed 255 characters'
        ],
        'meta_description' => [
            'max_length' => 'Meta description cannot exceed 500 characters'
        ],
        'meta_keyword' => [
            'max_length' => 'Meta keyword cannot exceed 500 characters'
        ],
        'status' => [
            'in_list' => 'Status must be either 0 or 1'
        ],
        'publish' => [
            'in_list' => 'Publish must be either 0 or 1'
        ],
        'featured' => [
            'in_list' => 'Featured must be either 0 or 1'
        ],
        'order' => [
            'integer' => 'Order must be a valid integer'
        ]
    ];

    /**
     * Skip validation flag
     * 
     * @var bool
     */
    protected $skipValidation = false;

    /**
     * Get brand by canonical
     * 
     * @param string $canonical Brand canonical
     * @return array|null Brand data
     */
    public function getBrandByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get brands by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Brands in catalogue
     */
    public function getBrandsByCatalogue(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('brand_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get featured brands
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Featured brands
     */
    public function getFeaturedBrands(int $limit = 10, int $offset = 0): array
    {
        return $this->where('featured', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get all published brands
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Published brands
     */
    public function getPublishedBrands(int $limit = 10, int $offset = 0): array
    {
        return $this->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search brands
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchBrands(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('title', $keyword)
                ->orLike('description', $keyword)
                ->orLike('meta_keyword', $keyword);
        
        $builder->where('publish', 1);
        $builder->orderBy('order', 'ASC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get brands count by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @return int Count of brands
     */
    public function getBrandsCountByCatalogue(int $catalogueId): int
    {
        return $this->where('brand_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get brands count by status
     * 
     * @param int $status Status to count
     * @return int Count of brands
     */
    public function getBrandsCountByStatus(int $status): int
    {
        return $this->where('status', $status)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get brands count by featured status
     * 
     * @param int $featured Featured status
     * @return int Count of brands
     */
    public function getBrandsCountByFeatured(int $featured): int
    {
        return $this->where('featured', $featured)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Update brand order
     * 
     * @param int $brandId Brand ID
     * @param int $order New order
     * @return bool Update success
     */
    public function updateBrandOrder(int $brandId, int $order): bool
    {
        return $this->update($brandId, ['order' => $order]);
    }

    /**
     * Get brands for dropdown
     * 
     * @return array Brands for dropdown
     */
    public function getBrandsForDropdown(): array
    {
        return $this->select('id, title')
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->findAll();
    }
}
