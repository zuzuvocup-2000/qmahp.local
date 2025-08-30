<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Article Model
 * 
 * Handles database operations for the article table including
 * article management, search, and relationship handling
 * 
 * @package App\Models
 */
class ArticleModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'article';

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
        'meta_title',
        'meta_description',
        'meta_keyword',
        'article_catalogue_id',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
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
        'canonical' => 'required|min_length[2]|max_length[255]|is_unique[article.canonical,id,{id}]',
        'description' => 'permit_empty|max_length[500]',
        'meta_title' => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'meta_keyword' => 'permit_empty|max_length[500]',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'order' => 'permit_empty|integer'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'title' => [
            'required' => 'Article title is required',
            'min_length' => 'Article title must be at least 2 characters long',
            'max_length' => 'Article title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Article canonical is required',
            'min_length' => 'Article canonical must be at least 2 characters long',
            'max_length' => 'Article canonical cannot exceed 255 characters',
            'is_unique' => 'Article canonical must be unique'
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
     * Get article by canonical
     * 
     * @param string $canonical Article canonical
     * @return array|null Article data
     */
    public function getArticleByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get articles by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Articles in catalogue
     */
    public function getArticlesByCatalogue(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('article_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get featured articles
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Featured articles
     */
    public function getFeaturedArticles(int $limit = 10, int $offset = 0): array
    {
        return $this->where('featured', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get hot articles
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Hot articles
     */
    public function getHotArticles(int $limit = 10, int $offset = 0): array
    {
        return $this->where('hot', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get new articles
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array New articles
     */
    public function getNewArticles(int $limit = 10, int $offset = 0): array
    {
        return $this->where('new', 1)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search articles
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchArticles(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('title', $keyword)
                ->orLike('description', $keyword)
                ->orLike('content', $keyword)
                ->orLike('meta_keyword', $keyword);
        
        $builder->where('publish', 1);
        $builder->orderBy('order', 'ASC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get recent articles
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Recent articles
     */
    public function getRecentArticles(int $limit = 10, int $offset = 0): array
    {
        return $this->where('publish', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get popular articles by view count
     * 
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Popular articles
     */
    public function getPopularArticles(int $limit = 10, int $offset = 0): array
    {
        return $this->where('publish', 1)
                    ->orderBy('view_count', 'DESC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Update article view count
     * 
     * @param int $articleId Article ID
     * @return bool Update success
     */
    public function incrementViewCount(int $articleId): bool
    {
        $article = $this->find($articleId);
        if ($article) {
            $viewCount = ($article['view_count'] ?? 0) + 1;
            return $this->update($articleId, ['view_count' => $viewCount]);
        }
        return false;
    }

    /**
     * Get articles count by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @return int Count of articles
     */
    public function getArticlesCountByCatalogue(int $catalogueId): int
    {
        return $this->where('article_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get articles count by status
     * 
     * @param int $status Status to count
     * @return int Count of articles
     */
    public function getArticlesCountByStatus(int $status): int
    {
        return $this->where('status', $status)
                    ->where('publish', 1)
                    ->countAllResults();
    }
}
