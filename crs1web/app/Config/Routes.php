<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// LOGIN
$routes->post('/proslogin', 'Login\Login::ProsLogin');
$routes->get('/login', 'Login\Login::index');
// LOGOUT
$routes->get('/logout', 'Login\Login::Logout');

// BERANDA
$routes->get('/', 'Beranda\Beranda::index');

// KELOLA PENGGUNA LAYANAN
$routes->get('/kelola-pengguna-layanan', 'Kelola\KelolaPengguna::index');
// TAMBAH PENGGUNA
$routes->get('/tambah-pengguna-layanan', 'Kelola\KelolaPengguna::TambahPengguna');
$routes->post('/sub-tambah-pengguna', 'Kelola\KelolaPengguna::SaveTambahPengguna');
// DETAIL PENGGUNA
$routes->get('/detail-pengguna-layanan/(:any)', 'Kelola\KelolaPengguna::DetailPengguna/$1');
// EDIT PENGGUNA
$routes->get('/edit-pengguna-layanan/(:any)', 'Kelola\KelolaPengguna::EditPengguna/$1');
$routes->post('/sub-edit-pengguna', 'Kelola\KelolaPengguna::SaveEditPengguna');
// HAPUS PENGGUNA
$routes->delete('/hapus-pengguna-layanan/(:any)', 'Kelola\KelolaPengguna::HapusPengguna/$1');

// KELOLA ENTRY PENGGUNA
// TAMBAH ENTRY PENGGUNA (ADMIN)
$routes->get('/tambah-entry-pengguna', 'Kelola\KelolaEntryPengguna::TambahEntryPengguna');
$routes->post('/sub-tambah-entry-pengguna', 'Kelola\KelolaEntryPengguna::SaveTambahEntryPengguna');
// EDIT ENTRY PENGGUNA
$routes->get('/edit-entry-pengguna/(:any)', 'Kelola\KelolaEntryPengguna::EditEntryPengguna/$1');
$routes->post('/sub-edit-entry-pengguna', 'Kelola\KelolaEntryPengguna::SaveEditEntryPengguna');
// HAPUS ENTRY PENGGUNA
$routes->delete('/hapus-entry-pengguna/(:any)', 'Kelola\KelolaEntryPengguna::HapusEntryPengguna/$1');
// TAMBAH ENTRY PENGGUNA (UMUM)
$routes->get('/tambah-entry-pengguna-umum', 'Kelola\KelolaEntryPengguna::TambahEntryPenggunaUmum');
$routes->post('/sub-tambah-entry-pengguna-umum', 'Kelola\KelolaEntryPengguna::SaveTambahEntryPenggunaUmum');
// DETAIL ENTRY PENGGUNA
$routes->get('/detail-entry-pengguna/(:any)', 'Kelola\KelolaEntryPengguna::DetailEntryPengguna/$1');
// GET DATA PENGGUNA UNTUK TAMBAH ENTRY PENGGUNA (UMUM)
$routes->post('/entry/getdatapengguna', 'Kelola\KelolaEntryPengguna::GetDataPengguna');

// KELOLA KONSULTASI ONLINE
$routes->get('/kelola-konsultasi-online', 'Kelola\KelolaKonsultasiOnline::index');
// EDIT KONSULTASI ONLINE
$routes->get('/edit-konsultasi-online/(:any)', 'Kelola\KelolaKonsultasiOnline::EditKonsultasiOnline/$1');
$routes->post('/sub-edit-konsultasi-online', 'Kelola\KelolaKonsultasiOnline::SaveEditKonsultasiOnline');
// HAPUS KONSULTASI ONLINE
$routes->delete('/hapus-konsultasi-online/(:any)', 'Kelola\KelolaKonsultasiOnline::HapusKonsultasiOnline/$1');
// FEEDBACK KONSULTASI ONLINE
$routes->post('/sub-feedback-entry-pengguna', 'Kelola\KelolaKonsultasiOnline::SaveFeedbackKonsultasiOnline/$1');

// KELOLA BROADCAST
$routes->get('/kelola-broadcast', 'Kelola\KelolaBroadcast::index');
// TAMBAH BROADCAST
$routes->get('/tambah-broadcast', 'Kelola\KelolaBroadcast::TambahBroadcast');
$routes->post('/sub-tambah-broadcast', 'Kelola\KelolaBroadcast::SaveTambahBroadcast');
// EDIT BROADCAST
$routes->get('/edit-broadcast/(:any)', 'Kelola\KelolaBroadcast::EditBroadcast/$1');
$routes->post('sub-edit-broadcast', 'Kelola\KelolaBroadcast::SaveEditBroadcast');
// DETAIL BROADCAST
$routes->get('/detail-broadcast/(:any)', 'Kelola\KelolaBroadcast::DetailBroadcast/$1');
// HAPUS BROADCAST
$routes->delete('/hapus-broadcast/(:any)', 'Kelola\KelolaBroadcast::HapusBroadcast/$1');
// KIRIM BROADCAST
$routes->get('/kirim-broadcast/(:any)', 'Kelola\KelolaBroadcast::KirimBroadcast/$1');
// TEST BROADCAST
$routes->get('/test-broadcast/(:any)', 'Kelola\KelolaBroadcast::TestKirimBroadcast/$1');

// KELOLA USER
$routes->get('/kelola-user', 'Kelola\KelolaUser::index');
// TAMBAH USER
$routes->get('/tambah-user', 'Kelola\KelolaUser::TambahUser');
$routes->post('/sub-tambah-user', 'Kelola\KelolaUser::SaveTambahUser');
// EDIT USER
$routes->get('/edit-user/(:any)', 'Kelola\KelolaUser::EditUser/$1');
$routes->post('/sub-edit-user', 'Kelola\KelolaUser::SaveEditUser');
// HAPUS USER
$routes->delete('/hapus-user/(:any)', 'Kelola\KelolaUser::HapusUser/$1');

// KELOLA JENIS LAYANAN
$routes->get('/kelola-jenis-layanan', 'Kelola\KelolaJenisLayanan::index');
// TAMBAH JENIS LAYANAN
$routes->get('/tambah-jenis-layanan', 'Kelola\KelolaJenisLayanan::TambahJenisLayanan');
$routes->post('/sub-tambah-jenis-layanan', 'Kelola\KelolaJenisLayanan::SaveTambahJenisLayanan');
// EDIT JENIS LAYANAN
$routes->get('/edit-jenis-layanan/(:any)', 'Kelola\KelolaJenisLayanan::EditJenisLayanan/$1');
$routes->post('/sub-edit-jenis-layanan', 'Kelola\KelolaJenisLayanan::SaveEditJenisLayanan');
// HAPUS USER
$routes->delete('/hapus-jenis-layanan/(:any)', 'Kelola\KelolaJenisLayanan::HapusJenisLayanan/$1');

// EDIT PROFIL
$routes->get('/edit-profil', 'Kelola\KelolaUser::EditProfil');
$routes->post('/sub-edit-profil', 'Kelola\KelolaUser::SaveEditProfil');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
