<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * SlideCatalogueModel - Manages slide categories and classifications
 * 
 * This model handles slide catalogues including banner organization,
 * hierarchical structures, and relationship management with slides.
 * 
 * @package App\Models
 * @author System
 */
class SlideCatalogueModel extends Model
{
    protected $table = 'slide_catalogue';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'title',
        'canonical',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'parent_id',
        'lft',
        'rgt',
        'level',
        'image',
        'icon',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sort_order',
        'slide_type',
        'position',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'canonical' => 'required|min_length[3]|max_length[255]|is_unique[slide_catalogue.canonical,id,{id}]',
        'description' => 'permit_empty|max_length[500]',
        'content' => 'permit_empty',
        'meta_title' => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'meta_keyword' => 'permit_empty|max_length[500]',
        'parent_id' => 'permit_empty|integer',
        'lft' => 'permit_empty|integer',
        'rgt' => 'permit_empty|integer',
        'level' => 'permit_empty|integer',
        'image' => 'permit_empty|max_length[255]',
        'icon' => 'permit_empty|max_length[255]',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
        'slide_type' => 'permit_empty|max_length[100]',
        'position' => 'permit_empty|max_length[100]',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Title is required',
            'min_length' => 'Title must be at least 3 characters long',
            'max_length' => 'Title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Canonical is required',
            'min_length' => 'Canonical must be at least 3 characters long',
            'max_length' => 'Canonical cannot exceed 255 characters',
            'is_unique' => 'Canonical already exists'
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
        'parent_id' => [
            'integer' => 'Parent ID must be a valid integer'
        ],
        'lft' => [
            'integer' => 'Left value must be a valid integer'
        ],
        'rgt' => [
            'integer' => 'Right value must be a valid integer'
        ],
        'level' => [
            'integer' => 'Level must be a valid integer'
        ],
        'image' => [
            'max_length' => 'Image path cannot exceed 255 characters'
        ],
        'icon' => [
            'max_length' => 'Icon path cannot exceed 255 characters'
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
        'hot' => [
            'in_list' => 'Hot must be either 0 or 1'
        ],
        'new' => [
            'in_list' => 'New must be either 0 or 1'
        ],
        'sort_order' => [
            'integer' => 'Sort order must be a valid integer'
        ],
        'slide_type' => [
            'max_length' => 'Slide type cannot exceed 100 characters'
        ],
        'position' => [
            'max_length' => 'Position cannot exceed 100 characters'
        ],
        'userid_created' => [
            'integer' => 'User ID created must be a valid integer'
        ],
        'userid_updated' => [
            'integer' => 'User ID updated must be a valid integer'
        ]
    ];

    /**
     * Get catalogue by canonical
     * 
     * @param string $canonical The canonical string
     * @return array|null The catalogue data or null if not found
     */
    public function getCatalogueByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get catalogues by parent ID
     * 
     * @param int|null $parentId The parent ID (null for root level)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The catalogues
     */
    public function getCataloguesByParent(?int $parentId = null, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1);
        
        if ($parentId === null) {
            $builder->where('parent_id IS NULL');
        } else {
            $builder->where('parent_id', $parentId);
        }
        
        $builder->orderBy('sort_order', 'ASC')
                ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get catalogue tree structure
     * 
     * @param int|null $parentId The parent ID to start from
     * @return array The catalogue tree
     */
    public function getCatalogueTree(?int $parentId = null): array
    {
        $catalogues = $this->getCataloguesByParent($parentId);
        $tree = [];
        
        foreach ($catalogues as $catalogue) {
            $children = $this->getCatalogueTree($catalogue['id']);
            if (!empty($children)) {
                $catalogue['children'] = $children;
            }
            $tree[] = $catalogue;
        }
        
        return $tree;
    }

