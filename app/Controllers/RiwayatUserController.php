<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Bookings;

class RiwayatUserController extends ResourceController
{
    protected $modelName = 'App\Models\Bookings';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */


    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id_user = null)
    {
        $data = $this->model->getBookingsByUser($id_user);

        return $this->respond([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

}