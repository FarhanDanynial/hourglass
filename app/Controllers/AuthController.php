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
            $username = trim($data['username'] ?? '');
            $password = trim($data['password'] ?? '');

            // Validate input
            if (empty($username) || empty($password)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Username and password are required.'
                ]);
            }

            $user = $this->auth_users_model->where('au_username', $username)->first();

            if ($user && password_verify($password, $user['au_password'])) {
                // Get user_id from users_model
                $user_id = $this->users_model->where('u_au_id', $user['au_id'])->first();

                // Set session
                session()->set([
                    'id' => $user['au_id'],
                    'username' => $user['au_username'],
                    'user_id' => $user_id['u_id'] ?? null,
                    'isLoggedIn' => true
                ]);

                // Check user type and set redirect accordingly
                if (isset($user['au_type']) && $user['au_type'] === 'admin') {
                    $redirectUrl = '/admin/dashboard';
                } elseif (isset($user['au_type']) && $user['au_type'] === 'customer') {
                    $redirectUrl = '/customer/dashboard';
                } else {
                    // Unknown user type
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Unauthorized user type.'
                    ]);
                }

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Login successful.',
                    'redirect' => $redirectUrl
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid credentials.'
                ]);
            }
        }

        // If not AJAX, return 404 or redirect
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}