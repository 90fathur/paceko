<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BannerModel;

class Banners extends BaseController
{
    protected $bannerModel;

    public function __construct()
    {
        $this->bannerModel = new BannerModel();
    }

    public function index()
    {
        $banners = $this->bannerModel->orderBy('id', 'DESC')->findAll();

        $data = [
            'title'      => 'Kelola Banner Iklan & Sponsor - Admin PACEKO.com',
            'activeMenu' => 'banners',
            'banners'    => $banners
        ];

        return view('admin/banners/index', $data);
    }

    public function store()
    {
        $rules = [
            'title'        => 'required|min_length[3]|max_length[200]',
            'position'     => 'required|in_list[header,home_top,home_middle,sidebar,sidebar_bottom,in_article,after_article,footer]',
            'banner_image' => 'uploaded[banner_image]|max_size[banner_image,5120]|is_image[banner_image]|mime_in[banner_image,image/jpg,image/jpeg,image/png,image/webp,image/gif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('banner_image');
        $newName = $imageFile->getRandomName();
        $uploadDir = FCPATH . 'uploads/banners';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageFile->move($uploadDir, $newName);

        $bannerData = [
            'title'      => trim((string)$this->request->getPost('title')),
            'position'   => $this->request->getPost('position'),
            'image_url'  => 'uploads/banners/' . $newName,
            'target_url' => trim((string)$this->request->getPost('target_url')) ?: '#',
            'start_date' => $this->request->getPost('start_date') ?: null,
            'end_date'   => $this->request->getPost('end_date') ?: null,
            'status'     => $this->request->getPost('status') ?? 'active',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->bannerModel->insert($bannerData);
        return redirect()->to('/admin/banners')->with('success', 'Banner iklan baru berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $banner = $this->bannerModel->find((int)$id);
        if (!$banner) {
            return redirect()->to('/admin/banners')->with('error', 'Banner tidak ditemukan.');
        }

        $rules = [
            'title'        => 'required|min_length[3]|max_length[200]',
            'position'     => 'required|in_list[header,home_top,home_middle,sidebar,sidebar_bottom,in_article,after_article,footer]',
            'banner_image' => 'permit_empty|max_size[banner_image,5120]|is_image[banner_image]|mime_in[banner_image,image/jpg,image/jpeg,image/png,image/webp,image/gif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $bannerData = [
            'title'      => trim((string)$this->request->getPost('title')),
            'position'   => $this->request->getPost('position'),
            'target_url' => trim((string)$this->request->getPost('target_url')) ?: '#',
            'start_date' => $this->request->getPost('start_date') ?: null,
            'end_date'   => $this->request->getPost('end_date') ?: null,
            'status'     => $this->request->getPost('status') ?? 'active'
        ];

        $imageFile = $this->request->getFile('banner_image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $uploadDir = FCPATH . 'uploads/banners';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imageFile->move($uploadDir, $newName);
            $bannerData['image_url'] = 'uploads/banners/' . $newName;
        }

        $this->bannerModel->update((int)$id, $bannerData);
        return redirect()->to('/admin/banners')->with('success', 'Banner iklan berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $banner = $this->bannerModel->find((int)$id);
        if (!$banner) {
            return redirect()->to('/admin/banners')->with('error', 'Banner tidak ditemukan.');
        }

        $this->bannerModel->delete((int)$id);
        return redirect()->to('/admin/banners')->with('success', 'Banner iklan berhasil dihapus.');
    }
}

