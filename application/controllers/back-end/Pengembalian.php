<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengembalian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('logged') != TRUE) {
            redirect('login-sistem');
        }

        $this->load->model('Pengembalian_model', 'mdl');
    }

    public function index()
    {
        // Jika user adalah siswa, tampilkan halaman riwayat pribadi (termasuk denda yang tersimpan)
        if ($this->session->userdata('role') === 'siswa') {
            $this->load->model('Riwayat_model', 'riwayat');
            $data['page'] = 'back-end/form/riwayat';
            $data['judul'] = 'Riwayat Peminjaman Saya';
            $data['resultPeminjaman'] = $this->riwayat->findPeminjaman();
        } else {
            $data['page']             = 'back-end/form/pengembalian';
            $data['judul']            = 'Data Pengembalian';
            $data['resultPeminjaman'] = $this->mdl->findPeminjaman();
        }

        $this->load->view('back-end/layout/header', $data);
        $this->load->view('back-end/layout/navbar');
        $this->load->view('back-end/layout/sidebar');
        $this->load->view('back-end/layout/content', $data);
        $this->load->view('back-end/layout/footer');
    }

    public function peminjaman($id)
    {
        $row = $this->mdl->findPeminjamanById($id);
        echo json_encode($row);
    }

    public function viewDetailPeminjaman($id)
    {
        $detail = $this->mdl->findPeminjamanDetail($id);

        $no = 1;
        foreach ($detail as $rs) {
            echo "
            <tr>
                <td class='text-center'>{$no}</td>
                <td>
                    {$rs->kode_buku}<br>
                    Judul: {$rs->judul}<br>
                    Pengarang: {$rs->pengarang}<br>
                    Penerbit: {$rs->penerbit}
                </td>
                <td class='text-center'>{$rs->qty}</td>
            </tr>
            ";
            $no++;
        }
    }

    public function save()
    {
        $peminjaman_id    = $this->input->post('peminjaman_id');
        $tgl_pengembalian = $this->input->post('tgl_pengembalian');
        // Hitung denda di server untuk keamanan (tarif per-hari = 5000)
        $denda_per_hari = 5000;
        $denda = 0;

        if (!$peminjaman_id) {
            echo json_encode(['status' => false]);
            return;
        }

        // Ambil info peminjaman untuk tanggal kembali
        $peminjaman = $this->db->get_where('peminjaman', ['id' => $peminjaman_id])->row();
        if ($peminjaman && $tgl_pengembalian) {
            $jatuhTempo = new DateTime($peminjaman->tgl_kembali);
            $dikembalikan = new DateTime($tgl_pengembalian);
            if ($dikembalikan > $jatuhTempo) {
                $selisih = $jatuhTempo->diff($dikembalikan)->days;
                $denda = $selisih * $denda_per_hari;
            }
        }

        // INSERT PENGEMBALIAN
        $data_pengembalian = [
            'peminjaman_id'    => $peminjaman_id,
            'tgl_pengembalian' => $tgl_pengembalian,
            'denda'            => $denda
        ];

        $this->db->insert('pengembalian', $data_pengembalian);

        // UPDATE STATUS PEMINJAMAN
        $this->db->where('id', $peminjaman_id);
        $this->db->update('peminjaman', [
            'status' => 'dikembalikan'
        ]);

        // UPDATE STOK BUKU
        $detail = $this->mdl->findPeminjamanDetail($peminjaman_id);

        foreach ($detail as $rs) {
            $this->db->set('stok', 'stok + ' . $rs->qty, FALSE);
            $this->db->where('id', $rs->buku_id);
            $this->db->update('buku');
        }

        echo json_encode(['status' => true]);
    }
}