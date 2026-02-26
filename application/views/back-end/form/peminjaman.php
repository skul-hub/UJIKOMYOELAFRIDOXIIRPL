<style>
/* CARD */
.card {
    border-radius: 14px;
    box-shadow: 0 6px 25px rgba(0,0,0,.08);
}

/* HEADER */
.card-header {
    background: linear-gradient(135deg, #17a2b8, #117a8b);
    color: #fff;
    border-radius: 14px 14px 0 0;
}

.card-title {
    font-weight: 600;
}

/* FORM */
.form-control-sm {
    border-radius: 8px;
}

label {
    font-weight: 600;
    font-size: 13px;
}

/* BUTTON */
.btn {
    border-radius: 20px;
    padding: 6px 16px;
}

/* TABLE */
.table thead th {
    background: #f8f9fa;
    font-weight: 600;
    text-align: center;
}

.table tbody tr:hover {
    background: #f1f5ff;
}

.table td {
    vertical-align: middle;
}

/* INFO */
.code-info {
    background: #e9f5ff;
    padding: 8px 12px;
    border-radius: 8px;
    display: inline-block;
    font-size: 13px;
}

/* MODAL */
.modal-content {
    border-radius: 14px;
}

.modal-header {
    background: #17a2b8;
    color: #fff;
    border-radius: 14px 14px 0 0;
}

.modal-header .close {
    color: #fff;
}
</style>

<section class="content-header">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-book"></i> Data Peminjaman Buku
                </h3>
            </div>

            <div class="card-body">
                <div class="row">

                    <!-- FORM PEMINJAMAN -->
                    <div class="col-lg-4">
                        <form id="form-peminjaman">

                            <?php if($this->session->userdata('role') == 'admin'): ?>
                            <div class="form-group">
                                <label>Pilih Anggota</label>
                                <select name="anggota_id" class="form-control form-control-sm" required>
                                    <option value="">-- Pilih Anggota --</option>
                                    <?php foreach($resultAnggota as $a): ?>
                                        <option value="<?= $a->id ?>">
                                            <?= $a->nama ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php else: ?>
                            <div class="form-group">
                                <label>Data Anggota</label>
                                <input type="text"
                                    class="form-control form-control-sm"
                                    value="<?= $this->session->userdata('nama') ?>"
                                    readonly>
                                <input type="hidden"
                                    name="anggota_id"
                                    value="<?= $this->session->userdata('anggota_id') ?>">
                            </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label>Tanggal Pinjam</label>
                                <input type="date"
                                    class="form-control form-control-sm"
                                    id="tgl_pinjam"
                                    name="tgl_pinjam"
                                    value="<?= date('Y-m-d') ?>">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Kembali</label>
                                <input type="date"
                                    class="form-control form-control-sm"
                                    id="tgl_kembali"
                                    name="tgl_kembali">
                            </div>

                        </form>
                    </div>

                    <!-- LIST BUKU -->
                    <div class="col-lg-8">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="code-info">
                                Tambahkan buku yang akan dipinjam
                            </span>
                            <button class="btn btn-sm btn-outline-info" onclick="buku();">
                                <i class="fa fa-plus"></i> Pilih Buku
                            </button>
                        </div>

                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Detail Buku</th>
                                    <th width="10%">Qty</th>
                                    <th width="10%">#</th>
                                </tr>
                            </thead>
                            <tbody id="viewListBuku"></tbody>
                        </table>
                    </div>

                    <!-- BUTTON -->
                    <div class="col-lg-12 text-right mt-3">
                        <button type="button"
                            class="btn btn-primary"
                            id="btn-simpan">
                            <i class="fa fa-save"></i> Proses Peminjaman
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL LIST BUKU -->
<div class="modal fade" id="modalListBuku">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>
                    <i class="fa fa-book-open"></i> List Buku
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($resultBuku as $b): ?>
                        <tr>
                            <td><?= $b->kode_buku ?></td>
                            <td><?= $b->judul ?></td>
                            <td class="text-center"><?= $b->stok ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info"
                                    onclick="pilihBuku('<?= $b->id ?>')">
                                    <i class="fa fa-check"></i> Pilih
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    viewBuku();

    $("#btn-simpan").click(function(){

        var form = new FormData(document.getElementById("form-peminjaman"));

        if($("#tgl_kembali").val() == ""){
            alert("Tanggal kembali wajib diisi");
            return false;
        }

        $.ajax({
            type:"POST",
            url:"<?= site_url('back-end/peminjaman/save') ?>",
            data:form,
            contentType:false,
            processData:false,
            dataType:"JSON",
            success:function(res){
                if(res.status){
                    alert("Peminjaman berhasil 🔥");
                    location.reload();
                }else{
                    alert("Gagal simpan!");
                }
            }
        });
    });
});

function buku(){
    $("#modalListBuku").modal('show');
}

function pilihBuku(id){
    $.post("<?= site_url('back-end/peminjaman/tambahBuku') ?>",
    {id_buku:id},
    function(res){
        if(res.Pesan){
            alert(res.Pesan);
        }else{
            viewBuku();
            $("#modalListBuku").modal('hide');
        }
    },"JSON");
}

function viewBuku(){
    $("#viewListBuku").load("<?= site_url('back-end/peminjaman/viewListBuku') ?>");
}

function hapusBuku(id){
    if(!confirm('Hapus buku dari daftar?')) return;
    $.ajax({
        type: "POST",
        url: "<?= site_url('back-end/peminjaman/hapusBuku') ?>/"+id,
        dataType: "JSON",
        success: function(res){
            if(res.status){
                viewBuku();
            }else{
                alert('Gagal menghapus buku');
            }
        },
        error: function(){
            alert('Terjadi kesalahan. Coba lagi.');
        }
    });
}
</script>