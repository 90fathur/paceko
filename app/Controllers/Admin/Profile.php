<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title'      => 'Profil Pengguna - Admin PACEKO.com',
            'activeMenu' => 'profile',
            'user'       => $user
        ];

        return view('admin/profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $displayName = trim((string)$this->request->getPost('display_name'));
        $email = trim((string)$this->request->getPost('user_email'));

        if (empty($displayName) || empty($email)) {
            return redirect()->back()->with('error', 'Nama dan Email wajib diisi.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Format alamat email tidak valid.');
        }

        $this->userModel->updateProfile($userId, [
            'display_name' => $displayName,
            'user_email'   => $email
        ]);

        session()->set('display_name', $displayName);
        session()->set('email', $email);

        return redirect()->to('/admin/profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $userId = session()->get('user_id');
        $currentPassword = (string)$this->request->getPost('current_password');
        $newPassword = (string)$this->request->getPost('new_password');
        $confirmPassword = (string)$this->request->getPost('confirm_password');

        if (empty($currentPassword) || empty($newPassword)) {
            return redirect()->back()->with('error', 'Semua kolom password wajib diisi.');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok.');
        }

        // BSSN Standard: Minimum 8 characters for admin authentication
        if (strlen($newPassword) < 8) {
            return redirect()->back()->with('error', 'Password baru minimal 8 karakter sesuai standar keamanan.');
        }

        $user = $this->userModel->find($userId);
        if (!$this->userModel->verifyPassword($user, $currentPassword)) {
            return redirect()->back()->with('error', 'Password saat ini salah.');
        }

        $this->userModel->updatePassword($userId, $newPassword);
        return redirect()->to('/admin/profile')->with('success', 'Password berhasil diperbarui.');
    }
}

