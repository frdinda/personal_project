<?php

namespace App\Controllers\Kelola;

use App\Controllers\BaseController;
use App\Models\PenggunaLayananModel;
use App\Models\JenisLayananModel;
use App\Models\UserModel;
use App\Models\EntryPenggunaLayananModel;
use App\Models\NotifikasiModel;
use App\Models\KonsultasiOnlineModel;
use App\Models\HariLiburModel;

use function PHPUnit\Framework\isNull;

class KelolaEntryPengguna extends BaseController
{
    protected $penggunaLayananModel;
    protected $jenisLayananModel;
    protected $userModel;
    protected $entryPenggunaLayananModel;
    protected $notifikasiModel;
    protected $konsultasiOnlineModel;
    protected $hariLiburModel;

    public function __construct()
    {
        $this->penggunaLayananModel = new PenggunaLayananModel();
        $this->jenisLayananModel = new JenisLayananModel();
        $this->userModel = new UserModel();
        $this->entryPenggunaLayananModel = new EntryPenggunaLayananModel();
        $this->notifikasiModel = new NotifikasiModel();
        $this->konsultasiOnlineModel = new KonsultasiOnlineModel();
        $this->hariLiburModel = new HariLiburModel();
    }

    // TAMBAH ENTRY PENGGUNA ADMIN
    public function TambahEntryPengguna()
    {
        // SENDING NOTIFIKASI YANG BELUM
        $data_notifikasi = $this->notifikasiModel->get_data_notifikasi_belum();
        foreach ($data_notifikasi as $d) {
            if ($d['tanggal_kirim_notifikasi'] == date('Y-m-d')) {
                $detail_user = $this->userModel->get_detail_user($d['user_id']);
                $data = [
                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                    'nama' => $detail_user['nama_unit_kerja'],
                    'message' => $d['text_notifikasi'],
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $this->notifikasiModel->save([
                    'id_notifikasi' => $d['id_notifikasi'],
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
            }
        }
        $data_konsultasi_hari_ini = $this->konsultasiOnlineModel->get_data_konsultasi_online_per_tanggal();
        if (isset($data_konsultasi_hari_ini)) {
            foreach ($data_konsultasi_hari_ini as $d) :
                $jam = explode(":", $d['jam_konsultasi_online']);
                $jam_minus_1 = (int)$jam[0] - 1;
                $tanggal_dan_jam = $d['tanggal_konsultasi_online'] . " " . $jam_minus_1;
                $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($d['no_telp_pengguna']);
                $detail_konsultan = $this->userModel->get_detail_user($d['NIP']);
                $detail_notifikasi = $this->notifikasiModel->get_detail_notifikasi_pengingat($d['id_konsultasi_online']);
                if ($detail_notifikasi != null) {
                } else {
                    if ($tanggal_dan_jam == date('Y-m-d H')) {
                        $text_notifikasi = "*1 JAM LAGI KONSULTASI ANDA AKAN DIMULAI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nSegera persiapkan perangkat Anda untuk Konsultasi Online Bersama Konsultan kami di \nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $d['room_zoom'] . "\n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') . "/" . $d['id_entry'];
                        $this->notifikasiModel->insert([
                            'id_broadcast' => $d['id_konsultasi_online'],
                            'user_id' => '-',
                            'text_notifikasi' => $text_notifikasi,
                            'tanggal_kirim_notifikasi' => date('Y-m-d'),
                            'status_kirim_notifikasi' => 'Sudah',
                            'jenis_notifikasi' => 'Pengingat'
                        ]);
                        $data = [
                            'no_telp_pengguna' => $detail_konsultan['no_telp_representatif'],
                            'nama' => $detail_konsultan['nama_kepala'],
                            'message' => $text_notifikasi,
                            'subject' => "Notifikasi"
                        ];
                        $this->_sendWhatsapp($data);
                        $text_notifikasi = "*1 JAM LAGI KONSULTASI ANDA AKAN DIMULAI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nSegera persiapkan perangkat Anda untuk Konsultasi Online Bersama Konsultan kami di \nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $d['room_zoom'] . "\n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') . "/" . $d['id_entry'];
                        $data = [
                            'no_telp_pengguna' => $detail_pengguna['no_telp_pengguna'],
                            'nama' => $detail_pengguna['nama_pengguna'],
                            'message' => $text_notifikasi,
                            'subject' => "Notifikasi"
                        ];
                        $this->_sendWhatsapp($data);
                    }
                }
            endforeach;
        }
        if (isset($this->session->akses)) {
            $data_user = $this->userModel->get_user();
            $data_pengguna_layanan = $this->penggunaLayananModel->get_pengguna_layanan();
            $jenis_layanan = $this->jenisLayananModel->get_jenis_layanan();
            $data = [
                'data_user' => $data_user,
                'data_pengguna_layanan' => $data_pengguna_layanan,
                'jenis_layanan' => $jenis_layanan,
                'nama_page' => 'Tambah Entry Pengguna Layanan',
                'nama_user' => $this->session->nama_unit_kerja,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
            ];
            return view('kelola/kelola_entry_pengguna/tambah_entry_pengguna', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveTambahEntryPengguna()
    {
        if ($this->request->getVar('jenis_konsultasi') == 'Online') {
            if ($this->request->getVar('jadwal_konsultasi') != "") {
                $jadwal = $this->CekJadwalKonsultasiOnline();
                if ($jadwal == 'success') {
                    if ($this->session->akses == 'Admin') {
                        $tanggal_entry = explode("T", $this->request->getVar('tanggal_entry'));
                        $tanggal_entry = implode(" ", $tanggal_entry);
                        $id_entry = md5(date('YmdHis') . "entry" . $this->request->getVar('no_telp_pengguna'));
                        $this->entryPenggunaLayananModel->insert([
                            'id_entry' => $id_entry,
                            'tanggal_entry' => $tanggal_entry,
                            'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                            'user_id' => $this->request->getVar('user_id'),
                            'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                            'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                            'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                        ]);
                    } else {
                        $id_entry = md5(date('YmdHis') . "entry" . $this->request->getVar('no_telp_pengguna'));
                        $this->entryPenggunaLayananModel->insert([
                            'id_entry' => $id_entry,
                            'tanggal_entry' => date('Y-m-d H:i:s'),
                            'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                            'user_id' => $this->request->getVar('user_id'),
                            'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                            'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                            'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                        ]);
                    }
                    $penjadwalan = $this->SaveKonsultasiOnline();
                    if ($penjadwalan == 'success') {
                        echo "<script>
                            alert('Data Berhasil Disimpan');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                    } else {
                        echo "<script>
                            alert('Data Tidak Berhasil Disimpan');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                    }
                    echo "<script>
                        alert('Data Berhasil Disimpan');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                } else {
                    echo "<script>
                        alert('Data Tidak Berhasil Disimpan');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                }
            } else {
                echo "<script>
                    alert('Data Tidak Lengkap');
                    window.location.href='/tambah-entry-pengguna';
                    </script>";
            }
        } else {
            if ($this->session->akses == 'Admin') {
                $tanggal_entry = explode("T", $this->request->getVar('tanggal_entry'));
                $tanggal_entry = implode(" ", $tanggal_entry);
                $id_entry = md5(date('YmdHis') . "entry" . $this->request->getVar('no_telp_pengguna'));
                $this->entryPenggunaLayananModel->insert([
                    'id_entry' => $id_entry,
                    'tanggal_entry' => $tanggal_entry,
                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                    'user_id' => $this->request->getVar('user_id'),
                    'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                    'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                    'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                ]);
            } else {
                $id_entry = md5(date('YmdHis') . "entry" . $this->request->getVar('no_telp_pengguna'));
                $this->entryPenggunaLayananModel->insert([
                    'id_entry' => $id_entry,
                    'tanggal_entry' => date('Y-m-d H:i:s'),
                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                    'user_id' => $this->request->getVar('user_id'),
                    'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                    'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                    'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                ]);
            }
            echo "<script>
                alert('Data Berhasil Disimpan');
                window.location.href='/kelola-pengguna-layanan';
                </script>";
        }
    }

    // EDIT ENTRY PENGGUNA
    public function EditEntryPengguna($id_entry)
    {
        if (isset($this->session->akses)) {
            $detail_entry = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($id_entry);
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_entry['no_telp_pengguna']);
            $jenis_layanan = $this->jenisLayananModel->get_jenis_layanan();
            $data_user = $this->userModel->get_user();
            $data_pengguna_layanan = $this->penggunaLayananModel->get_pengguna_layanan();
            $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online_by_entry($id_entry);
            $data = [
                'jenis_layanan' => $jenis_layanan,
                'nama_page' => 'Edit Entry Pengguna Layanan',
                'nama_user' => $this->session->nama_unit_kerja,
                'data_user' => $data_user,
                'detail_entry' => $detail_entry,
                'jenis_akses' => $this->session->akses,
                'detail_pengguna' => $detail_pengguna,
                'data_pengguna_layanan' => $data_pengguna_layanan,
                'user_id' => $this->session->user_id,
                'detail_jadwal_konsultasi' => $detail_jadwal_konsultasi
            ];
            return view('kelola/kelola_entry_pengguna/edit_entry_pengguna', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveEditEntryPengguna()
    {
        if ($this->request->getVar('jenis_konsultasi') == 'Online') {
            if ($this->request->getVar('jadwal_konsultasi') != "" && $this->request->getVar('jam_konsultasi') != "") {
                $jadwal = $this->CekJadwalKonsultasiOnline();
                if ($jadwal == 'success') {
                    if ($this->session->akses == 'Admin') {
                        $tanggal_entry = explode("T", $this->request->getVar('tanggal_entry'));
                        $tanggal_entry = implode(" ", $tanggal_entry);
                        $this->entryPenggunaLayananModel->save([
                            'id_entry' => $this->request->getVar('id_entry'),
                            'tanggal_entry' => $tanggal_entry,
                            'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                            'user_id' => $this->request->getVar('user_id'),
                            'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                            'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                            'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                        ]);
                    } else {
                        $this->entryPenggunaLayananModel->save([
                            'id_entry' => $this->request->getVar('id_entry'),
                            'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                            'user_id' => $this->request->getVar('user_id'),
                            'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                            'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                            'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                        ]);
                    }
                    $penjadwalan = $this->SaveKonsultasiOnline();
                    if ($penjadwalan == 'success') {
                        echo "<script>
                            alert('Data Berhasil Disimpan');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                    } else {
                        echo "<script>
                            alert('Data Tidak Berhasil Disimpan');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                    }
                    echo "<script>
                        alert('Data Berhasil Disimpan');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                } else {
                    echo "<script>
                        alert('Data Tidak Berhasil Disimpan');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                }
            } else {
                echo "<script>
                    alert('Data Tidak Lengkap');
                    window.location.href='/tambah-entry-pengguna';
                    </script>";
            }
        } else {
            if ($this->session->akses == 'Admin') {
                $tanggal_entry = explode("T", $this->request->getVar('tanggal_entry'));
                $tanggal_entry = implode(" ", $tanggal_entry);
                $this->entryPenggunaLayananModel->save([
                    'id_entry' => $this->request->getVar('id_entry'),
                    'tanggal_entry' => $tanggal_entry,
                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                    'user_id' => $this->request->getVar('user_id'),
                    'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                    'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                    'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                ]);
                $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online_by_entry($this->request->getVar('id_entry'));
                $detail_entry_pengguna_layanan = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($this->request->getVar('id_entry'));
                $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_jadwal_konsultasi['no_telp_pengguna']);
                $detail_konsultan = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
                $detail_user = $this->userModel->get_detail_user($detail_jadwal_konsultasi['user_id']);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nJika Anda ingin melakukan Konsultasi Online kembali, silahkan input data diri Anda di: " . base_url('/tambah-entry-pengguna-umum') . "\n\nTerima kasih telah menggunakan layanan kami.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_jadwal_konsultasi['no_telp_pengguna'],
                    'nama' => $detail_pengguna['nama_pengguna'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nUntuk jadwal lainnya, silahkan lihat di: " . base_url('/') . "\n\nTerima kasih.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_konsultan['no_telp_representatif'],
                    'nama' => $detail_konsultan['nama_kepala'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_user['nama_unit_kerja'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nUntuk jadwal lainnya, silahkan lihat di: " . base_url('/') . "\n\nTerima kasih.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                    'nama' => $detail_user['nama_kepala'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $this->konsultasiOnlineModel->delete([
                    'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online')
                ]);
            } else {
                $this->entryPenggunaLayananModel->save([
                    'id_entry' => $this->request->getVar('id_entry'),
                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                    'user_id' => $this->request->getVar('user_id'),
                    'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                    'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                    'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                ]);
                $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online_by_entry($this->request->getVar('id_entry'));
                $detail_entry_pengguna_layanan = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($this->request->getVar('id_entry'));
                $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_jadwal_konsultasi['no_telp_pengguna']);
                $detail_konsultan = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
                $detail_user = $this->userModel->get_detail_user($detail_jadwal_konsultasi['user_id']);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nJika Anda ingin melakukan Konsultasi Online kembali, silahkan input data diri Anda di: " . base_url('/tambah-entry-pengguna-umum') . "\n\nTerima kasih telah menggunakan layanan kami.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_jadwal_konsultasi['no_telp_pengguna'],
                    'nama' => $detail_pengguna['nama_pengguna'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nUntuk jadwal lainnya, silahkan lihat di: " . base_url('/') . "\n\nTerima kasih.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_konsultan['no_telp_representatif'],
                    'nama' => $detail_konsultan['nama_kepala'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_user['nama_unit_kerja'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nUntuk jadwal lainnya, silahkan lihat di: " . base_url('/') . "\n\nTerima kasih.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                    'nama' => $detail_user['nama_kepala'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $this->konsultasiOnlineModel->delete([
                    'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online')
                ]);
            }
            echo "<script>
                alert('Data Berhasil Disimpan');
                window.location.href='/kelola-pengguna-layanan';
                </script>";
        }
    }

    // HAPUS ENTRY PENGGUNA
    public function HapusEntryPengguna($id_entry)
    {
        $detail_entry_pengguna_layanan = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($id_entry);
        if ($detail_entry_pengguna_layanan['jenis_konsultasi'] == 'Online') {
            $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online_by_entry($id_entry);
            if ($detail_jadwal_konsultasi['tanggal_konsultasi_online'] > date('Y-m-d')) {
                $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_jadwal_konsultasi['no_telp_pengguna']);
                $detail_konsultan = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
                $detail_user = $this->userModel->get_detail_user($detail_jadwal_konsultasi['user_id']);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nJika Anda ingin melakukan Konsultasi Online kembali, silahkan input data diri Anda di: " . base_url('/tambah-entry-pengguna-umum') . "\n\nTerima kasih telah menggunakan layanan kami.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $id_entry,
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_jadwal_konsultasi['no_telp_pengguna'],
                    'nama' => $detail_pengguna['nama_pengguna'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nUntuk jadwal lainnya, silahkan lihat di: " . base_url('/') . "\n\nTerima kasih.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $id_entry,
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_konsultan['no_telp_representatif'],
                    'nama' => $detail_konsultan['nama_kepala'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_user['nama_unit_kerja'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nUntuk jadwal lainnya, silahkan lihat di: " . base_url('/') . "\n\nTerima kasih.";
                $this->notifikasiModel->insert([
                    'id_broadcast' => $id_entry,
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                    'nama' => $detail_user['nama_kepala'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online_by_entry($id_entry);
                $this->entryPenggunaLayananModel->delete($id_entry);
                if ($detail_jadwal_konsultasi != null) {
                    $this->konsultasiOnlineModel->delete($detail_jadwal_konsultasi['id_konsultasi_online']);
                }
                echo "<script>
            alert('Data Berhasil Dihapus');
            window.location.href='/kelola-pengguna-layanan';
            </script>";
            } else {
                $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online_by_entry($id_entry);
                $this->entryPenggunaLayananModel->delete($id_entry);
                if ($detail_jadwal_konsultasi != null) {
                    $this->konsultasiOnlineModel->delete($detail_jadwal_konsultasi['id_konsultasi_online']);
                }
            }
        } else {
            $this->entryPenggunaLayananModel->delete($id_entry);
            echo "<script>
            alert('Data Berhasil Dihapus');
            window.location.href='/kelola-pengguna-layanan';
            </script>";
        }
    }

    // TAMBAH ENTRY PENGGUNA UNTUK PENGGUNA, BEBAS DIAKSES OLEH ORANG DILUAR SISTEM
    public function TambahEntryPenggunaUmum()
    {
        // SENDING NOTIFIKASI YANG BELUM
        $data_notifikasi = $this->notifikasiModel->get_data_notifikasi_belum();
        foreach ($data_notifikasi as $d) {
            if ($d['tanggal_kirim_notifikasi'] == date('Y-m-d')) {
                $detail_user = $this->userModel->get_detail_user($d['user_id']);
                $data = [
                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                    'nama' => $detail_user['nama_unit_kerja'],
                    'message' => $d['text_notifikasi'],
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $this->notifikasiModel->save([
                    'id_notifikasi' => $d['id_notifikasi'],
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
            }
        }
        $data_konsultasi_hari_ini = $this->konsultasiOnlineModel->get_data_konsultasi_online_per_tanggal();
        if (isset($data_konsultasi_hari_ini)) {
            foreach ($data_konsultasi_hari_ini as $d) :
                $jam = explode(":", $d['jam_konsultasi_online']);
                $jam_minus_1 = (int)$jam[0] - 1;
                $tanggal_dan_jam = $d['tanggal_konsultasi_online'] . " " . $jam_minus_1;
                $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($d['no_telp_pengguna']);
                $detail_konsultan = $this->userModel->get_detail_user($d['NIP']);
                $detail_notifikasi = $this->notifikasiModel->get_detail_notifikasi_pengingat($d['id_konsultasi_online']);
                if ($detail_notifikasi != null) {
                } else {
                    if ($tanggal_dan_jam == date('Y-m-d H')) {
                        $text_notifikasi = "*1 JAM LAGI KONSULTASI ANDA AKAN DIMULAI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nSegera persiapkan perangkat Anda untuk Konsultasi Online Bersama Konsultan kami di \nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $d['room_zoom'] . "\n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') . "/" . $d['id_entry'];
                        $this->notifikasiModel->insert([
                            'id_broadcast' => $d['id_konsultasi_online'],
                            'user_id' => '-',
                            'text_notifikasi' => $text_notifikasi,
                            'tanggal_kirim_notifikasi' => date('Y-m-d'),
                            'status_kirim_notifikasi' => 'Sudah',
                            'jenis_notifikasi' => 'Pengingat'
                        ]);
                        $data = [
                            'no_telp_pengguna' => $detail_konsultan['no_telp_representatif'],
                            'nama' => $detail_konsultan['nama_kepala'],
                            'message' => $text_notifikasi,
                            'subject' => "Notifikasi"
                        ];
                        $this->_sendWhatsapp($data);
                        $text_notifikasi = "*1 JAM LAGI KONSULTASI ANDA AKAN DIMULAI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nSegera persiapkan perangkat Anda untuk Konsultasi Online Bersama Konsultan kami di \nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $d['room_zoom'] . "\n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') . "/" . $d['id_entry'];
                        $data = [
                            'no_telp_pengguna' => $detail_pengguna['no_telp_pengguna'],
                            'nama' => $detail_pengguna['nama_pengguna'],
                            'message' => $text_notifikasi,
                            'subject' => "Notifikasi"
                        ];
                        $this->_sendWhatsapp($data);
                    }
                }
            endforeach;
        }
        $data = [
            'nama_page' => 'Tambah Entry Pengguna Umum',
            'nama_user' => $this->session->nama_unit_kerja,
            'jenis_akses' => $this->session->akses,
            'data_user' => $this->userModel->get_user(),
            'jenis_layanan' => $this->jenisLayananModel->get_jenis_layanan(),
            'user_id' => $this->session->user_id
        ];
        return view('kelola/kelola_entry_pengguna/tambah_entry_pengguna_umum', $data);
    }

    public function SaveTambahEntryPenggunaUmum()
    {
        if ($this->request->getVar('jenis_konsultasi') == 'Online') {
            if ($this->request->getVar('jadwal_konsultasi') != "") {
                $jadwal = $this->CekJadwalKonsultasiOnline();
                if ($jadwal == 'success') {
                    $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($this->request->getVar('no_telp_pengguna'));
                    if ($detail_pengguna != null) {
                        $this->penggunaLayananModel->save([
                            'email_pengguna' => $this->request->getVar('email_pengguna'),
                            'nama_pengguna' => $this->request->getVar('nama_pengguna'),
                            'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                            'instansi_asal_pengguna' => $this->request->getVar('instansi_asal_pengguna')
                        ]);
                    } else {
                        $this->penggunaLayananModel->insert([
                            'email_pengguna' => $this->request->getVar('email_pengguna'),
                            'nama_pengguna' => $this->request->getVar('nama_pengguna'),
                            'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                            'instansi_asal_pengguna' => $this->request->getVar('instansi_asal_pengguna')
                        ]);
                    }

                    $id_entry = md5(date('YmdHis') . "entry" . $this->request->getVar('no_telp_pengguna'));
                    $this->entryPenggunaLayananModel->insert([
                        'id_entry' => $id_entry,
                        'tanggal_entry' => date('Y-m-d H:i:s'),
                        'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                        'user_id' => $this->request->getVar('user_id'),
                        'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                        'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                        'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
                    ]);
                    $penjadwalan = $this->SaveKonsultasiOnline();
                    if ($penjadwalan == 'success') {
                        if (isset($this->session->akses)) {
                            echo "<script>
                            alert('Data Berhasil Disimpan');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                        } else {
                            echo "<script>
                            alert('Data Berhasil Disimpan, Jadwal Akan Diinformasikan via Whatsapp');
                            </script>";
                            return view('sukses/sukses_selamat_datang');
                        }
                    } else {
                        echo "<script>
                            alert('Data Tidak Berhasil Disimpan');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                    }
                    echo "<script>
                        alert('Data Berhasil Disimpan');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                } else {
                    echo "<script>
                        alert('Data Tidak Berhasil Disimpan');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                }
            } else {
                echo "<script>
                    alert('Data Tidak Lengkap');
                    window.location.href='/tambah-entry-pengguna';
                    </script>";
            }
        } else {
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($this->request->getVar('no_telp_pengguna'));
            if ($detail_pengguna != null) {
                $this->penggunaLayananModel->save([
                    'email_pengguna' => $this->request->getVar('email_pengguna'),
                    'nama_pengguna' => $this->request->getVar('nama_pengguna'),
                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                    'instansi_asal_pengguna' => $this->request->getVar('instansi_asal_pengguna')
                ]);
            } else {
                $this->penggunaLayananModel->insert([
                    'email_pengguna' => $this->request->getVar('email_pengguna'),
                    'nama_pengguna' => $this->request->getVar('nama_pengguna'),
                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                    'instansi_asal_pengguna' => $this->request->getVar('instansi_asal_pengguna')
                ]);
            }

            $id_entry = md5(date('YmdHis') . "entry" . $this->request->getVar('no_telp_pengguna'));
            $this->entryPenggunaLayananModel->insert([
                'id_entry' => $id_entry,
                'tanggal_entry' => date('Y-m-d H:i:s'),
                'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                'user_id' => $this->request->getVar('user_id'),
                'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                'perihal_konsultasi' => $this->request->getVar('perihal_konsultasi'),
                'jenis_konsultasi' => $this->request->getVar('jenis_konsultasi')
            ]);
            if (isset($this->session->akses)) {
                echo "<script>
                alert('Data Berhasil Disimpan');
                window.location.href='/kelola-pengguna-layanan';
                </script>";
            } else {
                return view('sukses/sukses_selamat_datang');
            }
        }
    }

    // DETAIL ENTRY PENGGUNA, BEBAS DIAKSES OLEH ORANG DILUAR SISTEM (SEBAGAI INFORMASI UNTUK MASYARAKAT UMUM)
    public function DetailEntryPengguna($id_entry)
    {
        // SENDING NOTIFIKASI YANG BELUM
        $data_notifikasi = $this->notifikasiModel->get_data_notifikasi_belum();
        foreach ($data_notifikasi as $d) {
            if ($d['tanggal_kirim_notifikasi'] == date('Y-m-d')) {
                $detail_user = $this->userModel->get_detail_user($d['user_id']);
                $data = [
                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                    'nama' => $detail_user['nama_unit_kerja'],
                    'message' => $d['text_notifikasi'],
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                $this->notifikasiModel->save([
                    'id_notifikasi' => $d['id_notifikasi'],
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
            }
        }
        $data_konsultasi_hari_ini = $this->konsultasiOnlineModel->get_data_konsultasi_online_per_tanggal();
        if (isset($data_konsultasi_hari_ini)) {
            foreach ($data_konsultasi_hari_ini as $d) :
                $jam = explode(":", $d['jam_konsultasi_online']);
                $jam_minus_1 = (int)$jam[0] - 1;
                $tanggal_dan_jam = $d['tanggal_konsultasi_online'] . " " . $jam_minus_1;
                $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($d['no_telp_pengguna']);
                $detail_konsultan = $this->userModel->get_detail_user($d['NIP']);
                $detail_notifikasi = $this->notifikasiModel->get_detail_notifikasi_pengingat($d['id_konsultasi_online']);
                if ($detail_notifikasi != null) {
                } else {
                    if ($tanggal_dan_jam == date('Y-m-d H')) {
                        $text_notifikasi = "*1 JAM LAGI KONSULTASI ANDA AKAN DIMULAI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nSegera persiapkan perangkat Anda untuk Konsultasi Online Bersama Konsultan kami di \nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $d['room_zoom'] . "\n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') . "/" . $d['id_entry'];
                        $this->notifikasiModel->insert([
                            'id_broadcast' => $d['id_konsultasi_online'],
                            'user_id' => '-',
                            'text_notifikasi' => $text_notifikasi,
                            'tanggal_kirim_notifikasi' => date('Y-m-d'),
                            'status_kirim_notifikasi' => 'Sudah',
                            'jenis_notifikasi' => 'Pengingat'
                        ]);
                        $data = [
                            'no_telp_pengguna' => $detail_konsultan['no_telp_representatif'],
                            'nama' => $detail_konsultan['nama_kepala'],
                            'message' => $text_notifikasi,
                            'subject' => "Notifikasi"
                        ];
                        $this->_sendWhatsapp($data);
                        $text_notifikasi = "*1 JAM LAGI KONSULTASI ANDA AKAN DIMULAI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nSegera persiapkan perangkat Anda untuk Konsultasi Online Bersama Konsultan kami di \nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $d['room_zoom'] . "\n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') . "/" . $d['id_entry'];
                        $data = [
                            'no_telp_pengguna' => $detail_pengguna['no_telp_pengguna'],
                            'nama' => $detail_pengguna['nama_pengguna'],
                            'message' => $text_notifikasi,
                            'subject' => "Notifikasi"
                        ];
                        $this->_sendWhatsapp($data);
                    }
                }
            endforeach;
        }

        $detail_entry_pengguna = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($id_entry);
        if ($detail_entry_pengguna != null) {
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_entry_pengguna['no_telp_pengguna']);
            if ($detail_pengguna != null) {
                $detail_user = $this->userModel->get_detail_user($detail_entry_pengguna['user_id']);
                if ($detail_user != null) {
                    if ($detail_entry_pengguna['jenis_konsultasi'] == 'Online') {
                        $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online_by_entry($id_entry);
                        if ($detail_jadwal_konsultasi != null) {
                            $detail_konsultan = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
                            if ($detail_konsultan != null) {
                                $data = [
                                    'nama_page' => 'Detail Entry Pengguna',
                                    'nama_user' => $this->session->nama_unit_kerja,
                                    'jenis_akses' => $this->session->akses,
                                    'detail_user' => $detail_user,
                                    'jenis_layanan' => $this->jenisLayananModel->get_jenis_layanan(),
                                    'user_id' => $this->session->user_id,
                                    'detail_entry_pengguna' => $detail_entry_pengguna,
                                    'detail_jadwal_konsultasi' => $detail_jadwal_konsultasi,
                                    'detail_konsultan' => $detail_konsultan,
                                    'detail_pengguna' => $detail_pengguna
                                ];
                                return view('kelola/kelola_entry_pengguna/detail_entry_pengguna', $data);
                            } else {
                                if (isset($this->session->akses)) {
                                    echo "<script>
                                        alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                                        window.location.href='/kelola-pengguna-layanan';
                                        </script>";
                                } else {
                                    echo "<script>
                                        alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                                        window.location.href='/login';
                                        </script>";
                                }
                            }
                        } else {
                            if (isset($this->session->akses)) {
                                echo "<script>
                                    alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                                    window.location.href='/kelola-pengguna-layanan';
                                    </script>";
                            } else {
                                echo "<script>
                                    alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                                    window.location.href='/login';
                                    </script>";
                            }
                        }
                    } else {
                        $data = [
                            'nama_page' => 'Detail Entry Pengguna',
                            'nama_user' => $this->session->nama_unit_kerja,
                            'jenis_akses' => $this->session->akses,
                            'detail_user' => $detail_user,
                            'jenis_layanan' => $this->jenisLayananModel->get_jenis_layanan(),
                            'user_id' => $this->session->user_id,
                            'detail_entry_pengguna' => $detail_entry_pengguna,
                            'detail_pengguna' => $detail_pengguna
                        ];
                        return view('kelola/kelola_entry_pengguna/detail_entry_pengguna', $data);
                    }
                } else {
                    if (isset($this->session->akses)) {
                        echo "<script>
                            alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                    } else {
                        echo "<script>
                            alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                            window.location.href='/login';
                            </script>";
                    }
                }
            } else {
                if (isset($this->session->akses)) {
                    echo "<script>
                        alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                } else {
                    echo "<script>
                        alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                        window.location.href='/login';
                        </script>";
                }
            }
        } else {
            if (isset($this->session->akses)) {
                echo "<script>
                    alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                    window.location.href='/kelola-pengguna-layanan';
                    </script>";
            } else {
                echo "<script>
                    alert('Data Entry Pengguna Telah Dihapus, Silahkan Kontak Helpdesk untuk informasi lebih lanjut https://wa.link/tekfds');
                    window.location.href='/login';
                    </script>";
            }
        }
    }

    // GETDATAPENGGUNA
    public function GetDataPengguna()
    {
        $no_telp_pengguna = $this->request->getPost("id");
        $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($no_telp_pengguna);
        if (isset($detail_pengguna)) {
            return $this->response->setJson($detail_pengguna);
        } else {
            $detail_pengguna = [
                'email_pengguna' => '',
                'no_telp_pengguna' => '',
                'nama_pengguna' => '',
                'instansi_asal_pengguna' => '',
                'id_entry' => '',
                'tanggal_entry' => '',
                'user_id' => '',
                'perihal_konsultasi' => '',
                'jenis_layanan' => '',
                'nama_unit_kerja' => '',
                'nama_kepala' => '',
                'nip_kepala' => '',
                'jenis_akses' => '',
                'password' => '',
                'no_telp_representatif' => ''
            ];
            return $this->response->setJson($detail_pengguna);
        }
    }

    private function _sendWhatsapp($data)
    {
        $token = "t30zy7uy2EwHWf2hsSb3";
        $curl = curl_init();
        if (isset($data['image'])) {
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $data['no_telp_pengguna'],
                    'message' => $data['message'],
                    'url' => $data['image']
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization:' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        } else {
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $data['no_telp_pengguna'],
                    'message' => $data['message']
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization:' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }
    }

    // CEK JADWAL DAN JAM
    public function CekJadwalKonsultasiOnline()
    {
        $id_entry = $this->request->getVar('id_entry');
        if ($this->request->getVar('tanggal_ditentukan') != null) {
            $tanggal_entry = date('Y-m-d H:i:s');
            $jadwal_konsultasi = $this->request->getVar('jadwal_konsultasi');
            $data_hari_libur = $this->hariLiburModel->get_hari_libur();
            foreach ($data_hari_libur as $h) :
                if ($h['tanggal_hari_libur'] == $jadwal_konsultasi) {
                    if (isset($this->session->akses)) {
                        if ($id_entry != null) {
                            echo "<script>
                            alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                            window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                            </script>";
                        } else {
                            echo "<script>
                            alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                        }
                    } else {
                        echo "<script>
                    alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                    window.location.href='/tambah-entry-pengguna-umum';
                    </script>";
                    }
                }
            endforeach;
            $day = date('D', strtotime($jadwal_konsultasi));
            if ($day == 'Sat' || $day == 'Sun') {
                if (isset($this->session->akses)) {
                    if ($id_entry != null) {
                        echo "<script>
                        alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                        window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                        </script>";
                    } else {
                        echo "<script>
                        alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                    }
                } else {
                    echo "<script>
                alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                window.location.href='/tambah-entry-pengguna-umum';
                </script>";
                }
            }
        } else {
            $tanggal_entry = explode("T", $this->request->getVar('tanggal_entry'));
            $tanggal_entry = $tanggal_entry[0] . " " . $tanggal_entry[1] . ":00";
            // $tanggal_entry = implode(" ", $tanggal_entry);
            $jadwal_konsultasi = $this->request->getVar('jadwal_konsultasi');
            $data_hari_libur = $this->hariLiburModel->get_hari_libur();
            foreach ($data_hari_libur as $h) :
                if ($h['tanggal_hari_libur'] == $jadwal_konsultasi) {
                    if (isset($this->session->akses)) {
                        if ($id_entry != null) {
                            echo "<script>
                            alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                            window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                            </script>";
                        } else {
                            echo "<script>
                            alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                        }
                    } else {
                        echo "<script>
                    alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                    window.location.href='/tambah-entry-pengguna-umum';
                    </script>";
                    }
                }
            endforeach;
            $day = date('D', strtotime($jadwal_konsultasi));
            if ($day == 'Sat' || $day == 'Sun') {
                if (isset($this->session->akses)) {
                    if ($id_entry != null) {
                        echo "<script>
                        alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                        window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                        </script>";
                    } else {
                        echo "<script>
                        alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                    }
                } else {
                    echo "<script>
                alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                window.location.href='/tambah-entry-pengguna-umum';
                </script>";
                }
            }
        }
        $jadwal_konsultasi = $this->request->getVar('jadwal_konsultasi');
        $jam_konsultasi = $this->request->getVar('jam_konsultasi');
        $user_id = $this->request->getVar('user_id');
        if (isset($id_entry)) {
        } else {
            $detail_entry = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan_by_tanggal_dan_no_telp($tanggal_entry, $this->request->getVar('no_telp_pengguna'));
            if ($detail_entry != null) {
                $id_entry = $detail_entry['id_entry'];
            } else {
                $id_entry = null;
            }
        }
        $data_konsultasi_online_user_per_tanggal = $this->konsultasiOnlineModel->get_data_konsultasi_online_user_per_tanggal($user_id, $jadwal_konsultasi);
        $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($this->request->getVar('no_telp_pengguna'));
        $detail_user = $this->userModel->get_detail_user($user_id);
        $jamisi[0] = 0;
        $jamisi[1] = 0;
        $jamisi[2] = 0;
        $a = 0;
        // liat  room zoom yang kosong
        $roomisi[0] = 0;
        $roomisi[1] = 0;
        $roomisi[2] = 0;
        $roomisi[3] = 0;
        $roomisi[4] = 0;
        $roomisi[5] = 0;
        $roomisi[6] = 0;
        $roomisi[7] = 0;
        $roomisi[8] = 0;
        $roomisi[9] = 0;
        $roomisi[10] = 0;
        $roomisi[11] = 0;
        $roomisi[12] = 0;
        $roomisi[13] = 0;
        $roomisi[14] = 0;
        $roomisi[15] = 0;
        $roomisi[16] = 0;
        $roomisi[17] = 0;
        $roomisi[18] = 0;
        $roomisi[19] = 0;
        $b = 0;
        foreach ($data_konsultasi_online_user_per_tanggal as $d) :
            if ($d['room_zoom'] == '1') {
                $roomisi[0] = $roomisi[0] + 1;
            } else if ($d['room_zoom'] == '2') {
                $roomisi[1] = $roomisi[1] + 1;
            } else if ($d['room_zoom'] == '3') {
                $roomisi[2] = $roomisi[2] + 1;
            } else if ($d['room_zoom'] == '4') {
                $roomisi[2] = $roomisi[3] + 1;
            } else if ($d['room_zoom'] == '5') {
                $roomisi[2] = $roomisi[4] + 1;
            } else if ($d['room_zoom'] == '6') {
                $roomisi[2] = $roomisi[5] + 1;
            } else if ($d['room_zoom'] == '7') {
                $roomisi[2] = $roomisi[6] + 1;
            } else if ($d['room_zoom'] == '8') {
                $roomisi[2] = $roomisi[7] + 1;
            } else if ($d['room_zoom'] == '9') {
                $roomisi[2] = $roomisi[8] + 1;
            } else if ($d['room_zoom'] == '10') {
                $roomisi[2] = $roomisi[9] + 1;
            } else if ($d['room_zoom'] == '11') {
                $roomisi[2] = $roomisi[10] + 1;
            } else if ($d['room_zoom'] == '12') {
                $roomisi[2] = $roomisi[11] + 1;
            } else if ($d['room_zoom'] == '13') {
                $roomisi[2] = $roomisi[12] + 1;
            } else if ($d['room_zoom'] == '14') {
                $roomisi[2] = $roomisi[13] + 1;
            } else if ($d['room_zoom'] == '15') {
                $roomisi[2] = $roomisi[14] + 1;
            } else if ($d['room_zoom'] == '16') {
                $roomisi[2] = $roomisi[15] + 1;
            } else if ($d['room_zoom'] == '17') {
                $roomisi[2] = $roomisi[16] + 1;
            } else if ($d['room_zoom'] == '18') {
                $roomisi[2] = $roomisi[17] + 1;
            } else if ($d['room_zoom'] == '19') {
                $roomisi[2] = $roomisi[18] + 1;
            } else if ($d['room_zoom'] == '20') {
                $roomisi[2] = $roomisi[19] + 1;
            }
        endforeach;
        if ($roomisi[0] < 1) {
            $roomkosong[$a] = '1';
            $b++;
        } else if ($roomisi[1] < 1) {
            $roomkosong[$a] = '2';
            $b++;
        } else if ($roomisi[2] < 1) {
            $roomkosong[$a] = '3';
            $b++;
        } else if ($roomisi[3] < 1) {
            $roomkosong[$a] = '4';
            $b++;
        } else if ($roomisi[4] < 1) {
            $roomkosong[$a] = '5';
            $b++;
        } else if ($roomisi[5] < 1) {
            $roomkosong[$a] = '6';
            $b++;
        } else if ($roomisi[6] < 1) {
            $roomkosong[$a] = '7';
            $b++;
        } else if ($roomisi[7] < 1) {
            $roomkosong[$a] = '8';
            $b++;
        } else if ($roomisi[8] < 1) {
            $roomkosong[$a] = '9';
            $b++;
        } else if ($roomisi[9] < 1) {
            $roomkosong[$a] = '10';
            $b++;
        } else if ($roomisi[10] < 1) {
            $roomkosong[$a] = '11';
            $b++;
        } else if ($roomisi[11] < 1) {
            $roomkosong[$a] = '12';
            $b++;
        } else if ($roomisi[12] < 1) {
            $roomkosong[$a] = '13';
            $b++;
        } else if ($roomisi[13] < 1) {
            $roomkosong[$a] = '14';
            $b++;
        } else if ($roomisi[14] < 1) {
            $roomkosong[$a] = '15';
            $b++;
        } else if ($roomisi[15] < 1) {
            $roomkosong[$a] = '16';
            $b++;
        } else if ($roomisi[16] < 1) {
            $roomkosong[$a] = '17';
            $b++;
        } else if ($roomisi[17] < 1) {
            $roomkosong[$a] = '18';
            $b++;
        } else if ($roomisi[18] < 1) {
            $roomkosong[$a] = '19';
            $b++;
        } else if ($roomisi[19] < 1) {
            $roomkosong[$a] = '20';
            $b++;
        }
        // NENTUKAN JAM KONSULTASI
        // cari dulu jam apa aja yang kosong
        foreach ($data_konsultasi_online_user_per_tanggal as $d) :
            if ($d['jam_konsultasi_online'] == '13:00:00') {
                $jamisi[0] = $jamisi[0] + 1;
            } else if ($d['jam_konsultasi_online'] == '14:00:00') {
                $jamisi[1] = $jamisi[1] + 1;
            } else if ($d['jam_konsultasi_online'] == '15:00:00') {
                $jamisi[2] = $jamisi[2] + 1;
            }
        endforeach;
        if ($jamisi[0] < 1) {
            $jamkosong[$a] = '13:00:00';
            $a++;
        } else if ($jamisi[1] < 1) {
            $jamkosong[$a] = '14:00:00';
            $a++;
        } else if ($jamisi[2] < 1) {
            $jamkosong[$a] = '15:00:00';
            $a++;
        }
        if ($jamisi[0] > 1) {
            $jamyangisi[$a] = '13:00:00';
            $a++;
        } else if ($jamisi[1] > 1) {
            $jamyangisi[$a] = '14:00:00';
            $a++;
        } else if ($jamisi[2] > 1) {
            $jamyangisi[$a] = '15:00:00';
            $a++;
        }
        if (isset($this->session->user_id)) {
            $user_id_notifikasi = $this->session->user_id;
        } else {
            $user_id_notifikasi = "-";
        }
        if (isset($jamkosong)) {
            return 'success';
        } else {
            if (isset($this->session->akses)) {
                if ($id_entry != null) {
                    echo "<script>
                    alert('Jadwal pada tanggal terpilih sudah penuh, silahkan pilih tanggal lain');
                    window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                    </script>";
                } else {
                    echo "<script>
                    alert('Jadwal pada tanggal terpilih sudah penuh, silahkan pilih tanggal lain');
                    window.location.href='/kelola-pengguna-layanan';
                    </script>";
                }
            } else {
                echo "<script>
                alert('Jadwal pada tanggal terpilih sudah penuh, silahkan pilih tanggal lain');
                window.location.href='/tambah-entry-pengguna-umum';
                </script>";
            }
        }
    }

    // SAVE KONSULTASI ONLINE
    public function SaveKonsultasiOnline()
    {
        // pertama get jadwal dulu, terus liat jadwal terakhir di hari yang diinginkan
        $id_entry = $this->request->getVar('id_entry');
        if ($this->request->getVar('tanggal_ditentukan') != null) {
            $tanggal_entry = date('Y-m-d H:i:s');
            $jadwal_konsultasi = $this->request->getVar('jadwal_konsultasi');
            $data_hari_libur = $this->hariLiburModel->get_hari_libur();
            foreach ($data_hari_libur as $h) :
                if ($h['tanggal_hari_libur'] == $jadwal_konsultasi) {
                    if (isset($this->session->akses)) {
                        if ($id_entry != null) {
                            echo "<script>
                            alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                            window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                            </script>";
                        } else {
                            echo "<script>
                            alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                        }
                    } else {
                        echo "<script>
                    alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                    window.location.href='/tambah-entry-pengguna-umum';
                    </script>";
                    }
                }
            endforeach;
            $day = date('D', strtotime($jadwal_konsultasi));
            if ($day == 'Sat' || $day == 'Sun') {
                if (isset($this->session->akses)) {
                    if ($id_entry != null) {
                        echo "<script>
                        alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                        window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                        </script>";
                    } else {
                        echo "<script>
                        alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                    }
                } else {
                    echo "<script>
                alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                window.location.href='/tambah-entry-pengguna-umum';
                </script>";
                }
            }
        } else {
            $tanggal_entry = explode("T", $this->request->getVar('tanggal_entry'));
            $tanggal_entry = $tanggal_entry[0] . " " . $tanggal_entry[1] . ":00";
            // $tanggal_entry = implode(" ", $tanggal_entry);
            $jadwal_konsultasi = $this->request->getVar('jadwal_konsultasi');
            $data_hari_libur = $this->hariLiburModel->get_hari_libur();
            foreach ($data_hari_libur as $h) :
                if ($h['tanggal_hari_libur'] == $jadwal_konsultasi) {
                    if (isset($this->session->akses)) {
                        if ($id_entry != null) {
                            echo "<script>
                            alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                            window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                            </script>";
                        } else {
                            echo "<script>
                            alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                            window.location.href='/kelola-pengguna-layanan';
                            </script>";
                        }
                    } else {
                        echo "<script>
                    alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                    window.location.href='/tambah-entry-pengguna-umum';
                    </script>";
                    }
                }
            endforeach;
            $day = date('D', strtotime($jadwal_konsultasi));
            if ($day == 'Sat' || $day == 'Sun') {
                if (isset($this->session->akses)) {
                    if ($id_entry != null) {
                        echo "<script>
                        alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                        window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                        </script>";
                    } else {
                        echo "<script>
                        alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                        window.location.href='/kelola-pengguna-layanan';
                        </script>";
                    }
                } else {
                    echo "<script>
                alert('Mohon maaf, tidak ada konsultasi pada tanggal tersebut, silahkan pilih tanggal lain');
                window.location.href='/tambah-entry-pengguna-umum';
                </script>";
                }
            }
        }
        $jadwal_konsultasi = $this->request->getVar('jadwal_konsultasi');
        $jam_konsultasi = $this->request->getVar('jam_konsultasi');
        $user_id = $this->request->getVar('user_id');
        if (isset($id_entry)) {
        } else {
            $detail_entry = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan_by_tanggal_dan_no_telp($tanggal_entry, $this->request->getVar('no_telp_pengguna'));
            if ($detail_entry != null) {
                $id_entry = $detail_entry['id_entry'];
            } else {
                $id_entry = null;
            }
        }
        $data_konsultasi_online_user_per_tanggal = $this->konsultasiOnlineModel->get_data_konsultasi_online_user_per_tanggal($user_id, $jadwal_konsultasi);
        $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($this->request->getVar('no_telp_pengguna'));
        $detail_user = $this->userModel->get_detail_user($user_id);
        $jamisi[0] = 0;
        $jamisi[1] = 0;
        $jamisi[2] = 0;
        $a = 0;
        // liat  room zoom yang kosong
        $roomisi[0] = 0;
        $roomisi[1] = 0;
        $roomisi[2] = 0;
        $roomisi[3] = 0;
        $roomisi[4] = 0;
        $roomisi[5] = 0;
        $roomisi[6] = 0;
        $roomisi[7] = 0;
        $roomisi[8] = 0;
        $roomisi[9] = 0;
        $roomisi[10] = 0;
        $roomisi[11] = 0;
        $roomisi[12] = 0;
        $roomisi[13] = 0;
        $roomisi[14] = 0;
        $roomisi[15] = 0;
        $roomisi[16] = 0;
        $roomisi[17] = 0;
        $roomisi[18] = 0;
        $roomisi[19] = 0;
        $b = 0;
        foreach ($data_konsultasi_online_user_per_tanggal as $d) :
            if ($d['room_zoom'] == '1') {
                $roomisi[0] = $roomisi[0] + 1;
            } else if ($d['room_zoom'] == '2') {
                $roomisi[1] = $roomisi[1] + 1;
            } else if ($d['room_zoom'] == '3') {
                $roomisi[2] = $roomisi[2] + 1;
            } else if ($d['room_zoom'] == '4') {
                $roomisi[2] = $roomisi[3] + 1;
            } else if ($d['room_zoom'] == '5') {
                $roomisi[2] = $roomisi[4] + 1;
            } else if ($d['room_zoom'] == '6') {
                $roomisi[2] = $roomisi[5] + 1;
            } else if ($d['room_zoom'] == '7') {
                $roomisi[2] = $roomisi[6] + 1;
            } else if ($d['room_zoom'] == '8') {
                $roomisi[2] = $roomisi[7] + 1;
            } else if ($d['room_zoom'] == '9') {
                $roomisi[2] = $roomisi[8] + 1;
            } else if ($d['room_zoom'] == '10') {
                $roomisi[2] = $roomisi[9] + 1;
            } else if ($d['room_zoom'] == '11') {
                $roomisi[2] = $roomisi[10] + 1;
            } else if ($d['room_zoom'] == '12') {
                $roomisi[2] = $roomisi[11] + 1;
            } else if ($d['room_zoom'] == '13') {
                $roomisi[2] = $roomisi[12] + 1;
            } else if ($d['room_zoom'] == '14') {
                $roomisi[2] = $roomisi[13] + 1;
            } else if ($d['room_zoom'] == '15') {
                $roomisi[2] = $roomisi[14] + 1;
            } else if ($d['room_zoom'] == '16') {
                $roomisi[2] = $roomisi[15] + 1;
            } else if ($d['room_zoom'] == '17') {
                $roomisi[2] = $roomisi[16] + 1;
            } else if ($d['room_zoom'] == '18') {
                $roomisi[2] = $roomisi[17] + 1;
            } else if ($d['room_zoom'] == '19') {
                $roomisi[2] = $roomisi[18] + 1;
            } else if ($d['room_zoom'] == '20') {
                $roomisi[2] = $roomisi[19] + 1;
            }
        endforeach;
        if ($roomisi[0] < 1) {
            $roomkosong[$a] = '1';
            $b++;
        } else if ($roomisi[1] < 1) {
            $roomkosong[$a] = '2';
            $b++;
        } else if ($roomisi[2] < 1) {
            $roomkosong[$a] = '3';
            $b++;
        } else if ($roomisi[3] < 1) {
            $roomkosong[$a] = '4';
            $b++;
        } else if ($roomisi[4] < 1) {
            $roomkosong[$a] = '5';
            $b++;
        } else if ($roomisi[5] < 1) {
            $roomkosong[$a] = '6';
            $b++;
        } else if ($roomisi[6] < 1) {
            $roomkosong[$a] = '7';
            $b++;
        } else if ($roomisi[7] < 1) {
            $roomkosong[$a] = '8';
            $b++;
        } else if ($roomisi[8] < 1) {
            $roomkosong[$a] = '9';
            $b++;
        } else if ($roomisi[9] < 1) {
            $roomkosong[$a] = '10';
            $b++;
        } else if ($roomisi[10] < 1) {
            $roomkosong[$a] = '11';
            $b++;
        } else if ($roomisi[11] < 1) {
            $roomkosong[$a] = '12';
            $b++;
        } else if ($roomisi[12] < 1) {
            $roomkosong[$a] = '13';
            $b++;
        } else if ($roomisi[13] < 1) {
            $roomkosong[$a] = '14';
            $b++;
        } else if ($roomisi[14] < 1) {
            $roomkosong[$a] = '15';
            $b++;
        } else if ($roomisi[15] < 1) {
            $roomkosong[$a] = '16';
            $b++;
        } else if ($roomisi[16] < 1) {
            $roomkosong[$a] = '17';
            $b++;
        } else if ($roomisi[17] < 1) {
            $roomkosong[$a] = '18';
            $b++;
        } else if ($roomisi[18] < 1) {
            $roomkosong[$a] = '19';
            $b++;
        } else if ($roomisi[19] < 1) {
            $roomkosong[$a] = '20';
            $b++;
        }
        // NENTUKAN JAM KONSULTASI
        // cari dulu jam apa aja yang kosong
        foreach ($data_konsultasi_online_user_per_tanggal as $d) :
            if ($d['jam_konsultasi_online'] == '13:00:00') {
                $jamisi[0] = $jamisi[0] + 1;
            } else if ($d['jam_konsultasi_online'] == '14:00:00') {
                $jamisi[1] = $jamisi[1] + 1;
            } else if ($d['jam_konsultasi_online'] == '15:00:00') {
                $jamisi[2] = $jamisi[2] + 1;
            }
        endforeach;
        if ($jamisi[0] < 1) {
            $jamkosong[$a] = '13:00:00';
            $a++;
        } else if ($jamisi[1] < 1) {
            $jamkosong[$a] = '14:00:00';
            $a++;
        } else if ($jamisi[2] < 1) {
            $jamkosong[$a] = '15:00:00';
            $a++;
        }
        if ($jamisi[0] > 1) {
            $jamyangisi[$a] = '13:00:00';
            $a++;
        } else if ($jamisi[1] > 1) {
            $jamyangisi[$a] = '14:00:00';
            $a++;
        } else if ($jamisi[2] > 1) {
            $jamyangisi[$a] = '15:00:00';
            $a++;
        }
        if (isset($this->session->user_id)) {
            $user_id_notifikasi = $this->session->user_id;
        } else {
            $user_id_notifikasi = "-";
        }
        if (isset($jamkosong)) {
            $jamkosong_implode = implode(", ", $jamkosong);
            if (isset($jam_konsultasi)) {
                $detail_notifikasi = $this->notifikasiModel->get_detail_notifikasi_by_broadcast($this->request->getVar('id_konsultasi_online'));
                $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online($this->request->getVar('id_konsultasi_online'));
                if ($jadwal_konsultasi == date('Y-m-d')) {
                    if ($jam_konsultasi > date('H:i:s')) {
                        if (isset($jamyangisi)) {
                            // INI KALAU JAM YANG ISI ADA (MAKSUDNYA HARI ITU, UDAH ADA JADWAL, TAPI KAN BELUM TAU JADWALNYA JAM BERAPA)
                            foreach ($jamyangisi as $j) :
                                if ($j == $jam_konsultasi) {
                                    echo "<script>
                                    alert('Jadwal Kosong untuk Konsultasi Hanya di " . $jamkosong_implode . " ');
                                    window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                                    </script>";
                                } else {
                                    if (isset($detail_jadwal_konsultasi)) {
                                        // INI KALAU EDIT JADWALNYAT
                                        $this->konsultasiOnlineModel->save([
                                            'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online'),
                                            'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                                            'user_id' => $this->request->getVar('user_id'),
                                            'tanggal_konsultasi_online' => $jadwal_konsultasi,
                                            'jam_konsultasi_online' => $jam_konsultasi,
                                            'id_entry' => $id_entry
                                        ]);

                                        if (isNull($detail_jadwal_konsultasi['NIP']) || $detail_jadwal_konsultasi['NIP'] == '111') {
                                            // INI UNTUK KASUBNYA LAGI TAPI UNTUK MENENTUKAN KONSULTAN
                                            $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Segera tentukan konsultan.* \nLebih lengkap di " . base_url('/');
                                            $this->notifikasiModel->insert([
                                                'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                                'user_id' => $user_id_notifikasi,
                                                'text_notifikasi' => $text_notifikasi,
                                                'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                                'status_kirim_notifikasi' => 'Sudah'
                                            ]);
                                            $data = [
                                                'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                                'nama' => $detail_user['nama_unit_kerja'],
                                                'message' => $text_notifikasi,
                                                'subject' => "Notifikasi"
                                            ];
                                            $this->_sendWhatsapp($data);
                                            return "success";
                                        } else {
                                            // INI UNTUK KASUBNYA
                                            $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di: " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                            $this->notifikasiModel->insert([
                                                'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                                'user_id' => $user_id_notifikasi,
                                                'text_notifikasi' => $text_notifikasi,
                                                'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                                'status_kirim_notifikasi' => 'Sudah'
                                            ]);
                                            $data = [
                                                'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                                'nama' => $detail_user['nama_unit_kerja'],
                                                'message' => $text_notifikasi,
                                                'subject' => "Notifikasi"
                                            ];
                                            $this->_sendWhatsapp($data);

                                            // INI UNTUK PEGAWAINYA
                                            $detail_pegawai = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
                                            $text_notifikasi = "Hai " . $detail_pegawai['nama_kepala'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di: " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                            $data = [
                                                'no_telp_pengguna' => $detail_pegawai['no_telp_representatif'],
                                                'nama' => $detail_pegawai['nama_kepala'],
                                                'message' => $text_notifikasi,
                                                'subject' => "Notifikasi"
                                            ];
                                            $this->_sendWhatsapp($data);
                                            return "success";

                                            // UNTUK PENGGUNA LAYANAN
                                            $text_notifikasi = "Hai " . $detail_pengguna['nama_pengguna'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pegawai['nama_kepala'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                            $this->notifikasiModel->insert([
                                                'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                                'user_id' => $user_id_notifikasi,
                                                'text_notifikasi' => $text_notifikasi,
                                                'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                                'status_kirim_notifikasi' => 'Sudah'
                                            ]);
                                            $data = [
                                                'no_telp_pengguna' => $detail_pengguna['no_telp_pengguna'],
                                                'nama' => $detail_pengguna['nama_pengguna'],
                                                'message' => $text_notifikasi,
                                                'subject' => "Notifikasi"
                                            ];
                                            $this->_sendWhatsapp($data);
                                        }
                                    } else {
                                        // INI KALAU TAMBAH JADWAL
                                        $id_konsultasi_online = md5(date('YmdHis') . $this->request->getVar('no_telp_pengguna'));
                                        $this->konsultasiOnlineModel->insert([
                                            'id_konsultasi_online' => $id_konsultasi_online,
                                            'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                                            'user_id' => $this->request->getVar('user_id'),
                                            'NIP' => '111',
                                            'tanggal_konsultasi_online' => $jadwal_konsultasi,
                                            'jam_konsultasi_online' => $jamkosong[0],
                                            'id_entry' => $id_entry,
                                            'room_zoom' => $roomkosong[0]
                                        ]);

                                        // INI UNTUK KASUBNYA
                                        $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Jadwal Pertemuan* dengan " . $detail_pengguna['nama_pengguna'] . " pada tanggal " . $jadwal_konsultasi . " pukul " . $jamkosong[0] . " \n*Segera tentukan konsultan.* \nLebih lengkap di: " . base_url('/');
                                        $this->notifikasiModel->insert([
                                            'id_broadcast' => $id_konsultasi_online,
                                            'user_id' => $user_id_notifikasi,
                                            'text_notifikasi' => $text_notifikasi,
                                            'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                            'status_kirim_notifikasi' => 'Sudah'
                                        ]);
                                        $data = [
                                            'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                            'nama' => $detail_user['nama_unit_kerja'],
                                            'message' => $text_notifikasi,
                                            'subject' => "Notifikasi"
                                        ];
                                        $this->_sendWhatsapp($data);
                                        return "success";
                                    }
                                }
                            endforeach;
                        } else {
                            // INI KALAU BENER-BENER GAADA JADWAL HARI ITU
                            if (isset($detail_jadwal_konsultasi)) {
                                // INI KALAU EDIT JADWAL
                                $this->konsultasiOnlineModel->save([
                                    'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online'),
                                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                                    'user_id' => $this->request->getVar('user_id'),
                                    'tanggal_konsultasi_online' => $jadwal_konsultasi,
                                    'jam_konsultasi_online' => $jam_konsultasi,
                                    'id_entry' => $id_entry
                                ]);
                                if (isNull($detail_jadwal_konsultasi['NIP']) || $detail_jadwal_konsultasi['NIP'] == '111') {
                                    // INI UNTUK KASUBNYA, MINTA SEGERA TENTUKAN KONSULTAN
                                    $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Segera tentukan konsultan.* \nLebih lengkap di " . base_url('/');
                                    $this->notifikasiModel->insert([
                                        'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                        'user_id' => $user_id_notifikasi,
                                        'text_notifikasi' => $text_notifikasi,
                                        'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                        'status_kirim_notifikasi' => 'Sudah'
                                    ]);
                                    $data = [
                                        'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                        'nama' => $detail_user['nama_unit_kerja'],
                                        'message' => $text_notifikasi,
                                        'subject' => "Notifikasi"
                                    ];
                                    $this->_sendWhatsapp($data);
                                    return "success";
                                } else {
                                    // INI UNTUK KASUBNYA
                                    $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di: " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                    $this->notifikasiModel->insert([
                                        'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                        'user_id' => $user_id_notifikasi,
                                        'text_notifikasi' => $text_notifikasi,
                                        'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                        'status_kirim_notifikasi' => 'Sudah'
                                    ]);
                                    $data = [
                                        'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                        'nama' => $detail_user['nama_unit_kerja'],
                                        'message' => $text_notifikasi,
                                        'subject' => "Notifikasi"
                                    ];
                                    $this->_sendWhatsapp($data);

                                    // INI UNTUK PEGAWAINYA
                                    $detail_pegawai = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
                                    $text_notifikasi = "Hai " . $detail_pegawai['nama_kepala'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di: " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                    $data = [
                                        'no_telp_pengguna' => $detail_pegawai['no_telp_representatif'],
                                        'nama' => $detail_pegawai['nama_kepala'],
                                        'message' => $text_notifikasi,
                                        'subject' => "Notifikasi"
                                    ];
                                    $this->_sendWhatsapp($data);
                                    return "success";

                                    // UNTUK PENGGUNA LAYANAN
                                    $text_notifikasi = "Hai " . $detail_pengguna['nama_pengguna'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pegawai['nama_kepala'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                    $this->notifikasiModel->insert([
                                        'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                        'user_id' => $user_id_notifikasi,
                                        'text_notifikasi' => $text_notifikasi,
                                        'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                        'status_kirim_notifikasi' => 'Sudah'
                                    ]);
                                    $data = [
                                        'no_telp_pengguna' => $detail_pengguna['no_telp_pengguna'],
                                        'nama' => $detail_pengguna['nama_pengguna'],
                                        'message' => $text_notifikasi,
                                        'subject' => "Notifikasi"
                                    ];
                                    $this->_sendWhatsapp($data);
                                }
                            } else {
                                // INI YANG TAMBAH BARU
                                $id_konsultasi_online = md5(date('YmdHis') . $this->request->getVar('no_telp_pengguna'));
                                $this->konsultasiOnlineModel->insert([
                                    'id_konsultasi_online' => $id_konsultasi_online,
                                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                                    'user_id' => $this->request->getVar('user_id'),
                                    'NIP' => '111',
                                    'tanggal_konsultasi_online' => $jadwal_konsultasi,
                                    'jam_konsultasi_online' => $jamkosong[0],
                                    'id_entry' => $id_entry,
                                    'room_zoom' => $roomkosong[0]
                                ]);

                                // UNTUK KASUBNYA
                                $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Jadwal Pertemuan* dengan " . $detail_pengguna['nama_pengguna'] . " pada tanggal " . $jadwal_konsultasi . " pukul " . $jamkosong[0] . ". \n*Segera tentukan konsultan.* \nLebih lengkap di: " . base_url('/');
                                $this->notifikasiModel->insert([
                                    'id_broadcast' => $id_konsultasi_online,
                                    'user_id' => $user_id_notifikasi,
                                    'text_notifikasi' => $text_notifikasi,
                                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                    'status_kirim_notifikasi' => 'Sudah'
                                ]);
                                $data = [
                                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                    'nama' => $detail_user['nama_unit_kerja'],
                                    'message' => $text_notifikasi,
                                    'subject' => "Notifikasi"
                                ];
                                $this->_sendWhatsapp($data);
                                return "success";
                            }
                        }
                    } else {
                        echo "<script>
                        alert('Pilih jadwal kosong di atas jam saat ini');
                        window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                        </script>";
                    }
                } else {
                    if (isset($jamyangisi)) {
                        // INI KALAU JAM YANG ISI ADA (MAKSUDNYA HARI ITU, UDAH ADA JADWAL, TAPI KAN BELUM TAU JADWALNYA JAM BERAPA)
                        foreach ($jamyangisi as $j) :
                            if ($j == $jam_konsultasi) {
                                echo "<script>
                                    alert('Jadwal Kosong untuk Konsultasi Hanya di " . $jamkosong_implode . " ');
                                    window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                                    </script>";
                            } else {
                                if (isset($detail_jadwal_konsultasi)) {
                                    // INI KALAU EDIT JADWALNYAT
                                    $this->konsultasiOnlineModel->save([
                                        'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online'),
                                        'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                                        'user_id' => $this->request->getVar('user_id'),
                                        'tanggal_konsultasi_online' => $jadwal_konsultasi,
                                        'jam_konsultasi_online' => $jam_konsultasi,
                                        'id_entry' => $id_entry
                                    ]);

                                    if (isNull($detail_jadwal_konsultasi['NIP']) || $detail_jadwal_konsultasi['NIP'] == '111') {
                                        // INI UNTUK KASUBNYA LAGI TAPI UNTUK MENENTUKAN KONSULTAN
                                        $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Segera tentukan konsultan.* \nLebih lengkap di " . base_url('/');
                                        $this->notifikasiModel->insert([
                                            'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                            'user_id' => $user_id_notifikasi,
                                            'text_notifikasi' => $text_notifikasi,
                                            'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                            'status_kirim_notifikasi' => 'Sudah'
                                        ]);
                                        $data = [
                                            'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                            'nama' => $detail_user['nama_unit_kerja'],
                                            'message' => $text_notifikasi,
                                            'subject' => "Notifikasi"
                                        ];
                                        $this->_sendWhatsapp($data);
                                        return "success";
                                    } else {
                                        // INI UNTUK KASUBNYA
                                        $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di: " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                        $this->notifikasiModel->insert([
                                            'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                            'user_id' => $user_id_notifikasi,
                                            'text_notifikasi' => $text_notifikasi,
                                            'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                            'status_kirim_notifikasi' => 'Sudah'
                                        ]);
                                        $data = [
                                            'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                            'nama' => $detail_user['nama_unit_kerja'],
                                            'message' => $text_notifikasi,
                                            'subject' => "Notifikasi"
                                        ];
                                        $this->_sendWhatsapp($data);

                                        // INI UNTUK PEGAWAINYA
                                        $detail_pegawai = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
                                        $text_notifikasi = "Hai " . $detail_pegawai['nama_kepala'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di: " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                        $data = [
                                            'no_telp_pengguna' => $detail_pegawai['no_telp_representatif'],
                                            'nama' => $detail_pegawai['nama_kepala'],
                                            'message' => $text_notifikasi,
                                            'subject' => "Notifikasi"
                                        ];
                                        $this->_sendWhatsapp($data);
                                        return "success";

                                        // UNTUK PENGGUNA LAYANAN
                                        $text_notifikasi = "Hai " . $detail_pengguna['nama_pengguna'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pegawai['nama_kepala'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                        $this->notifikasiModel->insert([
                                            'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                            'user_id' => $user_id_notifikasi,
                                            'text_notifikasi' => $text_notifikasi,
                                            'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                            'status_kirim_notifikasi' => 'Sudah'
                                        ]);
                                        $data = [
                                            'no_telp_pengguna' => $detail_pengguna['no_telp_pengguna'],
                                            'nama' => $detail_pengguna['nama_pengguna'],
                                            'message' => $text_notifikasi,
                                            'subject' => "Notifikasi"
                                        ];
                                        $this->_sendWhatsapp($data);
                                    }
                                } else {
                                    // INI KALAU TAMBAH JADWAL
                                    $id_konsultasi_online = md5(date('YmdHis') . $this->request->getVar('no_telp_pengguna'));
                                    $this->konsultasiOnlineModel->insert([
                                        'id_konsultasi_online' => $id_konsultasi_online,
                                        'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                                        'user_id' => $this->request->getVar('user_id'),
                                        'NIP' => '111',
                                        'tanggal_konsultasi_online' => $jadwal_konsultasi,
                                        'jam_konsultasi_online' => $jamkosong[0],
                                        'id_entry' => $id_entry,
                                        'room_zoom' => $roomkosong[0]
                                    ]);

                                    // INI UNTUK KASUBNYA
                                    $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Jadwal Pertemuan* dengan " . $detail_pengguna['nama_pengguna'] . " pada tanggal " . $jadwal_konsultasi . " pukul " . $jamkosong[0] . " \n*Segera tentukan konsultan.* \nLebih lengkap di: " . base_url('/');
                                    $this->notifikasiModel->insert([
                                        'id_broadcast' => $id_konsultasi_online,
                                        'user_id' => $user_id_notifikasi,
                                        'text_notifikasi' => $text_notifikasi,
                                        'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                        'status_kirim_notifikasi' => 'Sudah'
                                    ]);
                                    $data = [
                                        'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                        'nama' => $detail_user['nama_unit_kerja'],
                                        'message' => $text_notifikasi,
                                        'subject' => "Notifikasi"
                                    ];
                                    $this->_sendWhatsapp($data);
                                    return "success";
                                }
                            }
                        endforeach;
                    } else {
                        // INI KALAU BENER-BENER GAADA JADWAL HARI ITU
                        if (isset($detail_jadwal_konsultasi)) {
                            // INI KALAU EDIT JADWAL
                            $this->konsultasiOnlineModel->save([
                                'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online'),
                                'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                                'user_id' => $this->request->getVar('user_id'),
                                'tanggal_konsultasi_online' => $jadwal_konsultasi,
                                'jam_konsultasi_online' => $jam_konsultasi,
                                'id_entry' => $id_entry
                            ]);
                            if (isNull($detail_jadwal_konsultasi['NIP']) || $detail_jadwal_konsultasi['NIP'] == '111') {
                                // INI UNTUK KASUBNYA, MINTA SEGERA TENTUKAN KONSULTAN
                                $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Segera tentukan konsultan.* \nLebih lengkap di " . base_url('/');
                                $this->notifikasiModel->insert([
                                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                    'user_id' => $user_id_notifikasi,
                                    'text_notifikasi' => $text_notifikasi,
                                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                    'status_kirim_notifikasi' => 'Sudah'
                                ]);
                                $data = [
                                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                    'nama' => $detail_user['nama_unit_kerja'],
                                    'message' => $text_notifikasi,
                                    'subject' => "Notifikasi"
                                ];
                                $this->_sendWhatsapp($data);
                                return "success";
                            } else {
                                // INI UNTUK KASUBNYA
                                $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di: " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                $this->notifikasiModel->insert([
                                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                    'user_id' => $user_id_notifikasi,
                                    'text_notifikasi' => $text_notifikasi,
                                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                    'status_kirim_notifikasi' => 'Sudah'
                                ]);
                                $data = [
                                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                    'nama' => $detail_user['nama_unit_kerja'],
                                    'message' => $text_notifikasi,
                                    'subject' => "Notifikasi"
                                ];
                                $this->_sendWhatsapp($data);

                                // INI UNTUK PEGAWAINYA
                                $detail_pegawai = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
                                $text_notifikasi = "Hai " . $detail_pegawai['nama_kepala'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pengguna['nama_pengguna'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di: " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                $data = [
                                    'no_telp_pengguna' => $detail_pegawai['no_telp_representatif'],
                                    'nama' => $detail_pegawai['nama_kepala'],
                                    'message' => $text_notifikasi,
                                    'subject' => "Notifikasi"
                                ];
                                $this->_sendWhatsapp($data);
                                return "success";

                                // UNTUK PENGGUNA LAYANAN
                                $text_notifikasi = "Hai " . $detail_pengguna['nama_pengguna'] . "! \nAda *Perubahan Jadwal Pertemuan* antara Anda dengan " . $detail_pegawai['nama_kepala'] . " yang sebelumnya tanggal " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " jam " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " menjadi tanggal *" . $jadwal_konsultasi . " pukul " . $jam_konsultasi . "*. \n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap di " . base_url('/detail-entry-pengguna/') . "/" . $detail_jadwal_konsultasi['id_entry'];
                                $this->notifikasiModel->insert([
                                    'id_broadcast' => $this->request->getVar('id_konsultasi_online'),
                                    'user_id' => $user_id_notifikasi,
                                    'text_notifikasi' => $text_notifikasi,
                                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                    'status_kirim_notifikasi' => 'Sudah'
                                ]);
                                $data = [
                                    'no_telp_pengguna' => $detail_pengguna['no_telp_pengguna'],
                                    'nama' => $detail_pengguna['nama_pengguna'],
                                    'message' => $text_notifikasi,
                                    'subject' => "Notifikasi"
                                ];
                                $this->_sendWhatsapp($data);
                            }
                        } else {
                            // INI YANG TAMBAH BARU
                            $id_konsultasi_online = md5(date('YmdHis') . $this->request->getVar('no_telp_pengguna'));
                            $this->konsultasiOnlineModel->insert([
                                'id_konsultasi_online' => $id_konsultasi_online,
                                'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                                'user_id' => $this->request->getVar('user_id'),
                                'NIP' => '111',
                                'tanggal_konsultasi_online' => $jadwal_konsultasi,
                                'jam_konsultasi_online' => $jamkosong[0],
                                'id_entry' => $id_entry,
                                'room_zoom' => $roomkosong[0]
                            ]);

                            // UNTUK KASUBNYA
                            $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Jadwal Pertemuan* dengan " . $detail_pengguna['nama_pengguna'] . " pada tanggal " . $jadwal_konsultasi . " pukul " . $jamkosong[0] . ". \n*Segera tentukan konsultan.* \nLebih lengkap di: " . base_url('/');
                            $this->notifikasiModel->insert([
                                'id_broadcast' => $id_konsultasi_online,
                                'user_id' => $user_id_notifikasi,
                                'text_notifikasi' => $text_notifikasi,
                                'tanggal_kirim_notifikasi' => date('Y-m-d'),
                                'status_kirim_notifikasi' => 'Sudah'
                            ]);
                            $data = [
                                'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                                'nama' => $detail_user['nama_unit_kerja'],
                                'message' => $text_notifikasi,
                                'subject' => "Notifikasi"
                            ];
                            $this->_sendWhatsapp($data);
                            return "success";
                        }
                    }
                }
            } else {
                // INI KALAU DIA NGGAK NGEDIT (GA MILIH JAM KONSULTASI)
                $id_konsultasi_online = md5(date('YmdHis') . $this->request->getVar('no_telp_pengguna'));
                $this->konsultasiOnlineModel->insert([
                    'id_konsultasi_online' => $id_konsultasi_online,
                    'no_telp_pengguna' => $this->request->getVar('no_telp_pengguna'),
                    'user_id' => $this->request->getVar('user_id'),
                    'NIP' => '111',
                    'tanggal_konsultasi_online' => $jadwal_konsultasi,
                    'jam_konsultasi_online' => $jamkosong[0],
                    'id_entry' => $id_entry,
                    'room_zoom' => $roomkosong[0]
                ]);

                // UNTUK KASUBNYA
                $text_notifikasi = "Hai " . $detail_user['nama_unit_kerja'] . "! \nAda *Jadwal Pertemuan* dengan " . $detail_pengguna['nama_pengguna'] . " pada tanggal " . $jadwal_konsultasi . " pukul " . $jamkosong[0] . ". \n*Segera tentukan konsultan*. \nLebih lengkap di: " . base_url('/');
                $this->notifikasiModel->insert([
                    'id_broadcast' => $id_konsultasi_online,
                    'user_id' => $user_id_notifikasi,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => date('Y-m-d'),
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
                $data = [
                    'no_telp_pengguna' => $detail_user['no_telp_representatif'],
                    'nama' => $detail_user['nama_unit_kerja'],
                    'message' => $text_notifikasi,
                    'subject' => "Notifikasi"
                ];
                $this->_sendWhatsapp($data);
                return "success";
            }
        } else {
            if (isset($this->session->akses)) {
                if ($id_entry != null) {
                    echo "<script>
                    alert('Jadwal pada tanggal terpilih sudah penuh, silahkan pilih tanggal lain');
                    window.location.href='/edit-entry-pengguna/" . $id_entry . "';
                    </script>";
                } else {
                    echo "<script>
                    alert('Jadwal pada tanggal terpilih sudah penuh, silahkan pilih tanggal lain');
                    window.location.href='/kelola-pengguna-layanan';
                    </script>";
                }
            } else {
                echo "<script>
                alert('Jadwal pada tanggal terpilih sudah penuh, silahkan pilih tanggal lain');
                window.location.href='/tambah-entry-pengguna-umum';
                </script>";
            }
        }

        // INI DARI EDIT ENTRY PENGGUNA OLEH DUTA LAYANAN
    }
}