    /**
     * Get catalogues by slide type
     * 
     * @param string $slideType The slide type to filter by
     * @param int $limit The limit of results
     * @return array The catalogues of specified slide type
     */
    public function getCataloguesBySlideType(string $slideType, int $limit = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('slide_type', $slideType)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get catalogues by position
     * 
     * @param string $position The position to filter by
     * @param int $limit The limit of results
     * @return array The catalogues at specified position
     */
    public function getCataloguesByPosition(string $position, int $limit = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('position', $position)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get featured catalogues
     * 
     * @param int $limit The limit of results
     * @return array The featured catalogues
     */
    public function getFeaturedCatalogues(int $limit = 10): array
    {
        return $this->where('featured', 1)
                    ->where('publish', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('title', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get catalogues for dropdown selection
     * 
     * @param int|null $excludeId The ID to exclude from results
     * @return array The catalogues formatted for dropdown
     */
    public function getCataloguesForDropdown(?int $excludeId = null): array
    {
        $builder = $this->select('id, title, parent_id, level, slide_type, position')
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        $catalogues = $builder->findAll();
        $dropdown = [];
        
        foreach ($catalogues as $catalogue) {
            $prefix = str_repeat('— ', $catalogue['level']);
            $suffix = '';
            if (!empty($catalogue['slide_type'])) {
                $suffix .= ' (' . $catalogue['slide_type'];
                if (!empty($catalogue['position'])) {
                    $suffix .= ' - ' . $catalogue['position'];
                }
                $suffix .= ')';
            }
            $dropdown[$catalogue['id']] = $prefix . $catalogue['title'] . $suffix;
        }
        
        return $dropdown;
    }

    /**
     * Get catalogue breadcrumb
     * 
     * @param int $catalogueId The catalogue ID
     * @return array The breadcrumb trail
     */
    public function getCatalogueBreadcrumb(int $catalogueId): array
    {
        $breadcrumb = [];
        $current = $this->find($catalogueId);
        
        if (!$current) {
            return $breadcrumb;
        }
        
        $breadcrumb[] = $current;
        
        while ($current['parent_id'] !== null) {
            $current = $this->find($current['parent_id']);
            if ($current) {
                array_unshift($breadcrumb, $current);
            } else {
                break;
            }
        }
        
        return $breadcrumb;
    }

    /**
     * Get catalogue count by status
     * 
     * @return array The counts by status
     */
    public function getCatalogueCounts(): array
    {
        return [
            'total' => $this->countAllResults(),
            'published' => $this->where('publish', 1)->countAllResults(),
            'unpublished' => $this->where('publish', 0)->countAllResults(),
            'featured' => $this->where('featured', 1)->where('publish', 1)->countAllResults(),
            'hot' => $this->where('hot', 1)->where('publish', 1)->countAllResults(),
            'new' => $this->where('new', 1)->where('publish', 1)->countAllResults()
        ];
    }

    /**
     * Check if canonical exists
     * 
     * @param string $canonical The canonical to check
     * @param int|null $excludeId The ID to exclude from check
     * @return bool True if exists, false otherwise
     */
    public function isCanonicalExists(string $canonical, ?int $excludeId = null): bool
    {
        $builder = $this->where('canonical', $canonical);
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Get catalogues by level
     * 
     * @param int $level The level to get
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The catalogues at specified level
     */
    public function getCataloguesByLevel(int $level, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('level', $level)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get catalogue siblings
     * 
     * @param int $catalogueId The catalogue ID
     * @return array The sibling catalogues
     */
    public function getCatalogueSiblings(int $catalogueId): array
    {
        $current = $this->find($catalogueId);
        if (!$current || $current['parent_id'] === null) {
            return [];
        }
        
        return $this->where('parent_id', $current['parent_id'])
                    ->where('id !=', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('title', 'ASC')
                    ->findAll();
    }

    /**
     * Get catalogues with slide count
     * 
     * @param int $limit The limit of results
     * @return array The catalogues with slide count
     */
    public function getCataloguesWithSlideCount(int $limit = 0): array
    {
        $builder = $this->select('slide_catalogue.*, COUNT(slides.id) as slide_count')
                        ->join('slides', 'slides.slide_catalogue_id = slide_catalogue.id', 'left')
                        ->where('slide_catalogue.publish', 1)
                        ->groupBy('slide_catalogue.id')
                        ->orderBy('slide_catalogue.sort_order', 'ASC')
                        ->orderBy('slide_catalogue.title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Search catalogues by title or description
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchCatalogues(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->groupStart()
                            ->like('title', $keyword)
                            ->orLike('description', $keyword)
                            ->orLike('content', $keyword)
                            ->orLike('slide_type', $keyword)
                            ->orLike('position', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get available slide types
     * 
     * @return array The available slide types
     */
    public function getAvailableSlideTypes(): array
    {
        return $this->select('DISTINCT(slide_type) as slide_type')
                    ->where('publish', 1)
                    ->where('slide_type IS NOT NULL')
                    ->where('slide_type !=', '')
                    ->orderBy('slide_type', 'ASC')
                    ->findAll();
    }

    /**
     * Get available positions
     * 
     * @return array The available positions
     */
    public function getAvailablePositions(): array
    {
        return $this->select('DISTINCT(position) as position')
                    ->where('publish', 1)
                    ->where('position IS NOT NULL')
                    ->where('position !=', '')
                    ->orderBy('position', 'ASC')
                    ->findAll();
    }
}
