<?php

namespace App\Models;

use CodeIgniter\Model;

class Form_Model extends Model
{

    protected $table = "form";

    public function addForm($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function getForm($id = null)
    {
        if ($id == null) {
            $query = $this->table($this->table)->findAll();
            return $query;
        } else {
            $query = $this->table($this->table)->where('id', $id)->findAll();
            return $query;
        }
    }

    public function deleteForm($id)
    {
        return $this->db->table($this->table)->delete(['id' => $id]);
    }

    public function updateForm($id, $data)
    {
        return $this->db->table($this->table)->update($data, ['id' => $id]);
    }
}
