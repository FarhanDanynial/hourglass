<?php

namespace Modules\Customer\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class CustomerController extends BaseController
{
    protected $users_model;
    

    public function __construct()
    {
        $this->users_model             = new UserModel();
        $this->session                = service('session');
    }

    public function index()
    {
        $user_id = $this->session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/customer/login');
        }
        $user = $this->users_model->where('u_id', $user_id)->first();

        $data = [
            'name' => $user['u_name'],
            'email' => $user['u_email'],
            'phone' => $user['u_phone'],
            'points' => $user['u_points'],
            'membership_id' => $user['u_membership_id'],
        ];
        
        return view('App\Modules\Customer\Views\dashboard', $data);
    }

    public function membership()
    {
        $user_id = $this->session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/customer/login');
        }
        $user = $this->users_model->where('u_id', $user_id)->first();

        $data = [
            'name' => $user['u_name'],
            'email' => $user['u_email'],
            'phone' => $user['u_phone'],
            'points' => $user['u_points'],
            'membership_id' => $user['u_membership_id'],
        ];

        return view('App\Modules\Customer\Views\membership', $data);
    }

    public function history()
    {
        $user_id = $this->session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/customer/login');
        }
        $user = $this->users_model->where('u_id', $user_id)->first();

        $data = [
            'name' => $user['u_name'],
            'email' => $user['u_email'],
            'phone' => $user['u_phone'],
            'points' => $user['u_points'],
            'membership_id' => $user['u_membership_id'],
        ];

        return view('App\Modules\Customer\Views\history', $data);
    }

    public function order()
    {
        $user_id = $this->session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/customer/login');
        }
        $user = $this->users_model->where('u_id', $user_id)->first();

        $data = [
            'name' => $user['u_name'],
            'email' => $user['u_email'],
            'phone' => $user['u_phone'],
            'points' => $user['u_points'],
            'membership_id' => $user['u_membership_id'],
        ];

        return view('App\Modules\Customer\Views\order', $data);
    }

    public function voucher()
    {
        $user_id = $this->session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/customer/login');
        }
        $user = $this->users_model->where('u_id', $user_id)->first();

        $data = [
            'name' => $user['u_name'],
            'email' => $user['u_email'],
            'phone' => $user['u_phone'],
            'points' => $user['u_points'],
            'membership_id' => $user['u_membership_id'],
        ];

        return view('App\Modules\Customer\Views\voucher', $data);
    }

    public function profile()
    {
        $user_id = $this->session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/customer/login');
        }
        $user = $this->users_model->where('u_id', $user_id)->first();

        $data = [
            'name' => $user['u_name'],
            'email' => $user['u_email'],
            'phone' => $user['u_phone'],
            'points' => $user['u_points'],
            'membership_id' => $user['u_membership_id'],
        ];

        return view('App\Modules\Customer\Views\profile', $data);
    }

    public function spinWheel()
    {
        // Define segments and their winning percentages
        $segments = [
            ['label' => 'Prize 1', 'percentage' => 1],
            ['label' => 'Prize 2', 'percentage' => 19],
            ['label' => 'Prize 3', 'percentage' => 20],
            ['label' => 'Prize 4', 'percentage' => 30],
            ['label' => 'Try Again', 'percentage' => 30],
        ];

        return view('App\Modules\Customer\Views\spin_wheel', ['segments' => $segments]);
    }

}
