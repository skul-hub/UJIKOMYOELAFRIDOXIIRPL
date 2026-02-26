<section class="content new-ui">
  <div class="container-fluid">
    <div class="row g-4">

      <!-- LEFT : FORM -->
      <div class="col-lg-4">
        <div class="glass-card slide-left">

          <div class="glass-header">
            <span class="icon-circle">
              <i class="fas fa-book"></i>
            </span>
            <div>
              <h5>Manajemen Buku</h5>
              <small>Tambah & edit data buku</small>
            </div>
          </div>

          <form id="form-buku" class="glass-body">
            <input type="hidden" name="id" id="id">

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="kode_buku" name="kode_buku" placeholder="Kode">
              <label>Kode Buku</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul">
              <label>Judul Buku</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Pengarang">
              <label>Pengarang</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Penerbit">
              <label>Penerbit</label>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" id="tahun" name="tahun">
                  <label>Tahun</label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" id="stok" name="stok">
                  <label>Stok</label>
                </div>
              </div>
            </div>

            <button type="button" id="btn-simpan" class="btn btn-primary w-100">
              <i class="fas fa-save"></i> Simpan Buku
            </button>

            <button type="button" id="btn-update" class="btn btn-warning w-100 d-none mt-2">
              Update Data
            </button>

            <button type="button" id="btn-refresh" class="btn btn-light w-100 d-none mt-2">
              Batal
            </button>
          </form>
        </div>
      </div>

      <!-- RIGHT : TABLE -->
      <div class="col-lg-8">
        <div class="glass-card slide-right">

          <div class="glass-header between">
            <div>
              <h5>Daftar Buku</h5>
              <small>Semua koleksi perpustakaan</small>
            </div>
            <span class="badge-soft"><?= count($result) ?> Buku</span>
          </div>

          <div class="glass-body">
            <table id="table-buku" class="table modern-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Informasi Buku</th>
                  <th>Tahun</th>
                  <th>Stok</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; foreach($result as $r): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <strong><?= $r->judul ?></strong><br>
                    <small>
                      <?= $r->pengarang ?> • <?= $r->penerbit ?><br>
                      <span class="text-muted">Kode: <?= $r->kode_buku ?></span>
                    </small>
                  </td>
                  <td><?= $r->tahun ?></td>
                  <td><span class="stock-pill"><?= $r->stok ?></span></td>
                  <td>
                    <button class="btn-icon edit" onclick="edit(<?= $r->id ?>)">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-icon delete" onclick="hapus(<?= $r->id ?>)">
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

<!-- ================= CSS ================= -->
<style>
.new-ui{padding:20px;animation:fadeUp .6s ease}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1}}

.glass-card{
  background:#fff;
  border-radius:18px;
  box-shadow:0 20px 40px rgba(0,0,0,.08);
  height:100%;
}

.glass-header{
  display:flex;
  align-items:center;
  gap:12px;
  padding:20px;
  border-bottom:1px solid #eee;
}
.glass-header.between{justify-content:space-between}

.icon-circle{
  width:44px;height:44px;
  background:linear-gradient(135deg,#6366f1,#22d3ee);
  color:#fff;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
}

.glass-body{padding:20px}

.modern-table td{vertical-align:middle}
.modern-table tbody tr:hover{background:#f5f7ff}

.stock-pill{
  background:#dcfce7;
  color:#166534;
  padding:4px 12px;
  border-radius:20px;
  font-size:12px;
}

.badge-soft{
  background:#eef2ff;
  color:#3730a3;
  padding:6px 14px;
  border-radius:20px;
}

/* ===== BUTTON ICON (FIX ICON EDIT) ===== */
.btn-icon{
  width:38px;
  height:38px;
  border:none;
  border-radius:12px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  transition:.2s;
}

.btn-icon i{
  font-size:15px;
  color:#fff; /* PENTING */
}

.btn-icon.edit{
  background:linear-gradient(135deg,#3b82f6,#06b6d4);
}

.btn-icon.delete{
  background:#ef4444;
}

.btn-icon:hover{
  transform:scale(1.08);
  opacity:.9;
}

.slide-left{animation:left .6s ease}
.slide-right{animation:right .6s ease}
@keyframes left{from{opacity:0;transform:translateX(-30px)}to{opacity:1}}
@keyframes right{from{opacity:0;transform:translateX(30px)}to{opacity:1}}
</style>

<!-- ================= JS ================= -->
<script>
$(function(){
  $('#table-buku').DataTable({ordering:false});

  $('#btn-simpan').click(function(){
    $.post("<?= site_url('back-end/Buku/save') ?>",
      $('#form-buku').serialize(),
      r=>{ if(r.status) location.reload(); },
      'json'
    );
  });

  $('#btn-update').click(function(){
    $.post("<?= site_url('back-end/Buku/update') ?>",
      $('#form-buku').serialize(),
      r=>{ if(r.status) location.reload(); },
      'json'
    );
  });

  $('#btn-refresh').click(()=>location.reload());
});

function edit(id){
  $.getJSON("<?= site_url('back-end/Buku/edit/') ?>"+id,function(d){
    $('#form-buku')[0].reset();
    for(let k in d) $('#'+k).val(d[k]);
    $('#btn-simpan').addClass('d-none');
    $('#btn-update,#btn-refresh').removeClass('d-none');
  });
}

function hapus(id){
  if(confirm('Hapus data buku?')){
    $.getJSON("<?= site_url('back-end/Buku/hapus/') ?>",()=>location.reload());
  }
}
</script>