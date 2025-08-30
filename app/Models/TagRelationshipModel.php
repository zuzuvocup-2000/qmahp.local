<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * TagRelationshipModel - Manages tag relationships and associations
 * 
 * This model handles relationships between tags and various objects,
 * including many-to-many tag associations and tag clouds.
 * 
 * @package App\Models
 * @author System
 */
class TagRelationshipModel extends Model
{
    protected $table = 'tag_relationship';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'tag_id',
        'object_id',
        'object_type',
        'sort_order',
        'status',
        'publish',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'tag_id' => 'required|integer',
        'object_id' => 'required|integer',
        'object_type' => 'required|max_length[100]',
        'sort_order' => 'permit_empty|integer',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'tag_id' => [
            'required' => 'Tag ID is required',
            'integer' => 'Tag ID must be a valid integer'
        ],
        'object_id' => [
            'required' => 'Object ID is required',
            'integer' => 'Object ID must be a valid integer'
        ],
        'object_type' => [
            'required' => 'Object type is required',
            'max_length' => 'Object type cannot exceed 100 characters'
        ],
        'sort_order' => [
            'integer' => 'Sort order must be a valid integer'
        ],
        'status' => [
            'in_list' => 'Status must be either 0 or 1'
        ],
        'publish' => [
            'in_list' => 'Publish must be either 0 or 1'
        ],
        'userid_created' => [
            'integer' => 'User ID created must be a valid integer'
        ],
        'userid_updated' => [
            'integer' => 'User ID updated must be a valid integer'
        ]
    ];

    /**
     * Get tag relationships by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tag relationships
     */
    public function getTagRelationshipsByObject(int $objectId, string $objectType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('object_id', $objectId)
                        ->where('object_type', $objectType)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tag relationships by tag
     * 
     * @param int $tagId The tag ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tag relationships
     */
    public function getTagRelationshipsByTag(int $tagId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('tag_id', $tagId)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tag relationships by object type
     * 
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tag relationships
     */
    public function getTagRelationshipsByObjectType(string $objectType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('object_type', $objectType)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Check if tag relationship exists
     * 
     * @param int $tagId The tag ID
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return bool True if exists, false otherwise
     */
    public function isTagRelationshipExists(int $tagId, int $objectId, string $objectType): bool
    {
        return $this->where('tag_id', $tagId)
                    ->where('object_id', $objectId)
                    ->where('object_type', $objectType)
                    ->where('publish', 1)
                    ->countAllResults() > 0;
    }

    /**
     * Get tag count by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return int The tag count
     */
    public function getTagCountByObject(int $objectId, string $objectType): int
    {
        return $this->where('object_id', $objectId)
                    ->where('object_type', $objectType)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get object count by tag
     * 
     * @param int $tagId The tag ID
     * @return int The object count
     */
    public function getObjectCountByTag(int $tagId): int
    {
        return $this->where('tag_id', $tagId)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get tag relationships with tag details
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @return array The tag relationships with tag details
     */
    public function getTagRelationshipsWithTagDetails(int $objectId, string $objectType, int $limit = 0): array
    {
        $builder = $this->select('tag_relationship.*, tags.title as tag_title, tags.canonical as tag_canonical, tags.color as tag_color')
                        ->join('tags', 'tags.id = tag_relationship.tag_id', 'left')
                        ->where('tag_relationship.object_id', $objectId)
                        ->where('tag_relationship.object_type', $objectType)
                        ->where('tag_relationship.publish', 1)
                        ->orderBy('tag_relationship.sort_order', 'ASC')
                        ->orderBy('tag_relationship.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tag relationships with object details
     * 
     * @param int $tagId The tag ID
     * @param int $limit The limit of results
     * @return array The tag relationships with object details
     */
    public function getTagRelationshipsWithObjectDetails(int $tagId, int $limit = 0): array
    {
        $builder = $this->select('tag_relationship.*, objects.title as object_title, objects.canonical as object_canonical')
                        ->join('objects', 'objects.id = tag_relationship.object_id', 'left')
                        ->where('tag_relationship.tag_id', $tagId)
                        ->where('tag_relationship.publish', 1)
                        ->orderBy('tag_relationship.sort_order', 'ASC')
                        ->orderBy('tag_relationship.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get popular tags by object type
     * 
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @return array The popular tags
     */
    public function getPopularTagsByObjectType(string $objectType, int $limit = 10): array
    {
        return $this->select('tag_relationship.tag_id, COUNT(*) as usage_count, tags.title as tag_title, tags.canonical as tag_canonical')
                    ->join('tags', 'tags.id = tag_relationship.tag_id', 'left')
                    ->where('tag_relationship.object_type', $objectType)
                    ->where('tag_relationship.publish', 1)
                    ->groupBy('tag_relationship.tag_id')
                    ->orderBy('usage_count', 'DESC')
                    ->orderBy('tags.title', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get tag cloud by object type
     * 
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @return array The tag cloud
     */
    public function getTagCloudByObjectType(string $objectType, int $limit = 20): array
    {
        return $this->select('tag_relationship.tag_id, COUNT(*) as usage_count, tags.title as tag_title, tags.canonical as tag_canonical, tags.color as tag_color')
                    ->join('tags', 'tags.id = tag_relationship.tag_id', 'left')
                    ->where('tag_relationship.object_type', $objectType)
                    ->where('tag_relationship.publish', 1)
                    ->groupBy('tag_relationship.tag_id')
                    ->having('usage_count >', 0)
                    ->orderBy('usage_count', 'DESC')
                    ->orderBy('tags.title', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Search tag relationships
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchTagRelationships(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->groupStart()
                            ->like('object_type', $keyword)
                        ->groupEnd()
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tag relationship statistics
     * 
     * @return array The tag relationship statistics
     */
    public function getTagRelationshipStatistics(): array
    {
        return [
            'total' => $this->countAllResults(),
            'published' => $this->where('publish', 1)->countAllResults(),
            'unpublished' => $this->where('publish', 0)->countAllResults(),
            'by_object_type' => $this->select('object_type, COUNT(*) as count')
                                     ->where('publish', 1)
                                     ->groupBy('object_type')
                                     ->findAll()
        ];
    }

    /**
     * Get available object types
     * 
     * @return array The available object types
     */
    public function getAvailableObjectTypes(): array
    {
        return $this->select('DISTINCT(object_type) as object_type')
                    ->where('publish', 1)
                    ->where('object_type IS NOT NULL')
                    ->where('object_type !=', '')
                    ->orderBy('object_type', 'ASC')
                    ->findAll();
    }

    /**
     * Delete tag relationships by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return bool True if successful, false otherwise
     */
    public function deleteTagRelationshipsByObject(int $objectId, string $objectType): bool
    {
        return $this->where('object_id', $objectId)
                    ->where('object_type', $objectType)
                    ->delete();
    }

    /**
     * Delete tag relationships by tag
     * 
     * @param int $tagId The tag ID
     * @return bool True if successful, false otherwise
     */
    public function deleteTagRelationshipsByTag(int $tagId): bool
    {
        return $this->where('tag_id', $tagId)
                    ->delete();
    }

    /**
     * Get related objects by tag
     * 
     * @param int $tagId The tag ID
     * @param string $objectType The object type to filter by
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The related objects
     */
    public function getRelatedObjectsByTag(int $tagId, ?string $objectType = null, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->select('tag_relationship.object_id, tag_relationship.object_type, COUNT(*) as tag_count')
                        ->where('tag_relationship.tag_id', $tagId)
                        ->where('tag_relationship.publish', 1);
        
        if ($objectType !== null) {
            $builder->where('tag_relationship.object_type', $objectType);
        }
        
        $builder->groupBy('tag_relationship.object_id, tag_relationship.object_type')
                ->orderBy('tag_count', 'DESC')
                ->orderBy('tag_relationship.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get similar objects by tags
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @return array The similar objects
     */
    public function getSimilarObjectsByTags(int $objectId, string $objectType, int $limit = 10): array
    {
        // Get tags for the current object
        $currentTags = $this->select('tag_id')
                           ->where('object_id', $objectId)
                           ->where('object_type', $objectType)
                           ->where('publish', 1)
                           ->findAll();
        
        if (empty($currentTags)) {
            return [];
        }
        
        $tagIds = array_column($currentTags, 'tag_id');
        
        // Find objects with similar tags
        return $this->select('tag_relationship.object_id, tag_relationship.object_type, COUNT(*) as common_tags')
                    ->whereIn('tag_relationship.tag_id', $tagIds)
                    ->where('tag_relationship.publish', 1)
                    ->where('tag_relationship.object_id !=', $objectId)
                    ->groupBy('tag_relationship.object_id, tag_relationship.object_type')
                    ->having('common_tags >', 0)
                    ->orderBy('common_tags', 'DESC')
                    ->orderBy('tag_relationship.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
