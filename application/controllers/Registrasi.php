<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $this->load->view('back-end/form/registrasi');
    }

    public function save()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password');
        $nama     = $this->input->post('nm_siswa', true);

        // VALIDASI
        if (!$username || !$password || !$nama) {
            echo json_encode([
                'status' => false,
                'msg' => 'Data belum lengkap'
            ]);
            return;
        }

        // CEK USERNAME SUDAH ADA
        $cek = $this->db->get_where('users', [
            'username' => $username
        ])->row();

        if ($cek) {
            echo json_encode([
                'status' => false,
                'msg' => 'Username sudah digunakan'
            ]);
            return;
        }

        $this->db->trans_start();

        // INSERT USERS
        $dataUser = [
            'nama'     => $nama,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'siswa'
        ];

        $this->db->insert('users', $dataUser);
        $id_user = $this->db->insert_id();

        // INSERT ANGGOTA
        $dataAnggota = [
            'user_id' => $id_user,
            'nis'     => $this->input->post('nis', true),
            'kelas'   => $this->input->post('kelas', true),
            'alamat'  => $this->input->post('alamat', true),
            'status'  => 'aktif'
        ];

        $this->db->insert('anggota', $dataAnggota);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode([
                'status' => false,
                'msg' => 'Registrasi gagal'
            ]);
        } else {
            echo json_encode([
                'status' => true,
                'msg' => 'Registrasi berhasil'
            ]);
        }
    }
}
