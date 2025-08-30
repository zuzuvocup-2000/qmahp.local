<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * LocationCatalogueModel - Manages location categories and organization
 * 
 * This model handles location categorization, organization, and hierarchical
 * structure for efficient location management and retrieval.
 * 
 * @package App\Models
 * @author System
 */
class LocationCatalogueModel extends Model
{
    protected $table = 'location_catalogue';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'title',
        'slug',
        'canonical',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'description',
        'content',
        'image',
        'parent_id',
        'level',
        'lft',
        'rgt',
        'location_type',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sort_order',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'slug' => 'required|max_length[255]|is_unique[location_catalogue.slug,id,{id}]',
        'canonical' => 'permit_empty|max_length[500]',
        'meta_title' => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'meta_keyword' => 'permit_empty|max_length[500]',
        'description' => 'permit_empty|max_length[1000]',
        'content' => 'permit_empty',
        'image' => 'permit_empty|max_length[500]',
        'parent_id' => 'permit_empty|integer',
        'level' => 'permit_empty|integer|greater_than_equal_to[0]',
        'lft' => 'permit_empty|integer|greater_than_equal_to[0]',
        'rgt' => 'permit_empty|integer|greater_than_equal_to[0]',
        'location_type' => 'permit_empty|max_length[100]',
        'status' => 'permit_empty|in_list[0,1,2]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Catalogue title is required',
            'max_length' => 'Catalogue title cannot exceed 255 characters'
        ],
        'slug' => [
            'required' => 'Catalogue slug is required',
            'max_length' => 'Catalogue slug cannot exceed 255 characters',
            'is_unique' => 'Catalogue slug must be unique'
        ],
        'canonical' => [
            'max_length' => 'Canonical URL cannot exceed 500 characters'
        ],
        'meta_title' => [
            'max_length' => 'Meta title cannot exceed 255 characters'
        ],
        'meta_description' => [
            'max_length' => 'Meta description cannot exceed 500 characters'
        ],
        'meta_keyword' => [
            'max_length' => 'Meta keywords cannot exceed 500 characters'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 1000 characters'
        ],
        'image' => [
            'max_length' => 'Image path cannot exceed 500 characters'
        ],
        'parent_id' => [
            'integer' => 'Parent ID must be a valid integer'
        ],
        'level' => [
            'integer' => 'Level must be a valid integer',
            'greater_than_equal_to' => 'Level must be greater than or equal to 0'
        ],
        'lft' => [
            'integer' => 'Left value must be a valid integer',
            'greater_than_equal_to' => 'Left value must be greater than or equal to 0'
        ],
        'rgt' => [
            'integer' => 'Right value must be a valid integer',
            'greater_than_equal_to' => 'Right value must be greater than or equal to 0'
        ],
        'location_type' => [
            'max_length' => 'Location type cannot exceed 100 characters'
        ],
        'status' => [
            'in_list' => 'Status must be either 0 (inactive), 1 (active), or 2 (archived)'
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
     * @param string $canonical The canonical URL
     * @return array|null The catalogue or null if not found
     */
    public function getCatalogueByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get catalogue by slug
     * 
     * @param string $slug The catalogue slug
     * @return array|null The catalogue or null if not found
     */
    public function getCatalogueBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get catalogue tree structure
     * 
     * @param int $parentId The parent ID (0 for root)
     * @param int $level The maximum level to retrieve
     * @return array The catalogue tree
     */
    public function getCatalogueTree(int $parentId = 0, int $level = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($parentId === 0) {
            $builder->where('parent_id IS NULL OR parent_id = 0');
        } else {
            $builder->where('parent_id', $parentId);
        }
        
        if ($level > 0) {
            $builder->where('level <=', $level);
        }
        
        $catalogues = $builder->findAll();
        $tree = [];
        
        foreach ($catalogues as $catalogue) {
            $children = $this->getCatalogueTree($catalogue['id'], $level > 0 ? $level - 1 : 0);
            if (!empty($children)) {
                $catalogue['children'] = $children;
            }
            $tree[] = $catalogue;
        }
        
        return $tree;
    }

    /**
     * Get catalogues by parent
     * 
     * @param int $parentId The parent ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The catalogues
     */
    public function getCataloguesByParent(int $parentId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('parent_id', $parentId)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get catalogues by level
     * 
     * @param int $level The catalogue level
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The catalogues
     */
    public function getCataloguesByLevel(int $level, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('level', $level)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get catalogues by location type
     * 
     * @param string $locationType The location type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The catalogues
     */
    public function getCataloguesByLocationType(string $locationType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('location_type', $locationType)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get root catalogues
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The root catalogues
     */
    public function getRootCatalogues(int $limit = 0, int $offset = 0): array
    {
        return $this->getCataloguesByParent(0, $limit, $offset);
    }

    /**
     * Get catalogues by status
     * 
     * @param int $status The catalogue status (0=inactive, 1=active, 2=archived)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The catalogues
     */
    public function getCataloguesByStatus(int $status, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('status', $status)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get active catalogues
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The active catalogues
     */
    public function getActiveCatalogues(int $limit = 0, int $offset = 0): array
    {
        return $this->getCataloguesByStatus(1, $limit, $offset);
    }

    /**
     * Get inactive catalogues
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The inactive catalogues
     */
    public function getInactiveCatalogues(int $limit = 0, int $offset = 0): array
    {
        return $this->getCataloguesByStatus(0, $limit, $offset);
    }

    /**
     * Get archived catalogues
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The archived catalogues
     */
    public function getArchivedCatalogues(int $limit = 0, int $offset = 0): array
    {
        return $this->getCataloguesByStatus(2, $limit, $offset);
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
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('title', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get hot catalogues
     * 
     * @param int $limit The limit of results
     * @return array The hot catalogues
     */
    public function getHotCatalogues(int $limit = 10): array
    {
        return $this->where('hot', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('title', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get new catalogues
     * 
     * @param int $limit The limit of results
     * @return array The new catalogues
     */
    public function getNewCatalogues(int $limit = 10): array
    {
        return $this->where('new', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('title', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get catalogues with location count
     * 
     * @param int $limit The limit of results
     * @return array The catalogues with location count
     */
    public function getCataloguesWithLocationCount(int $limit = 0): array
    {
        $builder = $this->select('location_catalogue.*, COUNT(location.id) as location_count')
                        ->join('location', 'location.location_catalogue_id = location_catalogue.id', 'left')
                        ->where('location_catalogue.publish', 1)
                        ->where('location_catalogue.status', 1)
                        ->groupBy('location_catalogue.id')
                        ->orderBy('location_catalogue.sort_order', 'ASC')
                        ->orderBy('location_catalogue.title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get catalogues by parent with location count
     * 
     * @param int $parentId The parent ID
     * @param int $limit The limit of results
     * @return array The catalogues with location count
     */
    public function getCataloguesByParentWithLocationCount(int $parentId, int $limit = 0): array
    {
        $builder = $this->select('location_catalogue.*, COUNT(location.id) as location_count')
                        ->join('location', 'location.location_catalogue_id = location_catalogue.id', 'left')
                        ->where('location_catalogue.parent_id', $parentId)
                        ->where('location_catalogue.publish', 1)
                        ->where('location_catalogue.status', 1)
                        ->groupBy('location_catalogue.id')
                        ->orderBy('location_catalogue.sort_order', 'ASC')
                        ->orderBy('location_catalogue.title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get available location types
     * 
     * @return array The available location types
     */
    public function getAvailableLocationTypes(): array
    {
        return $this->select('location_type, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('location_type IS NOT NULL')
                    ->where('location_type !=', '')
                    ->groupBy('location_type')
                    ->orderBy('count', 'DESC')
                    ->findAll();
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
                        ->where('status', 1)
                        ->groupStart()
                            ->like('title', $keyword)
                            ->orLike('description', $keyword)
                            ->orLike('content', $keyword)
                            ->orLike('meta_keyword', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get catalogue path (breadcrumb)
     * 
     * @param int $catalogueId The catalogue ID
     * @return array The catalogue path
     */
    public function getCataloguePath(int $catalogueId): array
    {
        $path = [];
        $current = $this->find($catalogueId);
        
        if (!$current) {
            return $path;
        }
        
        $path[] = $current;
        
        while ($current['parent_id'] && $current['parent_id'] > 0) {
            $current = $this->find($current['parent_id']);
            if ($current) {
                array_unshift($path, $current);
            } else {
                break;
            }
        }
        
        return $path;
    }

    /**
     * Get catalogue count by parent
     * 
     * @param int $parentId The parent ID
     * @return int The catalogue count
     */
    public function getCatalogueCountByParent(int $parentId): int
    {
        return $this->where('parent_id', $parentId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get catalogue count by level
     * 
     * @param int $level The catalogue level
     * @return int The catalogue count
     */
    public function getCatalogueCountByLevel(int $level): int
    {
        return $this->where('level', $level)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get catalogue count by location type
     * 
     * @param string $locationType The location type
     * @return int The catalogue count
     */
    public function getCatalogueCountByLocationType(string $locationType): int
    {
        return $this->where('location_type', $locationType)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
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
            'active' => $this->where('status', 1)->countAllResults(),
            'inactive' => $this->where('status', 0)->countAllResults(),
            'archived' => $this->where('status', 2)->countAllResults(),
            'featured' => $this->where('featured', 1)->where('publish', 1)->countAllResults(),
            'hot' => $this->where('hot', 1)->where('publish', 1)->countAllResults(),
            'new' => $this->where('new', 1)->where('publish', 1)->countAllResults(),
            'root' => $this->where('parent_id IS NULL OR parent_id = 0')->where('publish', 1)->where('status', 1)->countAllResults()
        ];
    }

    /**
     * Get catalogue hierarchy levels
     * 
     * @return array The hierarchy levels
     */
    public function getCatalogueHierarchyLevels(): array
    {
        return $this->select('level, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->groupBy('level')
                    ->orderBy('level', 'ASC')
                    ->findAll();
    }

    /**
     * Get catalogues by date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @return array The catalogues in date range
     */
    public function getCataloguesByDateRange(string $startDate, string $endDate, int $limit = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->where('DATE(created_at) >=', $startDate)
                        ->where('DATE(created_at) <=', $endDate)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get recent catalogues
     * 
     * @param int $limit The limit of results
     * @return array The recent catalogues
     */
    public function getRecentCatalogues(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get catalogues by sort order
     * 
     * @param string $direction The sort direction (ASC or DESC)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The sorted catalogues
     */
    public function getCataloguesBySortOrder(string $direction = 'ASC', int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', $direction)
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get catalogues by location type with count
     * 
     * @param string $locationType The location type
     * @param int $limit The limit of results
     * @return array The catalogues with location count
     */
    public function getCataloguesByLocationTypeWithCount(string $locationType, int $limit = 0): array
    {
        $builder = $this->select('location_catalogue.*, COUNT(location.id) as location_count')
                        ->join('location', 'location.location_catalogue_id = location_catalogue.id', 'left')
                        ->where('location_catalogue.location_type', $locationType)
                        ->where('location_catalogue.publish', 1)
                        ->where('location_catalogue.status', 1)
                        ->groupBy('location_catalogue.id')
                        ->orderBy('location_catalogue.sort_order', 'ASC')
                        ->orderBy('location_catalogue.title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }
}
