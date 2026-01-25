<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GrupoModel; 

class Grupos extends BaseController
{
    public function index()
    {
        $model = new GrupoModel();
        
        $data = [
            'grupos' => $model->findAll(), 
            'title'  => 'Grupos Musculares'
        ];

        return view('templates/header', $data)
             . view('grupos/index', $data)
             . view('templates/footer');
    }

    public function show($id = null)
    {
        $model = new GrupoModel();
        $data['grupo'] = $model->find($id);

        if (empty($data['grupo'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grupo no encontrado');
        }

        return view('templates/header', ['title' => $data['grupo']['nombre']])
             . view('grupos/detalle', $data) 
             . view('templates/footer');
        }
}