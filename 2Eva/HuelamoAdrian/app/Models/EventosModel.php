<?php

namespace App\Models;

use CodeIgniter\Model;

class EventosModel extends Model
{
    protected $table = 'eventos';
    protected $allowedFields = ['nombre', 'fecha', 'aforo','id_ciudad'];
    /**
     * @param false|string $id
     *
     * @return array|null
     */

    public function getEventos($id = false)
    {
        if ($id === false) {
            $sql = $this->select('eventos.*, ciudades.nombre as ciudad_nombre');
            $sql = $this->join('ciudades','eventos.id_ciudad=ciudades.id');
            $sql = $this->where(['id' => $id]);
            $sql = $this->findAll();
            return $sql;
        }

        $sql = $this->select('eventos.*, ciudades.nombre as ciudad_nombre');
        $sql = $this->join('ciudades','eventos.id_ciudad=ciudades.id');
        $sql = $this->where(['id' => $id]);
        $sql = $this->first();
        return $sql;
    }
}
