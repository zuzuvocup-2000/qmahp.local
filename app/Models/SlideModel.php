<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Slide Model
 * 
 * Handles database operations for the slide table including
 * slide management, ordering, and relationship handling
 * 
 * @package App\Models
 */
class SlideModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'slide';

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
        'link',
        'target',
        'slide_catalogue_id',
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
        'canonical' => 'required|min_length[2]|max_length[255]|is_unique[slide.canonical,id,{id}]',
        'image' => 'required|max_length[500]',
        'description' => 'permit_empty|max_length[500]',
        'link' => 'permit_empty|max_length[500]',
        'target' => 'permit_empty|in_list[_self,_blank,_parent,_top]',
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
            'required' => 'Slide title is required',
            'min_length' => 'Slide title must be at least 2 characters long',
            'max_length' => 'Slide title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Slide canonical is required',
            'min_length' => 'Slide canonical must be at least 2 characters long',
            'max_length' => 'Slide canonical cannot exceed 255 characters',
            'is_unique' => 'Slide canonical must be unique'
        ],
        'image' => [
            'required' => 'Slide image is required',
            'max_length' => 'Image path cannot exceed 500 characters'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 500 characters'
        ],
        'link' => [
            'max_length' => 'Link cannot exceed 500 characters'
        ],
        'target' => [
            'in_list' => 'Target must be _self, _blank, _parent, or _top'
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
     * Get slide by canonical
     * 
     * @param string $canonical Slide canonical
     * @return array|null Slide data
     */
    public function getSlideByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get slides by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Slides in catalogue
     */
    public function getSlidesByCatalogue(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get featured slides
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Featured slides
     */
    public function getFeaturedSlides(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('featured', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get active slides
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Active slides
     */
    public function getActiveSlides(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('status', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get slides by status
     * 
     * @param int $status Slide status
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Slides by status
     */
    public function getSlidesByStatus(int $status, int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('status', $status)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search slides
     * 
     * @param string $keyword Search keyword
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchSlides(string $keyword, int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('title', $keyword)
                ->orLike('description', $keyword)
                ->orLike('canonical', $keyword);
        
        $builder->where('slide_catalogue_id', $catalogueId);
        $builder->where('publish', 1);
        $builder->orderBy('order', 'ASC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Update slide order
     * 
     * @param int $slideId Slide ID
     * @param int $order New order
     * @return bool Update success
     */
    public function updateSlideOrder(int $slideId, int $order): bool
    {
        return $this->update($slideId, ['order' => $order]);
    }

    /**
     * Update slide status
     * 
     * @param int $slideId Slide ID
     * @param int $status New status
     * @return bool Update success
     */
    public function updateSlideStatus(int $slideId, int $status): bool
    {
        return $this->update($slideId, ['status' => $status]);
    }

    /**
     * Update slide featured status
     * 
     * @param int $slideId Slide ID
     * @param int $featured Featured status
     * @return bool Update success
     */
    public function updateSlideFeatured(int $slideId, int $featured): bool
    {
        return $this->update($slideId, ['featured' => $featured]);
    }

    /**
     * Get slides count by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @return int Count of slides
     */
    public function getSlidesCountByCatalogue(int $catalogueId): int
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get slides count by status
     * 
     * @param int $status Slide status
     * @param int $catalogueId Catalogue ID
     * @return int Count of slides
     */
    public function getSlidesCountByStatus(int $status, int $catalogueId): int
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('status', $status)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get slides count by featured status
     * 
     * @param int $featured Featured status
     * @param int $catalogueId Catalogue ID
     * @return int Count of slides
     */
    public function getSlidesCountByFeatured(int $featured, int $catalogueId): int
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('featured', $featured)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get slides for carousel
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @return array Slides for carousel
     */
    public function getSlidesForCarousel(int $catalogueId, int $limit = 5): array
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('status', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get slides for banner
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @return array Slides for banner
     */
    public function getSlidesForBanner(int $catalogueId, int $limit = 3): array
    {
        return $this->where('slide_catalogue_id', $catalogueId)
                    ->where('featured', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get slides for dropdown
     * 
     * @param int $catalogueId Catalogue ID
     * @return array Slides for dropdown
     */
    public function getSlidesForDropdown(int $catalogueId): array
    {
        return $this->select('id, title, order')
                    ->where('slide_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->findAll();
    }

    /**
     * Reorder slides
     * 
     * @param array $slideIds Array of slide IDs in new order
     * @return bool Reorder success
     */
    public function reorderSlides(array $slideIds): bool
    {
        $success = true;
        
        foreach ($slideIds as $order => $slideId) {
            if (!$this->update($slideId, ['order' => $order + 1])) {
                $success = false;
            }
        }
        
        return $success;
    }
}
