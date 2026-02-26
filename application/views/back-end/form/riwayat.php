<style>
/* CARD */
.card {
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
}

/* HEADER */
.card-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #fff;
    border-radius: 12px 12px 0 0;
}

.card-title i {
    margin-right: 8px;
}

/* TABLE */
.table thead th {
    background-color: #f8f9fa;
    text-align: center;
    font-weight: 600;
}

.table tbody tr:hover {
    background-color: #f1f5ff;
}

.table td {
    vertical-align: middle;
}

/* DENDA */
.denda {
    font-weight: bold;
    color: #dc3545;
}

/* BADGE */
.badge {
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 20px;
}

/* BUTTON */
.btn-sm {
    border-radius: 20px;
    padding: 6px 14px;
}

/* MODAL */
.modal-content {
    border-radius: 12px;
}

.modal-header {
    background: #007bff;
    color: #fff;
    border-radius: 12px 12px 0 0;
}
</style>

<section class="content-header">
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-book"></i> Riwayat Peminjaman Buku
                </h3>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="DataTables" class="table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Peminjaman</th>
                                <th>Detail Anggota</th>
                                <th>Denda</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $no = 1;
                        foreach ($resultPeminjaman as $rs) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>

                                <td class="text-center">
                                    <strong><?= $rs->id ?></strong><br>
                                    <small>
                                        Pinjam : <?= date('d-m-Y', strtotime($rs->tgl_pinjam)) ?><br>
                                        Kembali : <?= date('d-m-Y', strtotime($rs->tgl_kembali)) ?>
                                    </small>
                                </td>

                                <td>
                                    <strong><?= $rs->nama ?></strong><br>
                                    <small>
                                        NIS : <?= $rs->nis ?><br>
                                        Kelas : <?= $rs->kelas ?>
                                    </small>
                                </td>

                                <td class="text-right">
                                <?php
                                // Jika sudah dikembalikan, tampilkan nilai denda yang disimpan di tabel pengembalian
                                if ($rs->status == 'dikembalikan') {
                                    if (isset($rs->denda) && $rs->denda > 0) {
                                        echo '<span class="denda">Rp '.number_format($rs->denda,0,",",".").'</span>';
                                    } else {
                                        echo '<span class="text-success">Rp 0</span>';
                                    }
                                } else {
                                    // Belum dikembalikan → hitung denda sementara (tarif per-hari 5000)
                                    $denda_per_hari = 5000;
                                    $tgl_sekarang = date('Y-m-d');
                                    $jatuhTempo = new DateTime($rs->tgl_kembali);
                                    $dikembalikan = new DateTime($tgl_sekarang);

                                    if ($dikembalikan <= $jatuhTempo) {
                                        echo '<span class="text-success">Rp 0</span>';
                                    } else {
                                        $selisih = $jatuhTempo->diff($dikembalikan)->days;
                                        $total = $selisih * $denda_per_hari;
                                        echo '<span class="denda">Rp '.number_format($total,0,",",".").'</span>';
                                    }
                                }
                                ?>
                                </td>

                                <td class="text-center">
                                <?php if ($rs->status == "dikembalikan") { ?>
                                    <span class="badge badge-success">
                                        <i class="fa fa-check"></i> Dikembalikan
                                    </span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">
                                        <i class="fa fa-clock"></i> Dipinjam
                                    </span>
                                <?php } ?>
                                </td>

                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="viewBuku('<?= $rs->id ?>')">
                                        <i class="fa fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL -->
<div class="modal fade" id="modalPengembalian">
    <div class="modal-dialog modal-lg" style="max-width:85%">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-book-reader"></i> Detail Buku Dipinjam
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Detail Buku</th>
                                <th class="text-center">Qty</th>
                            </tr>
                        </thead>
                        <tbody id="viewListBuku"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#DataTables').DataTable({
        paging: true,
        ordering: false,
        responsive: true
    });
});

function viewBuku(id) {
    $.ajax({
        type: "GET",
        url: "<?= site_url('back-end/riwayat/viewBuku/') ?>" + id,
        success: function (data) {
            $("#viewListBuku").html(data);
            $("#modalPengembalian").modal('show');
        }
    });
}
</script>