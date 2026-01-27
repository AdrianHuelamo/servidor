<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculasModel extends Model
{
    protected $table = 'peliculas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titulo, anio_estreno'];


    /**
     * @param false|int $id
     *
     * @return array|null
     */

    public function getPeliculas($id = false)
    {
        if ($id === false) {
            $sql = $this->select('peliculas.*');
            $sql = $this->findAll();
            return $sql;
        }

        $sql = $this->select('peliculas.*');
        $sql = $this->where(['id' => $id]);
        $sql = $this->first();
        return $sql;
    }
}
