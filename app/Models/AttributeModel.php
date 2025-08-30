<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * AttributeModel - Manages product attributes and specifications
 * 
 * This model handles product attributes, specifications, and their values
 * for comprehensive product management and filtering.
 * 
 * @package App\Models
 * @author System
 */
class AttributeModel extends Model
{
    protected $table = 'attribute';
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
        'description',
        'type',
        'input_type',
        'default_value',
        'is_required',
        'is_unique',
        'is_filterable',
        'is_searchable',
        'is_comparable',
        'is_visible',
        'is_editable',
        'validation_rules',
        'options',
        'sort_order',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'slug' => 'required|max_length[255]|is_unique[attribute.slug,id,{id}]',
        'description' => 'permit_empty|max_length[1000]',
        'type' => 'required|max_length[100]',
        'input_type' => 'required|max_length[100]',
        'default_value' => 'permit_empty|max_length[500]',
        'is_required' => 'permit_empty|in_list[0,1]',
        'is_unique' => 'permit_empty|in_list[0,1]',
        'is_filterable' => 'permit_empty|in_list[0,1]',
        'is_searchable' => 'permit_empty|in_list[0,1]',
        'is_comparable' => 'permit_empty|in_list[0,1]',
        'is_visible' => 'permit_empty|in_list[0,1]',
        'is_editable' => 'permit_empty|in_list[0,1]',
        'validation_rules' => 'permit_empty|max_length[500]',
        'options' => 'permit_empty',
        'sort_order' => 'permit_empty|integer',
        'status' => 'permit_empty|in_list[0,1,2]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Attribute name is required',
            'max_length' => 'Attribute name cannot exceed 255 characters'
        ],
        'slug' => [
            'required' => 'Attribute slug is required',
            'max_length' => 'Attribute slug cannot exceed 255 characters',
            'is_unique' => 'Attribute slug must be unique'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 1000 characters'
        ],
        'type' => [
            'required' => 'Attribute type is required',
            'max_length' => 'Attribute type cannot exceed 100 characters'
        ],
        'input_type' => [
            'required' => 'Input type is required',
            'max_length' => 'Input type cannot exceed 100 characters'
        ],
        'default_value' => [
            'max_length' => 'Default value cannot exceed 500 characters'
        ],
        'is_required' => [
            'in_list' => 'Is required must be either 0 or 1'
        ],
        'is_unique' => [
            'in_list' => 'Is unique must be either 0 or 1'
        ],
        'is_filterable' => [
            'in_list' => 'Is filterable must be either 0 or 1'
        ],
        'is_searchable' => [
            'in_list' => 'Is searchable must be either 0 or 1'
        ],
        'is_comparable' => [
            'in_list' => 'Is comparable must be either 0 or 1'
        ],
        'is_visible' => [
            'in_list' => 'Is visible must be either 0 or 1'
        ],
        'is_editable' => [
            'in_list' => 'Is editable must be either 0 or 1'
        ],
        'validation_rules' => [
            'max_length' => 'Validation rules cannot exceed 500 characters'
        ],
        'sort_order' => [
            'integer' => 'Sort order must be a valid integer'
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
        'userid_created' => [
            'integer' => 'User ID created must be a valid integer'
        ],
        'userid_updated' => [
            'integer' => 'User ID updated must be a valid integer'
        ]
    ];

    /**
     * Get attribute by slug
     * 
     * @param string $slug The attribute slug
     * @return array|null The attribute or null if not found
     */
    public function getAttributeBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get attributes by type
     * 
     * @param string $type The attribute type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attributes
     */
    public function getAttributesByType(string $type, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('type', $type)
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
     * Get attributes by input type
     * 
     * @param string $inputType The input type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attributes
     */
    public function getAttributesByInputType(string $inputType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('input_type', $inputType)
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
     * Get filterable attributes
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The filterable attributes
     */
    public function getFilterableAttributes(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('is_filterable', 1)
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
     * Get searchable attributes
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The searchable attributes
     */
    public function getSearchableAttributes(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('is_searchable', 1)
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
     * Get comparable attributes
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The comparable attributes
     */
    public function getComparableAttributes(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('is_comparable', 1)
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
     * Get visible attributes
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The visible attributes
     */
    public function getVisibleAttributes(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('is_visible', 1)
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
     * Get required attributes
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The required attributes
     */
    public function getRequiredAttributes(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('is_required', 1)
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
     * Get attributes by status
     * 
     * @param int $status The attribute status (0=inactive, 1=active, 2=archived)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attributes
     */
    public function getAttributesByStatus(int $status, int $limit = 0, int $offset = 0): array
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
     * Get active attributes
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The active attributes
     */
    public function getActiveAttributes(int $limit = 0, int $offset = 0): array
    {
        return $this->getAttributesByStatus(1, $limit, $offset);
    }

    /**
     * Get inactive attributes
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The inactive attributes
     */
    public function getInactiveAttributes(int $limit = 0, int $offset = 0): array
    {
        return $this->getAttributesByStatus(0, $limit, $offset);
    }

    /**
     * Get archived attributes
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The archived attributes
     */
    public function getArchivedAttributes(int $limit = 0, int $offset = 0): array
    {
        return $this->getAttributesByStatus(2, $limit, $offset);
    }

    /**
     * Get featured attributes
     * 
     * @param int $limit The limit of results
     * @return array The featured attributes
     */
    public function getFeaturedAttributes(int $limit = 10): array
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
     * Get hot attributes
     * 
     * @param int $limit The limit of results
     * @return array The hot attributes
     */
    public function getHotAttributes(int $limit = 10): array
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
     * Get new attributes
     * 
     * @param int $limit The limit of results
     * @return array The new attributes
     */
    public function getNewAttributes(int $limit = 10): array
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
     * Get available attribute types
     * 
     * @return array The available attribute types
     */
    public function getAvailableAttributeTypes(): array
    {
        return $this->select('type, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('type IS NOT NULL')
                    ->where('type !=', '')
                    ->groupBy('type')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Get available input types
     * 
     * @return array The available input types
     */
    public function getAvailableInputTypes(): array
    {
        return $this->select('input_type, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('input_type IS NOT NULL')
                    ->where('input_type !=', '')
                    ->groupBy('input_type')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Search attributes by name or description
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchAttributes(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->groupStart()
                            ->like('name', $keyword)
                            ->orLike('description', $keyword)
                            ->orLike('type', $keyword)
                            ->orLike('input_type', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attributes by sort order
     * 
     * @param string $direction The sort direction (ASC or DESC)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The sorted attributes
     */
    public function getAttributesBySortOrder(string $direction = 'ASC', int $limit = 0, int $offset = 0): array
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
     * Get attributes with options
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attributes with options
     */
    public function getAttributesWithOptions(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->where('options IS NOT NULL')
                        ->where('options !=', '')
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attributes by validation rules
     * 
     * @param string $rule The validation rule to search for
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attributes with the specified validation rule
     */
    public function getAttributesByValidationRule(string $rule, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->like('validation_rules', $rule)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute count by type
     * 
     * @param string $type The attribute type
     * @return int The attribute count
     */
    public function getAttributeCountByType(string $type): int
    {
        return $this->where('type', $type)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get attribute count by input type
     * 
     * @param string $inputType The input type
     * @return int The attribute count
     */
    public function getAttributeCountByInputType(string $inputType): int
    {
        return $this->where('input_type', $inputType)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get attribute count by status
     * 
     * @return array The counts by status
     */
    public function getAttributeCounts(): array
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
            'filterable' => $this->where('is_filterable', 1)->where('publish', 1)->where('status', 1)->countAllResults(),
            'searchable' => $this->where('is_searchable', 1)->where('publish', 1)->where('status', 1)->countAllResults(),
            'comparable' => $this->where('is_comparable', 1)->where('publish', 1)->where('status', 1)->countAllResults(),
            'visible' => $this->where('is_visible', 1)->where('publish', 1)->where('status', 1)->countAllResults(),
            'required' => $this->where('is_required', 1)->where('publish', 1)->where('status', 1)->countAllResults()
        ];
    }

    /**
     * Get attributes by date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @return array The attributes in date range
     */
    public function getAttributesByDateRange(string $startDate, string $endDate, int $limit = 0): array
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
     * Get recent attributes
     * 
     * @param int $limit The limit of results
     * @return array The recent attributes
     */
    public function getRecentAttributes(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get attributes by feature flags
     * 
     * @param array $flags The feature flags to filter by
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attributes matching the feature flags
     */
    public function getAttributesByFeatureFlags(array $flags, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1);
        
        foreach ($flags as $flag => $value) {
            if (in_array($flag, ['is_required', 'is_unique', 'is_filterable', 'is_searchable', 'is_comparable', 'is_visible', 'is_editable'])) {
                $builder->where($flag, $value);
            }
        }
        
        $builder->orderBy('sort_order', 'ASC')
                ->orderBy('name', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attributes for product comparison
     * 
     * @param int $limit The limit of results
     * @return array The comparable attributes
     */
    public function getAttributesForComparison(int $limit = 20): array
    {
        return $this->where('is_comparable', 1)
                    ->where('is_visible', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get attributes for product filtering
     * 
     * @param int $limit The limit of results
     * @return array The filterable attributes
     */
    public function getAttributesForFiltering(int $limit = 50): array
    {
        return $this->where('is_filterable', 1)
                    ->where('is_visible', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }
}
