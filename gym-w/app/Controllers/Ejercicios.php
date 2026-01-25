<?php

namespace App\Controllers;

use App\Models\EjercicioModel;
use App\Models\GrupoModel;
use App\Models\FavoritoModel;

class Ejercicios extends BaseController
{
    public function index()
    {
        $model = model(EjercicioModel::class);
        $grupoModel = model(GrupoModel::class);
        $favoritoModel = new FavoritoModel(); 

        $filtros = [
            'search'     => $this->request->getGet('search'),
            'dificultad' => $this->request->getGet('dificultad'),
            'grupo'      => $this->request->getGet('grupo')
        ];

        $paginaActual = (int) ($this->request->getGet('page') ?? 1);
        $porPagina = 6; 
        $offset = ($paginaActual - 1) * $porPagina;

        $totalEjercicios = $model->prepararConsulta($filtros)->countAllResults();
        $ejercicios = $model->prepararConsulta($filtros)->findAll($porPagina, $offset);
        $totalPaginas = ceil($totalEjercicios / $porPagina);

        $misFavoritos = [];
        if (session()->has('isLoggedIn')) {
            $favs = $favoritoModel->where('id_user', session()->get('user_id'))->findAll();
            $misFavoritos = array_column($favs, 'id_ejercicio');
        }

        $data = [
            'ejercicios_list'    => $ejercicios,
            'grupos_para_filtro' => $grupoModel->findAll(),
            'filtros_activos'    => $filtros,
            'title'              => 'Listado de Ejercicios',
            'pagina_actual'      => $paginaActual,
            'total_paginas'      => $totalPaginas,
            'mis_favoritos'      => $misFavoritos 
        ];

        return view('templates/header', $data)
             . view('ejercicios/index', $data)
             . view('templates/footer');
    }

    public function show($id)
    {
        $model = model(EjercicioModel::class);
        $favoritoModel = new FavoritoModel();

        $ejercicio = $model->getEjercicios($id);

        if (empty($ejercicio)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $esFavorito = false;
        if (session()->has('isLoggedIn')) {
            $check = $favoritoModel->esFavorito(session()->get('user_id'), $id);
            if ($check) $esFavorito = true;
        }

        $data = [
            'ejercicio'   => $ejercicio,
            'title'       => $ejercicio['titulo'],
            'es_favorito' => $esFavorito 
        ];

        return view('templates/header', $data)
             . view('ejercicios/detalle', $data)
             . view('templates/footer');
    }

    public function toggleFavorito($idEjercicio)
    {
        if (!session()->has('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Inicia sesión para guardar favoritos.');
        }

        $userId = session()->get('user_id');
        $favModel = new FavoritoModel();

        $existe = $favModel->esFavorito($userId, $idEjercicio);

        if ($existe) {
            $favModel->delete($existe['id']);
        } else {
            $favModel->save([
                'id_user'      => $userId,
                'id_ejercicio' => $idEjercicio
            ]);
        }

        return redirect()->back(); 
    }

    public function misFavoritos()
    {
        if (!session()->has('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $model = new EjercicioModel();

        $misEjercicios = $model->getFavoritosUsuario($userId);

        $idsFavoritos = array_column($misEjercicios, 'id');

        $data = [
            'ejercicios_list' => $misEjercicios,
            'mis_favoritos'   => $idsFavoritos, 
            'title'           => 'Mis Ejercicios Favoritos'
        ];

        return view('templates/header', $data)
             . view('ejercicios/mis_favoritos', $data)
             . view('templates/footer');
    }

    public function autocomplete()
    {
        $request = service('request');
        $postData = $request->getPost();
        
        $response = array();
        $data = array();

        $response['token'] = csrf_hash();

        if (isset($postData['search'])) {
            $search = $postData['search'];
            $model = new \App\Models\EjercicioModel();
            
            $listaEjercicios = $model->select('id, titulo')
                                     ->like('titulo', $search)
                                     ->orderBy('titulo', 'ASC')
                                     ->findAll(10); 

            foreach ($listaEjercicios as $ejercicio) {
                $data[] = array(
                    "id" => $ejercicio['id'],
                    "value" => $ejercicio['titulo'],
                    "label" => $ejercicio['titulo']
                );
            }
        }

        $response['data'] = $data;
        return $this->response->setJSON($response);
    }
}