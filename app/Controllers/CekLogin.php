<?php

namespace App\Controllers;

use App\Controllers\Auth;
use \Firebase\JWT\JWT;
use CodeIgniter\RESTful\ResourceController;

class CekLogin extends ResourceController
{
    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function index()
    {
        try {
            $secret_key = $this->auth->privateKey();

            $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
            if ($authHeader == NULL) throw new \Exception("Missing Authorization Header");

            $arr = explode(" ", $authHeader);
            $token = $arr[1];

            if ($token) {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                if ($decoded) {
                    $output = [
                        'status' => 200,
                        'message' => "This is valid token",
                    ];

                    return $this->respond($output, 200);
                }
            } else {
                $output = [
                    'status' => 200,
                    'message' => "Authorization failed",
                ];

                return $this->respond($output, 200);
            }
        } catch (\Exception $e) {

            $output = [
                'status' => 401,
                'message' => $e->getMessage(),
            ];

            return $this->respond($output, 401);
        }
    }
}
