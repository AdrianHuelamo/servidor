<?php

namespace App\Controllers;
use App\Models\CantantesModel;

class Cantantes extends BaseController
{
    public function index()
    {
        $model = model(CantantesModel::class);

        $data = [
            'cantantes_list' => $model->getCantantes(),
            'title'     => 'Cantantes',
        ];

        return view('templates/header', $data)
            . view('cantantes/index')
            . view('templates/footer');
    }

    public function new()
    {
        helper('form');
        $model_can = model(CantantesModel::class);
        if($data['nombre'] = $model_can->findAll()){
            
            return view('templates/header', ['title' => 'Create a category item'])
            . view('cantantes/create', $data)
            . view('templates/footer');
        }

        
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['nombre']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'nombre' => 'required|max_length[50]|min_length[3]',
           
        ])) {
            // The validation fails, so returns the form.
            return $this->new();
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(CantantesModel::class);

        $model->save([
            'nombre' => $post['nombre'],
         
        ]);

        // return view('templates/header', ['title' => 'Create a news item'])
        //     . view('news/success')
        //     . view('templates/footer');
        return redirect()->to(base_url('/cantantes'));
    }

    public function delete($id)
    {
        if($id == null) {
            throw new PageNotFoundException('Cannot delete the news item');
        }

        $model = model(CantantesModel::class);
        if($model->where('id', $id)->find()){
            $model->where('id', $id)->delete();
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        // return view('template/header', ['title' => 'Delete item'])
        //     .view('news/success')
        //     .view('template/footer');
        return redirect()->to(base_url('/cantantes'));
    }

    public function update($id)
    {
        helper('form');

        if($id == null) {
            throw new PageNotFoundException('Cannot update the news item');
        }


        $model = model(CantantesModel::class);

        if($model->where('id', $id)->find()){
            $data = [
                'cantante' => $model->getCantantes($id),
                'title' => 'Update item',
            ];
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return view('templates/header')
            .view('cantantes/update',$data)
            .view('templates/footer');
        //return redirect()->to(base_url('/news'));
    }

    public function updatedItem($id)
    {
        helper('form');

        if(! $this->validate([
            'nombre' => 'required|max_length[50]|min_length[3]',
           
        ])) {
            return $this->update($id);
        }

        $post = $this->validator->getValidated();

        $data = [
            'id' => $id,
            'nombre' => $post['nombre'],
   
        ];
        $model = model(CantantesModel::class);
        $model->save($data);

        return redirect()->to(base_url('/cantantes'));
    }

    public function show(?int $id = null)
    {
        $model = model(CantantesModel::class);

        $data['cantante'] = $model->getCantantes($id);

        if ($data['cantante'] === null) {
            throw new PageNotFoundException('Cannot find the cantante item: ' . $id);
        }

        $data['title'] = $data['cantante']['nombre'];

        return view('templates/header', $data)
            . view('cantantes/view')
            . view('templates/footer');
    }
}