<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    protected $users_model;
    protected $auth_users_model;
    
    public function __construct()
    {
        $this->session                 = service('session');
    }

    public function login()
    {
        return view('Admin/auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('admin/login');
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'Admin Dashboard',
            'message' => 'Welcome to the Admin Dashboard!'
        ];
        return $this->render_admin('Admin/dashboard', $data);
    }
}