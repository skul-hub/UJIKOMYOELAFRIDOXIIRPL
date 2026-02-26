<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- ================= FORM ANGGOTA ================= -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 modern-card">
                    
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-plus"></i> Form Anggota
                        </h5>
                    </div>

                    <form id="form-anggota">
                        <div class="card-body">

                            <input type="hidden" id="id_siswa" name="id_siswa">
                            <input type="hidden" id="user_id" name="user_id">

                            <div class="form-group">
                                <label>NIS</label>
                                <input type="text" class="form-control form-control-sm"
                                       id="nis" name="nis">
                            </div>

                            <div class="form-group">
                                <label>Nama Siswa</label>
                                <input type="text" class="form-control form-control-sm"
                                       id="nm_siswa" name="nm_siswa">
                            </div>

                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control form-control-sm"
                                       id="kelas" name="kelas">
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control form-control-sm"
                                          id="alamat" name="alamat"></textarea>
                            </div>

                            <hr>
                            <small class="text-muted font-weight-bold">
                                Akun Login Anggota
                            </small>

                            <div class="form-group mt-2">
                                <label>Username</label>
                                <input type="text" class="form-control form-control-sm"
                                       id="username" name="username">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control form-control-sm"
                                       id="password" name="password">
                            </div>

                        </div>

                        <div class="card-footer text-right bg-white">
                            <button type="button" class="btn btn-sm btn-primary"
                                    id="btn-simpan">
                                <i class="fas fa-save"></i> Simpan
                            </button>

                            <button type="button" class="btn btn-sm btn-warning d-none"
                                    id="btn-update">
                                <i class="fas fa-edit"></i> Update
                            </button>

                            <button type="button" class="btn btn-sm btn-secondary d-none"
                                    id="btn-refresh">
                                <i class="fas fa-sync"></i> Batal
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- ================= TABLE ANGGOTA ================= -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 modern-card">

                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-users"></i> Data Anggota
                        </h5>
                    </div>

                    <div class="card-body table-responsive">
                        <table id="DataTables"
                               class="table table-bordered table-striped table-sm">
                            <thead class="text-center">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Detail Anggota</th>
                                    <th width="12%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $no = 1; foreach ($result as $rs): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>

                                    <td>
                                        <div><b>NIS</b> : <?= $rs->nis ?></div>
                                        <div><b>Nama</b> : <?= $rs->nama ?></div>
                                        <div><b>Kelas</b> : <?= $rs->kelas ?></div>
                                        <div><b>Alamat</b> : <?= $rs->alamat ?></div>
                                    </td>

                                    <td class="text-center">
                                        <div id="status_anggota<?= $rs->id ?>">
                                            <?php if ($rs->status == 'aktif'): ?>
                                                <button class="btn btn-sm btn-success"
                                                        onclick="status('<?= $rs->id ?>')">
                                                    Aktif
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-danger"
                                                        onclick="status('<?= $rs->id ?>')">
                                                    Non Aktif
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning"
                                                onclick="edit('<?= $rs->id ?>')">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger"
                                                onclick="hapus('<?= $rs->user_id ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>

.modern-card {
    border-radius: 14px;
    overflow: hidden;
}

.card-header {
    font-weight: 600;
}

.form-control-sm {
    border-radius: 8px;
    transition: 0.2s;
}

.form-control-sm:focus {
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    border-color: #2563eb;
}

textarea.form-control-sm {
    resize: none;
}

.btn {
    border-radius: 8px;
}

.table thead {
    background: #f1f5f9;
}

.table tbody tr:hover {
    background: #f8fafc;
    transition: 0.2s;
}

.table td {
    vertical-align: middle !important;
}

</style>

<script>
$(function () {

    $('#DataTables').DataTable({
        paging: true,
        ordering: false,
        responsive: true
    });

    $('#btn-simpan').click(function () {
        let formData = new FormData($('#form-anggota')[0]);

        if ($('#username').val() === '' || $('#password').val() === '') {
            alert('Username dan Password wajib diisi');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?= site_url("back-end/anggota/save") ?>',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (res) {
                if (res.status) location.reload();
            }
        });
    });

    $('#btn-update').click(function () {
        let formData = new FormData($('#form-anggota')[0]);

        $.ajax({
            type: 'POST',
            url: '<?= site_url("back-end/anggota/update") ?>',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (res) {
                if (res.status) location.reload();
            }
        });
    });

    $('#btn-refresh').click(function () {
        location.reload();
    });
});

function edit(id) {
    $.getJSON('<?= site_url("back-end/anggota/edit") ?>/' + id, function (data) {
        $('#btn-simpan').addClass('d-none');
        $('#btn-update, #btn-refresh').removeClass('d-none');

        $('#id_siswa').val(data.id);
        $('#user_id').val(data.user_id);
        $('#nis').val(data.nis);
        $('#nm_siswa').val(data.nama);
        $('#kelas').val(data.kelas);
        $('#alamat').val(data.alamat);
        $('#username').val(data.username);
    });
}

function hapus(user_id) {
    if (confirm('Yakin hapus data ini?')) {
        $.get('<?= site_url("back-end/anggota/hapus") ?>/' + user_id, function () {
            location.reload();
        });
    }
}

function status(id) {
    $.get('<?= site_url("back-end/anggota/status") ?>/' + id, function (res) {
        $('#status_anggota' + id).html(res);
    });
}
</script>