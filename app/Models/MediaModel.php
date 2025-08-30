<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * MediaModel - Manages media files and assets
 * 
 * This model handles media files including images, videos, documents,
 * and other file types with metadata and organization.
 * 
 * @package App\Models
 * @author System
 */
class MediaModel extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'title',
        'canonical',
        'description',
        'file_name',
        'file_path',
        'file_url',
        'file_type',
        'file_size',
        'file_extension',
        'mime_type',
        'alt_text',
        'caption',
        'media_catalogue_id',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sort_order',
        'width',
        'height',
        'duration',
        'thumbnail',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'canonical' => 'required|min_length[3]|max_length[255]|is_unique[media.canonical,id,{id}]',
        'description' => 'permit_empty|max_length[500]',
        'file_name' => 'required|max_length[255]',
        'file_path' => 'required|max_length[500]',
        'file_url' => 'permit_empty|max_length[500]',
        'file_type' => 'permit_empty|max_length[100]',
        'file_size' => 'permit_empty|integer',
        'file_extension' => 'permit_empty|max_length[20]',
        'mime_type' => 'permit_empty|max_length[100]',
        'alt_text' => 'permit_empty|max_length[255]',
        'caption' => 'permit_empty|max_length[500]',
        'media_catalogue_id' => 'permit_empty|integer',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
        'width' => 'permit_empty|integer',
        'height' => 'permit_empty|integer',
        'duration' => 'permit_empty|integer',
        'thumbnail' => 'permit_empty|max_length[500]',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Title is required',
            'min_length' => 'Title must be at least 3 characters long',
            'max_length' => 'Title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Canonical is required',
            'min_length' => 'Canonical must be at least 3 characters long',
            'max_length' => 'Canonical cannot exceed 255 characters',
            'is_unique' => 'Canonical already exists'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 500 characters'
        ],
        'file_name' => [
            'required' => 'File name is required',
            'max_length' => 'File name cannot exceed 255 characters'
        ],
        'file_path' => [
            'required' => 'File path is required',
            'max_length' => 'File path cannot exceed 500 characters'
        ],
        'file_url' => [
            'max_length' => 'File URL cannot exceed 500 characters'
        ],
        'file_type' => [
            'max_length' => 'File type cannot exceed 100 characters'
        ],
        'file_size' => [
            'integer' => 'File size must be a valid integer'
        ],
        'file_extension' => [
            'max_length' => 'File extension cannot exceed 20 characters'
        ],
        'mime_type' => [
            'max_length' => 'MIME type cannot exceed 100 characters'
        ],
        'alt_text' => [
            'max_length' => 'Alt text cannot exceed 255 characters'
        ],
        'caption' => [
            'max_length' => 'Caption cannot exceed 500 characters'
        ],
        'media_catalogue_id' => [
            'integer' => 'Media catalogue ID must be a valid integer'
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
        'sort_order' => [
            'integer' => 'Sort order must be a valid integer'
        ],
        'width' => [
            'integer' => 'Width must be a valid integer'
        ],
        'height' => [
            'integer' => 'Height must be a valid integer'
        ],
        'duration' => [
            'integer' => 'Duration must be a valid integer'
        ],
        'thumbnail' => [
            'max_length' => 'Thumbnail path cannot exceed 500 characters'
        ],
        'userid_created' => [
            'integer' => 'User ID created must be a valid integer'
        ],
        'userid_updated' => [
            'integer' => 'User ID updated must be a valid integer'
        ]
    ];

    /**
     * Get media by canonical
     * 
     * @param string $canonical The canonical string
     * @return array|null The media data or null if not found
     */
    public function getMediaByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get media by file type
     * 
     * @param string $fileType The file type to filter by
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The media files of specified type
     */
    public function getMediaByFileType(string $fileType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('file_type', $fileType)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get media by catalogue
     * 
     * @param int $catalogueId The catalogue ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The media files in specified catalogue
     */
    public function getMediaByCatalogue(int $catalogueId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('media_catalogue_id', $catalogueId)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get media by file extension
     * 
     * @param string $extension The file extension to filter by
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The media files with specified extension
     */
    public function getMediaByExtension(string $extension, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('file_extension', $extension)
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get featured media
     * 
     * @param int $limit The limit of results
     * @return array The featured media files
     */
    public function getFeaturedMedia(int $limit = 10): array
    {
        return $this->where('featured', 1)
                    ->where('publish', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get hot media
     * 
     * @param int $limit The limit of results
     * @return array The hot media files
     */
    public function getHotMedia(int $limit = 10): array
    {
        return $this->where('hot', 1)
                    ->where('publish', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get new media
     * 
     * @param int $limit The limit of results
     * @return array The new media files
     */
    public function getNewMedia(int $limit = 10): array
    {
        return $this->where('new', 1)
                    ->where('publish', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get images only
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The image files
     */
    public function getImages(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('file_type', 'image')
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get videos only
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The video files
     */
    public function getVideos(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('file_type', 'video')
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get documents only
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The document files
     */
    public function getDocuments(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('file_type', 'document')
                        ->where('publish', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Search media by title or description
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchMedia(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->groupStart()
                            ->like('title', $keyword)
                            ->orLike('description', $keyword)
                            ->orLike('file_name', $keyword)
                            ->orLike('alt_text', $keyword)
                            ->orLike('caption', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get media count by status
     * 
     * @return array The counts by status
     */
    public function getMediaCounts(): array
    {
        return [
            'total' => $this->countAllResults(),
            'published' => $this->where('publish', 1)->countAllResults(),
            'unpublished' => $this->where('publish', 0)->countAllResults(),
            'featured' => $this->where('featured', 1)->where('publish', 1)->countAllResults(),
            'hot' => $this->where('hot', 1)->where('publish', 1)->countAllResults(),
            'new' => $this->where('new', 1)->where('publish', 1)->countAllResults(),
            'images' => $this->where('file_type', 'image')->where('publish', 1)->countAllResults(),
            'videos' => $this->where('file_type', 'video')->where('publish', 1)->countAllResults(),
            'documents' => $this->where('file_type', 'document')->where('publish', 1)->countAllResults()
        ];
    }

    /**
     * Check if canonical exists
     * 
     * @param string $canonical The canonical to check
     * @param int|null $excludeId The ID to exclude from check
     * @return bool True if exists, false otherwise
     */
    public function isCanonicalExists(string $canonical, ?int $excludeId = null): bool
    {
        $builder = $this->where('canonical', $canonical);
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Get media by file size range
     * 
     * @param int $minSize The minimum file size in bytes
     * @param int $maxSize The maximum file size in bytes
     * @param int $limit The limit of results
     * @return array The media files within size range
     */
    public function getMediaByFileSize(int $minSize, int $maxSize, int $limit = 0): array
    {
        $builder = $this->where('file_size >=', $minSize)
                        ->where('file_size <=', $maxSize)
                        ->where('publish', 1)
                        ->orderBy('file_size', 'DESC')
                        ->orderBy('sort_order', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get media by dimensions
     * 
     * @param int $minWidth The minimum width
     * @param int $minHeight The minimum height
     * @param int $limit The limit of results
     * @return array The media files with specified dimensions
     */
    public function getMediaByDimensions(int $minWidth, int $minHeight, int $limit = 0): array
    {
        $builder = $this->where('width >=', $minWidth)
                        ->where('height >=', $minHeight)
                        ->where('publish', 1)
                        ->orderBy('width', 'DESC')
                        ->orderBy('height', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get available file types
     * 
     * @return array The available file types
     */
    public function getAvailableFileTypes(): array
    {
        return $this->select('DISTINCT(file_type) as file_type')
                    ->where('publish', 1)
                    ->where('file_type IS NOT NULL')
                    ->where('file_type !=', '')
                    ->orderBy('file_type', 'ASC')
                    ->findAll();
    }

    /**
     * Get available file extensions
     * 
     * @return array The available file extensions
     */
    public function getAvailableFileExtensions(): array
    {
        return $this->select('DISTINCT(file_extension) as file_extension')
                    ->where('publish', 1)
                    ->where('file_extension IS NOT NULL')
                    ->where('file_extension !=', '')
                    ->orderBy('file_extension', 'ASC')
                    ->findAll();
    }

    /**
     * Get media statistics by type
     * 
     * @return array The media statistics by type
     */
    public function getMediaStatisticsByType(): array
    {
        return $this->select('file_type, COUNT(*) as count, AVG(file_size) as avg_size')
                    ->where('publish', 1)
                    ->groupBy('file_type')
                    ->findAll();
    }

    /**
     * Get media with catalogue details
     * 
     * @param int $limit The limit of results
     * @return array The media with catalogue details
     */
    public function getMediaWithCatalogueDetails(int $limit = 0): array
    {
        $builder = $this->select('media.*, media_catalogue.title as catalogue_title, media_catalogue.canonical as catalogue_canonical')
                        ->join('media_catalogue', 'media_catalogue.id = media.media_catalogue_id', 'left')
                        ->where('media.publish', 1)
                        ->orderBy('media.sort_order', 'ASC')
                        ->orderBy('media.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }
}
