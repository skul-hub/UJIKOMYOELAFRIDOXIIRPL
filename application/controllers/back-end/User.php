<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function index()
    {
        echo "User controller OK";
    }

    public function create_admin()
    {
        $data = [
            'nama'     => 'admin',
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'admin'
        ];

        $this->db->insert('users', $data);

        echo "ADMIN BERHASIL DIBUAT";
    }
}
    