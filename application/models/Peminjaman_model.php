<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman_model extends CI_Model
{
    function findAnggota()
    {
        $this->db->select("anggota.*, users.nama");
        $this->db->from('anggota');
        $this->db->join("users", "users.id = anggota.user_id");
        $this->db->where('anggota.status', 'aktif');
        $this->db->order_by('users.id', 'ASC');

        return $this->db->get()->result();
    }

    function findBuku()
    {
        return $this->db->get('buku')->result();
    }

    function getPeminjaman()
    {
        $this->db->select("peminjaman.*, anggota.nis, anggota.kelas, users.nama");
        $this->db->from('peminjaman');
        $this->db->join('anggota', 'anggota.id = peminjaman.anggota_id');
        $this->db->join('users', 'users.id = anggota.user_id');

        // 🔥 FILTER SISWA
        if ($this->session->userdata('role') == 'siswa') {
            $this->db->where('users.id', $this->session->userdata('id_user'));
        }

        $this->db->order_by('peminjaman.id', 'DESC');

        return $this->db->get()->result();
    }

    function simpan_data_peminjaman($data)
    {
        $this->db->insert('peminjaman', $data);
        return $this->db->insert_id();
    }

    function simpan_data_peminjaman_detail($data)
    {
        return $this->db->insert('peminjaman_detail', $data);
    }

    function delete($peminjaman_id)
    {
        $this->db->trans_start();

        $this->db->where('peminjaman_id', $peminjaman_id);
        $this->db->delete('peminjaman_detail');

        $this->db->where('id', $peminjaman_id);
        $this->db->delete('peminjaman');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
