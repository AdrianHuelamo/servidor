<?php

namespace App\Models;

use CodeIgniter\Model;

class CancionesModel extends Model
{
    protected $table = 'canciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titulo', 'id_artista'];

    protected $returnType = 'array';


    public function getCanciones($id = false)
    {
        if ($id === false) {
            $sql = $this->select('canciones.*,artistas.nombre');
            $sql = $this->join('artistas', 'canciones.id_artista=artistas.id');
            $sql = $this->findAll();
            return $sql;
        }

        $sql = $this->select('canciones.*,artistas.nombre');
        $sql = $this->join('artistas', 'canciones.id_artista=artistas.id');
        $sql = $this->where(['canciones.id' => $id]);
        $sql = $this->first();
        return $sql;

    }
}