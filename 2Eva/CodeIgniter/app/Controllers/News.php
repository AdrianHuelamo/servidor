<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\CategoryModel;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news_list' => $model->getNews(),
            'title'     => 'News archive',
        ];

        return view('backend/templates/header', $data)
            . view('backend/news/index')
            . view('backend/templates/footer');
    }

    public function new()
    {
        helper('form');
        $model_cat = model(CategoryModel::class);
        if($data['category'] = $model_cat->findAll()){
            
            return view('backend/templates/header', ['title' => 'Create a news item'])
            . view('backend/news/create', $data)
            . view('backend/templates/footer');
        }

        
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['title', 'body','id_category']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
            'id_category' => 'required',
        ])) {
            // The validation fails, so returns the form.
            return $this->new();
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(NewsModel::class);

        $model->save([
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
            'id_category'  => $post['id_category'],
        ]);

        // return view('templates/header', ['title' => 'Create a news item'])
        //     . view('news/success')
        //     . view('templates/footer');
        return redirect()->to(base_url('/news'));
    }

    public function delete($id)
    {
        if($id == null) {
            throw new PageNotFoundException('Cannot delete the news item');
        }

        $model = model(NewsModel::class);
        if($model->where('id', $id)->find()){
            $model->where('id', $id)->delete();
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        // return view('template/header', ['title' => 'Delete item'])
        //     .view('news/success')
        //     .view('template/footer');
        return redirect()->to(base_url('/news'));
    }

    public function update($id)
    {
        helper('form');

        if($id == null) {
            throw new PageNotFoundException('Cannot update the news item');
        }

        $model = model(NewsModel::class);
        $model_cat = model(CategoryModel::class);

        if($model->where('id', $id)->find()){
            $data = [
                'news' => $model->where('id',$id)->first(),
                'title' => 'Update item',
                'category' => $model_cat->findAll(),
            ];
        }else{
            throw new PageNotFoundException('Selected item does not exists in database');
        }

        return view('backend/templates/header')
            .view('backend/news/update',$data)
            .view('backend/templates/footer');
        //return redirect()->to(base_url('/news'));
    }

    public function updatedItem($id)
    {
        helper('form');

        if(! $this->validate([
            'title' => 'required|max_length[255]|min_length[3]',
            'body' => 'required|max_length[5000]|min_length[10]',
            'id_category'  => 'required',
        ])) {
            return $this->update($id);
        }

        $post = $this->validator->getValidated();

        $data = [
            'id' => $id,
            'title' => $post['title'],
            'slug' => url_title($post['title'], '-', true),
            'body' => $post['body'],
            'id_category'  => $post['id_category'],
        ];
        $model = model(NewsModel::class);
        $model->save($data);

        return view('backend/templates/header',['title' => 'Item updated'])
            .view('backend/news/success')
            .view('backend/templates/footer');
        //return redirect()->to(base_url('/news'));
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