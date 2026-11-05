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

        try {
            $this->categoryModel->createCategory($name, $slug, $desc);
            return redirect()->to('/admin/categories')->with('success', 'Kategori baru berhasil ditambahkan.');
        } catch (\Throwable $e) {
            log_message('error', 'Gagal simpan kategori: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function update($id = null)
    {
        $name = trim((string)$this->request->getPost('name'));
        $slug = trim((string)$this->request->getPost('slug'));
        $desc = trim((string)$this->request->getPost('description'));

        if (empty($name)) {
            return redirect()->back()->with('error', 'Nama kategori wajib diisi.');
        }

        if (empty($id)) {
            return redirect()->back()->with('error', 'ID kategori tidak valid.');
        }

        try {
            $this->categoryModel->updateCategory((int)$id, $name, $slug, $desc);
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Throwable $e) {
            log_message('error', 'Gagal update kategori: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    public function delete($id = null)
    {
        if (empty($id)) {
            return redirect()->back()->with('error', 'ID kategori tidak valid.');
        }

        try {
            $this->categoryModel->deleteCategory((int)$id);
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Throwable $e) {
            log_message('error', 'Gagal hapus kategori: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}

