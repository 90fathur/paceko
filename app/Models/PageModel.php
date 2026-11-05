<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'wp_posts';
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'post_author', 'post_date', 'post_date_gmt', 'post_content',
        'post_title', 'post_excerpt', 'post_status', 'comment_status',
        'ping_status', 'post_password', 'post_name', 'to_ping', 'pinged',
        'post_modified', 'post_modified_gmt', 'post_content_filtered',
        'post_parent', 'guid', 'menu_order', 'post_type', 'post_mime_type',
        'comment_count'
    ];

    /**
     * Get all published or draft static pages
     */
    public function getAllPages(): array
    {
        return $this->where('post_type', 'page')
            ->orderBy('post_title', 'ASC')
            ->findAll();
    }

    /**
     * Get single published page by slug
     */
    public function getPageBySlug(string $slug): ?array
    {
        $page = $this->where('post_type', 'page')
            ->where('post_name', $slug)
            ->where('post_status', 'publish')
            ->first();

        return $page ?: null;
    }

    /**
     * Create page
     */
    public function createPage(array $data): int
    {
        $now = date('Y-m-d H:i:s');
        $slug = !empty($data['slug']) ? url_title($data['slug'], '-', true) : url_title($data['title'], '-', true);

        // Ensure unique slug
        $origSlug = $slug;
        $counter = 1;
        while ($this->where('post_name', $slug)->first()) {
            $slug = "{$origSlug}-{$counter}";
            $counter++;
        }

        $insertData = [
            'post_author'           => session()->get('user_id') ?? 1,
            'post_date'             => $now,
            'post_date_gmt'         => gmdate('Y-m-d H:i:s'),
            'post_content'          => $data['content'] ?? '',
            'post_title'            => $data['title'] ?? '',
            'post_excerpt'          => $data['excerpt'] ?? '',
            'post_status'           => $data['status'] ?? 'publish',
            'comment_status'        => 'closed',
            'ping_status'           => 'closed',
            'post_password'         => '',
            'post_name'             => $slug,
            'to_ping'               => '',
            'pinged'                => '',
            'post_modified'         => $now,
            'post_modified_gmt'     => gmdate('Y-m-d H:i:s'),
            'post_content_filtered' => '',
            'post_parent'           => 0,
            'guid'                  => base_url('halaman/' . $slug),
            'menu_order'            => 0,
            'post_type'             => 'page',
            'post_mime_type'        => '',
            'comment_count'         => 0,
        ];

        $this->insert($insertData);
        return $this->getInsertID();
    }

    /**
     * Update page
     */
    public function updatePage(int $id, array $data): bool
    {
        $now = date('Y-m-d H:i:s');
        $slug = !empty($data['slug']) ? url_title($data['slug'], '-', true) : url_title($data['title'], '-', true);

        $updateData = [
            'post_title'        => $data['title'],
            'post_name'         => $slug,
            'post_content'      => $data['content'],
            'post_excerpt'      => $data['excerpt'] ?? '',
            'post_status'       => $data['status'] ?? 'publish',
            'post_modified'     => $now,
            'post_modified_gmt' => gmdate('Y-m-d H:i:s'),
        ];

        return $this->update($id, $updateData);
    }
}

