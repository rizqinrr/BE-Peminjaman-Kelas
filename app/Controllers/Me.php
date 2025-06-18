<?php

namespace App\Controllers;

use App\Models\Users;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Me extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    use ResponseTrait;
    public function index()
    {
        $key = getenv('TOKEN_SCREET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');

        if (!$header) {
            return $this->failUnauthorized('Token Required');
        }

        // Pecah header: "Bearer {token}" => ambil index ke-1 (token-nya)
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            $id_user = $decoded->id_user ?? null;
            $uname = $decoded->name ?? null;
            $urole = $decoded->role ?? null;

            $model = new Users();
            $user = $model->find($id_user);
            $name = $model->find($uname);
            $role = $model->find($urole);

            if (!$user) {
                return $this->failNotFound('User tidak ditemukan');
            }

            if ($user['role'] !== $role) {
                return $this->fail('Role tidak sesuai');
            }

            unset($user['password']); // agar password tidak dikirim

            return $this->respond([
                'status' => true,
                'message' => 'Token valid. User berhasil diambil.',
                'user' => [$user, $role, $name]
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid atau sudah kedaluwarsa: ' . $e->getMessage());
        }
    }


    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
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
        //
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
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
