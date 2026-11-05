<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'paceko_menus';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'url', 'parent_id', 'order_num', 'target', 'is_active', 'created_at'
    ];

    /**
     * Get hierarchical menu tree with children for navigation
     */
    public function getMenuTree(bool $onlyActive = true): array
    {
        $builder = $this->orderBy('order_num', 'ASC')->orderBy('id', 'ASC');
        if ($onlyActive) {
            $builder->where('is_active', 1);
        }
        $allMenus = $builder->findAll();

        $tree = [];
        $children = [];

        foreach ($allMenus as $menu) {
            $parentId = (int)$menu['parent_id'];
            if ($parentId === 0) {
                $tree[$menu['id']] = $menu;
                $tree[$menu['id']]['children'] = [];
            } else {
                $children[$parentId][] = $menu;
            }
        }

        foreach ($children as $parentId => $items) {
            if (isset($tree[$parentId])) {
                $tree[$parentId]['children'] = $items;
            }
        }

        return array_values($tree);
    }

    /**
     * Get all parent menus (for select dropdown in admin)
     */
    public function getParentMenus(?int $excludeId = null): array
    {
        $builder = $this->where('parent_id', 0)->orderBy('order_num', 'ASC');
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        return $builder->findAll();
    }

    /**
     * Delete menu and its children
     */
    public function deleteMenu(int $id): bool
    {
        // Delete child items
        $this->where('parent_id', $id)->delete();
        // Delete parent
        return (bool)$this->delete($id);
    }
}

