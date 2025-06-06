<?php

namespace App\Controller;

class FrontController
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            redirect('/dashboard');
        }
        view('home');
    }
} 