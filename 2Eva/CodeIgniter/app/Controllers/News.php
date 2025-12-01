<?php
namespace App\Controllers;
use App\Models\NewsModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);
        $data = [
            'news_list' => $model->getNews(),
            'title'     => 'News archive',
        ];

        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }

    public function show(?string $slug = null)
    {
        $model = model(NewsModel::class);
        $data['news'] = $model->getNews($slug);

        if ($data['news'] === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view')
            . view('templates/footer');
    }

    //Mostrar Form insertar
     public function new()
    {
        helper('form');
        $model_cat = model(categoryModel::class);
        if ($data['category'] = $model->findAll()){
        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create', $data)
            . view('templates/footer');
        }
    }

     public function create()
    {
        helper('form');

        $data = $this->request->getPost(['title', 'body']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
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
        ]);

        //return view('templates/header', ['title' => 'Create a news item'])
        //   . view('news/success')
        //    . view('templates/footer');

        return redirect()->to(base_url('news'));        
    }
    public function delete($id) 
    {
        if ($id == null) {
            throw new PageNotFoundException('cannot delete the item');
        }

        $model = model(NewsModel::class);
        if($model->where('id', $id)->find()){
            $model->where('id', $id)->delete();
        } else {
            throw new PageNotFoundException('Selected item does not exist in database');
        }
        return redirect()->to(base_url('news'));        
    }

    public function update($id)
    {
        helper('form');

        if ($id==null) {
            throw new PageNotFoundException('Cannot update the item');
        }

        $model = model(NewsModel::class);

        if($model->where('id', $id)->find()) {
            $data = [
                'news' => $model->where('id', $id)->first(),
                'title' => 'update item',    
            ];
        } else {
            throw new PageNotFoundException('Selected item nor found in DB');
        }

        return view('templates/header',$data)
            . view('news/update')
            . view('templates/footer');
    }

     //editar noticia
    public function updatedItem($id)
    {
        helper('form');

        $data = $this->request->getPost(['title', 'body']);//name form

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return $this->update($id);
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(NewsModel::class);

        $model->save([
            'id' => $id,
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);

        return redirect()->to(base_url('news'));
    }
}