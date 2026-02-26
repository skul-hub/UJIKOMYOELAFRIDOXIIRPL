<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('logged') != 1) {
            redirect(site_url('login-sistem'));
            exit;
        }

        $this->load->model('Riwayat_model', 'mdl');
    }

    public function index()
    {
        $data['judul'] = 'Riwayat Peminjaman';
        $data['page']  = 'back-end/form/riwayat';
        $data['resultPeminjaman'] = $this->mdl->findPeminjaman();

        $this->load->view('back-end/layout/header', $data);
        $this->load->view('back-end/layout/navbar');
        $this->load->view('back-end/layout/sidebar');
        $this->load->view('back-end/layout/content', $data);
        $this->load->view('back-end/layout/footer');
    }

    public function viewBuku($id)
    {
        $peminjamanDetail = $this->mdl->findPeminjamanDetail($id);

        if ($peminjamanDetail) {
            $no = 1;
            foreach ($peminjamanDetail as $rs) {
                echo '
                    <tr>
                        <td class="text-center">' . $no++ . '</td>
                        <td>
                            ' . $rs->kode_buku . '<br>
                            Judul: ' . $rs->judul . '<br>
                            Pengarang: ' . $rs->pengarang . '<br>
                            Penerbit: ' . $rs->penerbit . '
                        </td>
                        <td class="text-center">' . $rs->qty . '</td>
                    </tr>
                ';
            }
        }
    }
}
