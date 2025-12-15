<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $allowedFields = ['title', 'slug', 'body','id_category', 'imagen'];
    /**
     * @param false|string $slug
     *
     * @return array|null
     */

    public function getNews($slug = false)
    {
        if ($slug === false) {
            $sql = $this->select('news.*, categories.category');
            $sql = $this->join('categories','news.id_category=categories.id');
            $sql = $this->where(['slug' => $slug]);
            $sql = $this->findAll();
            return $sql;
        }

        $sql = $this->select('news.*, categories.category');
        $sql = $this->join('categories','news.id_category=categories.id');
        $sql = $this->where(['slug' => $slug]);
        $sql = $this->first();
        return $sql;
    }
}
