<?php

namespace App\Controllers;

use App\Models\PersonajeModel;
use App\Models\CantantesModel;

class Personajes extends BaseController
{
    public function index()
    {
        $model = model(PersonajeModel::class);

        $data = [
            'personajes_list' => $model->getPersonajes(),
            'title'     => 'Canciones archive',
        ];

        return view('templates/header', $data)
            . view('personajes/index')
            . view('templates/footer');
    }
}