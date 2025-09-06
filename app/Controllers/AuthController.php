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

    public function loginHandle()
    {
        if ($this->request->isAJAX()) {

            $data = $this->request->getPost();
            $username = trim($data['username']);
            $password = trim($data['password']);
            $user_id = $this->users_model->where('u_au_id', $this->auth_users_model->where('au_username', $username)->first()['au_id'])->first();

        $user = $this->auth_users_model->where('au_username', $username)->first();

            if ($user && password_verify($password, $user['au_password'])) {
                session()->set([
                    'id' => $user['au_id'],
                    'username' => $user['au_username'],
                    'user_id' => $user_id['u_id'],
                    'isLoggedIn' => true
                ]);
                
                $redirectUrl = '';
                if ($user['au_type'] === 'admin') {
                    $redirectUrl = '/admin/dashboard';
                } elseif ($user['au_type'] === 'staff') {
                    $redirectUrl = '/staff/dashboard';
                }elseif ($user['au_type'] === 'customer') {
                    $redirectUrl = '/customer/dashboard';
                }

                return $this->response->setJSON([
                    'success'  => true,
                    'message'  => 'Login successful.',
                    'redirect' => $redirectUrl
                ]);
                  
            }else{
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid credentials.']);
            }

        }
    }
}