<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'paceko_messages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email', 'phone', 'subject', 'message', 'is_read', 'created_at'
    ];

    /**
     * Get unread count
     */
    public function getUnreadCount(): int
    {
        return $this->where('is_read', 0)->countAllResults();
    }
}

