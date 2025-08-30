<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * FileModel - Manages file uploads and storage
 * 
 * This model handles file management including uploads, storage,
 * categorization, and access control for various file types.
 * 
 * @package App\Models
 * @author System
 */
class FileModel extends Model
{
    protected $table = 'file';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
        'extension',
        'file_catalogue_id',
        'alt_text',
        'caption',
        'description',
        'tags',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sort_order',
        'download_count',
        'view_count',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'file_name' => 'required|max_length[255]',
        'file_path' => 'required|max_length[500]',
        'file_type' => 'required|max_length[100]',
        'file_size' => 'required|integer|greater_than[0]',
        'mime_type' => 'required|max_length[100]',
        'extension' => 'required|max_length[20]',
        'file_catalogue_id' => 'permit_empty|integer',
        'alt_text' => 'permit_empty|max_length[255]',
        'caption' => 'permit_empty|max_length[500]',
        'description' => 'permit_empty|max_length[1000]',
        'tags' => 'permit_empty|max_length[500]',
        'status' => 'permit_empty|in_list[0,1,2]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
        'download_count' => 'permit_empty|integer',
        'view_count' => 'permit_empty|integer',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'file_name' => [
            'required' => 'File name is required',
            'max_length' => 'File name cannot exceed 255 characters'
        ],
        'file_path' => [
            'required' => 'File path is required',
            'max_length' => 'File path cannot exceed 500 characters'
        ],
        'file_type' => [
            'required' => 'File type is required',
            'max_length' => 'File type cannot exceed 100 characters'
        ],
        'file_size' => [
            'required' => 'File size is required',
            'integer' => 'File size must be a valid integer',
            'greater_than' => 'File size must be greater than 0'
        ],
        'mime_type' => [
            'required' => 'MIME type is required',
            'max_length' => 'MIME type cannot exceed 100 characters'
        ],
        'extension' => [
            'required' => 'File extension is required',
            'max_length' => 'File extension cannot exceed 20 characters'
        ],
        'file_catalogue_id' => [
            'integer' => 'File catalogue ID must be a valid integer'
        ],
        'alt_text' => [
            'max_length' => 'Alt text cannot exceed 255 characters'
        ],
        'caption' => [
            'max_length' => 'Caption cannot exceed 500 characters'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 1000 characters'
        ],
        'tags' => [
            'max_length' => 'Tags cannot exceed 500 characters'
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
        'download_count' => [
            'integer' => 'Download count must be a valid integer'
        ],
        'view_count' => [
            'integer' => 'View count must be a valid integer'
        ],
        'userid_created' => [
            'integer' => 'User ID created must be a valid integer'
        ],
        'userid_updated' => [
            'integer' => 'User ID updated must be a valid integer'
        ]
    ];

