<?php

namespace App\Models;

use CodeIgniter\Model;

class Login_Model extends Model
{

    protected $table = "form";

    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        if (!$query || $this->db->error()["code"] == 1062) return false;
        return true;
    }

    public function checkLogin($username)
    {
        $query = $this->table($this->table)->where('username', $username)->countAll();

        if ($query >  0) {
            $result = $this->table($this->table)->where('username', $username)->limit(1)->get()->getRowArray();
        } else {
            $result = array();
        }
        return $result;
    }
}
