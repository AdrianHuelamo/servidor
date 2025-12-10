<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category'];


    /**
     * @param false|string $slug
     *
     * @return array|null
     */

    public function getCategory($id = false)
    {
        if ($id === false) {
            $sql = $this->select('categories.*');
            $sql = $this->findAll();
            return $sql;
        }

        $sql = $this->select('categories.*');
        $sql = $this->where(['id' => $id]);
        $sql = $this->first();
        return $sql;
    }
}
