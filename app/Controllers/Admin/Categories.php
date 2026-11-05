<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories('name', 'ASC');

        $data = [
            'title'      => 'Kelola Kategori - Admin PACEKO.com',
            'activeMenu' => 'categories',
            'categories' => $categories
        ];

        return view('admin/categories/index', $data);
    }

    public function store()
    {
        $name = trim((string)$this->request->getPost('name'));
        $slug = trim((string)$this->request->getPost('slug'));
        $desc = trim((string)$this->request->getPost('description'));

        if (empty($name)) {
            return redirect()->back()->with('error', 'Nama kategori wajib diisi.');
        }

        $this->categoryModel->createCategory($name, $slug, $desc);
        return redirect()->to('/admin/categories')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $name = trim((string)$this->request->getPost('name'));
        $slug = trim((string)$this->request->getPost('slug'));
        $desc = trim((string)$this->request->getPost('description'));

        if (empty($name)) {
            return redirect()->back()->with('error', 'Nama kategori wajib diisi.');
        }

        $this->categoryModel->updateCategory((int)$id, $name, $slug, $desc);
        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $this->categoryModel->deleteCategory((int)$id);
        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus.');
    }
}

