<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function login()
    {
        return view('Admin/auth/login');
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'message' => 'Welcome to the Admin Dashboard!'
        ];
        return $this->render_admin('Admin/dashboard', $data);
    }
}