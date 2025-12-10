<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $allowedFields = ['title', 'slug', 'body', 'id_category'];
    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getNews($slug = false)
    {
        if ($slug === false) {
            $sql = $this->select('news.*,category.category');
            $sql = $this->join('category', 'news.id_category=category.id');
            return $this->findAll();
        }

        $sql = $this->select('news.*,category.category');
        $sql = $this->join('category', 'news.id_category=category.id');
        $sql = $this->where(['slug' => $slug]);
        $sql = $this->first();
        return $sql;

        return $this->where(['slug' => $slug])->first();
    }
}