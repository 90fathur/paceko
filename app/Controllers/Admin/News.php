<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;

class News extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * List News with search, category filter & pagination
     */
    public function index()
    {
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 15;
        $offset = ($page - 1) * $limit;

        $filters = [
            'search'   => trim((string)$this->request->getGet('search')),
            'category' => trim((string)$this->request->getGet('category')),
            'status'   => trim((string)$this->request->getGet('status')),
        ];

        $news = $this->postModel->getAdminPosts($filters, $limit, $offset);
        $totalNews = $this->postModel->countAdminPosts($filters);
        $totalPages = ceil($totalNews / $limit);
        $categories = $this->categoryModel->getAllCategories('name', 'ASC');

        $data = [
            'title'       => 'Kelola Berita - Admin PACEKO.com',
            'activeMenu'  => 'news',
            'news'        => $news,
            'categories'  => $categories,
            'filters'     => $filters,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'totalNews'   => $totalNews,
            'limit'       => $limit
        ];

        return view('admin/news/index', $data);
    }

    /**
     * Create News Form
     */
    public function create()
    {
        $categories = $this->categoryModel->getAllCategories('name', 'ASC');

        $data = [
            'title'      => 'Tulis Berita Baru - Admin PACEKO.com',
            'activeMenu' => 'news_create',
            'categories' => $categories
        ];

        return view('admin/news/create', $data);
    }

    /**
     * Store News
     */
    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[5]|max_length[300]',
            'category_id' => 'required|numeric',
            'content'     => 'required|min_length[10]',
            'status'      => 'required|in_list[publish,draft]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $featuredImagePath = null;
            $imageFile = $this->request->getFile('featured_image');

            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                $newName = $imageFile->getRandomName();
                $uploadDir = FCPATH . 'uploads/news';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imageFile->move($uploadDir, $newName);
                $featuredImagePath = 'news/' . $newName;
            }

            $postData = [
                'title'     => $this->request->getPost('title'),
                'slug'      => $this->request->getPost('slug'),
                'excerpt'   => $this->request->getPost('excerpt'),
                'content'   => $this->request->getPost('content'),
                'status'    => $this->request->getPost('status'),
                'author_id' => session()->get('user_id') ?? 1
            ];

            $categoryId = (int)$this->request->getPost('category_id');
            $postId = $this->postModel->createNews($postData, $featuredImagePath, $categoryId);

            return redirect()->to('/admin/news')->with('success', 'Berita berhasil diterbitkan!');
        } catch (\Throwable $e) {
            log_message('error', 'Gagal menerbitkan berita: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menerbitkan berita: ' . $e->getMessage());
        }
    }

    /**
     * Edit News Form
     */
    public function edit($id = null)
    {
        $news = $this->postModel->getPostById((int)$id);
        if (!$news) {
            return redirect()->to('/admin/news')->with('error', 'Berita tidak ditemukan.');
        }

        $categories = $this->categoryModel->getAllCategories('name', 'ASC');

        $data = [
            'title'      => 'Edit Berita - Admin PACEKO.com',
            'activeMenu' => 'news',
            'news'       => $news,
            'categories' => $categories
        ];

        return view('admin/news/edit', $data);
    }

    /**
     * Update News
     */
    public function update($id = null)
    {
        $news = $this->postModel->getPostById((int)$id);
        if (!$news) {
            return redirect()->to('/admin/news')->with('error', 'Berita tidak ditemukan.');
        }

        $rules = [
            'title'       => 'required|min_length[5]|max_length[300]',
            'category_id' => 'required|numeric',
            'content'     => 'required|min_length[10]',
            'status'      => 'required|in_list[publish,draft]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $featuredImagePath = null;
            $imageFile = $this->request->getFile('featured_image');

            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                $newName = $imageFile->getRandomName();
                $uploadDir = FCPATH . 'uploads/news';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imageFile->move($uploadDir, $newName);
                $featuredImagePath = 'news/' . $newName;
            }

            $postData = [
                'title'   => $this->request->getPost('title'),
                'slug'    => $this->request->getPost('slug'),
                'excerpt' => $this->request->getPost('excerpt'),
                'content' => $this->request->getPost('content'),
                'status'  => $this->request->getPost('status'),
            ];

            $categoryId = (int)$this->request->getPost('category_id');
            $this->postModel->updateNews((int)$id, $postData, $featuredImagePath, $categoryId);

            return redirect()->to('/admin/news')->with('success', 'Berita berhasil diperbarui!');
        } catch (\Throwable $e) {
            log_message('error', 'Gagal memperbarui berita: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui berita: ' . $e->getMessage());
        }
    }

    /**
     * Delete News
     */
    public function delete($id = null)
    {
        $news = $this->postModel->getPostById((int)$id);
        if (!$news) {
            return redirect()->to('/admin/news')->with('error', 'Berita tidak ditemukan.');
        }

        $this->postModel->deleteNews((int)$id);
        return redirect()->to('/admin/news')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Upload Image Endpoint for Rich Text Editor (Summernote / Quill / CKEditor)
     */
    public function uploadImage()
    {
        $file = $this->request->getFile('image');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File tidak valid atau tidak ditemukan.'
            ])->setStatusCode(400);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Format file harus berupa JPG, PNG, GIF, atau WebP.'
            ])->setStatusCode(400);
        }

        if ($file->getSizeByUnit('mb') > 8) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ukuran gambar maksimal 8MB.'
            ])->setStatusCode(400);
        }

        $uploadDir = FCPATH . 'uploads/news';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadDir, $newName);

        $imageUrl = base_url('uploads/news/' . $newName);

        return $this->response->setJSON([
            'success' => true,
            'url'     => $imageUrl
        ]);
    }
}

