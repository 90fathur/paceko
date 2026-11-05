<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
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
     * Base query for posts with subqueries for relational data (100% ONLY_FULL_GROUP_BY safe)
     */
    protected function basePostQuery()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('wp_posts p');
        $builder->select('
            p.ID,
            p.post_title,
            p.post_name as slug,
            p.post_content,
            p.post_excerpt,
            p.post_date,
            p.post_status,
            p.post_type,
            COALESCE((SELECT COALESCE(display_name, user_login) FROM wp_users WHERE ID = p.post_author LIMIT 1), "Redaksi PACEKO") as author_name,
            COALESCE((SELECT t.name FROM wp_term_relationships tr JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = "category" JOIN wp_terms t ON tt.term_id = t.term_id WHERE tr.object_id = p.ID LIMIT 1), "Berita") as category_name,
            COALESCE((SELECT t.slug FROM wp_term_relationships tr JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = "category" JOIN wp_terms t ON tt.term_id = t.term_id WHERE tr.object_id = p.ID LIMIT 1), "berita") as category_slug,
            (SELECT t.term_id FROM wp_term_relationships tr JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = "category" JOIN wp_terms t ON tt.term_id = t.term_id WHERE tr.object_id = p.ID LIMIT 1) as category_id,
            COALESCE((SELECT CAST(meta_value AS UNSIGNED) FROM wp_postmeta WHERE post_id = p.ID AND meta_key = "post_views_count" LIMIT 1), 0) as views,
            COALESCE(
                (SELECT meta_value FROM wp_postmeta WHERE post_id = p.ID AND meta_key = "_ci_thumbnail" LIMIT 1),
                (SELECT pm_file.meta_value FROM wp_postmeta pm_thumb JOIN wp_postmeta pm_file ON pm_thumb.meta_value = pm_file.post_id AND pm_file.meta_key = "_wp_attached_file" WHERE pm_thumb.post_id = p.ID AND pm_thumb.meta_key = "_thumbnail_id" LIMIT 1),
                ""
            ) as file_path
        ');

        $builder->where('p.post_type', 'post');

        return $builder;
    }

    /**
     * Slider Posts (Top / Headline breaking news)
     */
    public function getSliderPosts(int $limit = 5): array
    {
        $builder = $this->basePostQuery();
        $builder->where('p.post_status', 'publish');
        $builder->orderBy('p.post_date', 'DESC');
        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }

    /**
     * Breaking News for running text ticker
     */
    public function getBreakingNews(int $limit = 10): array
    {
        $builder = $this->db->table('wp_posts');
        $builder->select('ID, post_title, post_name as slug, post_date');
        $builder->where('post_type', 'post');
        $builder->where('post_status', 'publish');
        $builder->orderBy('post_date', 'DESC');
        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }

    /**
     * Latest Published Posts
     */
    public function getLatestPosts(int $limit = 10, int $offset = 0): array
    {
        $builder = $this->basePostQuery();
        $builder->where('p.post_status', 'publish');
        $builder->orderBy('p.post_date', 'DESC');
        $builder->limit($limit, $offset);
        return $builder->get()->getResultArray();
    }

    /**
     * Popular Posts (based on views)
     */
    public function getPopularPosts(int $limit = 5): array
    {
        $builder = $this->basePostQuery();
        $builder->join('wp_postmeta pm_pviews', 'p.ID = pm_pviews.post_id AND pm_pviews.meta_key = "post_views_count"');
        $builder->where('p.post_status', 'publish');
        $builder->orderBy('CAST(pm_pviews.meta_value AS UNSIGNED)', 'DESC');
        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }

    /**
     * Posts by Category
     */
    public function getPostsByCategory(string $categorySlug, int $limit = 12, int $offset = 0): array
    {
        $builder = $this->basePostQuery();
        $builder->join('wp_term_relationships tr_cat', 'p.ID = tr_cat.object_id');
        $builder->join('wp_term_taxonomy tt_cat', 'tr_cat.term_taxonomy_id = tt_cat.term_taxonomy_id AND tt_cat.taxonomy = "category"');
        $builder->join('wp_terms t_cat', 'tt_cat.term_id = t_cat.term_id');
        $builder->where('p.post_status', 'publish');
        $builder->where('t_cat.slug', $categorySlug);
        $builder->orderBy('p.post_date', 'DESC');
        $builder->limit($limit, $offset);
        return $builder->get()->getResultArray();
    }

    /**
     * Count posts by Category
     */
    public function countPostsByCategory(string $categorySlug): int
    {
        $builder = $this->db->table('wp_posts p');
        $builder->join('wp_term_relationships tr', 'p.ID = tr.object_id');
        $builder->join('wp_term_taxonomy tt', 'tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = "category"');
        $builder->join('wp_terms t', 'tt.term_id = t.term_id');
        $builder->where('p.post_type', 'post');
        $builder->where('p.post_status', 'publish');
        $builder->where('t.slug', $categorySlug);
        return $builder->countAllResults();
    }

    /**
     * Single Post by Slug
     */
    public function getPostBySlug(string $slug): ?array
    {
        $builder = $this->basePostQuery();
        $builder->where('p.post_name', $slug);
        $builder->where('p.post_status', 'publish');
        $res = $builder->get()->getRowArray();
        return $res ?: null;
    }

    /**
     * Single Post by ID (for admin/preview)
     */
    public function getPostById(int $id): ?array
    {
        $builder = $this->basePostQuery();
        $builder->where('p.ID', $id);
        $res = $builder->get()->getRowArray();
        return $res ?: null;
    }

    /**
     * Related Posts
     */
    public function getRelatedPosts(int $postId, ?int $categoryId, int $limit = 4): array
    {
        $builder = $this->basePostQuery();
        $builder->where('p.post_status', 'publish');
        $builder->where('p.ID !=', $postId);
        if ($categoryId) {
            $builder->join('wp_term_relationships tr_rel', 'p.ID = tr_rel.object_id');
            $builder->join('wp_term_taxonomy tt_rel', 'tr_rel.term_taxonomy_id = tt_rel.term_taxonomy_id AND tt_rel.taxonomy = "category"');
            $builder->where('tt_rel.term_id', $categoryId);
        }
        $builder->orderBy('p.post_date', 'DESC');
        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }

    /**
     * Search Posts
     */
    public function searchPosts(string $keyword, int $limit = 12, int $offset = 0): array
    {
        $builder = $this->basePostQuery();
        $builder->where('p.post_status', 'publish');
        $builder->groupStart()
            ->like('p.post_title', $keyword)
            ->orLike('p.post_content', $keyword)
        ->groupEnd();
        $builder->orderBy('p.post_date', 'DESC');
        $builder->limit($limit, $offset);
        return $builder->get()->getResultArray();
    }

    /**
     * Count Search Results
     */
    public function countSearchResults(string $keyword): int
    {
        $builder = $this->db->table('wp_posts p');
        $builder->where('p.post_type', 'post');
        $builder->where('p.post_status', 'publish');
        $builder->groupStart()
            ->like('p.post_title', $keyword)
            ->orLike('p.post_content', $keyword)
        ->groupEnd();
        return $builder->countAllResults();
    }

    /**
     * Increment Views
     */
    public function incrementViews(int $postId): void
    {
        $existing = $this->db->table('wp_postmeta')
            ->where('post_id', $postId)
            ->where('meta_key', 'post_views_count')
            ->get()->getRow();

        if ($existing) {
            $current = (int)$existing->meta_value;
            $this->db->table('wp_postmeta')
                ->where('post_id', $postId)
                ->where('meta_key', 'post_views_count')
                ->update(['meta_value' => (string)($current + 1)]);
        } else {
            $this->db->table('wp_postmeta')->insert([
                'post_id' => $postId,
                'meta_key' => 'post_views_count',
                'meta_value' => '1'
            ]);
        }
    }

    /**
     * Admin: Get Posts with Filter & Pagination
     */
    public function getAdminPosts(array $filters = [], int $limit = 15, int $offset = 0): array
    {
        $builder = $this->basePostQuery();

        if (!empty($filters['search'])) {
            $builder->like('p.post_title', $filters['search']);
        }
        if (!empty($filters['status'])) {
            $builder->where('p.post_status', $filters['status']);
        } else {
            $builder->whereIn('p.post_status', ['publish', 'draft']);
        }
        if (!empty($filters['category'])) {
            $builder->join('wp_term_relationships tr_adm', 'p.ID = tr_adm.object_id');
            $builder->join('wp_term_taxonomy tt_adm', 'tr_adm.term_taxonomy_id = tt_adm.term_taxonomy_id AND tt_adm.taxonomy = "category"');
            $builder->join('wp_terms t_adm', 'tt_adm.term_id = t_adm.term_id');
            $builder->where('t_adm.slug', $filters['category']);
        }

        $builder->orderBy('p.post_date', 'DESC');
        $builder->limit($limit, $offset);
        return $builder->get()->getResultArray();
    }

    /**
     * Admin: Count Filtered Posts
     */
    public function countAdminPosts(array $filters = []): int
    {
        $builder = $this->db->table('wp_posts p');
        $builder->where('p.post_type', 'post');

        if (!empty($filters['search'])) {
            $builder->like('p.post_title', $filters['search']);
        }
        if (!empty($filters['status'])) {
            $builder->where('p.post_status', $filters['status']);
        } else {
            $builder->whereIn('p.post_status', ['publish', 'draft']);
        }
        if (!empty($filters['category'])) {
            $builder->join('wp_term_relationships tr', 'p.ID = tr.object_id', 'left');
            $builder->join('wp_term_taxonomy tt', 'tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = "category"', 'left');
            $builder->join('wp_terms t', 'tt.term_id = t.term_id', 'left');
            $builder->where('t.slug', $filters['category']);
        }

        return $builder->countAllResults();
    }

    /**
     * Admin: Create New Post
     */
    public function createNews(array $data, ?string $featuredImage = null, ?int $categoryId = null): int
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

        $postData = [
            'post_author'           => $data['author_id'] ?? session()->get('user_id') ?? 1,
            'post_date'             => $now,
            'post_date_gmt'         => gmdate('Y-m-d H:i:s'),
            'post_content'          => $data['content'] ?? '',
            'post_title'            => $data['title'] ?? '',
            'post_excerpt'          => $data['excerpt'] ?? clean_excerpt($data['content'] ?? '', 140),
            'post_status'           => $data['status'] ?? 'publish',
            'comment_status'        => 'open',
            'ping_status'           => 'closed',
            'post_password'         => '',
            'post_name'             => $slug,
            'to_ping'               => '',
            'pinged'                => '',
            'post_modified'         => $now,
            'post_modified_gmt'     => gmdate('Y-m-d H:i:s'),
            'post_content_filtered' => '',
            'post_parent'           => 0,
            'guid'                  => base_url('berita/' . $slug),
            'menu_order'            => 0,
            'post_type'             => 'post',
            'post_mime_type'        => '',
            'comment_count'         => 0,
        ];

        $this->db->table('wp_posts')->insert($postData);
        $postId = $this->db->insertID();

        // Save category relationship
        if ($categoryId) {
            $tt = $this->db->table('wp_term_taxonomy')
                ->where('term_id', $categoryId)
                ->where('taxonomy', 'category')
                ->get()->getRow();
            if ($tt) {
                $this->db->table('wp_term_relationships')->insert([
                    'object_id' => $postId,
                    'term_taxonomy_id' => $tt->term_taxonomy_id,
                    'term_order' => 0
                ]);
                $this->db->table('wp_term_taxonomy')
                    ->where('term_taxonomy_id', $tt->term_taxonomy_id)
                    ->increment('count', 1);
            }
        }

        // Save featured image if provided
        if ($featuredImage) {
            $this->db->table('wp_postmeta')->insert([
                'post_id' => $postId,
                'meta_key' => '_ci_thumbnail',
                'meta_value' => $featuredImage
            ]);
        }

        // Initialize views count
        $this->db->table('wp_postmeta')->insert([
            'post_id' => $postId,
            'meta_key' => 'post_views_count',
            'meta_value' => '1'
        ]);

        return $postId;
    }

    /**
     * Admin: Update Post
     */
    public function updateNews(int $id, array $data, ?string $featuredImage = null, ?int $categoryId = null): bool
    {
        $now = date('Y-m-d H:i:s');
        $slug = !empty($data['slug']) ? url_title($data['slug'], '-', true) : url_title($data['title'], '-', true);

        $updateData = [
            'post_title'            => $data['title'],
            'post_name'             => $slug,
            'post_content'          => $data['content'],
            'post_excerpt'          => $data['excerpt'] ?? clean_excerpt($data['content'], 140),
            'post_status'           => $data['status'] ?? 'publish',
            'post_modified'         => $now,
            'post_modified_gmt'     => gmdate('Y-m-d H:i:s'),
        ];

        $this->db->table('wp_posts')->where('ID', $id)->update($updateData);

        // Update category
        if ($categoryId) {
            $tt = $this->db->table('wp_term_taxonomy')
                ->where('term_id', $categoryId)
                ->where('taxonomy', 'category')
                ->get()->getRow();
            if ($tt) {
                $this->db->table('wp_term_relationships')->where('object_id', $id)->delete();
                $this->db->table('wp_term_relationships')->insert([
                    'object_id' => $id,
                    'term_taxonomy_id' => $tt->term_taxonomy_id,
                    'term_order' => 0
                ]);
            }
        }

        // Update featured image
        if ($featuredImage) {
            $existing = $this->db->table('wp_postmeta')
                ->where('post_id', $id)
                ->where('meta_key', '_ci_thumbnail')
                ->get()->getRow();
            if ($existing) {
                $this->db->table('wp_postmeta')
                    ->where('post_id', $id)
                    ->where('meta_key', '_ci_thumbnail')
                    ->update(['meta_value' => $featuredImage]);
            } else {
                $this->db->table('wp_postmeta')->insert([
                    'post_id' => $id,
                    'meta_key' => '_ci_thumbnail',
                    'meta_value' => $featuredImage
                ]);
            }
        }

        return true;
    }

    /**
     * Admin: Delete Post
     */
    public function deleteNews(int $id): bool
    {
        $this->db->table('wp_posts')->where('ID', $id)->delete();
        $this->db->table('wp_postmeta')->where('post_id', $id)->delete();
        $this->db->table('wp_term_relationships')->where('object_id', $id)->delete();
        return true;
    }

    /**
     * Admin: Dashboard Statistics
     */
    public function getDashboardStats(): array
    {
        $totalPosts = $this->db->table('wp_posts')
            ->where('post_type', 'post')
            ->where('post_status', 'publish')
            ->countAllResults();

        $totalDrafts = $this->db->table('wp_posts')
            ->where('post_type', 'post')
            ->where('post_status', 'draft')
            ->countAllResults();

        $totalCategories = $this->db->table('wp_term_taxonomy')
            ->where('taxonomy', 'category')
            ->countAllResults();

        $totalUsers = $this->db->table('wp_users')->countAllResults();

        $viewsRow = $this->db->table('wp_postmeta')
            ->select('SUM(CAST(meta_value AS UNSIGNED)) as total_views')
            ->where('meta_key', 'post_views_count')
            ->get()->getRow();

        return [
            'total_posts'      => $totalPosts,
            'total_drafts'     => $totalDrafts,
            'total_categories' => $totalCategories,
            'total_users'      => $totalUsers,
            'total_views'      => (int)($viewsRow->total_views ?? 0)
        ];
    }
}
