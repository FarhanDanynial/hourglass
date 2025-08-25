<?php

use App\Controllers\AdminController;
use App\Controllers\StaffController;
use App\Controllers\CustomerController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\CustomerAuthController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', function ($routes) {
    $routes->get('/', [AdminController::class, 'index']);
});

$routes->group('pos', function($routes) {
    $routes->get('/', [StaffController::class, 'index']);
    $routes->get('loyalty/checkCode/(:any)', [StaffController::class, 'checkCode/$1']);
    $routes->get('loyalty/checkNum/(:any)', [StaffController::class, 'checkNum/$1']);
    $routes->post('submit', [StaffController::class, 'submit']);
});

$routes->group('customer', function($routes) {

    $routes->get('dashboard', [CustomerController::class, 'index']);
    $routes->get('membership', [CustomerController::class, 'membership']);
    $routes->get('history', [CustomerController::class, 'history']);
    $routes->get('order', [CustomerController::class, 'order']);
    $routes->get('voucher', [CustomerController::class, 'voucher']);
    $routes->get('profile', [CustomerController::class, 'profile']);
    $routes->get('spin_wheel', [CustomerController::class, 'spinWheel']);

    $routes->post('sendOtpWhatsapp', [CustomerAuthController::class, 'sendOtpWhatsApp']);
    $routes->post('verifyOtp', [CustomerAuthController::class, 'verifyOtp']);


    $routes->get('login', [CustomerAuthController::class, 'login']);
    $routes->get('register', [CustomerAuthController::class, 'register']);
    $routes->post('loginHandle', [CustomerAuthController::class, 'loginHandle']);
    $routes->post('registerHandle', [CustomerAuthController::class, 'registerHandle']);
    $routes->get('logout', [CustomerAuthController::class, 'logout']);
});