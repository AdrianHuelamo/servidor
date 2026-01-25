<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{
    protected $table = 'grupos_musculares';
    protected $allowedFields = ['nombre', 'imagen', 'descripcion'];

    public function getGrupos($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where('id', $id)->first();
    }
}