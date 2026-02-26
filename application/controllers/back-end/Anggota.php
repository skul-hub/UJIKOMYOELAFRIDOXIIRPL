<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('logged') != 1) {
            redirect(site_url('login-sistem'));
        }

        $this->load->model('anggota_model', 'mdl');
    }

    public function index()
    {
        $data['page']   = 'back-end/form/anggota';
        $data['judul']  = 'Data Anggota';
        $data['result'] = $this->mdl->find();

        $this->load->view('back-end/layout/header', $data);
        $this->load->view('back-end/layout/navbar');
        $this->load->view('back-end/layout/sidebar');
        $this->load->view('back-end/layout/content', $data);
        $this->load->view('back-end/layout/footer');
    }



    public function save()
    {
        $dataUser = [
            'nama'     => $this->input->post('nm_siswa'),
            'username' => $this->input->post('username'),
            'password' => password_hash(
                $this->input->post('password'),
                PASSWORD_DEFAULT
            ),
            'role'     => 'siswa',
        ];

        $id_user = $this->mdl->simpan_data($dataUser);

        if ($id_user) {
            $dataAnggota = [
                'user_id' => $id_user,
                'nis'     => $this->input->post('nis'),
                'kelas'   => $this->input->post('kelas'),
                'alamat'  => $this->input->post('alamat'),
            ];

            $this->mdl->simpan_data_anggota($dataAnggota);

            echo json_encode(['status' => TRUE]);
        } else {
            echo json_encode(['status' => FALSE]);
        }
    }

    public function update()
    {
        $dataUser = [
            'nama'     => $this->input->post('nm_siswa'),
            'username' => $this->input->post('username'),
            'role'     => 'siswa',
        ];

        if ($this->input->post('password') != '') {
            $dataUser['password'] = password_hash(
                $this->input->post('password'),
                PASSWORD_DEFAULT
            );
        }

        $updateUser = $this->mdl->update_user(
            $this->input->post('user_id'),
            $dataUser
        );

        if ($updateUser) {
            $dataAnggota = [
                'nis'    => $this->input->post('nis'),
                'kelas'  => $this->input->post('kelas'),
                'alamat' => $this->input->post('alamat'),
            ];

            $this->mdl->update_anggota(
                $this->input->post('id_siswa'),
                $dataAnggota
            );

            echo json_encode(['status' => TRUE]);
        } else {
            echo json_encode(['status' => FALSE]);
        }
    }

    public function edit($id)
    {
        $data = $this->mdl->findById($id);
        echo json_encode($data);
    }

    public function hapus($user_id)
    {
        $this->mdl->delete($user_id);
        echo json_encode(['status' => TRUE]);
    }

    public function status($id)
    {
        $row = $this->mdl->findById($id);

        $status = ($row->status == 'aktif') ? 'nonaktif' : 'aktif';

        $this->mdl->update_anggota($id, ['status' => $status]);

        $row = $this->mdl->findById($id);

        if ($row->status == 'nonaktif') {
            $btn = '<button class="btn btn-sm btn-danger"
                        onclick="status(\'' . $row->id . '\')">
                        <i class="fa fa-eye-slash"></i> Non Aktif
                    </button>';
        } else {
            $btn = '<button class="btn btn-sm btn-success"
                        onclick="status(\'' . $row->id . '\')">
                        <i class="fa fa-eye"></i> Aktif
                    </button>';
        }

        echo $btn;
    }
}
