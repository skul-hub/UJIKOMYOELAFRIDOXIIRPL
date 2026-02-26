<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends CI_Model
{
    public function getPeminjamanAktif()
    {
        $this->db->select(
            "peminjaman.*, 
             users.nama, 
             anggota.nis, 
             anggota.kelas"
        );
        $this->db->from('peminjaman');
        $this->db->join('anggota', 'anggota.id = peminjaman.anggota_id');
        $this->db->join('users', 'users.id = anggota.user_id');
        $this->db->where('peminjaman.status', 'dipinjam');
        $this->db->order_by('peminjaman.id', 'DESC');

        return $this->db->get()->result();
    }
}
