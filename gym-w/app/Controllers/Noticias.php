<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NoticiaModel;

class Noticias extends BaseController
{
    public function index()
    {
        $model = new NoticiaModel();

        $data = [
            'noticias' => $model->orderBy('fecha_publicacion', 'DESC')->findAll(),
            'title'    => 'Noticias'
        ];

        return view('templates/header', $data)
             . view('noticias/index', $data)
             . view('templates/footer');
    }

    public function show($id = null)
{
    $model = new NoticiaModel();
    $data['noticia'] = $model->find($id);

    if (empty($data['noticia'])) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Noticia no encontrada');
    }

    return view('templates/header', ['title' => $data['noticia']['titulo']])
         . view('noticias/detalle', $data) 
         . view('templates/footer');
}
}