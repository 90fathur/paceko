<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'paceko_banners';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'position', 'image_url', 'target_url',
        'start_date', 'end_date', 'status', 'created_at'
    ];

    /**
     * Get active banners for a specific position
     */
    public function getActiveBanners(?string $position = null): array
    {
        $today = date('Y-m-d');
        $builder = $this->where('status', 'active');

        if ($position) {
            $builder->where('position', $position);
        }

        $builder->groupStart()
            ->where('start_date IS NULL')
            ->orWhere('start_date <=', $today)
        ->groupEnd();

        $builder->groupStart()
            ->where('end_date IS NULL')
            ->orWhere('end_date >=', $today)
        ->groupEnd();

        $builder->orderBy('id', 'DESC');
        return $builder->findAll();
    }
}

