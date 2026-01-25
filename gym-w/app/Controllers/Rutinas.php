<?php

namespace App\Controllers;

use App\Models\RutinaModel;
use CodeIgniter\Controller;

class Rutinas extends BaseController
{
    public function index()
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');

        $model = new RutinaModel();
        $misRutinas = $model->where('id_user', session()->get('user_id'))
                            ->orderBy('created_at', 'DESC')
                            ->findAll();

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
            
            $nombre = $this->request->getPost('nombre');
            $userId = session()->get('user_id');

            $existe = $model->where('id_user', $userId)
                            ->where('nombre', $nombre)
                            ->first();

            if ($existe) {
                return redirect()->back()->with('error', 'Ya tienes una rutina llamada "' . esc($nombre) . '". Por favor, elige otro nombre.');
            }

            $model->save([
                'id_user'     => $userId,
                'nombre'      => $nombre,
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
            
            $db = \Config\Database::connect();
            
            $existe = $db->table('rutina_ejercicios') 
                         ->where('id_rutina', $idRutina)
                         ->where('id_ejercicio', $idEjercicio)
                         ->countAllResults();

            if ($existe > 0) {
                return redirect()->back()->with('error', '¡Ese ejercicio ya está en tu rutina!');
            }

            $model->agregarEjercicio($idRutina, $idEjercicio);
            return redirect()->back()->with('mensaje', 'Ejercicio añadido a la rutina.');
        }

        return redirect()->back()->with('error', 'Error al añadir ejercicio.');
    }

    public function update($id)
    {
        if (!session()->has('isLoggedIn')) return redirect()->to('/login');

        $model = new RutinaModel();
        $userId = session()->get('user_id');
        
        $rutina = $model->where('id', $id)->where('id_user', $userId)->first();

        if (!$rutina) {
            return redirect()->to('/rutinas')->with('error', 'No tienes permiso para editar esta rutina.');
        }

        if ($this->validate(['nombre' => 'required|min_length[3]'])) {
            
            $nombreNuevo = $this->request->getPost('nombre');

            $existe = $model->where('id_user', $userId)
                            ->where('nombre', $nombreNuevo)
                            ->where('id !=', $id)
                            ->first();

            if ($existe) {
                return redirect()->back()->with('error', 'Ya tienes otra rutina llamada "' . esc($nombreNuevo) . '".');
            }

            $model->update($id, [
                'nombre'      => $nombreNuevo,
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