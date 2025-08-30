<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Language Model
 * 
 * Handles database operations for the language table including
 * fulltext search capabilities across multiple fields
 * 
 * @package App\Models
 */
class LanguageModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'language';

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
        'order',
        'default',
        'publish',
        'userid_created',
        'userid_updated'
    ];

    /**
     * Validation rules
     * 
     * @var array
     */
    protected $validationRules = [
        'title' => 'required|min_length[1]|max_length[255]',
        'canonical' => 'required|min_length[1]|max_length[255]|is_unique[language.canonical,id,{id}]',
        'order' => 'permit_empty|integer',
        'publish' => 'permit_empty|in_list[0,1]',
        'default' => 'permit_empty|in_list[0,1]'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'title' => [
            'required' => 'Title is required',
            'min_length' => 'Title must be at least 1 character long',
            'max_length' => 'Title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Canonical is required',
            'min_length' => 'Canonical must be at least 1 character long',
            'max_length' => 'Canonical cannot exceed 255 characters',
            'is_unique' => 'Canonical must be unique'
        ],
        'order' => [
            'integer' => 'Order must be a valid integer'
        ],
        'publish' => [
            'in_list' => 'Publish must be either 0 or 1'
        ],
        'default' => [
            'in_list' => 'Default must be either 0 or 1'
        ]
    ];

    /**
     * Skip validation flag
     * 
     * @var bool
     */
    protected $skipValidation = false;

    /**
     * Search languages using fulltext search
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchLanguages(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        // Use MATCH AGAINST for fulltext search
        $builder->where("MATCH(id, title, canonical, image, description, `order`, `default`, created_at, updated_at, deleted_at, publish, userid_created, userid_updated) AGAINST(? IN BOOLEAN MODE)", $keyword);
        
        // Only get published languages
        $builder->where('publish', 1);
        
        // Order by relevance and then by order field
        $builder->orderBy("MATCH(id, title, canonical, image, description, `order`, `default`, created_at, updated_at, deleted_at, publish, userid_created, userid_updated) AGAINST(?) DESC", $keyword);
        $builder->orderBy('`order`', 'ASC');
        
        // Apply limit and offset
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get default language
     * 
     * @return array|null Default language data
     */
    public function getDefaultLanguage(): ?array
    {
        return $this->where('default', 1)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get published languages
     * 
     * @param string $orderBy Order by field
     * @param string $direction Order direction
     * @return array Published languages
     */
    public function getPublishedLanguages(string $orderBy = '`order`', string $direction = 'ASC'): array
    {
        return $this->where('publish', 1)
                    ->orderBy($orderBy, $direction)
                    ->findAll();
    }

    /**
     * Get language by canonical
     * 
     * @param string $canonical Canonical identifier
     * @return array|null Language data
     */
    public function getLanguageByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Check if canonical exists
     * 
     * @param string $canonical Canonical identifier
     * @param int|null $excludeId ID to exclude from check
     * @return bool True if exists
     */
    public function isCanonicalExists(string $canonical, ?int $excludeId = null): bool
    {
        $builder = $this->builder();
        $builder->where('canonical', $canonical);
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Get languages count by publish status
     * 
     * @param int $publish Publish status (0 or 1)
     * @return int Count of languages
     */
    public function getLanguagesCountByPublish(int $publish): int
    {
        return $this->where('publish', $publish)->countAllResults();
    }
}
