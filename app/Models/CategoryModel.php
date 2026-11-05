<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'wp_terms';
    protected $primaryKey = 'term_id';
    protected $allowedFields = ['name', 'slug', 'term_group'];

    /**
     * Get all categories with post count
     */
    public function getAllCategories(string $orderBy = 'tt.count', string $direction = 'DESC'): array
    {
        $builder = $this->db->table('wp_terms t');
        $builder->select('t.term_id, t.name, t.slug, tt.term_taxonomy_id, tt.description, tt.count');
        $builder->join('wp_term_taxonomy tt', 't.term_id = tt.term_id');
        $builder->where('tt.taxonomy', 'category');
        $builder->orderBy($orderBy, $direction);
        return $builder->get()->getResultArray();
    }

    /**
     * Get Top Categories for Navigation
     */
    public function getTopCategories(int $limit = 9): array
    {
        $builder = $this->db->table('wp_terms t');
        $builder->select('t.term_id, t.name, t.slug, tt.count');
        $builder->join('wp_term_taxonomy tt', 't.term_id = tt.term_id');
        $builder->where('tt.taxonomy', 'category');
        $builder->where('tt.count >', 0);
        $builder->where('t.slug !=', 'tak-berkategori');
        $builder->orderBy('tt.count', 'DESC');
        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }

    /**
     * Get Category by Slug
     */
    public function getCategoryBySlug(string $slug): ?array
    {
        $builder = $this->db->table('wp_terms t');
        $builder->select('t.term_id, t.name, t.slug, tt.term_taxonomy_id, tt.description, tt.count');
        $builder->join('wp_term_taxonomy tt', 't.term_id = tt.term_id');
        $builder->where('tt.taxonomy', 'category');
        $builder->where('t.slug', $slug);
        $res = $builder->get()->getRowArray();
        return $res ?: null;
    }

    /**
     * Get Category by ID
     */
    public function getCategoryById(int $id): ?array
    {
        $builder = $this->db->table('wp_terms t');
        $builder->select('t.term_id, t.name, t.slug, tt.term_taxonomy_id, tt.description, tt.count');
        $builder->join('wp_term_taxonomy tt', 't.term_id = tt.term_id');
        $builder->where('tt.taxonomy', 'category');
        $builder->where('t.term_id', $id);
        $res = $builder->get()->getRowArray();
        return $res ?: null;
    }

    /**
     * Create Category
     */
    public function createCategory(string $name, ?string $slug = null, ?string $description = ''): int
    {
        $slug = !empty($slug) ? url_title($slug, '-', true) : url_title($name, '-', true);

        $this->db->table('wp_terms')->insert([
            'name'       => $name,
            'slug'       => $slug,
            'term_group' => 0
        ]);
        $termId = $this->db->insertID();

        $this->db->table('wp_term_taxonomy')->insert([
            'term_id'     => $termId,
            'taxonomy'    => 'category',
            'description' => $description ?? '',
            'parent'      => 0,
            'count'       => 0
        ]);

        return $termId;
    }

    /**
     * Update Category
     */
    public function updateCategory(int $id, string $name, ?string $slug = null, ?string $description = ''): bool
    {
        $slug = !empty($slug) ? url_title($slug, '-', true) : url_title($name, '-', true);

        // Ensure unique slug for other terms
        $origSlug = $slug;
        $counter = 1;
        while ($this->where('slug', $slug)->where('term_id !=', $id)->first()) {
            $slug = "{$origSlug}-{$counter}";
            $counter++;
        }

        $this->db->table('wp_terms')->where('term_id', $id)->update([
            'name' => $name,
            'slug' => $slug
        ]);

        $this->db->table('wp_term_taxonomy')->where('term_id', $id)->where('taxonomy', 'category')->update([
            'description' => $description ?? ''
        ]);

        return true;
    }

    /**
     * Delete Category
     */
    public function deleteCategory(int $id): bool
    {
        $tt = $this->db->table('wp_term_taxonomy')->where('term_id', $id)->where('taxonomy', 'category')->get()->getRow();
        if ($tt) {
            $this->db->table('wp_term_relationships')->where('term_taxonomy_id', $tt->term_taxonomy_id)->delete();
            $this->db->table('wp_term_taxonomy')->where('term_taxonomy_id', $tt->term_taxonomy_id)->delete();
        }
        $this->db->table('wp_terms')->where('term_id', $id)->delete();
        return true;
    }
}

