<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\CategoryModel;
use App\Models\PageModel;

class Menus extends BaseController
{
    protected $menuModel;
    protected $categoryModel;
    protected $pageModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->categoryModel = new CategoryModel();
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        $menuTree = $this->menuModel->getMenuTree(false);
        $parentMenus = $this->menuModel->getParentMenus();
        $categories = $this->categoryModel->getAllCategories('name', 'ASC');
        $pages = $this->pageModel->getAllPages();

        $data = [
            'title'       => 'Pengaturan Menu & Dropdown - Admin PACEKO.com',
            'activeMenu'  => 'menus',
            'menuTree'    => $menuTree,
            'parentMenus' => $parentMenus,
            'categories'  => $categories,
            'pages'       => $pages
        ];

        return view('admin/menus/index', $data);
    }

    public function store()
    {
        $title = trim((string)$this->request->getPost('title'));
        $url = trim((string)$this->request->getPost('url'));
        $parentId = (int)$this->request->getPost('parent_id');
        $orderNum = (int)$this->request->getPost('order_num');
        $target = $this->request->getPost('target') ?? '_self';
        $isActive = $this->request->getPost('is_active') !== null ? 1 : 0;

        if (empty($title) || empty($url)) {
            return redirect()->back()->with('error', 'Nama menu dan URL tautan wajib diisi.');
        }

        $this->menuModel->insert([
            'title'      => $title,
            'url'        => $url,
            'parent_id'  => $parentId,
            'order_num'  => $orderNum,
            'target'     => $target,
            'is_active'  => $isActive,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/menus')->with('success', 'Menu navigasi berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $menu = $this->menuModel->find((int)$id);
        if (!$menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu tidak ditemukan.');
        }

        $title = trim((string)$this->request->getPost('title'));
        $url = trim((string)$this->request->getPost('url'));
        $parentId = (int)$this->request->getPost('parent_id');
        $orderNum = (int)$this->request->getPost('order_num');
        $target = $this->request->getPost('target') ?? '_self';
        $isActive = $this->request->getPost('is_active') !== null ? 1 : 0;

        // Prevent menu from becoming parent of itself
        if ($parentId === (int)$id) {
            $parentId = 0;
        }

        if (empty($title) || empty($url)) {
            return redirect()->back()->with('error', 'Nama menu dan URL tautan wajib diisi.');
        }

        $this->menuModel->update((int)$id, [
            'title'     => $title,
            'url'       => $url,
            'parent_id' => $parentId,
            'order_num' => $orderNum,
            'target'    => $target,
            'is_active' => $isActive
        ]);

        return redirect()->to('/admin/menus')->with('success', 'Menu navigasi berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $menu = $this->menuModel->find((int)$id);
        if (!$menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu tidak ditemukan.');
        }

        $this->menuModel->deleteMenu((int)$id);
        return redirect()->to('/admin/menus')->with('success', 'Menu berhasil dihapus.');
    }
}

