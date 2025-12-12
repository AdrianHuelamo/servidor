<?php

namespace App\Controllers;

use App\Models\ViajesModel;

class Viajes extends BaseController
{
    public function index()
    {
        $model = model(ViajesModel::class);

        $data = [
            'viajes_list' => $model->getViajes(),
            'title'     => 'Viajes archive',
        ];

        return view('templates/header', $data)
            . view('viajes/index')
            . view('templates/footer');
    }

    public function new()
    {
        helper('form');
     
            return view('templates/header', ['title' => 'Create a viajes item'])
            . view('viajes/create')
            . view('templates/footer');        
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['viaje', 'fecha','plazas']);

        if (! $this->validateData($data, [
            'viaje' => 'required|max_length[100]|min_length[3]',
            'fecha'  => 'required',
            'plazas' => 'required',
        ])) {
            return $this->new();
        }

        $post = $this->validator->getValidated();

        $model = model(ViajesModel::class);

        $model->save([
            'viaje' => $post['viaje'],
            'fecha'  => $post['fecha'],
            'plazas'  => $post['plazas'],
        ]);

        return redirect()->to(base_url('/viajes'));
    }

    public function delete($id)
    {
        if($id == null) {
            throw new PageNotFoundException('Cannot delete the viajes item');
        }

        $model = model(ViajesModel::class);
        if($model->where('id', $id)->find()){
            $model->where('id', $id)->delete();
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return redirect()->to(base_url('/viajes'));
    }

    public function update($id)
    {
        helper('form');

        if($id == null) {
            throw new PageNotFoundException('Cannot update the viajes item');
        }

        $model = model(ViajesModel::class);

        if($model->where('id', $id)->find()){
            $data = [
                'viajes' => $model->where('id',$id)->first(),
                'title' => 'Update item',
            ];
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return view('templates/header')
            .view('viajes/update',$data)
            .view('templates/footer');
    }

    public function updatedItem($id)
    {
        helper('form');

        if(! $this->validate([
            'viaje' => 'required|max_length[100]|min_length[3]',
            'fecha' => 'required',
            'plazas'  => 'required',
        ])) {
            return $this->update($id);
        }

        $post = $this->validator->getValidated();

        $data = [
            'id' => $id,
            'viaje' => $post['viaje'],
            'fecha' => $post['fecha'],
            'plazas'  => $post['plazas'],
        ];
        $model = model(ViajesModel::class);
        $model->save($data);

        return redirect()->to(base_url('/viajes'));
    }

    public function show(?int $id = null)
    {
        $model = model(ViajesModel::class);

        $data['viajes'] = $model->getViajes($id);

        if ($data['viajes'] === null) {
            throw new PageNotFoundException('Cannot find the viajes item: ' . $id);
        }

        $data['viaje'] = $data['viajes']['viaje'];

        return view('templates/header', $data)
            . view('viajes/view')
            . view('templates/footer');
    }
}