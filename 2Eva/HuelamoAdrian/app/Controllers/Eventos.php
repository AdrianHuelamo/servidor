<?php

namespace App\Controllers;

use App\Models\EventosModel;
use App\Models\CiudadesModel;

class Eventos extends BaseController
{
    public function index()
    {
        $model = model(EventosModel::class);

        $data = [
            'eventos_list' => $model->getEventos(),
            'title'     => 'Eventos archive',
        ];
        
        return view('templates/header', $data)
        . view('eventos/index')
        . view('templates/footer');
    }

    public function new()
    {
        helper('form');
        $model_ciu = model(CiudadesModel::class);
        if($data['nombre'] = $model_ciu->findAll()){
            
            return view('templates/header', ['title' => 'Create a evento item'])
            . view('eventos/create', $data)
            . view('templates/footer');
        }

        
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['nombre', 'fecha','aforo', 'id_ciudad']);

        if (! $this->validateData($data, [
            'nombre' => 'required|max_length[150]|min_length[3]',
            'fecha'  => 'required',
            'aforo' => 'required',
            'id_ciudad' => 'required',
        ])) {
            return $this->new();
        }

        $post = $this->validator->getValidated();

        $model = model(EventosModel::class);

        $model->save([
            'nombre' => $post['nombre'],
            'fecha'  => $post['fecha'],
            'aforo'  => $post['aforo'],
            'id_ciudad'  => $post['id_ciudad'],
        ]);

        return redirect()->to(base_url('/eventos'));
    }

    public function delete($id)
    {
        if($id == null) {
            throw new PageNotFoundException('Cannot delete the eventos item');
        }

        $model = model(EventosModel::class);
        if($model->where('id', $id)->find()){
            $model->where('id', $id)->delete();
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return redirect()->to(base_url('/eventos'));
    }

    public function update($id)
    {
        helper('form');

        if($id == null) {
            throw new PageNotFoundException('Cannot update the eventos item');
        }

        $model = model(EventosModel::class);
        $model_ciu = model(CiudadesModel::class);

        if($model->where('id', $id)->find()){
            $data = [
                'nombre' => $model->where('id',$id)->first(),
                'title' => 'Update item',
                'nombre' => $model_ciu->findAll(),
            ];
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return view('templates/header')
            .view('eventos/update',$data)
            .view('templates/footer');
    }

    public function updatedItem($id)
    {
        helper('form');

        if(! $this->validate([
            'nombre' => 'required|max_length[150]|min_length[3]',
            'fecha' => 'required',
            'aforo' => 'required',
            'id_ciudad'  => 'required',
        ])) {
            return $this->update($id);
        }

        $post = $this->validator->getValidated();

        $data = [
            'id' => $id,
            'nombre' => $post['nombre'],
            'fecha' => $post['fecha'],
            'aforo' => $post['aforo'],
            'id_ciudad'  => $post['id_ciudad'],
        ];
        $model = model(EventosModel::class);
        $model->save($data);

        return view('templates/header',['title' => 'Item updated'])
            .view('evetnos/index')
            .view('templates/footer');
    }

    public function show(?int $id = null)
    {
        $model = model(EventosModel::class);

        $data['eventos'] = $model->getEvetnos($id);

        if ($data['eventos'] === null) {
            throw new PageNotFoundException('Cannot find the eventos item: ' . $slug);
        }

        $data['nombre'] = $data['eventos']['nombre'];

        return view('templates/header', $data)
            . view('evetnos/view')
            . view('templates/footer');
    }
}