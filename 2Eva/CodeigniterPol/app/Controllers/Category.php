<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Category extends BaseController
{
    // -----------------------------------------------------------
    // R (Read) - Listado (Mapea a: $routes->get('category', [Category::class, 'index']);)
    // -----------------------------------------------------------
    public function index()
    {
        $model = model(CategoryModel::class);

        $data = [
            'category_list' => $model->findAll(),
            'title'         => 'Category Management',
        ];

        return view('templates/header', $data)
            . view('category/index')
            . view('templates/footer');
    }

    // -----------------------------------------------------------
    // C (Create) - Muestra Formulario (Mapea a: $routes->get('category/new', [Category::class, 'new']);)
    // -----------------------------------------------------------
    public function new()
    {
        helper('form');
        
        $data['title'] = 'Create New Category';

        return view('templates/header', $data)
            . view('category/create')
            . view('templates/footer');
    }

    // -----------------------------------------------------------
    // C (Create) - Procesa y Guarda (Mapea a: $routes->post('category', [Category::class, 'create']);)
    // -----------------------------------------------------------
    public function create()
    {
        helper('form');

        $data_form = $this->request->getPost(['category']); 

        if (! $this->validateData($data_form, [
            'category' => 'required|max_length[100]|min_length[2]|is_unique[category.category]',
        ])) {
            return $this->new();
        }

        $post = $this->validator->getValidated();
        $model = model(CategoryModel::class);

        $model->save([
            'category' => $post['category'], 
        ]);
        
        session()->setFlashdata('success', 'Category created successfully!');

        return redirect()->to(base_url('category'));
    }

    // -----------------------------------------------------------
    // R (Read) - Detalle (Mapea a: $routes->get('category/(:segment)', [Category::class, 'show']);)
    // -----------------------------------------------------------
    public function show(?string $slug = null)
    {
        throw new PageNotFoundException("Category show not implemented. Slug: $slug");
        // Implementación de show si usas slugs para categorías:
        /*
        $model = model(CategoryModel::class);
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

        $model = model(CategoryModel::class);
        $categoryItem = $model->find($id);

        if (empty($categoryItem)) {
            throw new PageNotFoundException('Selected category does not exist in database');
        }
        
        $model->delete($id);

        session()->setFlashdata('success', 'Category deleted successfully!');
        
        return redirect()->to(base_url('category'));
    }

    // -----------------------------------------------------------
    // U (Update) - 1. Muestra Formulario (Mapea a: $routes->get('category/update/(:num)',[Category::class, 'update']);)
    // -----------------------------------------------------------
    public function update($id = null)
    {
        helper('form');
        
        if ($id === null) {
            throw new PageNotFoundException('Cannot update the item: ID missing.');
        }

        $model = model(CategoryModel::class);
        $categoryItem = $model->find($id);

        if (empty($categoryItem)) {
            throw new PageNotFoundException('Selected category does not exist in database');
        }

        $data = [
            'category' => $categoryItem,
            'title'    => 'Update Category: ' . esc($categoryItem['category']),
        ];

        return view('templates/header', $data)
            . view('category/update')
            . view('templates/footer');
    }

    // -----------------------------------------------------------
    // U (Update) - 2. Procesa y Guarda (REQUIERE RUTA POST)
    // Mapea a: $routes->post('category/update/(:num)',[Category::class, 'updateSave']);
    // -----------------------------------------------------------
    public function updateSave($id)
    {
        helper('form');
        
        $data_form = $this->request->getPost(['category']);
        
        // La regla de unicidad excluye el ID que se está actualizando.
        $validationRules = [
            'category' => "required|max_length[100]|min_length[2]|is_unique[category.category,id,{$id}]",
        ];

        // Si la validación falla, recargamos el formulario llamando al método 'update' (GET)
        if (! $this->validateData($data_form + ['id' => $id], $validationRules)) {
            return $this->update($id); 
        }

        $post = $this->validator->getValidated();
        $model = model(CategoryModel::class);

        $model->save([
            'id'       => $id,
            'category' => $post['category'],
        ]);

        session()->setFlashdata('success', 'Category updated successfully!');
        
        return redirect()->to(base_url('category'));
    }
}