<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Product Model
 * 
 * Handles database operations for the product table including
 * product management, search, and relationship handling
 * 
 * @package App\Models
 */
class ProductModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'product';

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
        'gallery',
        'description',
        'content',
        'price',
        'price_sale',
        'price_wholesale',
        'quantity',
        'sku',
        'barcode',
        'weight',
        'dimensions',
        'brand_id',
        'product_catalogue_id',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sale',
        'view_count',
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
        'canonical' => 'required|min_length[2]|max_length[255]|is_unique[product.canonical,id,{id}]',
        'price' => 'permit_empty|numeric',
        'price_sale' => 'permit_empty|numeric',
        'price_wholesale' => 'permit_empty|numeric',
        'quantity' => 'permit_empty|integer',
        'sku' => 'permit_empty|min_length[3]|max_length[100]',
        'barcode' => 'permit_empty|min_length[8]|max_length[50]',
        'weight' => 'permit_empty|numeric',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sale' => 'permit_empty|in_list[0,1]',
        'order' => 'permit_empty|integer'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'title' => [
            'required' => 'Product title is required',
            'min_length' => 'Product title must be at least 2 characters long',
            'max_length' => 'Product title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Product canonical is required',
            'min_length' => 'Product canonical must be at least 2 characters long',
            'max_length' => 'Product canonical cannot exceed 255 characters',
            'is_unique' => 'Product canonical must be unique'
        ],
        'price' => [
            'numeric' => 'Price must be a valid number'
        ],
        'price_sale' => [
            'numeric' => 'Sale price must be a valid number'
        ],
        'price_wholesale' => [
            'numeric' => 'Wholesale price must be a valid number'
        ],
        'quantity' => [
            'integer' => 'Quantity must be a valid integer'
        ],
        'sku' => [
            'min_length' => 'SKU must be at least 3 characters long',
            'max_length' => 'SKU cannot exceed 100 characters'
        ],
        'barcode' => [
            'min_length' => 'Barcode must be at least 8 characters long',
            'max_length' => 'Barcode cannot exceed 50 characters'
        ],
        'weight' => [
            'numeric' => 'Weight must be a valid number'
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
        'sale' => [
            'in_list' => 'Sale must be either 0 or 1'
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
     * Get product by canonical
     * 
     * @param string $canonical Product canonical
     * @return array|null Product data
     */
    public function getProductByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get products by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Products in catalogue
     */
    public function getProductsByCatalogue(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('product_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get featured products
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Featured products
     */
    public function getFeaturedProducts(int $limit = 10, int $offset = 0): array
    {
        return $this->where('featured', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get hot products
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Hot products
     */
    public function getHotProducts(int $limit = 10, int $offset = 0): array
    {
        return $this->where('hot', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get new products
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array New products
     */
    public function getNewProducts(int $limit = 10, int $offset = 0): array
    {
        return $this->where('new', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get sale products
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Sale products
     */
    public function getSaleProducts(int $limit = 10, int $offset = 0): array
    {
        return $this->where('sale', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search products
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchProducts(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('title', $keyword)
                ->orLike('description', $keyword)
                ->orLike('content', $keyword)
                ->orLike('sku', $keyword)
                ->orLike('barcode', $keyword);
        
        $builder->where('publish', 1);
        $builder->orderBy('order', 'ASC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get products by price range
     * 
     * @param float $minPrice Minimum price
     * @param float $maxPrice Maximum price
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Products in price range
     */
    public function getProductsByPriceRange(float $minPrice, float $maxPrice, int $limit = 10, int $offset = 0): array
    {
        return $this->where('price >=', $minPrice)
                    ->where('price <=', $maxPrice)
                    ->where('publish', 1)
                    ->orderBy('price', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Update product view count
     * 
     * @param int $productId Product ID
     * @return bool Update success
     */
    public function incrementViewCount(int $productId): bool
    {
        $product = $this->find($productId);
        if ($product) {
            $viewCount = ($product['view_count'] ?? 0) + 1;
            return $this->update($productId, ['view_count' => $viewCount]);
        }
        return false;
    }

    /**
     * Get products count by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @return int Count of products
     */
    public function getProductsCountByCatalogue(int $catalogueId): int
    {
        return $this->where('product_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get products count by status
     * 
     * @param int $status Status to count
     * @return int Count of products
     */
    public function getProductsCountByStatus(int $status): int
    {
        return $this->where('status', $status)
                    ->where('publish', 1)
                    ->countAllResults();
    }
}
