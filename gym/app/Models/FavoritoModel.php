<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritoModel extends Model
{
    protected $table = 'favoritos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'id_ejercicio'];

    public function esFavorito($userId, $ejercicioId)
    {
        return $this->where('id_user', $userId)
                    ->where('id_ejercicio', $ejercicioId)
                    ->first();
    }
}