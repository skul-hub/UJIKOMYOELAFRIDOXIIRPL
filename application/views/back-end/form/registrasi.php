<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registrasi Anggota</title>

<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">

<style>
/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:#020617;
    min-height:100vh;
    overflow-x:hidden; /* FIX: bisa scroll vertikal */
}

/* FLOATING BACKGROUND */
.blob{
    position:fixed;
    border-radius:50%;
    filter:blur(120px);
    opacity:.5;
    z-index:0;
    animation:float 12s infinite ease-in-out alternate;
}

.blob1{
    width:400px;
    height:400px;
    background:#3b82f6;
    top:-100px;
    left:-100px;
}

.blob2{
    width:500px;
    height:500px;
    background:#9333ea;
    bottom:-150px;
    right:-150px;
    animation-delay:4s;
}

@keyframes float{
    from{ transform:translateY(0px); }
    to{ transform:translateY(60px); }
}

/* WRAPPER (INI YANG BIKIN BISA SCROLL) */
.page-wrapper{
    position:relative;
    z-index:2;
    padding:60px 20px;
    display:flex;
    justify-content:center;
    align-items:flex-start; /* BUKAN CENTER lagi */
    min-height:100vh;
}

/* GLASS CARD */
.register-box{
    width:100%;
    max-width:950px;
    display:flex;
    border-radius:28px;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(25px);
    border:1px solid rgba(255,255,255,0.1);
    box-shadow:0 30px 80px rgba(0,0,0,0.6);
    overflow:hidden;
    animation:fadeSlide .8s ease;
}

/* ANIMATION MASUK */
@keyframes fadeSlide{
    from{
        opacity:0;
        transform:translateY(40px) scale(.97);
    }
    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }
}

/* LEFT SIDE */
.info-side{
    width:45%;
    padding:50px;
    background:linear-gradient(135deg,#1e3a8a,#9333ea);
    color:#fff;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.info-side h2{
    font-weight:800;
    font-size:28px;
}

.info-side p{
    margin-top:15px;
    opacity:.9;
    line-height:1.6;
}

/* RIGHT FORM */
.form-side{
    width:55%;
    padding:50px;
    color:#fff;
}

.form-side h4{
    font-weight:700;
    margin-bottom:25px;
}

/* INPUT */
.form-control{
    height:52px;
    border-radius:14px;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.15);
    color:#fff;
    margin-bottom:18px;
}

textarea.form-control{
    height:auto;
    min-height:100px;
    padding-top:12px;
}

.form-control::placeholder{
    color:#cbd5e1;
}

.form-control:focus{
    background:rgba(255,255,255,0.15);
    box-shadow:0 0 0 3px rgba(59,130,246,.5);
    border:none;
    color:#fff;
}

/* BUTTON */
.btn-register{
    height:52px;
    border-radius:14px;
    font-weight:600;
    background:linear-gradient(135deg,#3b82f6,#9333ea);
    border:none;
    transition:.4s;
}

.btn-register:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 35px rgba(147,51,234,.6);
}

.btn-login{
    height:52px;
    border-radius:14px;
    border:1px solid rgba(255,255,255,.3);
    color:#fff;
    margin-top:12px;
}

.btn-login:hover{
    background:#fff;
    color:#020617;
}

/* RESPONSIVE (HP) */
@media(max-width:768px){
    .register-box{
        flex-direction:column;
    }
    .info-side,
    .form-side{
        width:100%;
        padding:30px;
    }
}
</style>
</head>

<body>

<!-- Background Glow -->
<div class="blob blob1"></div>
<div class="blob blob2"></div>

<div class="page-wrapper">
<div class="register-box">

    <!-- LEFT INFO -->
    <div class="info-side">
        <h2>Perpustakaan Digital</h2>
        <p>
            Daftarkan akun anggota untuk mengakses sistem peminjaman buku,
            katalog digital, dan layanan perpustakaan modern.
        </p>
    </div>

    <!-- RIGHT FORM -->
    <div class="form-side">
        <h4>Registrasi Anggota</h4>

        <form id="form-anggota">

            <input type="text" class="form-control" name="nis" placeholder="NIS">
            <input type="text" class="form-control" name="nm_siswa" placeholder="Nama Siswa">
            <input type="text" class="form-control" name="kelas" placeholder="Kelas">
            <textarea class="form-control" name="alamat" placeholder="Alamat"></textarea>

            <hr style="border-color:rgba(255,255,255,.2); margin:25px 0;">

            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">

            <button class="btn btn-register btn-block text-white" id="btn-simpan">
                <i class="fa fa-user-plus"></i> Proses Registrasi
            </button>

            <a href="<?= site_url('login-sistem') ?>" class="btn btn-login btn-block">
                <i class="fa fa-sign-in-alt"></i> Login Anggota
            </a>

        </form>
    </div>

</div>
</div>

<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script>
$(document).ready(function () {

    $('#btn-simpan').click(function () {

        let formData = new FormData($('#form-anggota')[0]);

        if ($('#username').val() === '' || $('#password').val() === '') {
            alert('Username dan Password wajib diisi');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?= site_url('registrasi-save') ?>',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (res) {
                if (res.status) {
                    alert('Registrasi berhasil');
                    window.location.href = '<?= site_url('login-sistem') ?>';
                }
            }
        });

        return false;
    });

});
</script>

</body>
</html>