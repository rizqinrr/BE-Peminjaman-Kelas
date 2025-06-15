<?php

namespace App\Filters;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('TOKEN_SCREET');
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return service('response')->setJSON([
                'status' => false,
                'message' => 'Token tidak ditemukan'
            ])->setStatusCode(401);
        }

        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            // Simpan decoded token ke request agar bisa digunakan di controller
            $_SERVER['userData'] = $decoded;
            $request->userData = $decoded;
        } catch (\Exception $e) {
            return service('response')->setJSON([
                'status' => false,
                'message' => 'Token tidak valid: ' . $e->getMessage()
            ])->setStatusCode(401);
        }

        // Jika token valid, lanjutkan
        return;
    }

    

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
