<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use Config\Services;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

// Default route settings
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// ------------------------------
// 🔹 Dynamic Module Routes Loader
// ------------------------------
$modulesPath = APPPATH . 'Modules/';
$modules = scandir($modulesPath);

foreach ($modules as $module) {
    if ($module === '.' || $module === '..') {
        continue;
    }

    $routePath = $modulesPath . $module . '/Config/Routes.php';
    if (is_file($routePath)) {
        require $routePath;
    }
}
