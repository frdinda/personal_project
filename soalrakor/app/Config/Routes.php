<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->get('/', 'Login\Login::index');
$routes->get('/login', 'Login\Login::index');
$routes->post('/proslogin', 'Login\Login::ProsLogin');

// LOGOUT
$routes->get('/logout', 'Login\Login::logout');

// ECK22
// BERANDA
$routes->get('/beranda', 'ECK22\Beranda\Beranda::index');
$routes->get('/detail-nilai/(:any)', 'ECK22\Beranda\Beranda::DetailPenilaian/$1');

// FORM PENILAIAN
$routes->get('/form-pilih-satker', 'ECK22\Penilaian\FormPenilaian::FormPilihSatker');
$routes->post('/form-konfirmasi', 'ECK22\Penilaian\FormPenilaian::FormPemastianSatker');
$routes->post('/form-penilaian', 'ECK22\Penilaian\FormPenilaian::FormPenilaian');
$routes->post('/sub-form-penilaian', 'ECK22\Penilaian\FormPenilaian::SubFormPenilaian');
$routes->post('/form-penilaian-sebelum', 'ECK22\Penilaian\FormPenilaian::FormPenilaianSebelum');

// KELOLA SOAL
$routes->get('/kelola-soal', 'ECK22\KelolaSoal\KelolaSoal::index');
$routes->get('/tambah-soal', 'ECK22\KelolaSoal\KelolaSoal::TambahSoal');
$routes->post('/sub-tambah-soal', 'ECK22\KelolaSoal\KelolaSoal::SubTambahSoal');
$routes->get('/edit-soal/(:any)', 'ECK22\KelolaSoal\KelolaSoal::EditSoal/$1');
$routes->post('/sub-edit-soal', 'ECK22\KelolaSoal\KelolaSoal::SubEditSoal');
$routes->post('/hapus-soal/(:any)', 'ECK22\KelolaSoal\KelolaSoal::HapusSoal/$1');
$routes->get('/mulai-random-soal', 'ECK22\KelolaSoal\KelolaSoal::MulaiRandomSoal');
$routes->get('/reset-random-soal', 'ECK22\KelolaSoal\KelolaSoal::ResetRandomSoal');

// KELOLA NILAI
$routes->get('/kelola-nilai', 'ECK22\Penilaian\KelolaNilai::index');
$routes->get('/edit-nilai/(:any)', 'ECK22\Penilaian\KelolaNilai::EditNilai/$1');
$routes->post('/sub-edit-nilai/(:any)', 'ECK22\Penilaian\KelolaNilai::SubEditNilai/$1');

// KELOLA USER
$routes->get('/kelola-user', 'ECK22\Kelola\KelolaUser::index');
$routes->get('/tambah-user', 'ECK22\Kelola\KelolaUser::TambahUser');
$routes->post('/sub-tambah-user', 'ECK22\Kelola\KelolaUser::SubTambahUser');
$routes->get('/edit-user/(:any)', 'ECK22\Kelola\KelolaUser::EditUser/$1');
$routes->post('/sub-edit-user', 'ECK22\Kelola\KelolaUser::SubEditUser');
$routes->post('/hapus-user/(:any)', 'ECK22\Kelola\KelolaUser::HapusUser/$1');

// KELOLA SATKER
$routes->get('/kelola-satker', 'ECK22\Kelola\KelolaSatker::index');
$routes->get('/tambah-satker', 'ECK22\Kelola\KelolaSatker::TambahSatker');
$routes->post('/sub-tambah-satker', 'ECK22\Kelola\KelolaSatker::SubTambahSatker');
$routes->get('/edit-satker/(:any)', 'ECK22\Kelola\KelolaSatker::EditSatker/$1');
$routes->post('/sub-edit-satker', 'ECK22\Kelola\KelolaSatker::SubEditSatker');
$routes->post('/hapus-satker/(:any)', 'ECK22\Kelola\KelolaSatker::HapusSatker/$1');


// TZI23
// BERANDA
$routes->get('/beranda-tzi23', 'TZI23\Beranda\Beranda::index');
$routes->get('/detail-nilai-tzi23/(:any)', 'TZI23\Beranda\Beranda::DetailPenilaian/$1');

// FORM PENILAIAN
$routes->get('/form-pilih-asesi-tzi23', 'TZI23\Penilaian\FormPenilaian::FormPilihAsesi');
$routes->post('/form-konfirmasi-tzi23', 'TZI23\Penilaian\FormPenilaian::FormPemastianAsesi');
$routes->post('/form-penilaian-tzi23', 'TZI23\Penilaian\FormPenilaian::FormPenilaian');
$routes->post('/sub-form-penilaian-tzi23', 'TZI23\Penilaian\FormPenilaian::SubFormPenilaian');
$routes->post('/form-penilaian-sebelum-tzi23', 'TZI23\Penilaian\FormPenilaian::FormPenilaianSebelum');

