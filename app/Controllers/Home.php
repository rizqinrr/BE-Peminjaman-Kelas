<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Ambil data dari token yang sudah divalidasi di filter
        $user = $_SERVER['userData'];

        // Tampilkan pesan personal
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Halo, ' . $user->email. ', anda adalah ' .$user->role

        ]);
    }
}
