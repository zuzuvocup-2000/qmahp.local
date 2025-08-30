<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * ReplyModel - Manages comment replies and nested discussions
 * 
 * This model handles replies to comments, creating threaded discussions
 * with proper moderation and approval features.
 * 
 * @package App\Models
 * @author System
 */
class ReplyModel extends Model
{
    protected $table = 'reply';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'content',
        'comment_id',
        'member_id',
        'user_id',
        'parent_reply_id',
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
        'content' => 'required|min_length[5]|max_length[500]',
        'comment_id' => 'required|integer',
        'member_id' => 'permit_empty|integer',
        'user_id' => 'permit_empty|integer',
        'parent_reply_id' => 'permit_empty|integer',
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
            'required' => 'Reply content is required',
            'min_length' => 'Reply content must be at least 5 characters long',
            'max_length' => 'Reply content cannot exceed 500 characters'
        ],
        'comment_id' => [
            'required' => 'Comment ID is required',
            'integer' => 'Comment ID must be a valid integer'
        ],
        'member_id' => [
            'integer' => 'Member ID must be a valid integer'
        ],
        'user_id' => [
            'integer' => 'User ID must be a valid integer'
        ],
        'parent_reply_id' => [
            'integer' => 'Parent reply ID must be a valid integer'
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
     * Get replies by comment
     * 
     * @param int $commentId The comment ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The replies
     */
    public function getRepliesByComment(int $commentId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('comment_id', $commentId)
                        ->where('publish', 1)
                        ->where('status', 1) // Approved replies only
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get replies by member
     * 
     * @param int $memberId The member ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The replies
     */
    public function getRepliesByMember(int $memberId, int $limit = 0, int $offset = 0): array
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
     * Get replies by user
     * 
     * @param int $userId The user ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The replies
     */
    public function getRepliesByUser(int $userId, int $limit = 0, int $offset = 0): array
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
     * Get replies by parent reply (nested replies)
     * 
     * @param int $parentReplyId The parent reply ID
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The nested replies
     */
    public function getRepliesByParent(int $parentReplyId, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('parent_reply_id', $parentReplyId)
                        ->where('publish', 1)
                        ->where('status', 1) // Approved replies only
                        ->orderBy('created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get replies by status
     * 
     * @param int $status The reply status (0=pending, 1=approved, 2=rejected)
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The replies
     */
    public function getRepliesByStatus(int $status, int $limit = 0, int $offset = 0): array
    {
        $builder = $this->where('status', $status)
                        ->orderBy('created_at', 'DESC');
        
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Get pending replies
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The pending replies
     */
    public function getPendingReplies(int $limit = 0, int $offset = 0): array
    {
        return $this->getRepliesByStatus(0, $limit, $offset);
    }

    /**
     * Get approved replies
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The approved replies
     */
    public function getApprovedReplies(int $limit = 0, int $offset = 0): array
    {
        return $this->getRepliesByStatus(1, $limit, $offset);
    }

    /**
     * Get rejected replies
     * 
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The rejected replies
     */
    public function getRejectedReplies(int $limit = 0, int $offset = 0): array
    {
        return $this->getRepliesByStatus(2, $limit, $offset);
    }

    /**
     * Get featured replies
     * 
     * @param int $limit The limit of results
     * @return array The featured replies
     */
    public function getFeaturedReplies(int $limit = 10): array
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
     * Get hot replies
     * 
     * @param int $limit The limit of results
     * @return array The hot replies
     */
    public function getHotReplies(int $limit = 10): array
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
     * Get new replies
     * 
     * @param int $limit The limit of results
     * @return array The new replies
     */
    public function getNewReplies(int $limit = 10): array
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
     * Get replies with member details
     * 
     * @param int $commentId The comment ID
     * @param int $limit The limit of results
     * @return array The replies with member details
     */
    public function getRepliesWithMemberDetails(int $commentId, int $limit = 0): array
    {
        $builder = $this->select('reply.*, members.fullname as member_name, members.avatar as member_avatar')
                        ->join('members', 'members.id = reply.member_id', 'left')
                        ->where('reply.comment_id', $commentId)
                        ->where('reply.publish', 1)
                        ->where('reply.status', 1)
                        ->orderBy('reply.sort_order', 'ASC')
                        ->orderBy('reply.created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get replies with user details
     * 
     * @param int $commentId The comment ID
     * @param int $limit The limit of results
     * @return array The replies with user details
     */
    public function getRepliesWithUserDetails(int $commentId, int $limit = 0): array
    {
        $builder = $this->select('reply.*, users.fullname as user_name, users.avatar as user_avatar')
                        ->join('users', 'users.id = reply.user_id', 'left')
                        ->where('reply.comment_id', $commentId)
                        ->where('reply.publish', 1)
                        ->where('reply.status', 1)
                        ->orderBy('reply.sort_order', 'ASC')
                        ->orderBy('reply.created_at', 'ASC');
        
        if ($limit > 0) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    /**
     * Get reply tree structure for a comment
     * 
     * @param int $commentId The comment ID
     * @return array The reply tree
     */
    public function getReplyTree(int $commentId): array
    {
        $replies = $this->getRepliesWithMemberDetails($commentId);
        $tree = [];
        
        foreach ($replies as $reply) {
            if ($reply['parent_reply_id'] === null) {
                $nestedReplies = $this->getRepliesByParent($reply['id']);
                if (!empty($nestedReplies)) {
                    $reply['nested_replies'] = $nestedReplies;
                }
                $tree[] = $reply;
            }
        }
        
        return $tree;
    }

    /**
     * Get all replies for a comment including nested ones
     * 
     * @param int $commentId The comment ID
     * @return array All replies in flat structure
     */
    public function getAllRepliesForComment(int $commentId): array
    {
        return $this->where('comment_id', $commentId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('parent_reply_id', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Search replies by content
     * 
     * @param string $keyword The search keyword
     * @param int $limit The limit of results
     * @param int $offset The offset for pagination
     * @return array The search results
     */
    public function searchReplies(string $keyword, int $limit = 0, int $offset = 0): array
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
     * Get reply count by comment
     * 
     * @param int $commentId The comment ID
     * @return int The reply count
     */
    public function getReplyCountByComment(int $commentId): int
    {
        return $this->where('comment_id', $commentId)
                    ->where('publish', 1)
                    ->where('status', 1)
                    ->countAllResults();
    }

    /**
     * Get reply count by status
     * 
     * @return array The counts by status
     */
    public function getReplyCounts(): array
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
     * Approve reply
     * 
     * @param int $replyId The reply ID
     * @return bool True if successful, false otherwise
     */
    public function approveReply(int $replyId): bool
    {
        return $this->update($replyId, ['status' => 1]);
    }

    /**
     * Reject reply
     * 
     * @param int $replyId The reply ID
     * @return bool True if successful, false otherwise
     */
    public function rejectReply(int $replyId): bool
    {
        return $this->update($replyId, ['status' => 2]);
    }

    /**
     * Toggle reply like
     * 
     * @param int $replyId The reply ID
     * @return bool True if successful, false otherwise
     */
    public function toggleReplyLike(int $replyId): bool
    {
        $reply = $this->find($replyId);
        if (!$reply) {
            return false;
        }
        
        $likes = $reply['likes'] ?? 0;
        return $this->update($replyId, ['likes' => $likes + 1]);
    }

    /**
     * Toggle reply dislike
     * 
     * @param int $replyId The reply ID
     * @return bool True if successful, false otherwise
     */
    public function toggleReplyDislike(int $replyId): bool
    {
        $reply = $this->find($replyId);
        if (!$reply) {
            return false;
        }
        
        $dislikes = $reply['dislikes'] ?? 0;
        return $this->update($replyId, ['dislikes' => $dislikes + 1]);
    }

    /**
     * Get replies by comment with pagination
     * 
     * @param int $commentId The comment ID
     * @param int $page The page number
     * @param int $perPage The number of replies per page
     * @return array The paginated replies
     */
    public function getRepliesByCommentPaginated(int $commentId, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $replies = $this->getRepliesByComment($commentId, $perPage, $offset);
        $total = $this->getReplyCountByComment($commentId);
        
        return [
            'replies' => $replies,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => ceil($total / $perPage),
                'has_next' => $page < ceil($total / $perPage),
                'has_prev' => $page > 1
            ]
        ];
    }

    /**
     * Get recent replies
     * 
     * @param int $limit The limit of results
     * @return array The recent replies
     */
    public function getRecentReplies(int $limit = 10): array
    {
        return $this->where('publish', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get replies by date range
     * 
     * @param string $startDate The start date (Y-m-d)
     * @param string $endDate The end date (Y-m-d)
     * @param int $limit The limit of results
     * @return array The replies in date range
     */
    public function getRepliesByDateRange(string $startDate, string $endDate, int $limit = 0): array
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
}
