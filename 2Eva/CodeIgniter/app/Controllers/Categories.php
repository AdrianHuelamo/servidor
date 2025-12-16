<?php

namespace App\Controllers;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    public function index()
    {
        $model = model(CategoryModel::class);

        $data = [
            'categories_list' => $model->getCategory(),
            'title'     => 'Categories',
        ];

        return view('backend/templates/header', $data)
            . view('backend/categories/index')
            . view('backend/templates/footer');
    }

    public function new()
    {
        helper('form');
        $model_cat = model(CategoryModel::class);
        if($data['category'] = $model_cat->findAll()){
            
            return view('backend/templates/header', ['title' => 'Create a category item'])
            . view('backend/categories/create', $data)
            . view('backend/templates/footer');
        }

        
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['category']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'category' => 'required|max_length[255]|min_length[3]',
           
        ])) {
            // The validation fails, so returns the form.
            return $this->new();
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(CategoryModel::class);

        $model->save([
            'category' => $post['category'],
         
        ]);

        // return view('templates/header', ['title' => 'Create a news item'])
        //     . view('news/success')
        //     . view('templates/footer');
        return redirect()->to(base_url('/categories'));
    }

    public function delete($id)
    {
        if($id == null) {
            throw new PageNotFoundException('Cannot delete the news item');
        }

        $model = model(CategoryModel::class);
        if($model->where('id', $id)->find()){
            $model->where('id', $id)->delete();
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        // return view('template/header', ['title' => 'Delete item'])
        //     .view('news/success')
        //     .view('template/footer');
        return redirect()->to(base_url('/categories'));
    }

    public function update($id)
    {
        helper('form');

        if($id == null) {
            throw new PageNotFoundException('Cannot update the news item');
        }

        $model = model(CategoryModel::class);

        if($model->where('id', $id)->find()){
            $data = [
                'category' => $model->where('id',$id)->first(),
                'title' => 'Update item',
            ];
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return view('backend/templates/header')
            .view('backend/categories/update',$data)
            .view('backend/templates/footer');
        //return redirect()->to(base_url('/news'));
    }

    public function updatedItem($id)
    {
        helper('form');

        if(! $this->validate([
            'category' => 'required|max_length[255]|min_length[3]',
           
        ])) {
            return $this->update($id);
        }

        $post = $this->validator->getValidated();

        $data = [
            'id' => $id,
            'category' => $post['category'],
   
        ];
        $model = model(CategoryModel::class);
        $model->save($data);

        return redirect()->to(base_url('/categories'));
    }

    public function show(?string $slug = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($slug);

        if ($data['news'] === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view('backend/templates/header', $data)
            . view('backend/news/view')
            . view('backend/templates/footer');
    }
}