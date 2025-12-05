<?php

namespace App\Models;

use CodeIgniter\Model;

class ConciertosModel extends Model
{
    protected $table = 'conciertos_valencia';
    protected $allowedFields = ['nombre_concierto', 'lugar', 'fecha', 'precio'];
    /**
     * @param false|string
     *
     * @return array|null
     */
    public function getConciertos()
    {
        $sql = $this->select('*');
        return $this->findAll();
        
        $sql = $this->first();
        return $sql;

    }
}