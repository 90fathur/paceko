<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/auth/login', [
            'title' => 'Login Admin - PACEKO.com'
        ]);
    }

    public function attemptLogin()
    {
        $username = trim((string)$this->request->getPost('username'));
        $password = (string)$this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan Password wajib diisi.');
        }

        $user = $this->userModel->getUserByUsernameOrEmail($username);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Pengguna tidak ditemukan.');
        }

        if (!$this->userModel->verifyPassword($user, $password)) {
            return redirect()->back()->withInput()->with('error', 'Password yang Anda masukkan salah.');
        }

        // Set session
        session()->set([
            'user_id'      => (int)$user['ID'],
            'username'     => $user['user_login'],
            'display_name' => $user['display_name'] ?? $user['user_login'],
            'email'        => $user['user_email'],
            'logged_in'    => true
        ]);

        return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang kembali, ' . esc($user['display_name'] ?? $user['user_login']));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Anda telah berhasil logout.');
    }
}

