<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('logged') != 1) {
            redirect('login-sistem');
            exit;
        }

        if ($this->session->userdata('role') !== 'admin') {
            redirect('halaman-sistem');
            exit;
        }

        $this->load->model('Buku_model', 'mdl');
    }

    public function index()
    {
        $data['page']   = 'back-end/form/buku';
        $data['judul']  = 'Data Buku';
        $data['result'] = $this->mdl->find();

        $this->load->view('back-end/layout/header', $data);
        $this->load->view('back-end/layout/navbar');
        $this->load->view('back-end/layout/sidebar');
        $this->load->view('back-end/layout/content', $data);
        $this->load->view('back-end/layout/footer');
    }

    public function save()
    {
        $data = [
            'kode_buku' => $this->input->post('kode_buku'),
            'judul'     => $this->input->post('judul'),
            'pengarang' => $this->input->post('pengarang'),
            'penerbit'  => $this->input->post('penerbit'),
            'tahun'     => $this->input->post('tahun'),
            'stok'      => $this->input->post('stok'),
        ];

        $insert = $this->mdl->insert($data);
        echo json_encode(['status' => $insert]);
    }

    public function edit($id)
    {
        echo json_encode($this->mdl->findById($id));
    }

    public function update()
{
    $id = $this->input->post('id'); 

    $data = array(
        'kode_buku' => $this->input->post('kode_buku'),
        'judul'     => $this->input->post('judul'),
        'pengarang' => $this->input->post('pengarang'),
        'penerbit'  => $this->input->post('penerbit'),
        'tahun'     => $this->input->post('tahun'),
        'stok'      => $this->input->post('stok')
    );

    $update = $this->mdl->update($id, $data);

    if ($update) {
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => false]);
    }
}

public function hapus($user_id)
    {
        $this->mdl->delete($user_id);
        echo json_encode(['status' => TRUE]);
    }

}
