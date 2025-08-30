<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * AttributeValueModel - Manages attribute values and specifications
 * 
 * This model handles the actual values for product attributes,
 * enabling detailed product specifications and filtering.
 * 
 * @package App\Models
 * @author System
 */
class AttributeValueModel extends Model
{
    protected $table = 'attribute_value';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'attribute_id',
        'product_id',
        'value',
        'value_text',
        'value_number',
        'value_decimal',
        'value_date',
        'value_boolean',
        'value_json',
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
        'attribute_id' => 'required|integer',
        'product_id' => 'required|integer',
        'value' => 'permit_empty|max_length[500]',
        'value_text' => 'permit_empty|max_length[1000]',
        'value_number' => 'permit_empty|integer',
        'value_decimal' => 'permit_empty|decimal',
        'value_date' => 'permit_empty|valid_date',
        'value_boolean' => 'permit_empty|in_list[0,1]',
        'value_json' => 'permit_empty|valid_json',
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
        'attribute_id' => [
            'required' => 'Attribute ID is required',
            'integer' => 'Attribute ID must be a valid integer'
        ],
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be a valid integer'
        ],
        'value' => [
            'max_length' => 'Value cannot exceed 500 characters'
        ],
        'value_text' => [
            'max_length' => 'Text value cannot exceed 1000 characters'
        ],
        'value_number' => [
            'integer' => 'Number value must be a valid integer'
        ],
        'value_decimal' => [
            'decimal' => 'Decimal value must be a valid decimal number'
        ],
        'value_date' => [
            'valid_date' => 'Date value must be a valid date'
        ],
        'value_boolean' => [
            'in_list' => 'Boolean value must be either 0 or 1'
        ],
        'value_json' => [
            'valid_json' => 'JSON value must be valid JSON format'
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
     * Get attribute values by product
     * 
     * @param int $productId The product ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attribute values
     */
    public function getAttributeValuesByProduct(int $productId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('product_id', $productId)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values by attribute
     * 
     * @param int $attributeId The attribute ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attribute values
     */
    public function getAttributeValuesByAttribute(int $attributeId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('attribute_id', $attributeId)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values with attribute details
     * 
     * @param int $productId The product ID
     * @param int $limit The limit of results
     * @return array The attribute values with attribute details
     */
    public function getAttributeValuesWithDetails(int $productId, int $limit = 0): array
    {
        $builder = $this->select('attribute_value.*, attribute.name as attribute_name, attribute.type as attribute_type, attribute.input_type as attribute_input_type')
                        ->join('attribute', 'attribute.id = attribute_value.attribute_id', 'left')
                        ->where('attribute_value.product_id', $productId)
                        ->where('attribute_value.publish', 1)
                        ->where('attribute_value.status', 1)
                        ->where('attribute.publish', 1)
                        ->where('attribute.status', 1)
                        ->orderBy('attribute_value.sort_order', 'ASC')
                        ->orderBy('attribute_value.created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values by value
     * 
     * @param string $value The attribute value to search for
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attribute values
     */
    public function getAttributeValuesByValue(string $value, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->groupStart()
                            ->like('value', $value)
                            ->orLike('value_text', $value)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values by numeric range
     * 
     * @param float $minValue The minimum numeric value
     * @param float $maxValue The maximum numeric value
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attribute values in range
     */
    public function getAttributeValuesByNumericRange(float $minValue, float $maxValue, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->where('value_number >=', $minValue)
                        ->where('value_number <=', $maxValue)
                        ->orderBy('value_number', 'ASC')
                        ->orderBy('sort_order', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values by decimal range
     * 
     * @param float $minValue The minimum decimal value
     * @param float $maxValue The maximum decimal value
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attribute values in range
     */
    public function getAttributeValuesByDecimalRange(float $minValue, float $maxValue, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->where('value_decimal >=', $minValue)
                        ->where('value_decimal <=', $maxValue)
                        ->orderBy('value_decimal', 'ASC')
                        ->orderBy('sort_order', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values by date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attribute values in date range
     */
    public function getAttributeValuesByDateRange(string $startDate, string $endDate, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->where('value_date >=', $startDate)
                        ->where('value_date <=', $endDate)
                        ->orderBy('value_date', 'ASC')
                        ->orderBy('sort_order', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values by boolean value
     * 
     * @param bool $value The boolean value
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attribute values
     */
    public function getAttributeValuesByBoolean(bool $value, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('value_boolean', $value ? 1 : 0)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values by status
     * 
     * @param int $status The attribute value status (0=inactive, 1=active, 2=archived)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The attribute values
     */
    public function getAttributeValuesByStatus(int $status, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('status', $status)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get active attribute values
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The active attribute values
     */
    public function getActiveAttributeValues(int $limit = 0, int $offset = 0): array
    {
        return $this->getAttributeValuesByStatus(1, $limit, $offset);
    }

    /**
     * Get inactive attribute values
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The inactive attribute values
     */
    public function getInactiveAttributeValues(int $limit = 0, int $offset = 0): array
    {
        return $this->getAttributeValuesByStatus(0, $limit, $offset);
    }

    /**
     * Get archived attribute values
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The archived attribute values
     */
    public function getArchivedAttributeValues(int $limit = 0, int $offset = 0): array
    {
        return $this->getAttributeValuesByStatus(2, $limit, $offset);
    }

    /**
     * Get featured attribute values
     * 
     * @param int $limit The limit of results
     * @return array The featured attribute values
     */
    public function getFeaturedAttributeValues(int $limit = 10): array
    {
        return $this->where('featured', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get hot attribute values
     * 
     * @param int $limit The limit of results
     * @return array The hot attribute values
     */
    public function getHotAttributeValues(int $limit = 10): array
    {
        return $this->where('hot', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get new attribute values
     * 
     * @param int $limit The limit of results
     * @return array The new attribute values
     */
    public function getNewAttributeValues(int $limit = 10): array
    {
        return $this->where('new', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get unique attribute values
     * 
     * @param int $attributeId The attribute ID
     * @param int $limit The limit of results
     * @return array The unique attribute values
     */
    public function getUniqueAttributeValues(int $attributeId, int $limit = 0): array
    {
        $builder = $this->select('DISTINCT value, value_text, value_number, value_decimal, value_date, value_boolean')
                        ->where('attribute_id', $attributeId)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('value', 'ASC')
                        ->orderBy('value_text', 'ASC')
                        ->orderBy('value_number', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values for filtering
     * 
     * @param int $attributeId The attribute ID
     * @param int $limit The limit of results
     * @return array The attribute values for filtering
     */
    public function getAttributeValuesForFiltering(int $attributeId, int $limit = 100): array
    {
        return $this->select('DISTINCT value, value_text, value_number, value_decimal, value_date, value_boolean, COUNT(*) as count')
                    ->where('attribute_id', $attributeId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->groupBy('value, value_text, value_number, value_decimal, value_date, value_boolean')
                    ->orderBy('count', 'DESC')
                    ->orderBy('value', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Search attribute values
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchAttributeValues(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->groupStart()
                            ->like('value', $keyword)
                            ->orLike('value_text', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute values by sort order
     * 
     * @param string $direction The sort direction (ASC or DESC)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The sorted attribute values
     */
    public function getAttributeValuesBySortOrder(string $direction = 'ASC', int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', $direction)
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get attribute value count by product
     * 
     * @param int $productId The product ID
     * @return int The attribute value count
     */
    public function getAttributeValueCountByProduct(int $productId): int
    {
        return $this->where('product_id', $productId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get attribute value count by attribute
     * 
     * @param int $attributeId The attribute ID
     * @return int The attribute value count
     */
    public function getAttributeValueCountByAttribute(int $attributeId): int
    {
        return $this->where('attribute_id', $attributeId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get attribute value count by status
     * 
     * @return array The counts by status
     */
    public function getAttributeValueCounts(): array
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
            'new' => $this->where('new', 1)->where('publish', 1)->countAllResults()
        ];
    }

    /**
     * Get attribute values by creation date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @return array The attribute values in creation date range
     */
    public function getAttributeValuesByCreationDateRange(string $startDate, string $endDate, int $limit = 0): array
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
     * Get recent attribute values
     * 
     * @param int $limit The limit of results
     * @return array The recent attribute values
     */
    public function getRecentAttributeValues(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get attribute values for product comparison
     * 
     * @param array $productIds The product IDs to compare
     * @param int $attributeId The attribute ID
     * @return array The attribute values for comparison
     */
    public function getAttributeValuesForComparison(array $productIds, int $attributeId): array
    {
        return $this->whereIn('product_id', $productIds)
                    ->where('attribute_id', $attributeId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('product_id', 'ASC')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get attribute values by multiple attributes
     * 
     * @param array $attributeIds The attribute IDs
     * @param int $productId The product ID
     * @return array The attribute values
     */
    public function getAttributeValuesByMultipleAttributes(array $attributeIds, int $productId): array
    {
        return $this->whereIn('attribute_id', $attributeIds)
                    ->where('product_id', $productId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('attribute_id', 'ASC')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Get attribute values with product details
     * 
     * @param int $attributeId The attribute ID
     * @param int $limit The limit of results
     * @return array The attribute values with product details
     */
    public function getAttributeValuesWithProductDetails(int $attributeId, int $limit = 0): array
    {
        $builder = $this->select('attribute_value.*, product.title as product_title, product.slug as product_slug')
                        ->join('product', 'product.id = attribute_value.product_id', 'left')
                        ->where('attribute_value.attribute_id', $attributeId)
                        ->where('attribute_value.publish', 1)
                        ->where('attribute_value.status', 1)
                        ->where('product.publish', 1)
                        ->where('product.status', 1)
                        ->orderBy('attribute_value.sort_order', 'ASC')
                        ->orderBy('attribute_value.created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }
}
