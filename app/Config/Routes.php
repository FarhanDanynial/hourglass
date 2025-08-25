<?php

use App\Controllers\AdminController;
use App\Controllers\StaffController;
use CodeIgniter\Router\RouteCollection;

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