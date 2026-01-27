<?php

namespace App\Controllers;

use App\Models\PersonajeModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\PeliculasModel;

class Personajes extends BaseController
{
    public function index()
    {
        $model = model(PersonajeModel::class);

        $data = [
            'personajes_list' => $model->getPersonajes(),
            'title'     => 'Canciones archive',
        ];

        return view('templates/header', $data)
            . view('personajes/index')
            . view('templates/footer');
    }

    public function delete($id)
    {
        if($id == null) {
            throw new PageNotFoundException('Cannot delete the news item');
        }

        $model = model(PersonajeModel::class);
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

        $model = model(PersonajeModel::class);
        $model_Pel = model(PeliculasModel::class);

        if($model->where('personajes.id', $id)->find()){
            $data = [
                'personaje' => $model->getPersonajes($id),
                'nombre' => $model_Pel->getPeliculas(),
            ];
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return view('templates/header')
            .view('personajes/update',$data)
            .view('templates/footer');
        //return redirect()->to(base_url('/news'));
    }

    public function updatedItem($id)
    {
        helper('form');

        if(! $this->validate([
            'nombre' => 'required|max_length[50]|min_length[3]',
            'id_pelicula'  => 'required',
        ])) {
            return $this->update($id);
        }

        $post = $this->validator->getValidated();

        $data = [
            'id' => $id,
            'nombre' => $post['nombre'],
            'id_cantante'  => $post['id_cantante'],
        ];
        $model = model(PersonajeModel::class);
        $model->save($data);

        return view('templates/header',['title' => 'Item updated'])
            .view('canciones/success')
            .view('templates/footer');
        //return redirect()->to(base_url('/news'));
    }

    public function show(?int $id = null)
    {
        $model = model(PersonajeModel::class);

        $data['personajes'] = $model->getPersonajes($id);

        if ($data['personajes'] === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $id);
        }

        $data['nombre'] = $data['personajes']['personaje_nombre'];

        return view('templates/header', $data)
            . view('personajes/view')
            . view('templates/footer');
    }
}