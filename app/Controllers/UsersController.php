<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class UsersController extends ResourceController
{
    protected $modelName = 'App\Models\Users';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data_users' => $this->model->orderBy('id_user', 'DESC')->findAll()
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
    public function show($id_user = null)
    {
        $data = [
            'message' => 'success',
            'users_byid' => $this->model->find($id_user)
        ];

        if ($data['users_byid'] == null) {
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
            'name' => 'required',
            'status' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->insert([
            'name' => esc($this->request->getVar('name')),
            'status' => esc($this->request->getVar('status')),
            'email' => esc($this->request->getVar('email')),
            'password' => esc($this->request->getVar('password')),
            'role' => esc($this->request->getVar('role')),
        ]);

        $response = [
            'messsage' => 'Data user berhasil ditambahkan'
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
    public function update($id_user = null)
    {
        $rules = $this->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->update($id_user, [
            'name' => esc($this->request->getVar('name')),
            'status' => esc($this->request->getVar('status')),
            'email' => esc($this->request->getVar('email')),
            'password' => esc($this->request->getVar('password')),
            'role' => esc($this->request->getVar('role')),
        ]);

        $response = [
            'messsage' => 'Data user berhasil diubah'
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
    public function delete($id_user = null)
    {
        $this->model->delete($id_user);

        $response = [
            'messsage' => 'Data user berhasil dihapus'
        ];

        return $this->respondDeleted($response);
    }
}
