<?php

namespace App\Controllers;

use App\Models\PersonajesModel;
use App\Models\PeliculasModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Personajes extends BaseController
{
    public function index()
    {
        $model = model(PersonajesModel::class);

        $data = [
            'personajes_list' => $model->getPersonajes(),
            //'title'     => 'Canciones archive',
        ];

        return view('templates/header', $data)
            . view('personajes/index')
            . view('templates/footer');
    }

    public function new()
    {
        //fumada mia
        helper('form');
        $model = model(PersonajesModel::class);
        $model_Pel = model(PeliculasModel::class);
        
        if(!empty($model)){
            $data = [
                'personaje' => $model->getPersonajes(),
                'pelicula' => $model_Pel->getPeliculas(),
            ];
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }
            
            return view('templates/header', ['title' => 'Create a cancion'])
            . view('personajes/create', $data)
            . view('templates/footer');        
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['nombre','id_pelicula']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'nombre' => 'required|max_length[50]|min_length[3]',
            'id_pelicula' => 'required',
        ])) {
            // The validation fails, so returns the form.
            return $this->new();
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(PersonajesModel::class);

        $model->save([
            'nombre' => $post['nombre'],
            'id_pelicula'  => $post['id_pelicula'],
        ]);

        // return view('templates/header', ['title' => 'Create a news item'])
        //     . view('news/success')
        //     . view('templates/footer');
        return redirect()->to(base_url('/personajes'));
    }

    

    public function update($id)
    {
        helper('form');

        if($id == null) {
            throw new PageNotFoundException('Cannot update the news item');
        }

        $model = model(PersonajesModel::class);
        $model_Pel = model(PeliculasModel::class);

        if($model->where('personajes.id', $id)->find()){
            $data = [
                'personaje' => $model->getPersonajes($id),
                'pelicula' => $model_Pel->getPeliculas(),
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
            'id_pelicula'  => $post['id_pelicula'],
        ];
        $model = model(PersonajesModel::class);
        $model->save($data);

        //return view('templates/header',['title' => 'Item updated'])
        //    .view('personajes/index')
        //    .view('templates/footer');
        return redirect()->to(base_url('/personajes'));
    }

    public function delete($id)
    {
        if($id == null) {
            throw new PageNotFoundException('Cannot delete the news item');
        }

        $model = model(PersonajesModel::class);
        if($model->where('id', $id)->find()){
            $model->where('id', $id)->delete();
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        // return view('template/header', ['title' => 'Delete item'])
        //     .view('news/success')
        //     .view('template/footer');
        return redirect()->to(base_url('/personajes'));
    }

    public function show(?int $id = null)
    {
        $model = model(PersonajesModel::class);

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