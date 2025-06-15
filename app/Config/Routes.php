<?php

use App\Controllers\RoomsController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->post('/register', 'Register::index');
$routes->post('/login', 'Login::index');
$routes->get('auth/check', 'Auth::check');

$routes->get('/rooms', 'RoomsController::index');

$routes->resource('/users', ['controller' => 'UsersController']);
$routes->resource('/rooms', ['controller' => 'RoomsController']);
$routes->resource('/bookings', ['controller' => 'BookingsController']);
$routes->resource('/riwayatuser', ['controller' => 'RiwayatUserController']);
