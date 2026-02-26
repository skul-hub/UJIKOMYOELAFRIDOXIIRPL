<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login | Sistem Perpustakaan</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">

<style>
/* ===== BACKGROUND ANIMASI ===== */
body{
    margin:0;
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background: radial-gradient(circle at 20% 20%, #1e3a8a, #020617 70%);
    overflow:hidden;
}

/* Floating glow */
body::before, body::after{
    content:"";
    position:absolute;
    width:500px;
    height:500px;
    border-radius:50%;
    filter:blur(120px);
    opacity:.4;
    animation: float 12s infinite linear;
}

body::before{
    background:#3b82f6;
    top:-100px;
    left:-100px;
}

body::after{
    background:#9333ea;
    bottom:-120px;
    right:-120px;
    animation-duration:16s;
}

@keyframes float{
    0%{transform:translateY(0) translateX(0);}
    50%{transform:translateY(40px) translateX(30px);}
    100%{transform:translateY(0) translateX(0);}
}

/* ===== MAIN CONTAINER ===== */
.main-container{
    position:relative;
    z-index:2;
    display:flex;
    min-height:100vh;
    align-items:center;
    justify-content:center;
    padding:20px;
}

/* GLASS CARD */
.login-glass{
    width:1000px;
    height:600px;
    display:flex;
    border-radius:30px;
    overflow:hidden;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(25px);
    border:1px solid rgba(255,255,255,0.1);
    box-shadow:0 40px 100px rgba(0,0,0,0.7);
}

/* ===== LEFT CYBER PANEL ===== */
.left-panel{
    width:50%;
    padding:60px;
    color:#fff;
    display:flex;
    flex-direction:column;
    justify-content:center;
    background:linear-gradient(160deg,rgba(30,64,175,0.4),rgba(2,6,23,0.6));
}

.logo{
    font-size:48px;
    margin-bottom:20px;
    color:#60a5fa;
}

.title{
    font-size:36px;
    font-weight:800;
    line-height:1.2;
}

.desc{
    margin-top:20px;
    opacity:.8;
}

/* Illustration circle */
.cyber-circle{
    margin-top:40px;
    width:180px;
    height:180px;
    border-radius:50%;
    border:2px dashed rgba(96,165,250,.4);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:60px;
    color:#60a5fa;
    animation: spin 20s linear infinite;
}

@keyframes spin{
    from{transform:rotate(0);}
    to{transform:rotate(360deg);}
}

/* ===== RIGHT FORM ===== */
.right-panel{
    width:50%;
    padding:70px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    color:#fff;
}

.form-title{
    font-size:28px;
    font-weight:700;
    margin-bottom:30px;
}

/* Input */
.form-group{
    position:relative;
    margin-bottom:25px;
}

.form-control{
    height:55px;
    border-radius:18px;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.15);
    color:#fff;
    padding-left:50px;
    transition:.3s;
}

.form-control::placeholder{
    color:#cbd5f5;
}

.form-control:focus{
    background:rgba(255,255,255,0.12);
    border-color:#60a5fa;
    box-shadow:0 0 15px rgba(96,165,250,.6);
    color:#fff;
}

.input-icon{
    position:absolute;
    top:50%;
    left:18px;
    transform:translateY(-50%);
    color:#60a5fa;
}

.toggle-password{
    position:absolute;
    top:50%;
    right:18px;
    transform:translateY(-50%);
    cursor:pointer;
    color:#cbd5f5;
}

/* Button Neon */
.btn-login{
    height:55px;
    border-radius:18px;
    background:linear-gradient(135deg,#3b82f6,#9333ea);
    border:none;
    font-weight:600;
    color:#fff;
    transition:.3s;
}

.btn-login:hover{
    transform:translateY(-3px);
    box-shadow:0 20px 40px rgba(147,51,234,.6);
}

/* Register Link */
.register-link{
    margin-top:20px;
    text-align:center;
}

.register-link a{
    color:#60a5fa;
    text-decoration:none;
    font-weight:600;
}
</style>
</head>

<body>

<div class="main-container">
    <div class="login-glass">

        <!-- LEFT CYBER INFO -->
        <div class="left-panel">
            <div class="logo">
                <i class="fas fa-book"></i>
            </div>

            <div class="title">
                Sistem<br>Perpustakaan Digital
            </div>

            <div class="desc">
                Platform modern untuk mengelola buku, anggota, dan peminjaman secara cepat dan aman.
            </div>

            
        </div>

        <!-- RIGHT LOGIN FORM -->
        <div class="right-panel">
            <div class="form-title">Login Akun</div>

            <form action="<?= site_url('auth_login/login') ?>" method="post">

                <div class="form-group">
                    <span class="input-icon"><i class="fa fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-login btn-block">
                    Login ke Sistem
                </button>

                <div class="register-link">
                    Belum punya akun?
                    <a href="<?= site_url('registrasi-anggota') ?>">Daftar Anggota</a>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>