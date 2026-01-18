<?php

namespace App\Controllers;

use App\Models\GrupoModel;
use App\Models\EjercicioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Grupos extends BaseController
{
    public function index()
    {
        $model = model(GrupoModel::class);

        $data = [
            'grupos_list' => $model->getGrupos(),
            'title'       => 'Grupos Musculares',
        ];

        return view('templates/header', $data)
            . view('grupos/index')
            . view('templates/footer');
    }

    public function show($id = null)
    {
        $modelGrupo = model(GrupoModel::class);
        $modelEjercicios = model(EjercicioModel::class);

        $data['grupo'] = $modelGrupo->getGrupos($id);

        if ($data['grupo'] === null) {
            throw new PageNotFoundException('No se encuentra el grupo muscular con ID: ' . $id);
        }

        $data['ejercicios_list'] = $modelEjercicios->where('id_grupo', $id)->findAll();
        
        $data['title'] = $data['grupo']['nombre'];

        return view('templates/header', $data)
            . view('grupos/view')
            . view('templates/footer');
    }
}