// KELOLA NILAI
$routes->get('/kelola-nilai-tzi23', 'TZI23\Penilaian\KelolaNilai::index');
$routes->get('/edit-nilai-tzi23/(:any)', 'TZI23\Penilaian\KelolaNilai::EditNilai/$1');
$routes->post('/sub-edit-nilai-tzi23/(:any)', 'TZI23\Penilaian\KelolaNilai::SubEditNilai/$1');

// KELOLA SOAL
$routes->get('/kelola-soal-tzi23', 'TZI23\KelolaSoal\KelolaSoal::index');
$routes->get('/tambah-soal-tzi23', 'TZI23\KelolaSoal\KelolaSoal::TambahSoal');
$routes->post('/sub-tambah-soal-tzi23', 'TZI23\KelolaSoal\KelolaSoal::SubTambahSoal');
$routes->get('/edit-soal-tzi23/(:any)', 'TZI23\KelolaSoal\KelolaSoal::EditSoal/$1');
$routes->post('/sub-edit-soal-tzi23', 'TZI23\KelolaSoal\KelolaSoal::SubEditSoal');
$routes->post('/hapus-soal-tzi23/(:any)', 'TZI23\KelolaSoal\KelolaSoal::HapusSoal/$1');
$routes->get('/mulai-random-soal-tzi23', 'TZI23\KelolaSoal\KelolaSoal::MulaiRandomSoal');
$routes->get('/reset-random-soal-tzi23', 'TZI23\KelolaSoal\KelolaSoal::ResetRandomSoal');

// KELOLA ASESI
$routes->get('/kelola-asesi-tzi23', 'TZI23\Kelola\KelolaAsesi::index');
$routes->get('/tambah-asesi-tzi23', 'TZI23\Kelola\KelolaAsesi::TambahAsesi');
$routes->post('/sub-tambah-asesi-tzi23', 'TZI23\Kelola\KelolaAsesi::SubTambahAsesi');
$routes->get('/edit-asesi-tzi23/(:any)', 'TZI23\Kelola\KelolaAsesi::EditAsesi/$1');
$routes->post('/sub-edit-asesi-tzi23', 'TZI23\Kelola\KelolaAsesi::SubEditAsesi');
$routes->post('/hapus-asesi-tzi23/(:any)', 'TZI23\Kelola\KelolaAsesi::HapusAsesi/$1');

// KELOLA USER
$routes->get('/kelola-user-tzi23', 'TZI23\Kelola\KelolaUser::index');
$routes->get('/tambah-user-tzi23', 'TZI23\Kelola\KelolaUser::TambahUser');
$routes->post('/sub-tambah-user-tzi23', 'TZI23\Kelola\KelolaUser::SubTambahUser');
$routes->get('/edit-user-tzi23/(:any)', 'TZI23\Kelola\KelolaUser::EditUser/$1');
$routes->post('/sub-edit-user-tzi23', 'TZI23\Kelola\KelolaUser::SubEditUser');
$routes->post('/hapus-user-tzi23/(:any)', 'TZI23\Kelola\KelolaUser::HapusUser/$1');


// UKOM23
// BERANDA
$routes->get('/beranda-ukom23', 'UKOM23\Beranda\Beranda::index');
$routes->get('/detail-nilai-ukom23/(:any)', 'UKOM23\Beranda\Beranda::DetailPenilaian/$1');
$routes->post('/pilihan-periode-beranda', 'UKOM23\Beranda\Beranda::PilihanPeriode');

// FORM PENILAIAN
$routes->get('/form-pilih-peserta-ukom23', 'UKOM23\Penilaian\FormPenilaian::FormPilihPeserta');
$routes->post('/form-konfirmasi-ukom23', 'UKOM23\Penilaian\FormPenilaian::FormPemastianPeserta');
$routes->post('/form-penilaian-ukom23', 'UKOM23\Penilaian\FormPenilaian::FormPenilaian');
$routes->post('/sub-form-penilaian-ukom23', 'UKOM23\Penilaian\FormPenilaian::SubFormPenilaian');
$routes->post('/form-penilaian-sebelum-ukom23', 'UKOM23\Penilaian\FormPenilaian::FormPenilaianSebelum');

// KELOLA SOAL
$routes->get('/kelola-soal-ukom23', 'UKOM23\KelolaSoal\KelolaSoal::index');
$routes->get('/tambah-soal-ukom23', 'UKOM23\KelolaSoal\KelolaSoal::TambahSoal');
$routes->post('/sub-tambah-soal-ukom23', 'UKOM23\KelolaSoal\KelolaSoal::SubTambahSoal');
$routes->get('/edit-soal-ukom23/(:any)', 'UKOM23\KelolaSoal\KelolaSoal::EditSoal/$1');
$routes->post('/sub-edit-soal-ukom23', 'UKOM23\KelolaSoal\KelolaSoal::SubEditSoal');
$routes->post('/hapus-soal-ukom23/(:any)', 'UKOM23\KelolaSoal\KelolaSoal::HapusSoal/$1');
$routes->get('/mulai-random-soal-ukom23', 'UKOM23\KelolaSoal\KelolaSoal::MulaiRandomSoal');
$routes->get('/reset-random-soal-ukom23', 'UKOM23\KelolaSoal\KelolaSoal::ResetRandomSoal');

