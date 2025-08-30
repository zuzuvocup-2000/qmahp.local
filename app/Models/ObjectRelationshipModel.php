<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * ObjectRelationshipModel - Manages object relationships and associations
 * 
 * This model handles relationships between different objects in the system,
 * including many-to-many relationships and cross-references.
 * 
 * @package App\Models
 * @author System
 */
class ObjectRelationshipModel extends Model
{
    protected $table = 'object_relationship';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'object_id',
        'object_type',
        'related_object_id',
        'related_object_type',
        'relationship_type',
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
        'object_id' => 'required|integer',
        'object_type' => 'required|max_length[100]',
        'related_object_id' => 'required|integer',
        'related_object_type' => 'required|max_length[100]',
        'relationship_type' => 'permit_empty|max_length[100]',
        'sort_order' => 'permit_empty|integer',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'object_id' => [
            'required' => 'Object ID is required',
            'integer' => 'Object ID must be a valid integer'
        ],
        'object_type' => [
            'required' => 'Object type is required',
            'max_length' => 'Object type cannot exceed 100 characters'
        ],
        'related_object_id' => [
            'required' => 'Related object ID is required',
            'integer' => 'Related object ID must be a valid integer'
        ],
        'related_object_type' => [
            'required' => 'Related object type is required',
            'max_length' => 'Related object type cannot exceed 100 characters'
        ],
        'relationship_type' => [
            'max_length' => 'Relationship type cannot exceed 100 characters'
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
     * Get relationships by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The relationships
     */
    public function getRelationshipsByObject(int $objectId, string $objectType, int $limit = 0, int $offset = 0): array
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
     * Get relationships by related object
     * 
     * @param int $relatedObjectId The related object ID
     * @param string $relatedObjectType The related object type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The relationships
     */
    public function getRelationshipsByRelatedObject(int $relatedObjectId, string $relatedObjectType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('related_object_id', $relatedObjectId)
                        ->where('related_object_type', $relatedObjectType)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get relationships by type
     * 
     * @param string $relationshipType The relationship type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The relationships
     */
    public function getRelationshipsByType(string $relationshipType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('relationship_type', $relationshipType)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Check if relationship exists
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $relatedObjectId The related object ID
     * @param string $relatedObjectType The related object type
     * @return bool True if exists, false otherwise
     */
    public function isRelationshipExists(int $objectId, string $objectType, int $relatedObjectId, string $relatedObjectType): bool
    {
        return $this->where('object_id', $objectId)
                    ->where('object_type', $objectType)
                    ->where('related_object_id', $relatedObjectId)
                    ->where('related_object_type', $relatedObjectType)
                    ->where('publish', 1)
                    ->countAllResults() > 0;
    }

    /**
     * Get relationship count by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return int The relationship count
     */
    public function getRelationshipCountByObject(int $objectId, string $objectType): int
    {
        return $this->where('object_id', $objectId)
                    ->where('object_type', $objectType)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get relationship count by related object
     * 
     * @param int $relatedObjectId The related object ID
     * @param string $relatedObjectType The related object type
     * @return int The relationship count
     */
    public function getRelationshipCountByRelatedObject(int $relatedObjectId, string $relatedObjectType): int
    {
        return $this->where('related_object_id', $relatedObjectId)
                    ->where('related_object_type', $relatedObjectType)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get relationships with object details
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @return array The relationships with object details
     */
    public function getRelationshipsWithObjectDetails(int $objectId, string $objectType, int $limit = 0): array
    {
        $builder = $this->select('object_relationship.*, related_objects.title as related_title, related_objects.canonical as related_canonical')
                        ->join($objectType . 's as related_objects', 'related_objects.id = object_relationship.related_object_id', 'left')
                        ->where('object_relationship.object_id', $objectId)
                        ->where('object_relationship.object_type', $objectType)
                        ->where('object_relationship.publish', 1)
                        ->orderBy('object_relationship.sort_order', 'ASC')
                        ->orderBy('object_relationship.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get relationships with related object details
     * 
     * @param int $relatedObjectId The related object ID
     * @param string $relatedObjectType The related object type
     * @param int $limit The limit of results
     * @return array The relationships with object details
     */
    public function getRelationshipsWithRelatedObjectDetails(int $relatedObjectId, string $relatedObjectType, int $limit = 0): array
    {
        $builder = $this->select('object_relationship.*, objects.title as object_title, objects.canonical as object_canonical')
                        ->join($relatedObjectType . 's as objects', 'objects.id = object_relationship.object_id', 'left')
                        ->where('object_relationship.related_object_id', $relatedObjectId)
                        ->where('object_relationship.related_object_type', $relatedObjectType)
                        ->where('object_relationship.publish', 1)
                        ->orderBy('object_relationship.sort_order', 'ASC')
                        ->orderBy('object_relationship.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Search relationships
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchRelationships(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->groupStart()
                            ->like('object_type', $keyword)
                            ->orLike('related_object_type', $keyword)
                            ->orLike('relationship_type', $keyword)
                        ->groupEnd()
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get relationship statistics
     * 
     * @return array The relationship statistics
     */
    public function getRelationshipStatistics(): array
    {
        return [
            'total' => $this->countAllResults(),
            'published' => $this->where('publish', 1)->countAllResults(),
            'unpublished' => $this->where('publish', 0)->countAllResults(),
            'by_type' => $this->select('relationship_type, COUNT(*) as count')
                              ->where('publish', 1)
                              ->groupBy('relationship_type')
                              ->findAll()
        ];
    }

    /**
     * Get available relationship types
     * 
     * @return array The available relationship types
     */
    public function getAvailableRelationshipTypes(): array
    {
        return $this->select('DISTINCT(relationship_type) as relationship_type')
                    ->where('publish', 1)
                    ->where('relationship_type IS NOT NULL')
                    ->where('relationship_type !=', '')
                    ->orderBy('relationship_type', 'ASC')
                    ->findAll();
    }

    /**
     * Get available object types
     * 
     * @return array The available object types
     */
    public function getAvailableObjectTypes(): array
    {
        $objectTypes = $this->select('DISTINCT(object_type) as object_type')
                            ->where('publish', 1)
                            ->where('object_type IS NOT NULL')
                            ->where('object_type !=', '')
                            ->findAll();
        
        $relatedObjectTypes = $this->select('DISTINCT(related_object_type) as object_type')
                                   ->where('publish', 1)
                                   ->where('related_object_type IS NOT NULL')
                                   ->where('related_object_type !=', '')
                                   ->findAll();
        
        $allTypes = array_merge($objectTypes, $relatedObjectTypes);
        $uniqueTypes = [];
        
        foreach ($allTypes as $type) {
            $uniqueTypes[$type['object_type']] = $type['object_type'];
        }
        
        return array_values($uniqueTypes);
    }

    /**
     * Delete relationships by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return bool True if successful, false otherwise
     */
    public function deleteRelationshipsByObject(int $objectId, string $objectType): bool
    {
        return $this->where('object_id', $objectId)
                    ->where('object_type', $objectType)
                    ->delete();
    }

    /**
     * Delete relationships by related object
     * 
     * @param int $relatedObjectId The related object ID
     * @param string $relatedObjectType The related object type
     * @return bool True if successful, false otherwise
     */
    public function deleteRelationshipsByRelatedObject(int $relatedObjectId, string $relatedObjectType): bool
    {
        return $this->where('related_object_id', $relatedObjectId)
                    ->where('related_object_type', $relatedObjectType)
                    ->delete();
    }
}
