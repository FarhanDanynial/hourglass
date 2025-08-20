<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'message' => 'Welcome to the Admin Dashboard!'
        ];
        return view('Admin/dashboard', $data);
    }
}
