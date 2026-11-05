<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->orderBy('ID', 'ASC')->findAll();

        $data = [
            'title'      => 'Kelola Wartawan & Pengguna - Admin PACEKO.com',
            'activeMenu' => 'users',
            'users'      => $users
        ];

        return view('admin/users/index', $data);
    }

    public function store()
    {
        $rules = [
            'username'     => 'required|min_length[3]|max_length[60]|is_unique[wp_users.user_login]',
            'display_name' => 'required|min_length[3]|max_length[100]',
            'email'        => 'required|valid_email|is_unique[wp_users.user_email]',
            'password'     => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $now = date('Y-m-d H:i:s');
        $userData = [
            'user_login'           => trim((string)$this->request->getPost('username')),
            'user_pass'            => password_hash((string)$this->request->getPost('password'), PASSWORD_DEFAULT),
            'user_nicename'        => url_title((string)$this->request->getPost('display_name'), '-', true),
            'user_email'           => trim((string)$this->request->getPost('email')),
            'user_url'             => '',
            'user_registered'      => $now,
            'user_activation_key'  => '',
            'user_status'          => 0,
            'display_name'         => trim((string)$this->request->getPost('display_name'))
        ];

        $this->userModel->insert($userData);
        return redirect()->to('/admin/users')->with('success', 'Wartawan/Pengguna baru berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $user = $this->userModel->find((int)$id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $displayName = trim((string)$this->request->getPost('display_name'));
        $email = trim((string)$this->request->getPost('email'));

        $this->userModel->update((int)$id, [
            'display_name'  => $displayName,
            'user_email'    => $email,
            'user_nicename' => url_title($displayName, '-', true)
        ]);

        return redirect()->to('/admin/users')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function resetPassword($id = null)
    {
        $user = $this->userModel->find((int)$id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $newPassword = (string)$this->request->getPost('new_password');
        if (strlen($newPassword) < 8) {
            return redirect()->back()->with('error', 'Kata sandi baru minimal 8 karakter sesuai standar keamanan.');
        }

        $this->userModel->updatePassword((int)$id, $newPassword);
        return redirect()->to('/admin/users')->with('success', 'Kata sandi untuk ' . esc($user['user_login']) . ' berhasil direset!');
    }

    public function delete($id = null)
    {
        if ((int)$id === 1 || (int)$id === (int)session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Anda tidak dapat menghapus akun admin utama atau akun Anda sendiri.');
        }

        $this->userModel->delete((int)$id);
        return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil dihapus.');
    }
}

