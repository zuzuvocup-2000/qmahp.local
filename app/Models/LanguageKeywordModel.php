<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Language Keyword Model
 * 
 * Handles database operations for language keywords and translations
 * Manages multilingual content with key-value pairs
 * 
 * @package App\Models
 */
class LanguageKeywordModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'language_keywords';

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
    protected $useSoftDeletes = false;

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
        'keyword',
        'en_translation',
        'vi_translation',
        'description',
        'order',
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
        'keyword' => 'required|min_length[1]|max_length[255]',
        'en_translation' => 'required|min_length[1]|max_length[500]',
        'vi_translation' => 'required|min_length[1]|max_length[500]',
        'order' => 'permit_empty|integer',
        'publish' => 'permit_empty|in_list[0,1]'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'keyword' => [
            'required' => 'Keyword is required',
            'min_length' => 'Keyword must be at least 1 character long',
            'max_length' => 'Keyword cannot exceed 255 characters',
            'is_unique' => 'Keyword must be unique'
        ],
        'en_translation' => [
            'required' => 'English translation is required',
            'min_length' => 'English translation must be at least 1 character long',
            'max_length' => 'English translation cannot exceed 500 characters'
        ],
        'vi_translation' => [
            'required' => 'Vietnamese translation is required',
            'min_length' => 'Vietnamese translation must be at least 1 character long',
            'max_length' => 'Vietnamese translation cannot exceed 500 characters'
        ],
        'order' => [
            'integer' => 'Order must be a valid integer'
        ],
        'publish' => [
            'in_list' => 'Publish must be either 0 or 1'
        ]
    ];

    /**
     * Skip validation flag
     * 
     * @var bool
     */
    protected $skipValidation = false;

    /**
     * Search keywords using LIKE for compatibility with all MySQL versions.
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchKeywords(string $keyword = '', int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();

        // If keyword is not empty, search in multiple columns using LIKE
        if (!empty($keyword)) {
            $builder->groupStart();
            $builder->like('keyword', $keyword);
            $builder->orLike('en_translation', $keyword);
            $builder->orLike('vi_translation', $keyword);
            $builder->orLike('description', $keyword);
            $builder->groupEnd();
        }

        // Only get published keywords
        $builder->where('publish', 1);

        // Order by 'order' field
        $builder->orderBy('`order`', 'ASC');

        // Apply limit and offset
        $builder->limit($limit, $offset);

        return $builder->get()->getResultArray();
    }

    /**
     * Get translation by keyword and language
     * 
     * @param string $keyword Keyword to translate
     * @param string $language Language code (en, vi)
     * @return string|null Translation text
     */
    public function getTranslation(string $keyword, string $language): ?string
    {
        $field = $language . '_translation';
        
        if (!in_array($field, ['en_translation', 'vi_translation'])) {
            return null;
        }
        
        $result = $this->select($field)
                      ->where('keyword', $keyword)
                      ->where('publish', 1)
                      ->first();
        
        return $result ? $result[$field] : null;
    }

    /**
     * Get all translations for a keyword
     * 
     * @param string $keyword Keyword to get translations for
     * @return array|null Translations array
     */
    public function getKeywordTranslations(string $keyword): ?array
    {
        return $this->where('keyword', $keyword)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Check if keyword exists
     * 
     * @param string $keyword Keyword to check
     * @param int|null $excludeId ID to exclude from check
     * @return bool True if exists
     */
    public function isKeywordExists(string $keyword, ?int $excludeId = null): bool
    {
        $builder = $this->builder();
        $builder->where('keyword', $keyword);
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Get keywords count by publish status
     * 
     * @param int|null $publish Publish status (0, 1, or null for all)
     * @return int Count of keywords
     */
    public function getKeywordsCount(?int $publish = null): int
    {
        $builder = $this->builder();
        
        if ($publish !== null) {
            $builder->where('publish', $publish);
        }
        
        return $builder->countAllResults();
    }
}
