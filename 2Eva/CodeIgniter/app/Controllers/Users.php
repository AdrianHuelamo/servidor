<?php
namespace App\Controllers;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    public function loginForm($error = null)
        {
            helper('form');
            if($error == null){
                return view('templates/header', ['title' => 'private Acces'])
                . view('users/login', ['error' => 'Credenciales incorrectas'])
                . view('templates/footer');
            }
        }
}    
?>