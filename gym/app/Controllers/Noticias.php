<?php

namespace App\Controllers;

use App\Models\NoticiaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Noticias extends BaseController
{
    public function index()
    {
        $model = model(NoticiaModel::class);

        $data = [
            'noticias_list' => $model->getNoticias(),
            'title'         => 'Últimas Noticias',
        ];

        return view('templates/header', $data)
            . view('noticias/index')
            . view('templates/footer');
    }

    public function show($id = null)
    {
        $model = model(NoticiaModel::class);

        $data['noticia'] = $model->getNoticias($id);

        if ($data['noticia'] === null) {
            throw new PageNotFoundException('No se encuentra la noticia: ' . $id);
        }

        $data['title'] = $data['noticia']['titulo'];

        return view('templates/header', $data)
            . view('noticias/view')
            . view('templates/footer');
    }
}