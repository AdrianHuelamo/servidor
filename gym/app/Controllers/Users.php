<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{

    protected $helpers = ['form'];


    public function loginForm()
    {
        if (session()->has('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('templates/header', ['title' => 'Iniciar Sesión'])
             . view('users/login')
             . view('templates/footer');
    }

    public function checkUser()
    {
        if (! $this->validate([
            'username' => 'required',
            'password' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Faltan datos');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        
        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            
            $sessionData = [
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'rol'       => $user['rol'], 
                'isLoggedIn'=> true
            ];
            session()->set($sessionData);

            return redirect()->to('/')->with('mensaje', '¡Bienvenido ' . $user['username'] . '!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Usuario o contraseña incorrectos');
        }
    }

    public function registerForm()
    {
        if (session()->has('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('templates/header', ['title' => 'Registro'])
             . view('users/register')
             . view('templates/footer');
    }

    public function createUser()
    {
        if (! $this->validate([
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[4]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();

        $model->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'      => 0 
        ]);

        return redirect()->to('login')->with('mensaje', 'Cuenta creada. ¡Ahora inicia sesión!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('mensaje', 'Sesión cerrada correctamente.');
    }
}