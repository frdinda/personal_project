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
$routes->get('/', 'Beranda\Beranda::index');
$routes->get('/login', 'Login\Login::index');
$routes->post('/proslogin', 'Login\Login::ProsLogin');
$routes->get('/beranda', 'Beranda\Beranda::index');
$routes->get('/logout', 'Login\Login::Logout');

// PENILAIAN ATASAN LANGSUNG
$routes->get('/pilih-atasan-langsung', 'PenilaianAtasanLangsung\PenilaianAtasanLangsung::PilihAtasanLangsung');
$routes->post('/dipilih-atasan-langsung', 'PenilaianAtasanLangsung\PenilaianAtasanLangsung::ProsesPilihAtasanLangsung');
$routes->get('/pilih-pegawai', 'PenilaianAtasanLangsung\PenilaianAtasanLangsung::PilihPegawai');
$routes->get('/penilaian-atasan-langsung/(:any)', 'PenilaianAtasanLangsung\PenilaianAtasanLangsung::PenilaianAtasanLangsung/$1');
$routes->post('/proses-penilaian-atasan-langsung', 'PenilaianAtasanLangsung\PenilaianAtasanLangsung::ProsesPenilaianAtasanLangsung');
// PENILAIAN POLLING
$routes->get('/polling-pegawai', 'PollingPegawai\PollingPegawai::index');
$routes->post('/proses-polling-pegawai', 'PollingPegawai\PollingPegawai::ProsesPollingPegawai');
// CURRENT RANKING
$routes->get('/current-ranking', 'CurrentRanking\CurrentRanking::index');
$routes->get('/tentukan-pegawai-teladan', 'CurrentRanking\CurrentRanking::TentukanPegawaiTeladan');

// KELOLA PEGAWAI
$routes->get('/kelola-pegawai', 'Kelola\KelolaPegawai::index');
// TAMBAH PEGAWAI
$routes->get('/tambah-pegawai', 'Kelola\KelolaPegawai::TambahPegawai');
$routes->post('/sub-tambah-pegawai', 'Kelola\KelolaPegawai::ProsesTambahPegawai');
// EDIT PEGAWAI
$routes->get('/edit-pegawai/(:any)', 'Kelola\KelolaPegawai::EditPegawai/$1');
$routes->post('/sub-edit-pegawai', 'Kelola\KelolaPegawai::ProsesEditPegawai');
// HAPUS PEGAWAI
$routes->get('/hapus-pegawai/(:any)', 'Kelola\KelolaPegawai::HapusPegawai/$1');

// EDIT PROFIL
$routes->get('/edit-profil', 'Kelola\KelolaPegawai::EditProfil');

// KELOLA PERTANYAAN
$routes->get('/kelola-pertanyaan', 'Kelola\KelolaPertanyaan::index');
// TAMBAH PERTANYAAN
$routes->get('/tambah-pertanyaan', 'Kelola\KelolaPertanyaan::TambahPertanyaan');
$routes->post('/sub-tambah-pertanyaan', 'Kelola\KelolaPertanyaan::ProsesTambahPertanyaan');
// EDIT PERTANYAAN
$routes->get('/edit-pertanyaan/(:any)', 'Kelola\KelolaPertanyaan::EditPertanyaan/$1');
$routes->post('/sub-edit-pertanyaan', 'Kelola\KelolaPertanyaan::ProsesEditPertanyaan');
// HAPUS PEGAWAI
$routes->get('/hapus-pertanyaan/(:any)', 'Kelola\KelolaPertanyaan::HapusPertanyaan/$1');




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
