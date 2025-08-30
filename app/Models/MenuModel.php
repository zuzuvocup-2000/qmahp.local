<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Menu Model
 * 
 * Handles database operations for the menu table including
 * menu management, hierarchy, and relationship handling
 * 
 * @package App\Models
 */
class MenuModel extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'menu';

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
        'url',
        'target',
        'icon',
        'parent_id',
        'menu_catalogue_id',
        'status',
        'publish',
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
        'canonical' => 'required|min_length[2]|max_length[255]|is_unique[menu.canonical,id,{id}]',
        'url' => 'permit_empty|max_length[500]',
        'target' => 'permit_empty|in_list[_self,_blank,_parent,_top]',
        'icon' => 'permit_empty|max_length[100]',
        'parent_id' => 'permit_empty|integer',
        'status' => 'permit_empty|in_list[0,1]',
        'publish' => 'permit_empty|in_list[0,1]',
        'order' => 'permit_empty|integer'
    ];

    /**
     * Validation messages
     * 
     * @var array
     */
    protected $validationMessages = [
        'title' => [
            'required' => 'Menu title is required',
            'min_length' => 'Menu title must be at least 2 characters long',
            'max_length' => 'Menu title cannot exceed 255 characters'
        ],
        'canonical' => [
            'required' => 'Menu canonical is required',
            'min_length' => 'Menu canonical must be at least 2 characters long',
            'max_length' => 'Menu canonical cannot exceed 255 characters',
            'is_unique' => 'Menu canonical must be unique'
        ],
        'url' => [
            'max_length' => 'URL cannot exceed 500 characters'
        ],
        'target' => [
            'in_list' => 'Target must be _self, _blank, _parent, or _top'
        ],
        'icon' => [
            'max_length' => 'Icon cannot exceed 100 characters'
        ],
        'parent_id' => [
            'integer' => 'Parent ID must be a valid integer'
        ],
        'status' => [
            'in_list' => 'Status must be either 0 or 1'
        ],
        'publish' => [
            'in_list' => 'Publish must be either 0 or 1'
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
     * Get menu by canonical
     * 
     * @param string $canonical Menu canonical
     * @return array|null Menu data
     */
    public function getMenuByCanonical(string $canonical): ?array
    {
        return $this->where('canonical', $canonical)
                    ->where('publish', 1)
                    ->first();
    }

    /**
     * Get menus by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Menus in catalogue
     */
    public function getMenusByCatalogue(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('menu_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get root menus (no parent)
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Root menus
     */
    public function getRootMenus(int $catalogueId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('menu_catalogue_id', $catalogueId)
                    ->where('parent_id IS NULL OR parent_id = 0')
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get child menus
     * 
     * @param int $parentId Parent menu ID
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Child menus
     */
    public function getChildMenus(int $parentId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('parent_id', $parentId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Get menu tree
     * 
     * @param int $catalogueId Catalogue ID
     * @param int $parentId Parent ID (0 for root)
     * @return array Menu tree
     */
    public function getMenuTree(int $catalogueId, int $parentId = 0): array
    {
        $menus = $this->where('menu_catalogue_id', $catalogueId)
                      ->where('parent_id', $parentId)
                      ->where('publish', 1)
                      ->orderBy('order', 'ASC')
                      ->findAll();

        foreach ($menus as &$menu) {
            $children = $this->getMenuTree($catalogueId, $menu['id']);
            if (!empty($children)) {
                $menu['children'] = $children;
            }
        }

        return $menus;
    }

    /**
     * Get menu breadcrumb
     * 
     * @param int $menuId Menu ID
     * @return array Menu breadcrumb
     */
    public function getMenuBreadcrumb(int $menuId): array
    {
        $breadcrumb = [];
        $currentMenu = $this->find($menuId);

        if (!$currentMenu) {
            return $breadcrumb;
        }

        $breadcrumb[] = $currentMenu;

        while ($currentMenu['parent_id'] && $currentMenu['parent_id'] > 0) {
            $currentMenu = $this->find($currentMenu['parent_id']);
            if ($currentMenu) {
                array_unshift($breadcrumb, $currentMenu);
            } else {
                break;
            }
        }

        return $breadcrumb;
    }

    /**
     * Get menus by status
     * 
     * @param int $status Menu status
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Menus by status
     */
    public function getMenusByStatus(int $status, int $limit = 10, int $offset = 0): array
    {
        return $this->where('status', $status)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }

    /**
     * Search menus
     * 
     * @param string $keyword Search keyword
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array Search results
     */
    public function searchMenus(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->builder();
        
        $builder->like('title', $keyword)
                ->orLike('canonical', $keyword)
                ->orLike('url', $keyword);
        
        $builder->where('publish', 1);
        $builder->orderBy('order', 'ASC');
        $builder->limit($limit, $offset);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Update menu order
     * 
     * @param int $menuId Menu ID
     * @param int $order New order
     * @return bool Update success
     */
    public function updateMenuOrder(int $menuId, int $order): bool
    {
        return $this->update($menuId, ['order' => $order]);
    }

    /**
     * Update menu parent
     * 
     * @param int $menuId Menu ID
     * @param int $parentId New parent ID
     * @return bool Update success
     */
    public function updateMenuParent(int $menuId, int $parentId): bool
    {
        return $this->update($menuId, ['parent_id' => $parentId]);
    }

    /**
     * Get menus count by catalogue
     * 
     * @param int $catalogueId Catalogue ID
     * @return int Count of menus
     */
    public function getMenusCountByCatalogue(int $catalogueId): int
    {
        return $this->where('menu_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get menus count by status
     * 
     * @param int $status Menu status
     * @return int Count of menus
     */
    public function getMenusCountByStatus(int $status): int
    {
        return $this->where('status', $status)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Get menus count by parent
     * 
     * @param int $parentId Parent ID
     * @return int Count of menus
     */
    public function getMenusCountByParent(int $parentId): int
    {
        return $this->where('parent_id', $parentId)
                    ->where('publish', 1)
                    ->countAllResults();
    }

    /**
     * Check if menu has children
     * 
     * @param int $menuId Menu ID
     * @return bool True if has children
     */
    public function hasChildren(int $menuId): bool
    {
        return $this->where('parent_id', $menuId)
                    ->where('publish', 1)
                    ->countAllResults() > 0;
    }

    /**
     * Get menus for dropdown
     * 
     * @param int $catalogueId Catalogue ID
     * @return array Menus for dropdown
     */
    public function getMenusForDropdown(int $catalogueId): array
    {
        return $this->select('id, title, parent_id')
                    ->where('menu_catalogue_id', $catalogueId)
                    ->where('publish', 1)
                    ->orderBy('order', 'ASC')
                    ->findAll();
    }
}
