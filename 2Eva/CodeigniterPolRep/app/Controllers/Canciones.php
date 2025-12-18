<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\CancionesModel;
use App\Models\ArtistasModel;


class Canciones extends BaseController
{
    public function index()
    {
        $model = model(CancionesModel::class);

        $data = [
            'canciones_list' => $model->getCanciones(),
            'title' => 'Canciones archive', // Siempre tiene que ser title
        ];

        return view('templates/header', $data)
            . view('canciones/index')
            . view('templates/footer');
    }


    public function show(?int $id = null)
    {
        $model = model(CancionesModel::class);

        $data['canciones'] = $model->getCanciones($id);

        if ($data['canciones'] === null) {
            throw new PageNotFoundException('Cannot find the canciones item: ' . $id);
        }

        $data['title'] = $data['canciones']['titulo']; //Siempre tiene que ser title

        return view('templates/header', $data)
            . view('canciones/view', $data)
            . view('templates/footer');
    }

    public function new()
    {
        helper('form');
        $model_artista = model(ArtistasModel::class);
        if ($data['artistas'] = $model_artista->findAll()) {
            return view('templates/header', ['title' => 'Create a canciones item'])
                . view('canciones/create', $data)
                . view('templates/footer');
        }
    }
    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['titulo', 'id_artista']);

        // Checks whether the submitted data passed the validation rules.
        if (
            !$this->validateData($data, [
                'titulo' => 'required|max_length[255]|min_length[3]',
                'id_artista' => 'required'
            ])
        ) {
            // The validation fails, so returns the form.
            return $this->new();
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(CancionesModel::class);

        $model->save([
            'titulo' => $post['titulo'],
            'id_artista' => $post['id_artista'],
        ]);

        // return view('templates/header', ['title' => 'Create a news item'])
        //     . view('news/success')
        //     . view('templates/footer');
        return redirect()->to(base_url('canciones'));

    }
    public function delete($id)
    {
        if ($id == null) {
            throw new PageNotFoundException('Cannot delete the item');
        }

        $model = model(CancionesModel::class);
        if ($model->where('id', $id)->find()) {
            $model->where('id', $id)->delete();
        } else {
            throw new PageNotFoundException('Selected item does not exist in database');
        }

        return redirect()->to(base_url('canciones'));
    }

    public function update($id)
    {
        helper('form');

        if ($id == null) {
            throw new PageNotFoundException('Cannot update the item');
        }

        $model = model(CancionesModel::class);
        $artistasmodel = model(ArtistasModel::class);
        if ($model->where('id', $id)->find()) {
            $data = [
                'canciones' => $model->where('id', $id)->first(),
                'title' => 'Update item',
                'artistas' => $artistasmodel->findAll(),
            ];
        } else {
            throw new PageNotFoundException('Selected item does not exist in database');
        }

        return view('templates/header', $data)
            . view('canciones/update')
            . view('templates/footer');
    }

    

    public function updatedItem($id)
    {
        helper('form');

        $data_form = $this->request->getPost(['titulo', 'id_artista']);

        $validationRules = [
            'titulo' => 'required|max_length[255]|min_length[3]',
            'id_artista' => 'required|integer|is_not_unique[artistas.id]',
        ];

        if (!$this->validateData($data_form, $validationRules)) {
            return $this->update($id);
        }

        $post = $this->validator->getValidated();
        $CancionesModel = model(CancionesModel::class);

        $CancionesModel->save([
            'id' => $id,
            'titulo' => $post['titulo'],
            'id_artista' => $post['id_artista'],
        ]);

        session()->setFlashdata('message', 'La Canción ha sido actualizada exitosamente.');

        return redirect()->to(base_url('/canciones'));
    }
}