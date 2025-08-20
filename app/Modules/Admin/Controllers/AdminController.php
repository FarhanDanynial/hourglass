<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        $data= [
            'title' => 'Admin Dashboard',
            'description' => 'Welcome to the admin dashboard.',
        ];

        return view('Modules\Booking\Views\dashboard', $data);
    }
}
