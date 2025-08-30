<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * CommentModel - Manages comments and user feedback
 * 
 * This model handles comments on various objects including articles,
 * products, and other content with moderation and approval features.
 * 
 * @package App\Models
 * @author System
 */
class CommentModel extends Model
{
    protected $table = 'comment';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'content',
        'object_id',
        'object_type',
        'member_id',
        'user_id',
        'parent_id',
        'status',
        'publish',
        'featured',
        'hot',
        'new',
        'sort_order',
        'rating',
        'likes',
        'dislikes',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $validationRules = [
        'content' => 'required|min_length[10]|max_length[1000]',
        'object_id' => 'required|integer',
        'object_type' => 'required|max_length[100]',
        'member_id' => 'permit_empty|integer',
        'user_id' => 'permit_empty|integer',
        'parent_id' => 'permit_empty|integer',
        'status' => 'permit_empty|in_list[0,1,2]',
        'publish' => 'permit_empty|in_list[0,1]',
        'featured' => 'permit_empty|in_list[0,1]',
        'hot' => 'permit_empty|in_list[0,1]',
        'new' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer',
        'rating' => 'permit_empty|integer|greater_than[0]|less_than_equal_to[5]',
        'likes' => 'permit_empty|integer',
        'dislikes' => 'permit_empty|integer',
        'userid_created' => 'permit_empty|integer',
        'userid_updated' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'content' => [
            'required' => 'Comment content is required',
            'min_length' => 'Comment content must be at least 10 characters long',
            'max_length' => 'Comment content cannot exceed 1000 characters'
        ],
        'object_id' => [
            'required' => 'Object ID is required',
            'integer' => 'Object ID must be a valid integer'
        ],
        'object_type' => [
            'required' => 'Object type is required',
            'max_length' => 'Object type cannot exceed 100 characters'
        ],
        'member_id' => [
            'integer' => 'Member ID must be a valid integer'
        ],
        'user_id' => [
            'integer' => 'User ID must be a valid integer'
        ],
        'parent_id' => [
            'integer' => 'Parent ID must be a valid integer'
        ],
        'status' => [
            'in_list' => 'Status must be either 0 (pending), 1 (approved), or 2 (rejected)'
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
        'rating' => [
            'integer' => 'Rating must be a valid integer',
            'greater_than' => 'Rating must be greater than 0',
            'less_than_equal_to' => 'Rating cannot exceed 5'
        ],
        'likes' => [
            'integer' => 'Likes must be a valid integer'
        ],
        'dislikes' => [
            'integer' => 'Dislikes must be a valid integer'
        ],
        'userid_created' => [
            'integer' => 'User ID created must be a valid integer'
        ],
        'userid_updated' => [
            'integer' => 'User ID updated must be a valid integer'
        ]
    ];

    /**
     * Get comments by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The comments
     */
    public function getCommentsByObject(int $objectId, string $objectType, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('object_id', $objectId)
                        ->where('object_type', $objectType)
                        ->where('publish', 1)
                        ->where('status', 1) // Approved comments only
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get comments by member
     * 
     * @param int $memberId The member ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The comments
     */
    public function getCommentsByMember(int $memberId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('member_id', $memberId)
                        ->where('publish', 1)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get comments by user
     * 
     * @param int $userId The user ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The comments
     */
    public function getCommentsByUser(int $userId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('user_id', $userId)
                        ->where('publish', 1)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get comments by parent (replies)
     * 
     * @param int $parentId The parent comment ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The reply comments
     */
    public function getCommentsByParent(int $parentId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('parent_id', $parentId)
                        ->where('publish', 1)
                        ->where('status', 1) // Approved comments only
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get comments by status
     * 
     * @param int $status The comment status (0=pending, 1=approved, 2=rejected)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The comments
     */
    public function getCommentsByStatus(int $status, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('status', $status)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get pending comments
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The pending comments
     */
    public function getPendingComments(int $limit = 0, int $offset = 0): array
    {
        return $this->getCommentsByStatus(0, $limit, $offset);
    }

    /**
     * Get approved comments
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The approved comments
     */
    public function getApprovedComments(int $limit = 0, int $offset = 0): array
    {
        return $this->getCommentsByStatus(1, $limit, $offset);
    }

    /**
     * Get rejected comments
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The rejected comments
     */
    public function getRejectedComments(int $limit = 0, int $offset = 0): array
    {
        return $this->getCommentsByStatus(2, $limit, $offset);
    }

    /**
     * Get featured comments
     * 
     * @param int $limit The limit of results
     * @return array The featured comments
     */
    public function getFeaturedComments(int $limit = 10): array
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
     * Get hot comments
     * 
     * @param int $limit The limit of results
     * @return array The hot comments
     */
    public function getHotComments(int $limit = 10): array
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
     * Get new comments
     * 
     * @param int $limit The limit of results
     * @return array The new comments
     */
    public function getNewComments(int $limit = 10): array
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
     * Get comments with member details
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @return array The comments with member details
     */
    public function getCommentsWithMemberDetails(int $objectId, string $objectType, int $limit = 0): array
    {
        $builder = $this->select('comment.*, members.fullname as member_name, members.avatar as member_avatar')
                        ->join('members', 'members.id = comment.member_id', 'left')
                        ->where('comment.object_id', $objectId)
                        ->where('comment.object_type', $objectType)
                        ->where('comment.publish', 1)
                        ->where('comment.status', 1)
                        ->orderBy('comment.sort_order', 'ASC')
                        ->orderBy('comment.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get comments with user details
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @param int $limit The limit of results
     * @return array The comments with user details
     */
    public function getCommentsWithUserDetails(int $objectId, string $objectType, int $limit = 0): array
    {
        $builder = $this->select('comment.*, users.fullname as user_name, users.avatar as user_avatar')
                        ->join('users', 'users.id = comment.user_id', 'left')
                        ->where('comment.object_id', $objectId)
                        ->where('comment.object_type', $objectType)
                        ->where('comment.publish', 1)
                        ->where('comment.status', 1)
                        ->orderBy('comment.sort_order', 'ASC')
                        ->orderBy('comment.created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get comment tree structure
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return array The comment tree
     */
    public function getCommentTree(int $objectId, string $objectType): array
    {
        $comments = $this->getCommentsWithMemberDetails($objectId, $objectType);
        $tree = [];
        
        foreach ($comments as $comment) {
            if ($comment['parent_id'] === null) {
                $replies = $this->getCommentsByParent($comment['id']);
                if (!empty($replies)) {
                    $comment['replies'] = $replies;
                }
                $tree[] = $comment;
            }
        }
        
        return $tree;
    }

    /**
     * Search comments by content
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchComments(string $keyword, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('publish', 1)
                        ->like('content', $keyword)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get comment count by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return int The comment count
     */
    public function getCommentCountByObject(int $objectId, string $objectType): int
    {
        return $this->where('object_id', $objectId)
                    ->where('object_type', $objectType)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get comment count by status
     * 
     * @return array The counts by status
     */
    public function getCommentCounts(): array
    {
        return [
            'total' => $this->countAllResults(),
            'published' => $this->where('publish', 1)->countAllResults(),
            'unpublished' => $this->where('publish', 0)->countAllResults(),
            'pending' => $this->where('status', 0)->countAllResults(),
            'approved' => $this->where('status', 1)->countAllResults(),
            'rejected' => $this->where('status', 2)->countAllResults(),
            'featured' => $this->where('featured', 1)->where('publish', 1)->countAllResults(),
            'hot' => $this->where('hot', 1)->where('publish', 1)->countAllResults(),
            'new' => $this->where('new', 1)->where('publish', 1)->countAllResults()
        ];
    }

    /**
     * Approve comment
     * 
     * @param int $commentId The comment ID
     * @return bool True if successful, false otherwise
     */
    public function approveComment(int $commentId): bool
    {
        return $this->update($commentId, ['status' => 1]);
    }

    /**
     * Reject comment
     * 
     * @param int $commentId The comment ID
     * @return bool True if successful, false otherwise
     */
    public function rejectComment(int $commentId): bool
    {
        return $this->update($commentId, ['status' => 2]);
    }

    /**
     * Toggle comment like
     * 
     * @param int $commentId The comment ID
     * @return bool True if successful, false otherwise
     */
    public function toggleCommentLike(int $commentId): bool
    {
        $comment = $this->find($commentId);
        if (!$comment) {
            return false;
        }
        
        $likes = $comment['likes'] ?? 0;
        return $this->update($commentId, ['likes' => $likes + 1]);
    }

    /**
     * Toggle comment dislike
     * 
     * @param int $commentId The comment ID
     * @return bool True if successful, false otherwise
     */
    public function toggleCommentDislike(int $commentId): bool
    {
        $comment = $this->find($commentId);
        if (!$comment) {
            return false;
        }
        
        $dislikes = $comment['dislikes'] ?? 0;
        return $this->update($commentId, ['dislikes' => $dislikes + 1]);
    }

    /**
     * Get average rating by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return float The average rating
     */
    public function getAverageRatingByObject(int $objectId, string $objectType): float
    {
        $result = $this->select('AVG(rating) as avg_rating')
                       ->where('object_id', $objectId)
                       ->where('object_type', $objectType)
                       ->where('publish', 1)
                       ->where('status', 1)
                       ->where('rating >', 0)
                       ->first();
        
        return $result ? (float) $result['avg_rating'] : 0.0;
    }

    /**
     * Get rating distribution by object
     * 
     * @param int $objectId The object ID
     * @param string $objectType The object type
     * @return array The rating distribution
     */
    public function getRatingDistributionByObject(int $objectId, string $objectType): array
    {
        return $this->select('rating, COUNT(*) as count')
                    ->where('object_id', $objectId)
                    ->where('object_type', $objectType)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->where('rating >', 0)
                    ->groupBy('rating')
                    ->orderBy('rating', 'DESC')
                    ->findAll();
    }
}
