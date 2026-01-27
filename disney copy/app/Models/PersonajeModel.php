<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonajeModel extends Model
{
    protected $table = 'personajes';
    protected $allowedFields = ['nombre','especie','rol','id_pelicula'];
    protected $primaryKey = 'id';
    /**
     * @param false|string $id
     *
     * @return array|null
     */

    public function getPersonajes($id = false)
    {
        $builder = $this->select('personajes.id, personajes.nombre as personaje_nombre, personajes.id_pelicula, peliculas.titulo as pelicula_nombre') ->join('peliculas', 'personajes.id_pelicula = peliculas.id');

        if ($id === false) {
            return $builder->findAll();
        }

        return $builder->where('personajes.id', $id)->first();
    }
}
