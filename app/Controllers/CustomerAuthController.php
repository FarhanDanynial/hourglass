<?php

namespace Modules\Customer\Controllers;

use App\Models\UserModel;
use App\Models\AuthUsersModel;
use App\Controllers\BaseController;
use Twilio\Rest\Client;

class CustomerAuthController extends BaseController
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
        return view('App\Modules\Customer\Views\auth\login');
    }

    public function register()
    {
        return view('App\Modules\Customer\Views\auth\register');
    }

    public function registerHandle()
    {
        if ($this->request->isAJAX()) {

            $data = $this->request->getPost();
            $username = trim($data['username']);
            $name = trim($data['name']);
            $email = trim($data['email']);
            $phone = trim($data['phone']);
            $password = $data['password'];
            $confirm = $data['confirm_password'];

            if ($password !== $confirm) {
                return $this->response->setJSON(['success' => false, 'message' => 'Passwords do not match.']);
            }

            // Check if user exists
            if ($this->users_model->where('u_email', $email)->first()) {
                return $this->response->setJSON(['success' => false, 'message' => 'email already exists.']);
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $this->auth_users_model->insert([
                'au_username' => $username,
                'au_password' => $hashed,
                'au_type' => 'customer',
            ]);
            $au_id = $this->auth_users_model->insertID();

            //generate random membership ID
            $membership_id = rand(1000000000, 9999999999);

            $this->users_model->insert([
                'u_au_id' => $au_id,
                'u_name' => $name,
                'u_email' => $email,
                'u_phone' => $phone,
                'u_membership_id' => $membership_id,
                'u_points' => 0 // Default points
            ]);

            return $this->response->setJSON(['success' => true, 'message' => 'Registration successful.']);
        }
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

                return $this->response->setJSON(['success' => true, 'message' => 'Login successful.']);
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Invalid credentials.']);
        }
    }

        
    public function sendOtpWhatsApp()
    {
        $request = $this->request->getJSON();
        $phone = trim($request->phone); // e.g., 0123456789

        // ✅ Normalize phone to +60 format
        if (strpos($phone, '+') !== 0) {
            if (substr($phone, 0, 1) === '0') {
                $phone = substr($phone, 1); // remove leading 0
            }
            $phone = '+60' . $phone;
        }

        $userModel = new UserModel();
        $user = $userModel->where('u_phone', $phone)->first();

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User with this phone does not exist.']);
        }

        $otp = rand(100000, 999999);
        session()->set("otp_$phone", $otp);

        try {
            $twilio = new Client($_ENV['TWILIO_SID'], $_ENV['TWILIO_TOKEN']);

            $twilio->messages->create(
                "whatsapp:$phone",
                [
                    'from' => $_ENV['TWILIO_WHATSAPP_FROM'],
                    'body' => "Your OTP is: $otp. Do not share this code."
                ]
            );

            return $this->response->setJSON(['success' => true, 'message' => 'OTP sent via WhatsApp.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to send WhatsApp message: ' . $e->getMessage()]);
        }
    }


    public function verifyOtp()
    {
        $request = $this->request->getJSON();
        $phone = trim($request->phone);
        $otp = $request->otp;

        // ✅ Normalize phone again for session key matching
        if (strpos($phone, '+') !== 0) {
            if (substr($phone, 0, 1) === '0') {
                $phone = substr($phone, 1);
            }
            $phone = '+60' . $phone;
        }

        $storedOtp = session()->get("otp_$phone");

        if ($otp == $storedOtp) {
            session()->remove("otp_$phone");

            $userModel = new \App\Models\UserModel();
            $user = $userModel->where('u_phone', $phone)->first();

            if (!$user) {
                return $this->response->setJSON(['success' => false, 'message' => 'User not found.']);
            }

            session()->set('user_id', $user['u_id']);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Login successful.',
                'redirect' => '/customer/dashboard'
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid OTP']);
        }
    }



    public function logout()
    {
        session()->destroy();
        return redirect()->to('customer/login');
    }
}
