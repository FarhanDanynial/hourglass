<?php
use Config\Services;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

$modules = ['Admin', 'Counter', 'Customer'];

foreach ($modules as $module) {
    $path = APPPATH . 'Modules/' . $module . '/Config/Routes.php';
    if (file_exists($path)) {
        require $path;
    }
}





