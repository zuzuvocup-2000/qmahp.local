<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * TagModel - Manages tags and labels
 * 
 * This model handles tags for categorizing and organizing
 * various content types including products, articles, and files.
 * 
 * @package App\Models
 * @author System
 */
class TagModel extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'name',
        'slug',
        'canonical',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'image',
        'color',
        'icon',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sort_order',
        'usage_count',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'slug' => 'required|max_length[255]|is_unique[tag.slug,id,{id}]',
        'canonical' => 'permit_empty|max_length[500]',
        'description' => 'permit_empty|max_length[1000]',
        'meta_title' => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'meta_keyword' => 'permit_empty|max_length[500]',
        'image' => 'permit_empty|max_length[500]',
        'color' => 'permit_empty|max_length[20]',
        'icon' => 'permit_empty|max_length[100]',
        'status' => 'permit_empty|in_list[0,1,2]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
        'usage_count' => 'permit_empty|integer|greater_than_equal_to[0]',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Tag name is required',
            'max_length' => 'Tag name cannot exceed 255 characters'
        ],
        'slug' => [
            'required' => 'Tag slug is required',
            'max_length' => 'Tag slug cannot exceed 255 characters',
            'is_unique' => 'Tag slug must be unique'
        ],
        'canonical' => [
            'max_length' => 'Canonical URL cannot exceed 500 characters'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 1000 characters'
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
        'image' => [
            'max_length' => 'Image path cannot exceed 500 characters'
        ],
        'color' => [
            'max_length' => 'Color cannot exceed 20 characters'
        ],
        'icon' => [
            'max_length' => 'Icon cannot exceed 100 characters'
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
        'usage_count' => [
            'integer' => 'Usage count must be a valid integer',
            'greater_than_equal_to' => 'Usage count must be greater than or equal to 0'
        ],
        'userid_created' => [
            'integer' => 'User ID created must be a valid integer'
        ],
        'userid_updated' => [
            'integer' => 'User ID updated must be a valid integer'
        ]
    ];

    /**
     * Get tag by slug
     * 
     * @param string $slug The tag slug
     * @return array|null The tag or null if not found
     */
    public function getTagBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get tag by canonical
     * 
     * @param string $canonical The canonical URL
     * @return array|null The tag or null if not found
     */
    public function getTagByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get tags by status
     * 
     * @param int $status The tag status (0=inactive, 1=active, 2=archived)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tags
     */
    public function getTagsByStatus(int $status, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('status', $status)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get active tags
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The active tags
     */
    public function getActiveTags(int $limit = 0, int $offset = 0): array
    {
        return $this->getTagsByStatus(1, $limit, $offset);
    }

    /**
     * Get inactive tags
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The inactive tags
     */
    public function getInactiveTags(int $limit = 0, int $offset = 0): array
    {
        return $this->getTagsByStatus(0, $limit, $offset);
    }

    /**
     * Get archived tags
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The archived tags
     */
    public function getArchivedTags(int $limit = 0, int $offset = 0): array
    {
        return $this->getTagsByStatus(2, $limit, $offset);
    }

    /**
     * Get featured tags
     * 
     * @param int $limit The limit of results
     * @return array The featured tags
     */
    public function getFeaturedTags(int $limit = 10): array
    {
        return $this->where('featured', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get hot tags
     * 
     * @param int $limit The limit of results
     * @return array The hot tags
     */
    public function getHotTags(int $limit = 10): array
    {
        return $this->where('hot', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get new tags
     * 
     * @param int $limit The limit of results
     * @return array The new tags
     */
    public function getNewTags(int $limit = 10): array
    {
        return $this->where('new', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get most used tags
     * 
     * @param int $limit The limit of results
     * @return array The most used tags
     */
    public function getMostUsedTags(int $limit = 20): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('usage_count', 'DESC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get tags by usage count range
     * 
     * @param int $minCount The minimum usage count
     * @param int $maxCount The maximum usage count
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tags in usage count range
     */
    public function getTagsByUsageCountRange(int $minCount, int $maxCount, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('usage_count >=', $minCount)
                        ->where('usage_count <=', $maxCount)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('usage_count', 'DESC')
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tags by color
     * 
     * @param string $color The color to filter by
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tags with the specified color
     */
    public function getTagsByColor(string $color, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('color', $color)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tags by icon
     * 
     * @param string $icon The icon to filter by
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tags with the specified icon
     */
    public function getTagsByIcon(string $icon, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('icon', $icon)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get available colors
     * 
     * @return array The available colors
     */
    public function getAvailableColors(): array
    {
        return $this->select('color, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('color IS NOT NULL')
                    ->where('color !=', '')
                    ->groupBy('color')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Get available icons
     * 
     * @return array The available icons
     */
    public function getAvailableIcons(): array
    {
        return $this->select('icon, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('icon IS NOT NULL')
                    ->where('icon !=', '')
                    ->groupBy('icon')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Search tags by name or description
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchTags(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->groupStart()
                            ->like('name', $keyword)
                            ->orLike('description', $keyword)
                            ->orLike('meta_keyword', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tags by sort order
     * 
     * @param string $direction The sort direction (ASC or DESC)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The sorted tags
     */
    public function getTagsBySortOrder(string $direction = 'ASC', int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', $direction)
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tags by date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @return array The tags in date range
     */
    public function getTagsByDateRange(string $startDate, string $endDate, int $limit = 0): array
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
     * Get recent tags
     * 
     * @param int $limit The limit of results
     * @return array The recent tags
     */
    public function getRecentTags(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get tag count by status
     * 
     * @return array The counts by status
     */
    public function getTagCounts(): array
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
            'with_color' => $this->where('color IS NOT NULL')->where('color !=', '')->where('publish', 1)->where('status', 1)->countAllResults(),
            'with_icon' => $this->where('icon IS NOT NULL')->where('icon !=', '')->where('publish', 1)->where('status', 1)->countAllResults()
        ];
    }

    /**
     * Get tag usage statistics
     * 
     * @return array The tag usage statistics
     */
    public function getTagUsageStatistics(): array
    {
        $result = $this->select('COUNT(*) as total_tags, SUM(usage_count) as total_usage, AVG(usage_count) as avg_usage, MIN(usage_count) as min_usage, MAX(usage_count) as max_usage')
                       ->where('publish', 1)
                       ->where('status', 1)
                       ->first();

        return $result ?: [
            'total_tags' => 0,
            'total_usage' => 0,
            'avg_usage' => 0,
            'min_usage' => 0,
            'max_usage' => 0
        ];
    }

    /**
     * Get popular tags
     * 
     * @param int $limit The limit of results
     * @return array The popular tags
     */
    public function getPopularTags(int $limit = 20): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->where('usage_count >', 0)
                    ->orderBy('usage_count', 'DESC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get unused tags
     * 
     * @param int $limit The limit of results
     * @return array The unused tags
     */
    public function getUnusedTags(int $limit = 20): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->where('usage_count', 0)
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get tags by multiple IDs
     * 
     * @param array $tagIds The tag IDs
     * @return array The tags
     */
    public function getTagsByIds(array $tagIds): array
    {
        return $this->whereIn('id', $tagIds)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    /**
     * Get tags with relationship count
     * 
     * @param int $limit The limit of results
     * @return array The tags with relationship count
     */
    public function getTagsWithRelationshipCount(int $limit = 0): array
    {
        $builder = $this->select('tag.*, COUNT(tag_relationship.id) as relationship_count')
                        ->join('tag_relationship', 'tag_relationship.tag_id = tag.id', 'left')
                        ->where('tag.publish', 1)
                        ->where('tag.status', 1)
                        ->groupBy('tag.id')
                        ->orderBy('tag.sort_order', 'ASC')
                        ->orderBy('tag.name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Increment usage count
     * 
     * @param int $tagId The tag ID
     * @return bool True if successful, false otherwise
     */
    public function incrementUsageCount(int $tagId): bool
    {
        $tag = $this->find($tagId);
        if (!$tag) {
            return false;
        }

        $usageCount = $tag['usage_count'] ?? 0;
        return $this->update($tagId, ['usage_count' => $usageCount + 1]);
    }

    /**
     * Decrement usage count
     * 
     * @param int $tagId The tag ID
     * @return bool True if successful, false otherwise
     */
    public function decrementUsageCount(int $tagId): bool
    {
        $tag = $this->find($tagId);
        if (!$tag) {
            return false;
        }

        $usageCount = $tag['usage_count'] ?? 0;
        $newCount = max(0, $usageCount - 1);
        return $this->update($tagId, ['usage_count' => $newCount]);
    }

    /**
     * Get tags for autocomplete
     * 
     * @param string $query The search query
     * @param int $limit The limit of results
     * @return array The tags for autocomplete
     */
    public function getTagsForAutocomplete(string $query, int $limit = 10): array
    {
        return $this->select('id, name, slug, usage_count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->like('name', $query)
                    ->orderBy('usage_count', 'DESC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }
}
