<?php

namespace App\Controllers;

use App\Models\EjercicioModel;
use App\Models\GrupoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Ejercicios extends BaseController
{
    public function index()
{
    $model = model(EjercicioModel::class);
    $grupoModel = model(GrupoModel::class);

    $filtros = [
        'search'     => $this->request->getGet('search'),
        'dificultad' => $this->request->getGet('dificultad'),
        'grupo'      => $this->request->getGet('grupo')
    ];

    $paginaActual = (int) ($this->request->getGet('page') ?? 1);
    $porPagina = 9; 
    $offset = ($paginaActual - 1) * $porPagina;

    $totalEjercicios = $model->prepararConsulta($filtros)->countAllResults();
    $ejercicios = $model->prepararConsulta($filtros)->findAll($porPagina, $offset);
    $totalPaginas = ceil($totalEjercicios / $porPagina);

    $data = [
        'ejercicios_list'    => $ejercicios,
        'grupos_para_filtro' => $grupoModel->findAll(),
        'filtros_activos'    => $filtros,
        'title'              => 'Listado de Ejercicios',
        'pagina_actual'      => $paginaActual,
        'total_paginas'      => $totalPaginas
    ];

    if ($this->request->isAJAX()) {
        return view('ejercicios/_grid', $data);
    }

    return view('templates/header', $data)
         . view('ejercicios/index', $data)
         . view('templates/footer');
}

    public function show($id)
    {
        $model = model(EjercicioModel::class);

        $ejercicio = $model->getEjercicios($id);

        if (empty($ejercicio)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'ejercicio' => $ejercicio,
            'title'     => $ejercicio['titulo'] 
        ];

        return view('templates/header', $data)
             . view('ejercicios/detalle', $data)
             . view('templates/footer');
    }
    
}