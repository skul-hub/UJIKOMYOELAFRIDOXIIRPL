<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_model extends CI_Model
{
    public function findPeminjaman()
    {
        $this->db->select("
            peminjaman.id,
            peminjaman.tgl_pinjam,
            peminjaman.tgl_kembali,
            peminjaman.status,
            anggota.nis,
            anggota.kelas,
            users.nama,
            pengembalian.denda as denda
        ");

        $this->db->from('peminjaman');
        $this->db->join('anggota', 'anggota.id = peminjaman.anggota_id');
        $this->db->join('users', 'users.id = anggota.user_id');
        $this->db->join('pengembalian', 'pengembalian.peminjaman_id = peminjaman.id', 'left');

        // Kalau bukan admin → hanya lihat data sendiri
        if ($this->session->userdata('role') != 'admin') {
            $this->db->where('users.id', $this->session->userdata('id_user'));
        }

        $this->db->order_by('peminjaman.id', 'DESC');

        return $this->db->get()->result();
    }

    public function findPeminjamanById($id)
    {
        $this->db->select("
            peminjaman.id,
            peminjaman.tgl_pinjam,
            peminjaman.tgl_kembali,
            peminjaman.status,
            anggota.nis,
            anggota.kelas,
            users.nama
        ");

        $this->db->from('peminjaman');
        $this->db->join('anggota', 'anggota.id = peminjaman.anggota_id');
        $this->db->join('users', 'users.id = anggota.user_id');
        $this->db->where('peminjaman.id', $id);

        return $this->db->get()->row();
    }

    public function findPeminjamanDetail($id)
    {
        $this->db->select("
            peminjaman_detail.*,
            buku.kode_buku,
            buku.judul,
            buku.pengarang,
            buku.penerbit
        ");

        $this->db->from('peminjaman_detail');
        $this->db->join('buku', 'buku.id = peminjaman_detail.buku_id');
        $this->db->where('peminjaman_detail.peminjaman_id', $id);
        $this->db->order_by('peminjaman_detail.id', 'ASC');

        return $this->db->get()->result();
    }
}
