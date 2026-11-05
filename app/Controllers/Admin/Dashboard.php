<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;

class Dashboard extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $stats = $this->postModel->getDashboardStats();
        $recentNews = $this->postModel->getAdminPosts([], 8, 0);
        $popularNews = $this->postModel->getPopularPosts(6);

        $data = [
            'title'       => 'Dashboard - Admin PACEKO.com',
            'activeMenu'  => 'dashboard',
            'stats'       => $stats,
            'recentNews'  => $recentNews,
            'popularNews' => $popularNews
        ];

        return view('admin/dashboard', $data);
    }
}

