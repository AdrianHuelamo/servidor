<?php

namespace App\Models;

use CodeIgniter\Model;

class CancionesModel extends Model
{
    protected $table = 'canciones';
    protected $allowedFields = ['nombre','id_cantante'];
    /**
     * @param false|string $id
     *
     * @return array|null
     */

    public function getCanciones($id = false)
    {
        $builder = $this->select('canciones.id, canciones.nombre as cancion_nombre, canciones.id_cantante, cantantes.nombre as cantante_nombre')
                        ->join('cantantes', 'canciones.id_cantante = cantantes.id');

        if ($id === false) {
            return $builder->findAll();
        }

        return $builder->where('canciones.id', $id)->first();
    }
}
