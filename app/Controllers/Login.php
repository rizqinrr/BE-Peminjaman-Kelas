<?php

namespace App\Controllers;

use App\Models\Users;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        helper(['form']);

        // Validasi input
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $email    = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $model = new Users();
        $user  = $model->where('email', $email)->first();

        if (!$user) {
            return $this->failNotFound('Email tidak ditemukan');
        }

        $verify = password_verify($this->request->getVar('password'), $user['password']);
        if (!$verify) return $this->fail('Wrong Password');

        // Ambil secret key dari .env
        $key = getenv('TOKEN_SCREET');

        // Payload JWT
        $payload = [
            'iss' => 'http://localhost', // bisa disesuaikan
            'aud' => 'http://localhost',
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + (60 * 60), // token berlaku 1 jam
            'uid' => $user['id_user'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        // Generate token
        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respond([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $token
        ]);
    }
}
