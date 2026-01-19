<?php

namespace App\Controllers;

use App\Models\EjercicioModel;
use App\Models\NoticiaModel;
use App\Models\GrupoModel;

class Home extends BaseController
{
    public function index()
    {
        $ejercicioModel = new EjercicioModel();
        $noticiaModel   = new NoticiaModel();
        $grupoModel     = new GrupoModel();

        $data = [
            'destacados' => $ejercicioModel->getDestacados(),
            
            'noticias'   => $noticiaModel->orderBy('fecha_publicacion', 'DESC')->findAll(3),
            
            'grupos'     => $grupoModel->findAll(),

            'title'      => 'Inicio - GymFit'
        ];

        return view('templates/header', $data)
             . view('home')
             . view('templates/footer');
    }
}