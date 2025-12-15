<?php
namespace App\Controllers;
use App\Models\UserModel;

class Users extends BaseController
{
    public function loginForm($error = null)
        {
            helper('form');
            if($error == null){
                return view('backend/templates/header', ['title' => 'private Acces'])
                . view('backend/users/login', ['error' => ''])
                . view('backend/templates/footer');
            }else{
                return view('backend/templates/header', ['title' => 'private Acces'])
                . view('backend/users/login', ['error' => 'Credenciales incorrectas'])
                . view('backend/templates/footer');
            }
        }

    public function checkUser()
        {
            helper('form');
            if (! $this->validate([
                'username' => 'required|max_length[255]|min_length[4]',
                'password' => 'required|max_length[500]|min_length[4]',
                ]))
            {
                return $this->loginForm();
            }
            $post = $this->validator->getValidated();

            $model = model(UserModel::class);

            if($data['user'] = $model->checkUser($post['username'],$post['password']))
            {
                return view('backend/templates/header', ['title' => 'admin'])
                . view('backend/users/admin', $data)
                . view('backend/templates/footer');
            } else {
                return $this->loginForm("error");
            }
        }
}    
?>