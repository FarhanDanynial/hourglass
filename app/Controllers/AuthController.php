<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuthUsersModel;

class AuthController extends BaseController
{
    protected $users_model;
    protected $auth_users_model;
    
    public function __construct()
    {
        $this->users_model             = new UserModel();
        $this->auth_users_model        = new AuthUsersModel();
        $this->session                 = service('session');
    }
    
    public function login()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'message' => 'Welcome to the Admin Dashboard!'
        ];
        return $this->render_admin('Admin/dashboard', $data);
    }
}