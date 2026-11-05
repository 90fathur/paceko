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
        $rules = [
            'site_title'   => 'required|min_length[3]|max_length[150]',
            'site_logo'    => 'permit_empty|max_size[site_logo,3072]|is_image[site_logo]|mime_in[site_logo,image/png,image/jpeg,image/webp,image/svg+xml]',
            'site_favicon' => 'permit_empty|max_size[site_favicon,1024]|ext_in[site_favicon,ico,png,jpg,jpeg,svg]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

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

        // Anti Copy-Paste Protection toggle (1 = enabled, 0 = disabled)
        $antiCopy = $this->request->getPost('enable_anti_copy') ? '1' : '0';
        $this->settingModel->setSetting('enable_anti_copy', $antiCopy);

        // Handle Logo Upload with strict extension & MIME check
        $logoFile = $this->request->getFile('site_logo');
        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $ext = strtolower($logoFile->getClientExtension());
            if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'svg'])) {
                $newName = 'logo_' . time() . '.' . $ext;
                $logoDir = FCPATH . 'uploads/settings';
                if (!is_dir($logoDir)) {
                    mkdir($logoDir, 0777, true);
                }
                $logoFile->move($logoDir, $newName);
                $this->settingModel->setSetting('site_logo', 'uploads/settings/' . $newName);

                // Also copy as default assets/images/logo.png for universal fallback
                @copy($logoDir . '/' . $newName, FCPATH . 'assets/images/logo.png');
            }
        }

        // Handle Favicon Upload with strict extension check
        $faviconFile = $this->request->getFile('site_favicon');
        if ($faviconFile && $faviconFile->isValid() && !$faviconFile->hasMoved()) {
            $favExt = strtolower($faviconFile->getClientExtension());
            if (in_array($favExt, ['ico', 'png', 'jpg', 'jpeg', 'svg'])) {
                $favName = 'favicon_' . time() . '.' . $favExt;
                $favDir = FCPATH . 'uploads/settings';
                if (!is_dir($favDir)) {
                    mkdir($favDir, 0777, true);
                }
                $faviconFile->move($favDir, $favName);
                $this->settingModel->setSetting('site_favicon', 'uploads/settings/' . $favName);
            }
        }

        return redirect()->to('/admin/settings')->with('success', 'Pengaturan dan logo website berhasil diperbarui!');
    }
}

