<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * LocationModel - Manages locations and addresses
 * 
 * This model handles location management including addresses, coordinates,
 * and geographical information for various business entities.
 * 
 * @package App\Models
 * @author System
 */
class LocationModel extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'title',
        'slug',
        'canonical',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'description',
        'content',
        'image',
        'location_catalogue_id',
        'parent_id',
        'level',
        'lft',
        'rgt',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website',
        'working_hours',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sort_order',
        'view_count',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'slug' => 'required|max_length[255]|is_unique[location.slug,id,{id}]',
        'canonical' => 'permit_empty|max_length[500]',
        'meta_title' => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'meta_keyword' => 'permit_empty|max_length[500]',
        'description' => 'permit_empty|max_length[1000]',
        'content' => 'permit_empty',
        'image' => 'permit_empty|max_length[500]',
        'location_catalogue_id' => 'permit_empty|integer',
        'parent_id' => 'permit_empty|integer',
        'level' => 'permit_empty|integer|greater_than_equal_to[0]',
        'lft' => 'permit_empty|integer|greater_than_equal_to[0]',
        'rgt' => 'permit_empty|integer|greater_than_equal_to[0]',
        'address' => 'permit_empty|max_length[500]',
        'city' => 'permit_empty|max_length[100]',
        'state' => 'permit_empty|max_length[100]',
        'country' => 'permit_empty|max_length[100]',
        'postal_code' => 'permit_empty|max_length[20]',
        'latitude' => 'permit_empty|decimal',
        'longitude' => 'permit_empty|decimal',
        'phone' => 'permit_empty|max_length[50]',
        'email' => 'permit_empty|valid_email',
        'website' => 'permit_empty|valid_url',
        'working_hours' => 'permit_empty|max_length[500]',
        'status' => 'permit_empty|in_list[0,1,2]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
        'view_count' => 'permit_empty|integer',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Location title is required',
            'max_length' => 'Location title cannot exceed 255 characters'
        ],
        'slug' => [
            'required' => 'Location slug is required',
            'max_length' => 'Location slug cannot exceed 255 characters',
            'is_unique' => 'Location slug must be unique'
        ],
        'canonical' => [
            'max_length' => 'Canonical URL cannot exceed 500 characters'
        ],
        'meta_title' => [
            'max_length' => 'Meta title cannot exceed 255 characters'
        ],
        'meta_description' => [
            'max_length' => 'Meta description cannot exceed 500 characters'
        ],
        'meta_keyword' => [
            'max_length' => 'Meta keywords cannot exceed 500 characters'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 1000 characters'
        ],
        'image' => [
            'max_length' => 'Image path cannot exceed 500 characters'
        ],
        'location_catalogue_id' => [
            'integer' => 'Location catalogue ID must be a valid integer'
        ],
        'parent_id' => [
            'integer' => 'Parent ID must be a valid integer'
        ],
        'level' => [
            'integer' => 'Level must be a valid integer',
            'greater_than_equal_to' => 'Level must be greater than or equal to 0'
        ],
        'lft' => [
            'integer' => 'Left value must be a valid integer',
            'greater_than_equal_to' => 'Left value must be greater than or equal to 0'
        ],
        'rgt' => [
            'integer' => 'Right value must be a valid integer',
            'greater_than_equal_to' => 'Right value must be greater than or equal to 0'
        ],
        'address' => [
            'max_length' => 'Address cannot exceed 500 characters'
        ],
        'city' => [
            'max_length' => 'City cannot exceed 100 characters'
        ],
        'state' => [
            'max_length' => 'State cannot exceed 100 characters'
        ],
        'country' => [
            'max_length' => 'Country cannot exceed 100 characters'
        ],
        'postal_code' => [
            'max_length' => 'Postal code cannot exceed 20 characters'
        ],
        'latitude' => [
            'decimal' => 'Latitude must be a valid decimal number'
        ],
        'longitude' => [
            'decimal' => 'Longitude must be a valid decimal number'
        ],
        'phone' => [
            'max_length' => 'Phone cannot exceed 50 characters'
        ],
        'email' => [
            'valid_email' => 'Email must be a valid email address'
        ],
        'website' => [
            'valid_url' => 'Website must be a valid URL'
        ],
        'working_hours' => [
            'max_length' => 'Working hours cannot exceed 500 characters'
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
     * Get location by canonical
     * 
     * @param string $canonical The canonical URL
     * @return array|null The location or null if not found
     */
    public function getLocationByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get location by slug
     * 
     * @param string $slug The location slug
     * @return array|null The location or null if not found
     */
    public function getLocationBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get locations by catalogue
     * 
     * @param int $catalogueId The catalogue ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The locations
     */
    public function getLocationsByCatalogue(int $catalogueId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('location_catalogue_id', $catalogueId)
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
     * Get locations by parent
     * 
     * @param int $parentId The parent ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The locations
     */
    public function getLocationsByParent(int $parentId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('parent_id', $parentId)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get locations by city
     * 
     * @param string $city The city name
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The locations
     */
    public function getLocationsByCity(string $city, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('city', $city)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get locations by state
     * 
     * @param string $state The state name
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The locations
     */
    public function getLocationsByState(string $state, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('state', $state)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get locations by country
     * 
     * @param string $country The country name
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The locations
     */
    public function getLocationsByCountry(string $country, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('country', $country)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get locations by postal code
     * 
     * @param string $postalCode The postal code
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The locations
     */
    public function getLocationsByPostalCode(string $postalCode, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('postal_code', $postalCode)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('title', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get locations by coordinates range
     * 
     * @param float $lat The center latitude
     * @param float $lng The center longitude
     * @param float $radius The radius in kilometers
     * @param int $limit The limit of results
     * @return array The locations within radius
     */
    public function getLocationsByCoordinatesRange(float $lat, float $lng, float $radius, int $limit = 0): array
    {
        // Haversine formula to calculate distance
        $sql = "SELECT *, 
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance 
                FROM location 
                WHERE publish = 1 AND status = 1 
                HAVING distance <= ? 
                ORDER BY distance ASC";
        
        $builder = $this->db->query($sql, [$lat, $lng, $lat, $radius]);
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->getResultArray();
    }

    /**
     * Get locations by status
     * 
     * @param int $status The location status (0=inactive, 1=active, 2=archived)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The locations
     */
    public function getLocationsByStatus(int $status, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('status', $status)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get active locations
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The active locations
     */
    public function getActiveLocations(int $limit = 0, int $offset = 0): array
    {
        return $this->getLocationsByStatus(1, $limit, $offset);
    }

    /**
     * Get inactive locations
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The inactive locations
     */
    public function getInactiveLocations(int $limit = 0, int $offset = 0): array
    {
        return $this->getLocationsByStatus(0, $limit, $offset);
    }

    /**
     * Get archived locations
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The archived locations
     */
    public function getArchivedLocations(int $limit = 0, int $offset = 0): array
    {
        return $this->getLocationsByStatus(2, $limit, $offset);
    }

    /**
     * Get featured locations
     * 
     * @param int $limit The limit of results
     * @return array The featured locations
     */
    public function getFeaturedLocations(int $limit = 10): array
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
     * Get hot locations
     * 
     * @param int $limit The limit of results
     * @return array The hot locations
     */
    public function getHotLocations(int $limit = 10): array
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
     * Get new locations
     * 
     * @param int $limit The limit of results
     * @return array The new locations
     */
    public function getNewLocations(int $limit = 10): array
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
     * Get most viewed locations
     * 
     * @param int $limit The limit of results
     * @return array The most viewed locations
     */
    public function getMostViewedLocations(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('view_count', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get locations with catalogue details
     * 
     * @param int $catalogueId The catalogue ID
     * @param int $limit The limit of results
     * @return array The locations with catalogue details
     */
    public function getLocationsWithCatalogueDetails(int $catalogueId, int $limit = 0): array
    {
        $builder = $this->select('location.*, location_catalogue.title as catalogue_title, location_catalogue.description as catalogue_description')
                        ->join('location_catalogue', 'location_catalogue.id = location.location_catalogue_id', 'left')
                        ->where('location.location_catalogue_id', $catalogueId)
                        ->where('location.publish', 1)
                        ->where('location.status', 1)
                        ->orderBy('location.sort_order', 'ASC')
                        ->orderBy('location.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Search locations by title, address, or description
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchLocations(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->groupStart()
                            ->like('title', $keyword)
                            ->orLike('description', $keyword)
                            ->orLike('content', $keyword)
                            ->orLike('meta_keyword', $keyword)
                            ->orLike('address', $keyword)
                            ->orLike('city', $keyword)
                            ->orLike('state', $keyword)
                            ->orLike('country', $keyword)
                            ->orLike('postal_code', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get location count by catalogue
     * 
     * @param int $catalogueId The catalogue ID
     * @return int The location count
     */
    public function getLocationCountByCatalogue(int $catalogueId): int
    {
        return $this->where('location_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get location count by city
     * 
     * @param string $city The city name
     * @return int The location count
     */
    public function getLocationCountByCity(string $city): int
    {
        return $this->where('city', $city)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get location count by state
     * 
     * @param string $state The state name
     * @return int The location count
     */
    public function getLocationCountByState(string $state): int
    {
        return $this->where('state', $state)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get location count by country
     * 
     * @param string $country The country name
     * @return int The location count
     */
    public function getLocationCountByCountry(string $country): int
    {
        return $this->where('country', $country)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get location count by status
     * 
     * @return array The counts by status
     */
    public function getLocationCounts(): array
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
     * Get locations by city distribution
     * 
     * @return array The locations by city distribution
     */
    public function getLocationsByCityDistribution(): array
    {
        return $this->select('city, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('city IS NOT NULL')
                    ->where('city !=', '')
                    ->groupBy('city')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Get locations by state distribution
     * 
     * @return array The locations by state distribution
     */
    public function getLocationsByStateDistribution(): array
    {
        return $this->select('state, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('state IS NOT NULL')
                    ->where('state !=', '')
                    ->groupBy('state')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Get locations by country distribution
     * 
     * @return array The locations by country distribution
     */
    public function getLocationsByCountryDistribution(): array
    {
        return $this->select('country, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('country IS NOT NULL')
                    ->where('country !=', '')
                    ->groupBy('country')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Increment view count
     * 
     * @param int $locationId The location ID
     * @return bool True if successful, false otherwise
     */
    public function incrementViewCount(int $locationId): bool
    {
        $location = $this->find($locationId);
        if (!$location) {
            return false;
        }
        
        $viewCount = $location['view_count'] ?? 0;
        return $this->update($locationId, ['view_count' => $viewCount + 1]);
    }

    /**
     * Get locations by date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @return array The locations in date range
     */
    public function getLocationsByDateRange(string $startDate, string $endDate, int $limit = 0): array
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
     * Get recent locations
     * 
     * @param int $limit The limit of results
     * @return array The recent locations
     */
    public function getRecentLocations(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get available cities
     * 
     * @return array The available cities
     */
    public function getAvailableCities(): array
    {
        return $this->select('city, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('city IS NOT NULL')
                    ->where('city !=', '')
                    ->groupBy('city')
                    ->orderBy('city', 'ASC')
                    ->findAll();
    }

    /**
     * Get available states
     * 
     * @return array The available states
     */
    public function getAvailableStates(): array
    {
        return $this->select('state, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('state IS NOT NULL')
                    ->where('state !=', '')
                    ->groupBy('state')
                    ->orderBy('state', 'ASC')
                    ->findAll();
    }

    /**
     * Get available countries
     * 
     * @return array The available countries
     */
    public function getAvailableCountries(): array
    {
        return $this->select('country, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('country IS NOT NULL')
                    ->where('country !=', '')
                    ->groupBy('country')
                    ->orderBy('country', 'ASC')
                    ->findAll();
    }
}
