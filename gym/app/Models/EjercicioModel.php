<?php

namespace App\Models;

use CodeIgniter\Model;

class EjercicioModel extends Model
{
    protected $table = 'ejercicios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_grupo', 'titulo', 'descripcion', 'dificultad', 'imagen', 'destacado'];

    public function prepararConsulta($filtros = [])
    {
        $this->select('ejercicios.*, grupos_musculares.nombre as grupo_nombre, grupos_musculares.imagen as grupo_imagen')
             ->join('grupos_musculares', 'ejercicios.id_grupo = grupos_musculares.id');

        if (!empty($filtros['search'])) {
            $this->like('ejercicios.titulo', $filtros['search'], 'after');
        }

        if (!empty($filtros['dificultad'])) {
            $this->where('ejercicios.dificultad', $filtros['dificultad']);
        }

        if (!empty($filtros['grupo'])) {
            $this->where('ejercicios.id_grupo', $filtros['grupo']);
        }
        return $this;
    }


    public function getEjercicios($id)
    {
        return $this->select('ejercicios.*, grupos_musculares.nombre as grupo_nombre, grupos_musculares.imagen as grupo_imagen')
                    ->join('grupos_musculares', 'ejercicios.id_grupo = grupos_musculares.id')
                    ->where('ejercicios.id', $id)
                    ->first();
    }

    public function getDestacados()
    {
        return $this->select('ejercicios.*, grupos_musculares.nombre as grupo_nombre')
                    ->join('grupos_musculares', 'ejercicios.id_grupo = grupos_musculares.id')
                    ->where('ejercicios.destacado', 1)
                    ->findAll(3);
    }

    public function getFavoritosUsuario($userId)
    {
        return $this->select('ejercicios.*, grupos_musculares.nombre as grupo_nombre')
                    ->join('favoritos', 'ejercicios.id = favoritos.id_ejercicio')
                    ->join('grupos_musculares', 'ejercicios.id_grupo = grupos_musculares.id')
                    ->where('favoritos.id_user', $userId)
                    ->orderBy('favoritos.created_at', 'DESC') // Los más recientes primero
                    ->findAll();
    }
}