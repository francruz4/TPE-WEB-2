<?php
require_once './libs/Router.php';
require_once './controllers/car-api.controller.php';
require_once './controllers/brand-api.controller.php';
// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('cars', 'GET', 'CarApiController', 'getCars');
$router->addRoute('cars/:ID', 'GET', 'CarApiController', 'getCar');
$router->addRoute('cars/:ID', 'DELETE', 'CarApiController', 'deleteCar');
$router->addRoute('cars', 'POST', 'CarApiController', 'insertCar'); 
$router->addRoute('cars/:ID', 'PUT', 'CarApiController', 'editCar');

$router->addRoute('brands', 'GET', 'BrandApiController', 'getBrands');
$router->addRoute('brands/:ID', 'GET', 'BrandApiController', 'getBrand');
$router->addRoute('brands/:ID', 'DELETE', 'BrandApiController', 'deleteBrand');
$router->addRoute('brands', 'POST', 'BrandApiController', 'insertBrand'); 
$router->addRoute('brands/:ID', 'PUT', 'BrandApiController', 'editBrand'); 
// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);