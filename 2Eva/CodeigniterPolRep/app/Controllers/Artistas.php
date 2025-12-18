<?php

namespace App\Controllers;

use App\Models\ArtistasModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Artistas extends BaseController
{
    // -----------------------------------------------------------
    // R (Read) - Listado (Mapea a: $routes->get('category', [Category::class, 'index']);)
    // -----------------------------------------------------------
    public function index()
    {
        $model = model(ArtistasModel::class);

        $data = [
            'artistas_list' => $model->findAll(),
            'title'         => 'Artistas Management',
        ];

        return view('templates/header', $data)
            . view('artistas/index')
            . view('templates/footer');
    }

    // -----------------------------------------------------------
    // C (Create) - Muestra Formulario (Mapea a: $routes->get('category/new', [Category::class, 'new']);)
    // -----------------------------------------------------------
    public function new()
    {
        helper('form');
        
        $data['title'] = 'Create New Artista';

        return view('templates/header', $data)
            . view('artistas/create')
            . view('templates/footer');
    }

    // -----------------------------------------------------------
    // C (Create) - Procesa y Guarda (Mapea a: $routes->post('category', [Category::class, 'create']);)
    // -----------------------------------------------------------
    public function create()
    {
        helper('form');

        $data_form = $this->request->getPost(['nombre']); 

        if (! $this->validateData($data_form, [
            'nombre' => 'required|max_length[100]|min_length[2]',
        ])) {
            return $this->new();
        }

        $post = $this->validator->getValidated();

        $model = model(ArtistasModel::class);

        $model->save([
            'nombre' => $post['nombre'], 
        ]);
        
        session()->setFlashdata('success', 'Artista created successfully!');

        return redirect()->to(base_url('artistas'));
    }

    // -----------------------------------------------------------
    // R (Read) - Detalle (Mapea a: $routes->get('category/(:segment)', [Category::class, 'show']);)
    // -----------------------------------------------------------
    public function show(?string $slug = null)
    {
        throw new PageNotFoundException("Category show not implemented. Slug: $slug");
        // Implementación de show si usas slugs para categorías:
        /*
        $model = model(ArtistasModel::class);
        $data['category'] = $model->where('slug', $slug)->first(); 

        if ($data['category'] === null) {
            throw new PageNotFoundException('Cannot find the category: ' . $slug);
        }
        $data['title'] = $data['category']['category'];
        
        return view('templates/header', $data)
            . view('category/view')
            . view('templates/footer');
        */
    }

    // -----------------------------------------------------------
    // D (Delete) - Borrar Categoría (Mapea a: $routes->get('category/del/(:num)',[Category::class, 'delete']);)
    // -----------------------------------------------------------
    public function delete($id)
    {
        if ($id === null) {
            throw new PageNotFoundException('Cannot delete the item: ID missing.');
        }

        $model = model(ArtistasModel::class);
        $artistasitem = $model->find($id);

        if (empty($artistasitem)) {
            throw new PageNotFoundException('Selected artistas does not exist in database');
        }
        
        $model->delete($id);

        session()->setFlashdata('success', 'Artista deleted successfully!');
        
        return redirect()->to(base_url('artistas'));
    }

    // -----------------------------------------------------------
    // U (Update) - 1. Muestra Formulario (Mapea a: $routes->get('category/update/(:num)',[Category::class, 'update']);)
    // -----------------------------------------------------------
  public function update($id)
{
        helper('form');
        
        if ($id == null) {
            throw new PageNotFoundException('Cannot update the item');
        }
        
        $model = model(ArtistasModel::class);
        if($model->where('id',$id)->find()){
            $data = [
                'artistas' => $model->where('id',$id)->first(),
                'title' => 'Update item',
                'nombre' => $model->findAll(),
            ];
        } else {
            throw new PageNotFoundException('Selected item does not exist in database');
        }

        return view('templates/header' , $data)
            . view('artistas/update')
            . view('templates/footer');
}

    // -----------------------------------------------------------
    // U (Update) - 2. Procesa y Guarda (REQUIERE RUTA POST)
    // Mapea a: $routes->post('category/update/(:num)',[Category::class, 'updateSave']);
    // -----------------------------------------------------------
public function updatedItem($id)
{
    helper('form');
    
    $data_form = $this->request->getPost(['nombre']);

    $validationRules = [
        'nombre' => "required|max_length[100]|min_length[2]|is_unique[artistas.nombre,id,{$id}]",
    ];

    if (! $this->validateData($data_form, $validationRules)) {
        return $this->update($id); 
    }

    $post = $this->validator->getValidated();
    $artistasmodel = model(ArtistasModel::class);

    $artistasmodel->save([
        'id'          => $id,
        'nombre'       => $post['nombre'],
    ]);
    
    session()->setFlashdata('message', 'El artista ha sido actualizado exitosamente.');
    
    return redirect()->to(base_url('/artistas'));
}
}