// KELOLA NILAI
$routes->get('/kelola-nilai-ukom23', 'UKOM23\Penilaian\KelolaNilai::index');
$routes->get('/edit-nilai-ukom23/(:any)', 'UKOM23\Penilaian\KelolaNilai::EditNilai/$1');
$routes->post('/sub-edit-nilai-ukom23/(:any)', 'UKOM23\Penilaian\KelolaNilai::SubEditNilai/$1');
$routes->post('/pilihan-periode-nilai', 'UKOM23\Penilaian\KelolaNilai::PilihanPeriode');

// KELOLA PERIODE
$routes->get('/kelola-periode-ukom23', 'UKOM23\Kelola\KelolaPeriode::index');
$routes->get('/tambah-periode-ukom23', 'UKOM23\Kelola\KelolaPeriode::TambahPeriode');
$routes->post('/sub-tambah-periode-ukom23', 'UKOM23\Kelola\KelolaPeriode::SubTambahPeriode');
$routes->get('/edit-periode-ukom23/(:any)', 'UKOM23\Kelola\KelolaPeriode::EditPeriode/$1');
$routes->post('/sub-edit-periode-ukom23', 'UKOM23\Kelola\KelolaPeriode::SubEditPeriode');
$routes->post('/hapus-periode-ukom23/(:any)', 'UKOM23\Kelola\KelolaPeriode::HapusPeriode/$1');
$routes->get('/edit-periode-berjalan-ukom23', 'UKOM23\Kelola\KelolaPeriode::EditPeriodeBerjalan');
$routes->post('/sub-edit-periode-berjalan-ukom23', 'UKOM23\Kelola\KelolaPeriode::SubEditPeriodeBerjalan');

// KELOLA USER
$routes->get('/kelola-user-ukom23', 'UKOM23\Kelola\KelolaUser::index');
$routes->get('/tambah-user-ukom23', 'UKOM23\Kelola\KelolaUser::TambahUser');
$routes->post('/sub-tambah-user-ukom23', 'UKOM23\Kelola\KelolaUser::SubTambahUser');
$routes->get('/edit-user-ukom23/(:any)', 'UKOM23\Kelola\KelolaUser::EditUser/$1');
$routes->post('/sub-edit-user-ukom23', 'UKOM23\Kelola\KelolaUser::SubEditUser');
$routes->post('/hapus-user-ukom23/(:any)', 'UKOM23\Kelola\KelolaUser::HapusUser/$1');

// KELOLA PESERTA
$routes->get('/kelola-peserta-ukom23', 'UKOM23\Kelola\KelolaPeserta::index');
$routes->get('/tambah-peserta-ukom23', 'UKOM23\Kelola\KelolaPeserta::TambahPeserta');
$routes->post('/sub-tambah-peserta-ukom23', 'UKOM23\Kelola\KelolaPeserta::SubTambahPeserta');
$routes->get('/edit-peserta-ukom23/(:any)', 'UKOM23\Kelola\KelolaPeserta::EditPeserta/$1');
$routes->post('/sub-edit-peserta-ukom23', 'UKOM23\Kelola\KelolaPeserta::SubEditPeserta');
$routes->post('/hapus-peserta-ukom23/(:any)', 'UKOM23\Kelola\KelolaPeserta::HapusPeserta/$1');
$routes->get('/kelola-peserta-periode-ukom23', 'UKOM23\Kelola\KelolaPeserta::PilihPeriodePeserta');
$routes->post('/sub-pilih-periode-peserta-ukom23', 'UKOM23\Kelola\KelolaPeserta::PilihPesertaPeriode');
$routes->post('/sub-pilih-peserta-periode-ukom23', 'UKOM23\Kelola\KelolaPeserta::SubPilihPesertaPeriode');

// KELOLA SATKER
$routes->get('/kelola-satker-ukom23', 'UKOM23\Kelola\KelolaSatker::index');
$routes->get('/tambah-satker-ukom23', 'UKOM23\Kelola\KelolaSatker::TambahSatker');
$routes->post('/sub-tambah-satker-ukom23', 'UKOM23\Kelola\KelolaSatker::SubTambahSatker');
$routes->get('/edit-satker-ukom23/(:any)', 'UKOM23\Kelola\KelolaSatker::EditSatker/$1');
$routes->post('/sub-edit-satker-ukom23', 'UKOM23\Kelola\KelolaSatker::SubEditSatker');
$routes->post('/hapus-satker-ukom23/(:any)', 'UKOM23\Kelola\KelolaSatker::HapusSatker/$1');


// form-pilih-peserta-ukom23
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
