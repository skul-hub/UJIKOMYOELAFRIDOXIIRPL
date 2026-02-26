<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$route['default_controller'] = 'auth_login'; 
$route['404_override'] = ''; 
$route['translate_uri_dashes'] = FALSE; 

$route['data-peminjaman'] = 'back-end/peminjaman'; 
$route['data-pengembalian'] = 'back-end/pengembalian';
$route['data-riwayat'] = 'back-end/riwayat'; 

$route['halaman-sistem'] = 'main'; 

$route['login-sistem'] = 'auth_login'; 
$route['logout-sistem'] = 'auth_login/logout'; 
$route['registrasi-anggota'] = 'registrasi';
$route['registrasi-save']    = 'registrasi/save';


// ================== ANGGOTA ==================
$route['data-anggota']                   = 'back-end/anggota';
$route['back-end/anggota/save']          = 'back-end/anggota/save';
$route['back-end/anggota/update']        = 'back-end/anggota/update';
$route['back-end/anggota/edit/(:num)']   = 'back-end/anggota/edit/$1';
$route['back-end/anggota/hapus/(:num)']  = 'back-end/anggota/hapus/$1';
$route['back-end/anggota/status/(:num)'] = 'back-end/anggota/status/$1';

// ================== BUKU ==================
$route['data-buku']                   = 'back-end/buku';
$route['back-end/buku/save']          = 'back-end/buku/save';
$route['back-end/buku/update']        = 'back-end/buku/update';
$route['back-end/buku/edit/(:num)']   = 'back-end/buku/edit/$1';
$route['back-end/buku/hapus/(:num)']  = 'back-end/buku/hapus/$1';



