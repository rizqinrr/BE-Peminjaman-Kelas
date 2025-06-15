<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Users;

class Register extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        helper(['form']);

        // Tambahkan validasi untuk field "name" karena tabel users mengharuskannya.
        $rules = [
            'name'         => 'required',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]',
            'confpassword' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        // Data yang akan dimasukkan ke tabel users
        // Disini kita asumsikan bahwa saat registrasi:
        // - "name" diambil dari form input
        // - "email" diambil dari form input
        // - "password" di-hash terlebih dahulu
        // - "role" ditetapkan sebagai "user" secara default (bisa diubah sesuai kebutuahan aplikasi)
        // - "status" ditetapkan sebagai "active" secara default (misalnya menandakan bahwa akun sudah aktif)
        $data = [
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'role'     => 'user',
            'status'   => 'active'
        ];

        $model = new Users();
        $registered = $model->insert($data);

        if (!$registered) {
            return $this->fail('Gagal melakukan registrasi.');
        }

        return $this->respondCreated([
            'status'  => true,
            'message' => 'User berhasil terdaftar',
            'data'    => $data,
        ]);
    }
}
