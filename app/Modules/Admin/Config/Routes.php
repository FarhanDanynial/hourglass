<?php
use Config\Services;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

use Modules\Admin\Controllers\AdminController;

/**
 * @var RouteCollection $routes
 */

$routes->group('admin',['namespace' => 'App\Modules\Admin\Controllers'], function($routes) {
    $routes->get('/', [AdminController::class, 'index']);
});
