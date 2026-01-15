<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Cargamos las vistas en orden como si fuera un sándwich
        echo view('templates/header');
        echo view('inicio');
        echo view('templates/footer');
    }
}