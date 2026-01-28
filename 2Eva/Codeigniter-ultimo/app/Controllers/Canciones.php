<?php

namespace App\Controllers;

use App\Models\CancionesModel;
use App\Models\CantantesModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Canciones extends BaseController
{
    public function index()
    {
        $model = model(CancionesModel::class);

        $data = [
            'canciones_list' => $model->getCanciones(),
            'title'     => 'Canciones archive',
        ];

        return view('templates/header', $data)
            . view('canciones/index')
            . view('templates/footer');
    }

    public function new()
    {
        helper('form');
        $model_can = model(CantantesModel::class);
        if($data['nombre'] = $model_can->findAll()){
            
            return view('templates/header', ['title' => 'Create a cancion'])
            . view('canciones/create', $data)
            . view('templates/footer');
        }

        
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['nombre','id_cantante']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'nombre' => 'required|max_length[50]|min_length[3]',
            'id_cantante' => 'required',
        ])) {
            // The validation fails, so returns the form.
            return $this->new();
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(CancionesModel::class);

        $model->save([
            'nombre' => $post['nombre'],
            'id_cantante'  => $post['id_cantante'],
        ]);

        // return view('templates/header', ['title' => 'Create a news item'])
        //     . view('news/success')
        //     . view('templates/footer');
        return redirect()->to(base_url('/canciones'));
    }

    public function delete($id)
    {
        if($id == null) {
            throw new PageNotFoundException('Cannot delete the news item');
        }

        $model = model(CancionesModel::class);
        if($model->where('id', $id)->find()){
            $model->where('id', $id)->delete();
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        // return view('template/header', ['title' => 'Delete item'])
        //     .view('news/success')
        //     .view('template/footer');
        return redirect()->to(base_url('/canciones'));
    }

    public function update($id)
    {
        helper('form');

        if($id == null) {
            throw new PageNotFoundException('Cannot update the news item');
        }

        $model = model(CancionesModel::class);
        $model_can = model(CantantesModel::class);

        if($model->where('canciones.id', $id)->find()){
            $data = [
                'canciones' => $model->getCanciones($id),
                'nombre' => $model_can->findAll(),
            ];
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return view('templates/header')
            .view('canciones/update',$data)
            .view('templates/footer');
        //return redirect()->to(base_url('/news'));
    }

    public function updatedItem($id)
    {
        helper('form');

        if(! $this->validate([
            'nombre' => 'required|max_length[50]|min_length[3]',
            'id_cantante'  => 'required',
        ])) {
            return $this->update($id);
        }

        $post = $this->validator->getValidated();

        $data = [
            'id' => $id,
            'nombre' => $post['nombre'],
            'id_cantante'  => $post['id_cantante'],
        ];
        $model = model(CancionesModel::class);
        $model->save($data);

        return view('templates/header',['title' => 'Item updated'])
            .view('canciones/success')
            .view('templates/footer');
        //return redirect()->to(base_url('/news'));
    }

    public function show(?int $id = null)
    {
        $model = model(CancionesModel::class);

        $data['canciones'] = $model->getCanciones($id);

        if ($data['canciones'] === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $id);
        }

        $data['nombre'] = $data['canciones']['cancion_nombre'];

        return view('templates/header', $data)
            . view('canciones/view')
            . view('templates/footer');
    }
}