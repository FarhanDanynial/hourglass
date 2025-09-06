<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\UserModel;
use App\Models\SalesModel;

class StaffController extends BaseController
{
    protected $users_model;
    protected $items_model;
    protected $sales_model;

    public function __construct()
    {
        $this->items_model             = new ItemModel();
        $this->users_model             = new UserModel();
        $this->sales_model             = new SalesModel();
        $this->session                = service('session');
    }

    public function login()
    {
        return view('Staff/auth/login');
    }

    public function index()
    {
        $items = $this->items_model->findAll();
        return view('Staff/pos', [
            'items' => $items
        ]);
    }

    public function main()
    {
        if (session()->get('user_type') != 'staff') {
            return redirect()->to('/staff/login');
        }

        $data = [
            'title' => 'Admin Dashboard',
            'message' => 'Welcome to the Admin Dashboard!'
        ];

        return $this->render_staff('Staff/main', $data);
    }

    public function checkCode($code = null)
    {
        $user = $this->users_model->where('u_membership_id', $code)->first();

        if ($user) {
            return $this->respond([
                'success' => true,
                'user' => [
                    'name' => $user['u_name'],
                    'points' => $user['u_points'],
                    'phone' => $user['u_phone'],
                    'created_at' => $user['u_created_at']
                ]
            ]);
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
    }

    public function checkNum($num = null)
    {
        $user = $this->users_model->where('u_phone', $num)->first();

        if ($user) {
            return $this->respond([
                'success' => true,
                'user' => [
                    'name' => $user['u_name'],
                    'points' => $user['u_points'],
                    'created_at' => $user['u_created_at']
                ]
            ]);
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
    }

    public function submit()
    {
        $phone = $this->request->getPost('customer_phone');
        $redeemable = $this->request->getPost('redeemable');
        if ($phone) {
            $user = $this->users_model->where('u_phone', $phone)->select('u_id, u_points')->first();

            $points = (int) $user['u_points'];
            $redeemable = (int) $this->request->getPost('redeemable');
            $updated_points = $points + $redeemable;

            $this->users_model->update($user['u_id'], ['u_points' => $updated_points]);
        }
        
        $json = $this->request->getPost('order_json');
        $orderItems = json_decode($json, true);

        foreach ($orderItems as $item) {
            $this->sales_model->insert([
                'sl_it_id'     => $item['it_id'],
                'sl_quantity'  => $item['quantity']
            ]);
        }
        
        return $this->respond([
            'success' => true,
            'message' => 'Order submitted successfully',
            'points'  => $updated_points ?? null
        ]);
    }
}
