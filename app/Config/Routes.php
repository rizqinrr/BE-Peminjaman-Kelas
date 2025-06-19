<?php

use App\Controllers\RoomsController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/home', 'Home::index', ['filter' => 'auth']);
$routes->get('/', 'Home::tampil');
$routes->post('/register', 'Register::index');
// POST http://localhost:8080/register

$routes->post('/login', 'Login::index');
// POST http://localhost:8080/login
$routes->get('auth/check', 'Auth::check');

$routes->get('/rooms', 'RoomsController::index');

$routes->resource('/users', ['controller' => 'UsersController']);
// GET http://localhost:8080/users
$routes->resource('/rooms', ['controller' => 'RoomsController']);
// GET http://localhost:8080/rooms mengambil list data ruangan
// POST http://localhost:8080/rooms menambahkan data ruangan
// PUT http://localhost:8080/rooms/2 mengubah data ruangan berdasarkan id rooms
// DELETE http://localhost:8080/rooms/3 mengahapus data ruangan berdasarkan id rooms
// GET http://localhost:8080/rooms/2 mengambil data ruangan berdasarkan id rooms
$routes->resource('/bookings', ['controller' => 'BookingsController']);
// GET http://localhost:8080/bookings mengambil list booking semua data
// POST http://localhost:8080/bookings menambahkan daftar booking
// PUT http://localhost:8080/bookings/1 mengubah data booking berdasarkan id booking
// GET http://localhost:8080/bookings/2 menampilkan data booking berdasarkan id ruangan
$routes->resource('/riwayatuser', ['controller' => 'RiwayatUserController']);
// GET http://localhost:8080/riwayatuser/1 mengambil riwayat booking user melalui id user
