<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;

class Pages extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        $pages = $this->pageModel->getAllPages();

        $data = [
            'title'      => 'Kelola Halaman Statis - Admin PACEKO.com',
            'activeMenu' => 'pages',
            'pages'      => $pages
        ];

        return view('admin/pages/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Halaman Baru - Admin PACEKO.com',
            'activeMenu' => 'pages_create'
        ];

        return view('admin/pages/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'   => 'required|min_length[3]|max_length[250]',
            'content' => 'required',
            'status'  => 'required|in_list[publish,draft]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pageData = [
            'title'   => $this->request->getPost('title'),
            'slug'    => $this->request->getPost('slug'),
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $this->request->getPost('content'),
            'status'  => $this->request->getPost('status')
        ];

        $this->pageModel->createPage($pageData);
        return redirect()->to('/admin/pages')->with('success', 'Halaman berhasil diterbitkan!');
    }

    public function edit($id = null)
    {
        $page = $this->pageModel->find((int)$id);
        if (!$page) {
            return redirect()->to('/admin/pages')->with('error', 'Halaman tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Halaman: ' . esc($page['post_title']),
            'activeMenu' => 'pages',
            'page'       => $page
        ];

        return view('admin/pages/edit', $data);
    }

    public function update($id = null)
    {
        $page = $this->pageModel->find((int)$id);
        if (!$page) {
            return redirect()->to('/admin/pages')->with('error', 'Halaman tidak ditemukan.');
        }

        $rules = [
            'title'   => 'required|min_length[3]|max_length[250]',
            'content' => 'required',
            'status'  => 'required|in_list[publish,draft]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pageData = [
            'title'   => $this->request->getPost('title'),
            'slug'    => $this->request->getPost('slug'),
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $this->request->getPost('content'),
            'status'  => $this->request->getPost('status')
        ];

        $this->pageModel->updatePage((int)$id, $pageData);
        return redirect()->to('/admin/pages')->with('success', 'Halaman berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $page = $this->pageModel->find((int)$id);
        if (!$page) {
            return redirect()->to('/admin/pages')->with('error', 'Halaman tidak ditemukan.');
        }

        $this->pageModel->delete((int)$id);
        return redirect()->to('/admin/pages')->with('success', 'Halaman berhasil dihapus.');
    }
}

