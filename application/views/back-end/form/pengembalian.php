<section class="content-header">
  <div class="container-fluid">

    <style>
      /* ===== TABLE & CARD ===== */
      .card {
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,.12);
        overflow: hidden;
      }

      .card-header {
        background: linear-gradient(135deg,#1e3a8a,#2563eb);
        color: #fff;
      }

      table tbody tr {
        transition: .3s;
      }

      table tbody tr:hover {
        background: #f1f5f9;
        transform: scale(1.01);
      }

      /* ===== BADGE ===== */
      .badge-success {
        background: linear-gradient(135deg,#16a34a,#22c55e);
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 20px;
      }

      .badge-danger {
        background: linear-gradient(135deg,#dc2626,#ef4444);
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 20px;
      }

      /* ===== BUTTON ===== */
      .btn {
        border-radius: 12px;
        transition: .3s;
      }

      .btn-primary {
        background: linear-gradient(135deg,#2563eb,#3b82f6);
        border: none;
      }

      .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37,99,235,.4);
      }

      .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(220,38,38,.4);
      }

      /* ===== MODAL ===== */
      .modal-content {
        border-radius: 20px;
        animation: zoomIn .4s ease;
      }

      @keyframes zoomIn {
        from { transform: scale(.85); opacity: 0 }
        to { transform: scale(1); opacity: 1 }
      }

      .form-control {
        border-radius: 12px;
      }
    </style>

    <!-- CARD -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fa fa-undo"></i> Data Pengembalian Buku
        </h3>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table id="DataTables" class="table table-striped table-hover">
            <thead class="text-center">
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
              <?php $no=1; foreach ($resultPeminjaman as $rs): ?>
              <?php
                $denda = 5000;
                $tgl_sekarang = date('Y-m-d');
                $jatuhTempo = new DateTime($rs->tgl_kembali);
                $dikembalikan = new DateTime($tgl_sekarang);
                $total = ($dikembalikan <= $jatuhTempo) ? 0 : $jatuhTempo->diff($dikembalikan)->days * $denda;
              ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>

                <td class="text-center">
                  <b>ID-<?= $rs->id ?></b><br>
                  <?= date('d-m-Y', strtotime($rs->tgl_pinjam)) ?> →
                  <?= date('d-m-Y', strtotime($rs->tgl_kembali)) ?>
                </td>

                <td>
                  <b><?= $rs->nama ?></b><br>
                  NIS: <?= $rs->nis ?><br>
                  Kelas: <?= $rs->kelas ?>
                </td>

                <td class="text-right">
                  <?= $total > 0 ? 'Rp '.number_format($total,0,',','.') : '-' ?>
                </td>

                <td class="text-center">
                  <?php if ($rs->status == 'dikembalikan'): ?>
                    <span class="badge badge-success">Dikembalikan</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Dipinjam</span>
                  <?php endif ?>
                </td>

                <td class="text-center">
                  <button class="btn btn-sm btn-primary"
                    onclick="pengembalian('<?= $rs->id ?>')">
                    <i class="fa fa-check"></i>
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
</section>

<!-- MODAL -->
<div class="modal fade" id="modalPengembalian" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title">
          <i class="fa fa-book"></i> Form Pengembalian
        </h4>
        <button type="button" class="close text-white" data-dismiss="modal">
          &times;
        </button>
      </div>

      <div class="modal-body">
        <div class="row">

          <div class="col-md-4">
            <form id="form-pengembalian">
              <input type="hidden" id="peminjaman_id" name="peminjaman_id">

              <div class="form-group">
                <label>No Peminjaman</label>
                <input type="text" class="form-control" id="no_pinjam" readonly>
              </div>

              <div class="form-group">
                <label>Tgl Kembali</label>
                <input type="date" class="form-control" id="tgl_kembali" readonly>
              </div>

              <div class="form-group">
                <label>Tgl Pengembalian</label>
                <input type="date" class="form-control" id="tgl_pengembalian"
                       name="tgl_pengembalian" value="<?= date('Y-m-d') ?>">
              </div>

              <div class="form-group">
                <label>Denda</label>
                <input type="text" class="form-control" id="denda" name="denda" readonly>
              </div>
            </form>
          </div>

          <div class="col-md-8">
            <table class="table table-sm table-striped">
              <thead class="text-center">
                <tr>
                  <th>No</th>
                  <th>Detail Buku</th>
                  <th>Qty</th>
                </tr>
              </thead>
              <tbody id="viewListBuku"></tbody>
            </table>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" id="btn-simpan">
          <i class="fa fa-save"></i> Proses Pengembalian
        </button>
      </div>

    </div>
  </div>
</div>

<script>
$(function(){
  $('#DataTables').DataTable({responsive:true});

  $('#btn-simpan').click(function(){
    let formData = new FormData($('#form-pengembalian')[0]);

    $.ajax({
      type:'POST',
      url:'<?= site_url("back-end/pengembalian/save") ?>',
      data:formData,
      contentType:false,
      processData:false,
      dataType:'JSON',
      success:function(res){
        if(res.status){
          $('#modalPengembalian').modal('hide');
          setTimeout(()=>location.reload(),300);
        }
      }
    });
  });
});

function pengembalian(id){
  $.getJSON('<?= site_url("back-end/pengembalian/peminjaman/") ?>'+id,function(d){
    $('#no_pinjam').val('ID-'+d.id);
    $('#peminjaman_id').val(d.id);
    $('#tgl_kembali').val(d.tgl_kembali);
    hitung(d.tgl_kembali);
    viewBuku(id);
    $('#modalPengembalian').modal('show');
  });
}

function hitung(tgl){
  let tarif=5000;
  let a=new Date(tgl);
  let b=new Date($('#tgl_pengembalian').val());
  let d=(b<=a)?0:Math.ceil((b-a)/(1000*3600*24))*tarif;
  $('#denda').val(d);
}

$('#tgl_pengembalian').on('change',function(){
  hitung($('#tgl_kembali').val());
});

function viewBuku(id){
  $('#viewListBuku').load('<?= site_url("back-end/pengembalian/viewDetailPeminjaman/") ?>'+id);
}
</script>