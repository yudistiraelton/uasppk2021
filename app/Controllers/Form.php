<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Form_Model;

class Form extends ResourceController
{
    public function __construct()
    {
        $this->model = new Form_Model();
    }

    public function getForm($id  = null)
    {
        $data = $this->model->getForm($id);
        if ($data == null || $data == '') {
            $output = [
                'status' => 404,
                'message' => 'No Form Found',
                'data' => []
            ];
            return $this->respond($output, 200);
        }

        $output = [
            'status' => 200,
            'message' => 'Successful',
            'data' => [
                'form' => $data,
            ]
        ];
        return $this->respond($output, 200);
    }

    public function addForm()
    {
        $json = $this->request->getJSON();

        $username = $json->username;
        $fullname = $json->fullname;
        $email = $json->email;
        $password = $json->password;

        $data = [
            'username' => $username,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password
        ];

        $insert = $this->model->addForm($data);

        if ($insert) {
            $output = [
                'status' => 200,
                'message' => 'Insert Form Success'
            ];
            return $this->respond($output, 200);
        }
    }

    public function deleteForm($id  = null)
    {
        $delete = $this->model->deleteForm($id);
        if ($delete) {
            $output = [
                'status' => 200,
                'message' => 'delete successfull',
                'data' => [
                    'id' => $id,
                ]
            ];
            return $this->respond($output, 200);
        }
    }

    public function updateForm($id = null)
    {
        $form = $this->model->getForm($id);
        if ($form == null || $form == '') {
            $output = [
                'status' => 404,
                'message' => 'No Form Found',
                'data' => []
            ];
            return $this->respond($output, 200);
        }

        $json = $this->request->getJSON();

        $username = $json->username;
        $fullname = $json->fullname;
        $email = $json->email;
        $password = $json->password;

        $data = [
            'username' => $username,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password
        ];

        $update = $this->model->updateForm($id, $data);

        if ($update) {
            $output = [
                'status' => 200,
                'message' => 'Successful',
                'data' => [
                    'form' => [
                        "id" => $id,
                        'username' => $username,
                        'fullname' => $fullname,
                        'email' => $email,
                        'password' => $password
                    ],
                ]
            ];
            return $this->respond($output, 200);
        }
    }
}
