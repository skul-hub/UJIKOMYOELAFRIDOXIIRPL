<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged')) {
            redirect('login-sistem');
        }

        $this->load->model('Peminjaman_model', 'mdl');
    }

    public function index()
    {
        $this->session->unset_userdata('cart_peminjaman');

        $data = [
            'page'          => 'back-end/form/peminjaman',
            'judul'         => 'Peminjaman Buku',
            'resultBuku'    => $this->mdl->findBuku(),
            'resultAnggota' => $this->mdl->findAnggota()
        ];

        $this->load->view('back-end/layout/header', $data);
        $this->load->view('back-end/layout/navbar');
        $this->load->view('back-end/layout/sidebar');
        $this->load->view('back-end/layout/content', $data);
        $this->load->view('back-end/layout/footer');
    }

    /* ================= TAMBAH BUKU ================= */
    public function tambahBuku()
    {
        $id = $this->input->post('id_buku');
        $buku = $this->db->get_where('buku', ['id' => $id])->row();

        if (!$buku || $buku->stok <= 0) {
            echo json_encode(['Pesan' => 'Buku tidak tersedia']);
            return;
        }

        $cart = $this->session->userdata('cart_peminjaman') ?? [];

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'buku_id' => $buku->id,
                'kode' => $buku->kode_buku,
                'judul' => $buku->judul,
                'qty' => 1
            ];
        }

        $this->session->set_userdata('cart_peminjaman', $cart);
        echo json_encode(['status' => true]);
    }

    /* ================= VIEW CART ================= */
    public function viewListBuku()
    {
        $cart = $this->session->userdata('cart_peminjaman');
        if (!$cart) return;

        $no = 1;
        foreach ($cart as $c) {
            echo "
            <tr>
                <td class='text-center'>{$no}</td>
                <td>{$c['kode']}<br>{$c['judul']}</td>
                <td class='text-center'>{$c['qty']}</td>
                <td class='text-center'>
                    <button class='btn btn-danger btn-sm'
                    onclick=\"hapusBuku('{$c['buku_id']}')\">
                    Hapus</button>
                </td>
            </tr>";
            $no++;
        }
    }

    public function hapusBuku($id)
    {
        $cart = $this->session->userdata('cart_peminjaman');
        unset($cart[$id]);
        $this->session->set_userdata('cart_peminjaman', $cart);
        echo json_encode(['status' => true]);
    }

    /* ================= SIMPAN ================= */
    public function save()
    {
        $anggota_id = $this->session->userdata('anggota_id');
        if ($this->session->userdata('role') == 'admin') {
            $anggota_id = $this->input->post('anggota_id');
        }

        $tgl_pinjam   = $this->input->post('tgl_pinjam');
        $tgl_kembali  = $this->input->post('tgl_kembali');
        $cart         = $this->session->userdata('cart_peminjaman');

        if (!$anggota_id || !$tgl_pinjam || !$tgl_kembali || !$cart) {
            echo json_encode(['status' => false]);
            return;
        }

        $this->db->trans_start();

        $this->db->insert('peminjaman', [
            'anggota_id' => $anggota_id,
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_kembali' => $tgl_kembali,
            'status'     => 'dipinjam'
        ]);

        $peminjaman_id = $this->db->insert_id();

        foreach ($cart as $c) {

            $this->db->insert('peminjaman_detail', [
                'peminjaman_id' => $peminjaman_id,
                'buku_id'       => $c['buku_id'],
                'qty'           => $c['qty']
            ]);

            $this->db->set('stok', 'stok-' . $c['qty'], false)
                ->where('id', $c['buku_id'])
                ->update('buku');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false]);
        } else {
            $this->session->unset_userdata('cart_peminjaman');
            echo json_encode(['status' => true]);
        }
    }
}
