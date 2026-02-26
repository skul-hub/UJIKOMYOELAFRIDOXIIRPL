<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian_model extends CI_Model {

    public function findPeminjaman()
    {
        $this->db->select("peminjaman.*, anggota.nis, anggota.kelas, users.nama");
        $this->db->from('peminjaman');
        $this->db->join("anggota", "anggota.id = peminjaman.anggota_id");
        $this->db->join("users", "users.id = anggota.user_id");
        $this->db->where('peminjaman.status', 'dipinjam');

        // ✅ FILTER HANYA JIKA SISWA
        if (
            $this->session->userdata('role') === 'siswa' &&
            $this->session->userdata('id_user')
        ) {
            $this->db->where('users.id', $this->session->userdata('id_user'));
        }

        $this->db->order_by('peminjaman.id', 'DESC');
        return $this->db->get()->result();
    }

    public function findPeminjamanById($id)
    {
        $this->db->select("peminjaman.*, anggota.nis, anggota.kelas, users.nama");
        $this->db->from('peminjaman');
        $this->db->join("anggota", "anggota.id = peminjaman.anggota_id");
        $this->db->join("users", "users.id = anggota.user_id");
        $this->db->where('peminjaman.id', $id);

        // ✅ AMAN UNTUK SISWA
        if (
            $this->session->userdata('role') === 'siswa' &&
            $this->session->userdata('id_user')
        ) {
            $this->db->where('users.id', $this->session->userdata('id_user'));
        }

        return $this->db->get()->row();
    }

    public function findPeminjamanDetail($id)
    {
        $this->db->select("peminjaman_detail.*, buku.kode_buku, buku.judul, buku.pengarang, buku.penerbit");
        $this->db->from('peminjaman_detail');
        $this->db->join("buku", "buku.id = peminjaman_detail.buku_id");
        $this->db->where('peminjaman_detail.peminjaman_id', $id);

        return $this->db->get()->result();
    }

    public function simpan_data($data)
    {
        return $this->db->insert('pengembalian', $data);
    }
}