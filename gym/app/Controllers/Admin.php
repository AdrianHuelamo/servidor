<?php

namespace App\Controllers;

use App\Models\EjercicioModel;
use App\Models\GrupoModel;
use App\Models\NoticiaModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'total_ejercicios' => model(EjercicioModel::class)->countAllResults(),
            'total_grupos'     => model(GrupoModel::class)->countAllResults(),
            'total_noticias'   => model(NoticiaModel::class)->countAllResults(),
            'total_usuarios'   => model(UserModel::class)->countAllResults(),
        ];
        return view('admin/dashboard', $data);
    }

    public function ejercicios()
    {
        $model = new EjercicioModel();
        $grupoModel = new GrupoModel(); 

        $filtros = [
            'search'     => $this->request->getGet('search'),
            'dificultad' => $this->request->getGet('dificultad'),
            'grupo'      => $this->request->getGet('grupo')
        ];

        $data = [
            'ejercicios' => $model->prepararConsulta($filtros)->paginate(9),
            'pager'      => $model->pager,
            'grupos'     => $grupoModel->findAll(),
            'filtros'    => $filtros 
        ];

        return view('admin/ejercicios/index', $data);
    }

    public function createEjercicio()
    {
        if (!$this->validate([
            'titulo'      => 'required|min_length[3]',
            'descripcion' => 'required',
            'grupo_id'    => 'required', 
            'dificultad'  => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new EjercicioModel();

        $datos = [
            'titulo'      => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'dificultad'  => $this->request->getPost('dificultad'),
            'id_grupo'    => $this->request->getPost('grupo_id'),
            'destacado'   => $this->request->getPost('destacado') ? 1 : 0, 
        ];

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move('img/', $nuevoNombre);
            $datos['imagen'] = $nuevoNombre;
        } else {
            $datos['imagen'] = 'default.jpg';
        }

        $model->save($datos);

        return redirect()->to('/admin/ejercicios')->with('mensaje', 'Ejercicio creado correctamente.');
    }

    public function editEjercicio($id)
    {
        $model = new EjercicioModel();
        $grupoModel = new GrupoModel();

        $data['ejercicio'] = $model->find($id);
        $data['grupos'] = $grupoModel->findAll();

        if (empty($data['ejercicio'])) {
            return redirect()->to('/admin/ejercicios')->with('error', 'Ejercicio no encontrado');
        }

        return view('admin/ejercicios/update', $data);
    }

    public function updateEjercicio($id)
    {
        $model = new EjercicioModel();

        if (!$this->validate([
            'titulo'   => 'required',
            'grupo_id' => 'required' 
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'titulo'      => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'dificultad'  => $this->request->getPost('dificultad'),
            'id_grupo'    => $this->request->getPost('grupo_id'),
            'destacado'   => $this->request->getPost('destacado') ? 1 : 0, 
        ];

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move('img/', $nuevoNombre);
            $datos['imagen'] = $nuevoNombre;
        }

        $model->update($id, $datos);

        return redirect()->to('/admin/ejercicios')->with('mensaje', 'Ejercicio actualizado correctamente.');
    }

    public function toggleDestacado($id)
    {
        $model = new EjercicioModel();
        $ejercicio = $model->find($id);

        if ($ejercicio) {
            $nuevoEstado = ($ejercicio['destacado'] == 1) ? 0 : 1;
            
            $model->update($id, ['destacado' => $nuevoEstado]);
            
            $msg = ($nuevoEstado == 1) ? '¡Ejercicio destacado!' : 'Ejercicio quitado de destacados.';
 
            return redirect()->to('/admin/ejercicios')->with('mensaje', $msg);
        }

        return redirect()->to('/admin/ejercicios')->with('error', 'Ejercicio no encontrado.');
    }

    public function deleteEjercicio($id)
    {
        $model = new EjercicioModel();
        $model->delete($id);
        return redirect()->to('/admin/ejercicios')->with('mensaje', 'Ejercicio eliminado correctamente.');
    }

    public function grupos() {
        $model = new GrupoModel();
        $data['grupos'] = $model->findAll();
        return view('admin/grupos/index', $data); 
    }

    public function newGrupo()
    {
        return view('admin/grupos/create');
    }

    public function createGrupo()
    {
        if (!$this->validate([
            'nombre'      => 'required|min_length[3]',
            'descripcion' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new GrupoModel();

        $datos = [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move('img/', $nuevoNombre);
            $datos['imagen'] = $nuevoNombre;
        } else {
            $datos['imagen'] = 'default.jpg';
        }

        $model->save($datos);

        return redirect()->to('/admin/grupos')->with('mensaje', 'Grupo muscular creado correctamente.');
    }

    public function editGrupo($id)
    {
        $model = new GrupoModel();
        $data['grupo'] = $model->find($id);

        if (empty($data['grupo'])) {
            return redirect()->to('/admin/grupos')->with('error', 'Grupo no encontrado');
        }

        return view('admin/grupos/update', $data);
    }

    public function updateGrupo($id)
    {
        $model = new GrupoModel();

        if (!$this->validate(['nombre' => 'required'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move('img/', $nuevoNombre);
            $datos['imagen'] = $nuevoNombre;
        }

        $model->update($id, $datos);

        return redirect()->to('/admin/grupos')->with('mensaje', 'Grupo actualizado correctamente.');
    }

    public function deleteGrupo($id) {
        $model = new GrupoModel();
        $model->delete($id);
        return redirect()->to('/admin/grupos')->with('mensaje', 'Grupo muscular eliminado.');
    }

    public function noticias() {
        $model = new NoticiaModel();
        $data['noticias'] = $model->orderBy('fecha_publicacion', 'DESC')->findAll();
        return view('admin/noticias/index', $data); 
    }

    public function newNoticia()
    {
        return view('admin/noticias/create');
    }

    public function createNoticia()
    {
        if (!$this->validate([
            'titulo'            => 'required|min_length[3]',
            'resumen'           => 'required|max_length[255]',
            'contenido'         => 'required',
            'fecha_publicacion' => 'required|valid_date'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new NoticiaModel();

        $datos = [
            'titulo'            => $this->request->getPost('titulo'),
            'resumen'           => $this->request->getPost('resumen'),
            'contenido'         => $this->request->getPost('contenido'),
            'fecha_publicacion' => $this->request->getPost('fecha_publicacion'),
        ];

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move('img/', $nuevoNombre);
            $datos['imagen'] = $nuevoNombre;
        } else {
            $datos['imagen'] = 'news_default.jpg';
        }

        $model->save($datos);

        return redirect()->to('/admin/noticias')->with('mensaje', 'Noticia publicada correctamente.');
    }

    public function editNoticia($id)
    {
        $model = new NoticiaModel();
        $data['noticia'] = $model->find($id);

        if (empty($data['noticia'])) {
            return redirect()->to('/admin/noticias')->with('error', 'Noticia no encontrada');
        }

        return view('admin/noticias/update', $data);
    }

    public function updateNoticia($id)
    {
        $model = new NoticiaModel();

        if (!$this->validate([
            'titulo'            => 'required',
            'fecha_publicacion' => 'required|valid_date'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'titulo'            => $this->request->getPost('titulo'),
            'resumen'           => $this->request->getPost('resumen'),
            'contenido'         => $this->request->getPost('contenido'),
            'fecha_publicacion' => $this->request->getPost('fecha_publicacion'),
        ];

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move('img/', $nuevoNombre);
            $datos['imagen'] = $nuevoNombre;
        }

        $model->update($id, $datos);

        return redirect()->to('/admin/noticias')->with('mensaje', 'Noticia actualizada correctamente.');
    }

    public function deleteNoticia($id) {
        $model = new NoticiaModel();
        $model->delete($id);
        return redirect()->to('/admin/noticias')->with('mensaje', 'Noticia eliminada correctamente.');
    }

    public function usuarios()
    {
        $model = new UserModel();
        $data['usuarios'] = $model->orderBy('id', 'DESC')->findAll();
        return view('admin/usuarios/index', $data);
    }

    public function deleteUsuario($id)
    {
        if ($id == session()->get('user_id')) {
            return redirect()->to('/admin/usuarios')->with('mensaje', '¡Error! No puedes eliminar tu propia cuenta de administrador.');
        }

        $model = new UserModel();
        $model->delete($id);
        
        return redirect()->to('/admin/usuarios')->with('mensaje', 'Usuario eliminado correctamente.');
    }

    public function rutinas()
    {
        $model = new \App\Models\RutinaModel();
        $userModel = new \App\Models\UserModel();

        $filtroUsuario = $this->request->getGet('user_id');

        $builder = $model->select('rutinas.*, users.username, users.email')
                         ->join('users', 'users.id = rutinas.id_user');

        if (!empty($filtroUsuario)) {
            $builder->where('rutinas.id_user', $filtroUsuario);
        }

        $data['rutinas'] = $builder->orderBy('rutinas.created_at', 'DESC')->findAll();
        
        $data['usuarios'] = $userModel->where('rol !=', 1) 
                                      ->orderBy('username', 'ASC')
                                      ->findAll();

        $data['usuario_seleccionado'] = $filtroUsuario;

        return view('admin/rutinas/index', $data);
    }
}