<?php

namespace App\Models;

use CodeIgniter\Model;

class CantantesModel extends Model
{
    protected $table = 'cantantes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre'];


    /**
     * @param false|int $id
     *
     * @return array|null
     */

    public function getCantantes($id = false)
    {
        if ($id === false) {
            $sql = $this->select('cantantes.*');
            $sql = $this->findAll();
            return $sql;
        }

        $sql = $this->select('cantantes.*');
        $sql = $this->where(['id' => $id]);
        $sql = $this->first();
        return $sql;
    }
}
