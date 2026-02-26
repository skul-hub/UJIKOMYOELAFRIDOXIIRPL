<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {

    private $table = 'buku';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function find()
    {
        return $this->db
            ->order_by('kode_buku', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function findById($id)
    {
        return $this->db
            ->get_where($this->table, ['id' => $id])
            ->row();
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }
}
