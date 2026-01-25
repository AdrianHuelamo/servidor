<?php

namespace App\Models;

use CodeIgniter\Model;

class NoticiaModel extends Model
{
    protected $table = 'noticias';
    protected $allowedFields = ['titulo', 'resumen', 'contenido', 'fecha_publicacion', 'imagen'];

    public function getNoticias($id = false)
    {
        if ($id === false) {
            return $this->orderBy('fecha_publicacion', 'DESC')->findAll();
        }

        return $this->where('id', $id)->first();
    }
}