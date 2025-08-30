<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * TourModel - Manages tours and travel packages
 * 
 * This model handles tour management including destinations,
 * itineraries, pricing, and availability for travel services.
 * 
 * @package App\Models
 * @author System
 */
class TourModel extends Model
{
    protected $table = 'tour';
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
        'gallery',
        'tour_catalogue_id',
        'location_id',
        'duration',
        'duration_type',
        'min_participants',
        'max_participants',
        'price',
        'price_currency',
        'discount_price',
        'discount_percentage',
        'departure_location',
        'destination_location',
        'departure_date',
        'return_date',
        'included_services',
        'excluded_services',
        'itinerary',
        'highlights',
        'requirements',
        'cancellation_policy',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sort_order',
        'view_count',
        'booking_count',
        'rating',
        'rating_count',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'slug' => 'required|max_length[255]|is_unique[tour.slug,id,{id}]',
        'canonical' => 'permit_empty|max_length[500]',
        'meta_title' => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'meta_keyword' => 'permit_empty|max_length[500]',
        'description' => 'permit_empty|max_length[1000]',
        'content' => 'permit_empty',
        'image' => 'permit_empty|max_length[500]',
        'gallery' => 'permit_empty',
        'tour_catalogue_id' => 'permit_empty|integer',
        'location_id' => 'permit_empty|integer',
        'duration' => 'permit_empty|integer|greater_than[0]',
        'duration_type' => 'permit_empty|max_length[50]',
        'min_participants' => 'permit_empty|integer|greater_than[0]',
        'max_participants' => 'permit_empty|integer|greater_than[0]',
        'price' => 'permit_empty|decimal',
        'price_currency' => 'permit_empty|max_length[10]',
        'discount_price' => 'permit_empty|decimal',
        'discount_percentage' => 'permit_empty|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
        'departure_location' => 'permit_empty|max_length[255]',
        'destination_location' => 'permit_empty|max_length[255]',
        'departure_date' => 'permit_empty|valid_date',
        'return_date' => 'permit_empty|valid_date',
        'included_services' => 'permit_empty',
        'excluded_services' => 'permit_empty',
        'itinerary' => 'permit_empty',
        'highlights' => 'permit_empty',
        'requirements' => 'permit_empty',
        'cancellation_policy' => 'permit_empty',
        'status' => 'permit_empty|in_list[0,1,2]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
        'view_count' => 'permit_empty|integer|greater_than_equal_to[0]',
        'booking_count' => 'permit_empty|integer|greater_than_equal_to[0]',
        'rating' => 'permit_empty|decimal|greater_than_equal_to[0]|less_than_equal_to[5]',
        'rating_count' => 'permit_empty|integer|greater_than_equal_to[0]',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Tour title is required',
            'max_length' => 'Tour title cannot exceed 255 characters'
        ],
        'slug' => [
            'required' => 'Tour slug is required',
            'max_length' => 'Tour slug cannot exceed 255 characters',
            'is_unique' => 'Tour slug must be unique'
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
        'tour_catalogue_id' => [
            'integer' => 'Tour catalogue ID must be a valid integer'
        ],
        'location_id' => [
            'integer' => 'Location ID must be a valid integer'
        ],
        'duration' => [
            'integer' => 'Duration must be a valid integer',
            'greater_than' => 'Duration must be greater than 0'
        ],
        'duration_type' => [
            'max_length' => 'Duration type cannot exceed 50 characters'
        ],
        'min_participants' => [
            'integer' => 'Minimum participants must be a valid integer',
            'greater_than' => 'Minimum participants must be greater than 0'
        ],
        'max_participants' => [
            'integer' => 'Maximum participants must be a valid integer',
            'greater_than' => 'Maximum participants must be greater than 0'
        ],
        'price' => [
            'decimal' => 'Price must be a valid decimal number'
        ],
        'price_currency' => [
            'max_length' => 'Price currency cannot exceed 10 characters'
        ],
        'discount_price' => [
            'decimal' => 'Discount price must be a valid decimal number'
        ],
        'discount_percentage' => [
            'integer' => 'Discount percentage must be a valid integer',
            'greater_than_equal_to' => 'Discount percentage must be greater than or equal to 0',
            'less_than_equal_to' => 'Discount percentage cannot exceed 100'
        ],
        'departure_location' => [
            'max_length' => 'Departure location cannot exceed 255 characters'
        ],
        'destination_location' => [
            'max_length' => 'Destination location cannot exceed 255 characters'
        ],
        'departure_date' => [
            'valid_date' => 'Departure date must be a valid date'
        ],
        'return_date' => [
            'valid_date' => 'Return date must be a valid date'
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
            'integer' => 'View count must be a valid integer',
            'greater_than_equal_to' => 'View count must be greater than or equal to 0'
        ],
        'booking_count' => [
            'integer' => 'Booking count must be a valid integer',
            'greater_than_equal_to' => 'Booking count must be greater than or equal to 0'
        ],
        'rating' => [
            'decimal' => 'Rating must be a valid decimal number',
            'greater_than_equal_to' => 'Rating must be greater than or equal to 0',
            'less_than_equal_to' => 'Rating cannot exceed 5'
        ],
        'rating_count' => [
            'integer' => 'Rating count must be a valid integer',
            'greater_than_equal_to' => 'Rating count must be greater than or equal to 0'
        ],
        'userid_created' => [
            'integer' => 'User ID created must be a valid integer'
        ],
        'userid_updated' => [
            'integer' => 'User ID updated must be a valid integer'
        ]
    ];

    /**
     * Get tour by slug
     * 
     * @param string $slug The tour slug
     * @return array|null The tour or null if not found
     */
    public function getTourBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get tour by canonical
     * 
     * @param string $canonical The canonical URL
     * @return array|null The tour or null if not found
     */
    public function getTourByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->first();
    }

    /**
     * Get tours by catalogue
     * 
     * @param int $catalogueId The catalogue ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tours
     */
    public function getToursByCatalogue(int $catalogueId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('tour_catalogue_id', $catalogueId)
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
     * Get tours by location
     * 
     * @param int $locationId The location ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tours
     */
    public function getToursByLocation(int $locationId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('location_id', $locationId)
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
     * Get tours by duration
     * 
     * @param int $minDuration The minimum duration
     * @param int $maxDuration The maximum duration
     * @param string $durationType The duration type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tours
     */
    public function getToursByDuration(int $minDuration, int $maxDuration, string $durationType = 'days', int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('duration >=', $minDuration)
                        ->where('duration <=', $maxDuration)
                        ->where('duration_type', $durationType)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('duration', 'ASC')
                        ->orderBy('sort_order', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tours by price range
     * 
     * @param float $minPrice The minimum price
     * @param float $maxPrice The maximum price
     * @param string $currency The currency
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tours
     */
    public function getToursByPriceRange(float $minPrice, float $maxPrice, string $currency = 'USD', int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('price >=', $minPrice)
                        ->where('price <=', $maxPrice)
                        ->where('price_currency', $currency)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('price', 'ASC')
                        ->orderBy('sort_order', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tours by departure date
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tours
     */
    public function getToursByDepartureDate(string $startDate, string $endDate, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('departure_date >=', $startDate)
                        ->where('departure_date <=', $endDate)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('departure_date', 'ASC')
                        ->orderBy('sort_order', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tours by participants
     * 
     * @param int $participants The number of participants
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tours
     */
    public function getToursByParticipants(int $participants, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('min_participants <=', $participants)
                        ->where('max_participants >=', $participants)
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
     * Get tours by status
     * 
     * @param int $status The tour status (0=inactive, 1=active, 2=archived)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tours
     */
    public function getToursByStatus(int $status, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('status', $status)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get active tours
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The active tours
     */
    public function getActiveTours(int $limit = 0, int $offset = 0): array
    {
        return $this->getToursByStatus(1, $limit, $offset);
    }

    /**
     * Get inactive tours
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The inactive tours
     */
    public function getInactiveTours(int $limit = 0, int $offset = 0): array
    {
        return $this->getToursByStatus(0, $limit, $offset);
    }

    /**
     * Get archived tours
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The archived tours
     */
    public function getArchivedTours(int $limit = 0, int $offset = 0): array
    {
        return $this->getToursByStatus(2, $limit, $offset);
    }

    /**
     * Get featured tours
     * 
     * @param int $limit The limit of results
     * @return array The featured tours
     */
    public function getFeaturedTours(int $limit = 10): array
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
     * Get hot tours
     * 
     * @param int $limit The limit of results
     * @return array The hot tours
     */
    public function getHotTours(int $limit = 10): array
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
     * Get new tours
     * 
     * @param int $limit The limit of results
     * @return array The new tours
     */
    public function getNewTours(int $limit = 10): array
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
     * Get most viewed tours
     * 
     * @param int $limit The limit of results
     * @return array The most viewed tours
     */
    public function getMostViewedTours(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('view_count', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get most booked tours
     * 
     * @param int $limit The limit of results
     * @return array The most booked tours
     */
    public function getMostBookedTours(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('booking_count', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get highest rated tours
     * 
     * @param int $limit The limit of results
     * @return array The highest rated tours
     */
    public function getHighestRatedTours(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->where('rating >', 0)
                    ->orderBy('rating', 'DESC')
                    ->orderBy('rating_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get tours with catalogue details
     * 
     * @param int $catalogueId The catalogue ID
     * @param int $limit The limit of results
     * @return array The tours with catalogue details
     */
    public function getToursWithCatalogueDetails(int $catalogueId, int $limit = 0): array
    {
        $builder = $this->select('tour.*, tour_catalogue.title as catalogue_title, tour_catalogue.description as catalogue_description')
                        ->join('tour_catalogue', 'tour_catalogue.id = tour.tour_catalogue_id', 'left')
                        ->where('tour.tour_catalogue_id', $catalogueId)
                        ->where('tour.publish', 1)
                        ->where('tour.status', 1)
                        ->orderBy('tour.sort_order', 'ASC')
                        ->orderBy('tour.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tours with location details
     * 
     * @param int $locationId The location ID
     * @param int $limit The limit of results
     * @return array The tours with location details
     */
    public function getToursWithLocationDetails(int $locationId, int $limit = 0): array
    {
        $builder = $this->select('tour.*, location.title as location_title, location.address as location_address')
                        ->join('location', 'location.id = tour.location_id', 'left')
                        ->where('tour.location_id', $locationId)
                        ->where('tour.publish', 1)
                        ->where('tour.status', 1)
                        ->orderBy('tour.sort_order', 'ASC')
                        ->orderBy('tour.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Search tours
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchTours(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->groupStart()
                            ->like('title', $keyword)
                            ->orLike('description', $keyword)
                            ->orLike('content', $keyword)
                            ->orLike('departure_location', $keyword)
                            ->orLike('destination_location', $keyword)
                            ->orLike('highlights', $keyword)
                            ->orLike('meta_keyword', $keyword)
                        ->groupEnd()
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tour count by catalogue
     * 
     * @param int $catalogueId The catalogue ID
     * @return int The tour count
     */
    public function getTourCountByCatalogue(int $catalogueId): int
    {
        return $this->where('tour_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get tour count by location
     * 
     * @param int $locationId The location ID
     * @return int The tour count
     */
    public function getTourCountByLocation(int $locationId): int
    {
        return $this->where('location_id', $locationId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get tour count by status
     * 
     * @return array The counts by status
     */
    public function getTourCounts(): array
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
            'with_discount' => $this->where('discount_price >', 0)->where('publish', 1)->where('status', 1)->countAllResults()
        ];
    }

    /**
     * Get tour statistics
     * 
     * @return array The tour statistics
     */
    public function getTourStatistics(): array
    {
        $result = $this->select('COUNT(*) as total_tours, AVG(price) as avg_price, MIN(price) as min_price, MAX(price) as max_price, AVG(duration) as avg_duration, SUM(booking_count) as total_bookings, AVG(rating) as avg_rating')
                       ->where('publish', 1)
                       ->where('status', 1)
                       ->first();

        return $result ?: [
            'total_tours' => 0,
            'avg_price' => 0,
            'min_price' => 0,
            'max_price' => 0,
            'avg_duration' => 0,
            'total_bookings' => 0,
            'avg_rating' => 0
        ];
    }

    /**
     * Get tours by date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @return array The tours in date range
     */
    public function getToursByDateRange(string $startDate, string $endDate, int $limit = 0): array
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
     * Get recent tours
     * 
     * @param int $limit The limit of results
     * @return array The recent tours
     */
    public function getRecentTours(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get tours by sort order
     * 
     * @param string $direction The sort direction (ASC or DESC)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The sorted tours
     */
    public function getToursBySortOrder(string $direction = 'ASC', int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('sort_order', $direction)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get tours with discount
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The tours with discount
     */
    public function getToursWithDiscount(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('discount_price >', 0)
                        ->where('publish', 1)
                        ->where('status', 1)
                        ->orderBy('discount_percentage', 'DESC')
                        ->orderBy('sort_order', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Increment view count
     * 
     * @param int $tourId The tour ID
     * @return bool True if successful, false otherwise
     */
    public function incrementViewCount(int $tourId): bool
    {
        $tour = $this->find($tourId);
        if (!$tour) {
            return false;
        }

        $viewCount = $tour['view_count'] ?? 0;
        return $this->update($tourId, ['view_count' => $viewCount + 1]);
    }

    /**
     * Increment booking count
     * 
     * @param int $tourId The tour ID
     * @return bool True if successful, false otherwise
     */
    public function incrementBookingCount(int $tourId): bool
    {
        $tour = $this->find($tourId);
        if (!$tour) {
            return false;
        }

        $bookingCount = $tour['booking_count'] ?? 0;
        return $this->update($tourId, ['booking_count' => $bookingCount + 1]);
    }

    /**
     * Update tour rating
     * 
     * @param int $tourId The tour ID
     * @param float $rating The new rating
     * @return bool True if successful, false otherwise
     */
    public function updateTourRating(int $tourId, float $rating): bool
    {
        $tour = $this->find($tourId);
        if (!$tour) {
            return false;
        }

        $currentRating = $tour['rating'] ?? 0;
        $currentCount = $tour['rating_count'] ?? 0;
        
        if ($currentCount > 0) {
            $newRating = (($currentRating * $currentCount) + $rating) / ($currentCount + 1);
        } else {
            $newRating = $rating;
        }

        return $this->update($tourId, [
            'rating' => $newRating,
            'rating_count' => $currentCount + 1
        ]);
    }

    /**
     * Get available duration types
     * 
     * @return array The available duration types
     */
    public function getAvailableDurationTypes(): array
    {
        return $this->select('duration_type, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('duration_type IS NOT NULL')
                    ->where('duration_type !=', '')
                    ->groupBy('duration_type')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Get available currencies
     * 
     * @return array The available currencies
     */
    public function getAvailableCurrencies(): array
    {
        return $this->select('price_currency, COUNT(*) as count')
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('price_currency IS NOT NULL')
                    ->where('price_currency !=', '')
                    ->groupBy('price_currency')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }
}
