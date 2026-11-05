<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MessageModel;

class Messages extends BaseController
{
    protected $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    public function index()
    {
        $messages = $this->messageModel->orderBy('id', 'DESC')->findAll();

        $data = [
            'title'      => 'Pesan Masuk & Aspirasi Pembaca - Admin PACEKO.com',
            'activeMenu' => 'messages',
            'messages'   => $messages
        ];

        return view('admin/messages/index', $data);
    }

    public function view($id = null)
    {
        $message = $this->messageModel->find((int)$id);
        if (!$message) {
            return redirect()->to('/admin/messages')->with('error', 'Pesan tidak ditemukan.');
        }

        // Mark as read
        if (!$message['is_read']) {
            $this->messageModel->update((int)$id, ['is_read' => 1]);
            $message['is_read'] = 1;
        }

        $data = [
            'title'      => 'Detail Pesan: ' . esc($message['subject']),
            'activeMenu' => 'messages',
            'message'    => $message
        ];

        return view('admin/messages/view', $data);
    }

    public function delete($id = null)
    {
        $this->messageModel->delete((int)$id);
        return redirect()->to('/admin/messages')->with('success', 'Pesan berhasil dihapus.');
    }
}

