<?php

namespace App\Models;

use CodeIgniter\Model;

class CiudadesModel extends Model
{
    protected $table = 'ciudades';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'provincia'];


    /**
     * @param false|string $id
     *
     * @return array|null
     */

    public function getCategory($id = false)
    {
        if ($id === false) {
            $sql = $this->select('ciudades.*');
            $sql = $this->findAll();
            return $sql;
        }

        $sql = $this->select('ciudades.*');
        $sql = $this->where(['id' => $id]);
        $sql = $this->first();
        return $sql;
    }
}
