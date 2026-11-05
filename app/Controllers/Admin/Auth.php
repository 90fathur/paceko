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
        $ip = $this->request->getIPAddress();
        $cache = \Config\Services::cache();
        $throttleKey = 'login_attempts_' . md5($ip);
        $attempts = (int)$cache->get($throttleKey);

        // BSSN / OWASP: Brute force attack protection (max 5 failed attempts per 15 mins)
        if ($attempts >= 5) {
            log_message('warning', "Login rate limit exceeded for IP: {$ip}");
            return redirect()->back()->with('error', 'Terlalu banyak percobaan login gagal. Demi keamanan standar BSSN, akun dikunci sementara selama 15 menit.');
        }

        $username = trim((string)$this->request->getPost('username'));
        $password = (string)$this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan Password wajib diisi.');
        }

        $user = $this->userModel->getUserByUsernameOrEmail($username);

        // BSSN Standard: Neutral error message to prevent account enumeration
        if (!$user || !$this->userModel->verifyPassword($user, $password)) {
            $cache->save($throttleKey, $attempts + 1, 900); // 15 mins
            $remaining = 5 - ($attempts + 1);
            $warn = $remaining > 0 ? " (Sisa percobaan: {$remaining})" : " (Akses terkunci 15 menit)";
            return redirect()->back()->withInput()->with('error', 'Username atau password yang Anda masukkan salah.' . $warn);
        }

        // Reset rate limit counter on success
        $cache->delete($throttleKey);

        // BSSN / OWASP: Session Regeneration against Session Fixation attacks
        session()->regenerate(true);

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

