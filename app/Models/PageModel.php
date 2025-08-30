<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Page Model
 * 
 * Handles database operations for the page table including
 * page management, search, and relationship handling
 * 
 * @package App\Models
 */
class PageModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'page';

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
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'page_catalogue_id',
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
        'canonical' => 'required|min_length[2]|max_length[255]|is_unique[page.canonical,id,{id}]',
        'description' => 'permit_empty|max_length[500]',
        'content' => 'required|min_length[10]',
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
            'required' => 'Page title is required',
            'min_length' => 'Page title must be at least 2 characters long',
            'max_length' => 'Page title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Page canonical is required',
            'min_length' => 'Page canonical must be at least 2 characters long',
            'max_length' => 'Page canonical cannot exceed 255 characters',
            'is_unique' => 'Page canonical must be unique'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 500 characters'
        ],
        'content' => [
            'required' => 'Page content is required',
            'min_length' => 'Page content must be at least 10 characters long'
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
     * Get page by canonical
     * 
     * @param string $canonical Page canonical
     * @return array|null Page data
     */
    public function getPageByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get pages by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Pages in catalogue
     */
    public function getPagesByCatalogue(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('page_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get featured pages
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Featured pages
     */
    public function getFeaturedPages(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('page_catalogue_id', $catalogueId)
                    ->where('featured', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get pages by status
     * 
     * @param int $status Page status
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Pages by status
     */
    public function getPagesByStatus(int $status, int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('page_catalogue_id', $catalogueId)
                    ->where('status', $status)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search pages
     * 
     * @param string $keyword Search keyword
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchPages(string $keyword, int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('title', $keyword)
                ->orLike('description', $keyword)
                ->orLike('content', $keyword)
                ->orLike('meta_keyword', $keyword);
        
        $builder->where('page_catalogue_id', $catalogueId);
        $builder->where('publish', 1);
        $builder->orderBy('order', 'ASC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get recent pages
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Recent pages
     */
    public function getRecentPages(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('page_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get pages by date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Pages in date range
     */
    public function getPagesByDateRange(string $startDate, string $endDate, int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('page_catalogue_id', $catalogueId)
                    ->where('DATE(created_at) >=', $startDate)
                    ->where('DATE(created_at) <=', $endDate)
                    ->where('publish', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Update page status
     * 
     * @param int $pageId Page ID
     * @param int $status New status
     * @return bool Update success
     */
    public function updatePageStatus(int $pageId, int $status): bool
    {
        return $this->update($pageId, ['status' => $status]);
    }

    /**
     * Update page featured status
     * 
     * @param int $pageId Page ID
     * @param int $featured Featured status
     * @return bool Update success
     */
    public function updatePageFeatured(int $pageId, int $featured): bool
    {
        return $this->update($pageId, ['featured' => $featured]);
    }

    /**
     * Update page order
     * 
     * @param int $pageId Page ID
     * @param int $order New order
     * @return bool Update success
     */
    public function updatePageOrder(int $pageId, int $order): bool
    {
        return $this->update($pageId, ['order' => $order]);
    }

    /**
     * Get pages count by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @return int Count of pages
     */
    public function getPagesCountByCatalogue(int $catalogueId): int
    {
        return $this->where('page_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get pages count by status
     * 
     * @param int $status Page status
     * @param int $catalogueId Catalogue ID
     * @return int Count of pages
     */
    public function getPagesCountByStatus(int $status, int $catalogueId): int
    {
        return $this->where('page_catalogue_id', $catalogueId)
                    ->where('status', $status)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get pages count by featured status
     * 
     * @param int $featured Featured status
     * @param int $catalogueId Catalogue ID
     * @return int Count of pages
     */
    public function getPagesCountByFeatured(int $featured, int $catalogueId): int
    {
        return $this->where('page_catalogue_id', $catalogueId)
                    ->where('featured', $featured)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get pages for sitemap
     * 
     * @param int $catalogueId Catalogue ID
     * @return array Pages for sitemap
     */
    public function getPagesForSitemap(int $catalogueId): array
    {
        return $this->select('id, title, canonical, updated_at')
                    ->where('page_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->findAll();
    }

    /**
     * Get pages for dropdown
     * 
     * @param int $catalogueId Catalogue ID
     * @return array Pages for dropdown
     */
    public function getPagesForDropdown(int $catalogueId): array
    {
        return $this->select('id, title, order')
                    ->where('page_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->findAll();
    }

    /**
     * Check if canonical exists
     * 
     * @param string $canonical Page canonical
     * @param int|null $excludeId ID to exclude from check
     * @return bool True if exists
     */
    public function isCanonicalExists(string $canonical, ?int $excludeId = null): bool
    {
        $builder = $this->builder();
        $builder->where('canonical', $canonical);
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }
}
