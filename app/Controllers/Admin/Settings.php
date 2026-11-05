<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $settings = $this->settingModel->getAllSettings();

        $data = [
            'title'      => 'Pengaturan Website & Identitas - Admin PACEKO.com',
            'activeMenu' => 'settings',
            'settings'   => $settings
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $fields = [
            'site_title', 'site_tagline', 'site_description', 'site_keywords',
            'office_address', 'contact_email', 'contact_phone',
            'social_facebook', 'social_twitter', 'social_instagram',
            'social_youtube', 'social_whatsapp', 'running_text_extra', 'footer_text'
        ];

        foreach ($fields as $field) {
            $val = trim((string)$this->request->getPost($field));
            $this->settingModel->setSetting($field, $val);
        }

        // Handle Logo Upload
        $logoFile = $this->request->getFile('site_logo');
        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $newName = 'logo_' . time() . '.' . $logoFile->getExtension();
            $logoDir = FCPATH . 'uploads/settings';
            if (!is_dir($logoDir)) {
                mkdir($logoDir, 0777, true);
            }
            $logoFile->move($logoDir, $newName);
            $this->settingModel->setSetting('site_logo', 'uploads/settings/' . $newName);

            // Also copy as default assets/images/logo.png for universal fallback
            copy($logoDir . '/' . $newName, FCPATH . 'assets/images/logo.png');
        }

        // Handle Favicon Upload
        $faviconFile = $this->request->getFile('site_favicon');
        if ($faviconFile && $faviconFile->isValid() && !$faviconFile->hasMoved()) {
            $favName = 'favicon_' . time() . '.' . $faviconFile->getExtension();
            $favDir = FCPATH . 'uploads/settings';
            if (!is_dir($favDir)) {
                mkdir($favDir, 0777, true);
            }
            $faviconFile->move($favDir, $favName);
            $this->settingModel->setSetting('site_favicon', 'uploads/settings/' . $favName);
        }

        return redirect()->to('/admin/settings')->with('success', 'Pengaturan dan logo website berhasil diperbarui!');
    }
}

