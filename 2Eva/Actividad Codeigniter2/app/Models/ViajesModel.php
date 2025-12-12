<?php

namespace App\Models;

use CodeIgniter\Model;

class ViajesModel extends Model
{
    protected $table = 'viajes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['viaje','fecha', 'plazas'];
    /**
     * @param false|string $id
     *
     * @return array|null
     */

    public function getViajes($id = false)
    {
        if ($id === false) {
            $sql = $this->select('viajes.*');
            $sql = $this->findAll();
            return $sql;
        }

        $sql = $this->select('viajes.*');
        $sql = $this->where(['id' => $id]);
        $sql = $this->first();
        return $sql;
    }
}
