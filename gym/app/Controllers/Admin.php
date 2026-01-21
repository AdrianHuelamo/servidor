<?php

namespace App\Controllers;

use App\Models\EjercicioModel;
use App\Models\GrupoModel;
use App\Models\NoticiaModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'total_ejercicios' => model(EjercicioModel::class)->countAllResults(),
            'total_grupos'     => model(GrupoModel::class)->countAllResults(),
            'total_noticias'   => model(NoticiaModel::class)->countAllResults(),
            'total_usuarios'   => model(UserModel::class)->countAllResults(),
        ];
        return view('admin/dashboard', $data);
    }

    public function ejercicios()
    {
        $model = new EjercicioModel();
        $data = [
            'ejercicios' => $model->paginate(10),
            'pager' => $model->pager
        ];
        return view('admin/ejercicios/index', $data);
    }

    public function deleteEjercicio($id)
    {
        $model = new EjercicioModel();
        $model->delete($id);
        return redirect()->to('/admin/ejercicios')->with('mensaje', 'Ejercicio eliminado correctamente.');
    }

    public function grupos() {
        $model = new GrupoModel();
        $data['grupos'] = $model->findAll();
        return view('admin/grupos/index', $data); 
    }

    public function deleteGrupo($id) {
        $model = new GrupoModel();
        $model->delete($id);
        return redirect()->to('/admin/grupos')->with('mensaje', 'Grupo muscular eliminado.');
    }

    public function noticias() {
        $model = new NoticiaModel();
        $data['noticias'] = $model->orderBy('fecha_publicacion', 'DESC')->findAll();
        return view('admin/noticias/index', $data); 
    }

    public function deleteNoticia($id) {
        $model = new NoticiaModel();
        $model->delete($id);
        return redirect()->to('/admin/noticias')->with('mensaje', 'Noticia eliminada correctamente.');
    }

    public function usuarios()
    {
        $model = new UserModel();
        $data['usuarios'] = $model->findAll();
        return view('admin/usuarios/index', $data);
    }
}