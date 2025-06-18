<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class RoomsController extends ResourceController
{
    protected $modelName = 'App\Models\Rooms';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $rooms = $this->model->orderBy('id_room', 'DESC')->findAll();
        $total = $this->model->countAll(); // atau $this->model->totalRuang() kalau ada

        $data = [
            'status' => true,
            'message' => 'success',
            'total_rooms' => $total,
            'data_rooms' => $rooms
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id_room = null)
    {
        $data = [
            'message' => 'success',
            'rooms_byid' => $this->model->find($id_room)
        ];

        if ($data['rooms_byid'] == null) {
            return $this->failNotFound('Data pegawai tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = $this->validate([
            'room_name' => 'required',
            'location' => 'required',
            'capacity' => 'required',
            'status' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->insert([
            'room_name' => esc($this->request->getVar('room_name')),
            'location' => esc($this->request->getVar('location')),
            'capacity' => esc($this->request->getVar('capacity')),
            'status' => esc($this->request->getVar('status')),
        ]);

        $response = [
            'messsage' => 'Data room berhasil ditambahkan'
        ];

        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id_room = null)
    {
        $rules = $this->validate([
            'room_name' => 'required',
            'location' => 'required',
            'capacity' => 'required',
            'status' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->update($id_room, [
            'room_name' => esc($this->request->getVar('room_name')),
            'location' => esc($this->request->getVar('location')),
            'capacity' => esc($this->request->getVar('capacity')),
            'status' => esc($this->request->getVar('status')),
        ]);

        $response = [
            'messsage' => 'Data room berhasil diubah'
        ];

        return $this->respond($response, 200);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id_room = null)
    {
        $this->model->delete($id_room);

        $response = [
            'messsage' => 'Data room berhasil dihapus'
        ];

        return $this->respondDeleted($response);
    }
}