    /**
     * Get files by catalogue
     * 
     * @param int $catalogueId The catalogue ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The files
     */
    public function getFilesByCatalogue(int $catalogueId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('file_catalogue_id', $catalogueId)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get files by type
     * 
     * @param string $fileType The file type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The files
     */
    public function getFilesByType(string $fileType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('file_type', $fileType)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get files by extension
     * 
     * @param string $extension The file extension
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The files
     */
    public function getFilesByExtension(string $extension, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('extension', $extension)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get files by MIME type
     * 
     * @param string $mimeType The MIME type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The files
     */
    public function getFilesByMimeType(string $mimeType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('mime_type', $mimeType)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get files by size range
     * 
     * @param int $minSize The minimum file size in bytes
     * @param int $maxSize The maximum file size in bytes
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The files
     */
    public function getFilesBySizeRange(int $minSize, int $maxSize, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('file_size >=', $minSize)
                        ->where('file_size <=', $maxSize)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get files by status
     * 
     * @param int $status The file status (0=inactive, 1=active, 2=archived)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The files
     */
    public function getFilesByStatus(int $status, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('status', $status)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get active files
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The active files
     */
    public function getActiveFiles(int $limit = 0, int $offset = 0): array
    {
        return $this->getFilesByStatus(1, $limit, $offset);
    }

    /**
     * Get inactive files
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The inactive files
     */
    public function getInactiveFiles(int $limit = 0, int $offset = 0): array
    {
        return $this->getFilesByStatus(0, $limit, $offset);
    }

    /**
     * Get archived files
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The archived files
     */
    public function getArchivedFiles(int $limit = 0, int $offset = 0): array
    {
        return $this->getFilesByStatus(2, $limit, $offset);
    }

    /**
     * Get featured files
     * 
     * @param int $limit The limit of results
     * @return array The featured files
     */
    public function getFeaturedFiles(int $limit = 10): array
    {
        return $this->where('featured', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get hot files
     * 
     * @param int $limit The limit of results
     * @return array The hot files
     */
    public function getHotFiles(int $limit = 10): array
    {
        return $this->where('hot', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get new files
     * 
     * @param int $limit The limit of results
     * @return array The new files
     */
    public function getNewFiles(int $limit = 10): array
    {
        return $this->where('new', 1)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get most downloaded files
     * 
     * @param int $limit The limit of results
     * @return array The most downloaded files
     */
    public function getMostDownloadedFiles(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('download_count', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get most viewed files
     * 
     * @param int $limit The limit of results
     * @return array The most viewed files
     */
    public function getMostViewedFiles(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('view_count', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get files with catalogue details
     * 
     * @param int $catalogueId The catalogue ID
     * @param int $limit The limit of results
     * @return array The files with catalogue details
     */
    public function getFilesWithCatalogueDetails(int $catalogueId, int $limit = 0): array
    {
        $builder = $this->select('file.*, file_catalogue.title as catalogue_title, file_catalogue.description as catalogue_description')
                        ->join('file_catalogue', 'file_catalogue.id = file.file_catalogue_id', 'left')
                        ->where('file.file_catalogue_id', $catalogueId)
                        ->where('file.publish', 1)
                        ->where('file.status', 1)
                        ->orderBy('file.sort_order', 'ASC')
                        ->orderBy('file.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Search files by name or description
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchFiles(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->groupStart()
                            ->like('file_name', $keyword)
                            ->orLike('alt_text', $keyword)
                            ->orLike('caption', $keyword)
                            ->orLike('description', $keyword)
                            ->orLike('tags', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get file count by catalogue
     * 
     * @param int $catalogueId The catalogue ID
     * @return int The file count
     */
    public function getFileCountByCatalogue(int $catalogueId): int
    {
        return $this->where('file_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get file count by type
     * 
     * @param string $fileType The file type
     * @return int The file count
     */
    public function getFileCountByType(string $fileType): int
    {
        return $this->where('file_type', $fileType)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get file count by status
     * 
     * @return array The counts by status
     */
    public function getFileCounts(): array
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
     * Get file size statistics
     * 
     * @return array The file size statistics
     */
    public function getFileSizeStatistics(): array
    {
        $result = $this->select('COUNT(*) as total_files, SUM(file_size) as total_size, AVG(file_size) as avg_size, MIN(file_size) as min_size, MAX(file_size) as max_size')
                       ->where('publish', 1)
                       ->where('status', 1)
                       ->first();
        
        return $result ?: [
            'total_files' => 0,
            'total_size' => 0,
            'avg_size' => 0,
            'min_size' => 0,
            'max_size' => 0
        ];
    }

    /**
     * Get file type distribution
     * 
     * @return array The file type distribution
     */
    public function getFileTypeDistribution(): array
    {
        return $this->select('file_type, COUNT(*) as count, SUM(file_size) as total_size')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->groupBy('file_type')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Increment download count
     * 
     * @param int $fileId The file ID
     * @return bool True if successful, false otherwise
     */
    public function incrementDownloadCount(int $fileId): bool
    {
        $file = $this->find($fileId);
        if (!$file) {
            return false;
        }
        
        $downloadCount = $file['download_count'] ?? 0;
        return $this->update($fileId, ['download_count' => $downloadCount + 1]);
    }

    /**
     * Increment view count
     * 
     * @param int $fileId The file ID
     * @return bool True if successful, false otherwise
     */
    public function incrementViewCount(int $fileId): bool
    {
        $file = $this->find($fileId);
        if (!$file) {
            return false;
        }
        
        $viewCount = $file['view_count'] ?? 0;
        return $this->update($fileId, ['view_count' => $viewCount + 1]);
    }

    /**
     * Get files by date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @return array The files in date range
     */
    public function getFilesByDateRange(string $startDate, string $endDate, int $limit = 0): array
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
     * Get files by tags
     * 
     * @param string $tags The tags to search for
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The files matching tags
     */
    public function getFilesByTags(string $tags, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->like('tags', $tags)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get recent files
     * 
     * @param int $limit The limit of results
     * @return array The recent files
     */
    public function getRecentFiles(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
