<?php

namespace App\Models;

use CodeIgniter\Model;

class RutinaModel extends Model
{
    protected $table = 'rutinas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'nombre', 'descripcion'];

    public function getEjerciciosDeRutina($idRutina)
    {
        return $this->db->table('rutina_ejercicios')
                        ->select('rutina_ejercicios.id as id_relacion, ejercicios.*, grupos_musculares.nombre as grupo_nombre')
                        ->join('ejercicios', 'rutina_ejercicios.id_ejercicio = ejercicios.id')
                        ->join('grupos_musculares', 'ejercicios.id_grupo = grupos_musculares.id')
                        ->where('rutina_ejercicios.id_rutina', $idRutina)
                        ->orderBy('rutina_ejercicios.created_at', 'ASC') 
                        ->get()
                        ->getResultArray();
    }

    public function agregarEjercicio($idRutina, $idEjercicio)
    {
        $existe = $this->db->table('rutina_ejercicios')
                           ->where('id_rutina', $idRutina)
                           ->where('id_ejercicio', $idEjercicio)
                           ->countAllResults();

        if ($existe == 0) {
            return $this->db->table('rutina_ejercicios')->insert([
                'id_rutina'    => $idRutina,
                'id_ejercicio' => $idEjercicio
            ]);
        }
        return false;
    }

    public function quitarEjercicio($idRelacion)
    {
        return $this->db->table('rutina_ejercicios')->delete(['id' => $idRelacion]);
    }
}