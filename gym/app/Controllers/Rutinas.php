<?php

namespace App\Controllers;

use App\Models\RutinaModel;
use App\Models\EjercicioModel;

class Rutinas extends BaseController
{
    public function index()
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');

        $model = new RutinaModel();
        $misRutinas = $model->where('id_user', session()->get('user_id'))->orderBy('created_at', 'DESC')->findAll();

        $data = ['rutinas' => $misRutinas, 'title' => 'Mis Rutinas'];

        return view('templates/header', $data)
             . view('rutinas/index', $data)
             . view('templates/footer');
    }

    public function create()
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');

        $model = new RutinaModel();

        if ($this->validate(['nombre' => 'required|min_length[3]'])) {
            $model->save([
                'id_user'     => session()->get('user_id'),
                'nombre'      => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion')
            ]);
            return redirect()->to('/rutinas')->with('mensaje', '¡Rutina creada! Ahora añade ejercicios.');
        }

        return redirect()->back()->with('error', 'El nombre es obligatorio.');
    }

    public function show($id)
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');

        $model = new RutinaModel();
        
        $rutina = $model->where('id', $id)->where('id_user', session()->get('user_id'))->first();

        if (!$rutina) {
            return redirect()->to('/rutinas')->with('error', 'Rutina no encontrada o no tienes permiso.');
        }

        $ejercicios = $model->getEjerciciosDeRutina($id);

        $data = [
            'rutina'     => $rutina,
            'ejercicios' => $ejercicios,
            'title'      => $rutina['nombre']
        ];

        return view('templates/header', $data)
             . view('rutinas/show', $data)
             . view('templates/footer');
    }

    public function addEjercicio($idRutina)
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');
        
        $idEjercicio = $this->request->getPost('id_ejercicio');
        $model = new RutinaModel();

        $rutina = $model->where('id', $idRutina)->where('id_user', session()->get('user_id'))->first();

        if ($rutina && $idEjercicio) {
            $model->agregarEjercicio($idRutina, $idEjercicio);
            return redirect()->back()->with('mensaje', 'Ejercicio añadido a la rutina.');
        }

        return redirect()->back()->with('error', 'Error al añadir ejercicio.');
    }

    public function update($id)
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');

        $model = new RutinaModel();
        
        $rutina = $model->where('id', $id)->where('id_user', session()->get('user_id'))->first();

        if (!$rutina) {
            return redirect()->to('/rutinas')->with('error', 'No tienes permiso para editar esta rutina.');
        }

        if ($this->validate(['nombre' => 'required|min_length[3]'])) {
            $model->update($id, [
                'nombre'      => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion')
            ]);
            return redirect()->to('/rutinas/show/'.$id)->with('mensaje', 'Rutina actualizada correctamente.');
        }

        return redirect()->back()->with('error', 'El nombre es obligatorio.');
    }

    public function removeEjercicio($idRutina, $idRelacion)
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');

        $model = new RutinaModel();
        $rutina = $model->where('id', $idRutina)->where('id_user', session()->get('user_id'))->first();
        
        if ($rutina) {
            $model->quitarEjercicio($idRelacion);
            return redirect()->back()->with('mensaje', 'Ejercicio eliminado de la rutina.');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');
        $model = new RutinaModel();
        $model->where('id', $id)->where('id_user', session()->get('user_id'))->delete();
        return redirect()->to('/rutinas')->with('mensaje', 'Rutina eliminada.');
    }
}