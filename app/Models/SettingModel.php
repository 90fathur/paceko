<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'paceko_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['setting_key', 'setting_value', 'updated_at'];

    /**
     * Cache for settings
     */
    protected static array $cache = [];

    /**
     * Get a setting value by key
     */
    public function getSetting(string $key, $default = null)
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $row = $this->where('setting_key', $key)->first();
        if ($row) {
            self::$cache[$key] = $row['setting_value'];
            return $row['setting_value'];
        }

        return $default;
    }

    /**
     * Get all settings as key => value array
     */
    public function getAllSettings(): array
    {
        $rows = $this->findAll();
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
            self::$cache[$r['setting_key']] = $r['setting_value'];
        }
        return $settings;
    }

    /**
     * Update or insert a setting
     */
    public function setSetting(string $key, $value): bool
    {
        $existing = $this->where('setting_key', $key)->first();
        $now = date('Y-m-d H:i:s');

        if ($existing) {
            $this->update($existing['id'], [
                'setting_value' => $value,
                'updated_at'    => $now
            ]);
        } else {
            $this->insert([
                'setting_key'   => $key,
                'setting_value' => $value,
                'updated_at'    => $now
            ]);
        }

        self::$cache[$key] = $value;
        return true;
    }

    /**
     * Save multiple settings at once
     */
    public function saveSettings(array $data): bool
    {
        foreach ($data as $key => $val) {
            $this->setSetting($key, $val);
        }
        return true;
    }
}

