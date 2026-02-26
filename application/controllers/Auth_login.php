<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_login extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('logged') == TRUE) {
            redirect('halaman-sistem');
            return;
        }

        $this->load->view('back-end/layout/login');
    }

    public function login()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');

        $user = $this->db
            ->get_where('users', ['username' => $username])
            ->row();

        if (!$user || !password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Username atau Password salah');
            redirect('login-sistem');
            return;
        }

        // ================= SISWA =================
        if (strtolower($user->role) === 'siswa') {

            $anggota = $this->db
                ->get_where('anggota', ['user_id' => $user->id])
                ->row();

            if (!$anggota) {
                show_error('Data anggota tidak ditemukan.');
            }

            $this->session->set_userdata([
                'logged'      => TRUE,
                'role'        => 'siswa',
                'id_user'     => $user->id,
                'anggota_id'  => $anggota->id,
                'nama'        => $user->nama,   // ✅ ambil dari users
                'nis'         => $anggota->nis,
                'kelas'       => $anggota->kelas
            ]);
        }

        // ================= ADMIN =================
        else {

            $this->session->set_userdata([
                'logged'  => TRUE,
                'role'    => 'admin',
                'id_user' => $user->id,
                'nama'    => $user->nama
            ]);
        }

        redirect('halaman-sistem');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login-sistem');
    }
}
