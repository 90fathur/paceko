<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'wp_users';
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'user_login', 'user_pass', 'user_nicename', 'user_email',
        'user_url', 'user_registered', 'user_activation_key', 'user_status',
        'display_name'
    ];

    /**
     * Find user by username or email
     */
    public function getUserByUsernameOrEmail(string $identifier): ?array
    {
        $user = $this->where('user_login', $identifier)
            ->orWhere('user_email', $identifier)
            ->first();

        return $user ?: null;
    }

    /**
     * Verify Password with WordPress hash compatibility & fallback
     */
    public function verifyPassword(array $user, string $password): bool
    {
        $hash = $user['user_pass'];

        // Standard PHP password_verify (bcrypt/argon2)
        if (password_verify($password, $hash)) {
            return true;
        }

        // WordPress variant prefix ($wp$2y$...)
        if (strpos($hash, '$wp$2y$') === 0) {
            $cleanHash = substr($hash, 3);
            if (password_verify($password, $cleanHash)) {
                // Rehash to standard password_hash
                $this->updatePassword($user['ID'], $password);
                return true;
            }
        }

        return false;
    }

    /**
     * Update Password
     */
    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['user_pass' => $hash]);
    }

    /**
     * Update Profile
     */
    public function updateProfile(int $userId, array $data): bool
    {
        $update = [
            'display_name'  => $data['display_name'] ?? '',
            'user_email'    => $data['user_email'] ?? '',
            'user_nicename' => url_title($data['display_name'] ?? '', '-', true)
        ];
        return $this->update($userId, $update);
    }
}

