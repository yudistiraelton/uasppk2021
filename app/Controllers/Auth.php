<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Models\Login_Model;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    public function __construct()
    {
        $this->model = new Login_Model();
    }

    public function privateKey()
    {
        $privateKey = "iniprivatekey";
        return $privateKey;
    }

    public function register()
    {
        $json = $this->request->getJSON();

        $username = $json->username;
        $fullname = $json->fullname;
        $email = $json->email;
        $password = $json->password;

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $dataRegister = [
            'username' => $username,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password_hash
        ];

        $register = $this->model->register($dataRegister);

        if ($register) {
            $output = [
                'status' => 200,
                'message' => 'Berhasil register'
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 400,
                'message' => 'Gagal register'
            ];
            return $this->respond($output, 400);
        }
    }

    public function login()
    {
        $json = $this->request->getJSON();

        $username = $json->username;
        $fullname = $json->fullname;
        $email = $json->email;
        $password = $json->password;

        $cek_login = $this->model->checkLogin($username);

        if (password_verify($password, $cek_login['password'])) {

            $secret_key = $this->privateKey();
            $issuer_claim = "THE_CLAIM";
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time();
            $notbefore_claim = $issuedat_claim + 10;
            $expire_claim = $issuedat_claim + 3600;
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $cek_login['id'],
                    "username" => $cek_login['username']
                )
            );

            $token = JWT::encode($token, $secret_key);

            $output = [
                'status' => 200,
                'message' => 'Berhasil login',
                "token" => $token,
                "username" => $username,
                'fullname' => $fullname,
                'email' => $email,
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 401,
                'message' => 'Login failed',
                "password" => $password
            ];
            return $this->respond($output, 401);
        }
    }
}
