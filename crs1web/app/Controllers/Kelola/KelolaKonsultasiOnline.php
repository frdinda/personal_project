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

class KelolaKonsultasiOnline extends BaseController
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

    public function index()
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
                        $text_notifikasi = "*1 JAM LAGI KONSULTASI ANDA AKAN DIMULAI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nSegera persiapkan perangkat Anda untuk Konsultasi Online Bersama Konsultan kami di \nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $d['room_zoom'] . "\n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') . "/" . $d['id_entry'];
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
                        $text_notifikasi = "*1 JAM LAGI KONSULTASI ANDA AKAN DIMULAI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nSegera persiapkan perangkat Anda untuk Konsultasi Online Bersama Konsultan kami di \nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $d['room_zoom'] . "\n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') . "/" . $d['id_entry'];
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
            $data_konsultasi = $this->konsultasiOnlineModel->get_data_konsultasi_online();
            $data_pengguna = $this->penggunaLayananModel->get_pengguna_layanan();
            $data_konsultan = $this->userModel->get_user();
            $data = [
                'data_konsultasi' => $data_konsultasi,
                'nama_page' => 'Kelola Konsultasi Online',
                'nama_user' => $this->session->nama_unit_kerja,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id,
                'data_pengguna' => $data_pengguna,
                'data_konsultan' => $data_konsultan
            ];
            return view('kelola/kelola_konsultasi_online/kelola_konsultasi_online', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    // EDIT KONSULTASI ONLINE
    public function EditKonsultasiOnline($id_konsultasi_online)
    {
        if (isset($this->session->akses)) {
            $data = [
                'detail_jadwal_konsultasi' => $this->konsultasiOnlineModel->get_detail_konsultasi_online_join($id_konsultasi_online),
                'data_user' => $this->userModel->get_user(),
                'nama_page' => 'Edit Konsultasi Online',
                'nama_user' => $this->session->nama_unit_kerja,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
            ];
            return view('kelola/kelola_konsultasi_online/edit_konsultasi_online', $data);
        }
    }

    public function SaveEditKonsultasiOnline()
    {
        if ($this->session->akses == 'Pegawai' || $this->session->akses == 'Unit Kerja') {
            $this->konsultasiOnlineModel->save([
                'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online'),
                'NIP' => $this->request->getVar('NIP')
            ]);
            $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online($this->request->getVar('id_konsultasi_online'));
            $detail_entry_pengguna_layanan = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($detail_jadwal_konsultasi['id_entry']);
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_jadwal_konsultasi['no_telp_pengguna']);
            $detail_konsultan = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
            $text_notifikasi = "*JADWAL KONSULTASI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nBerikut Jadwal Konsultasi Anda \nTanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . "\nPukul: " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . "\nKonsultan: " . $detail_konsultan['nama_kepala'] . "\nPerihal Konsultasi: " . $detail_entry_pengguna_layanan['perihal_konsultasi'] . "\nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $detail_jadwal_konsultasi['room_zoom'] . "\n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') .  "/" . $detail_jadwal_konsultasi['id_entry'];
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
            $text_notifikasi = "*JADWAL KONSULTASI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nBerikut Jadwal Konsultasi Anda \nTanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . "\nPukul: " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . "\nNama Pengguna Layanan: " . $detail_pengguna['nama_pengguna'] . "\nPerihal Konsultasi: " . $detail_entry_pengguna_layanan['perihal_konsultasi'] . "\nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $detail_jadwal_konsultasi['room_zoom'] . "\n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') .  "/" . $detail_jadwal_konsultasi['id_entry'];
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
        } else if ($this->session->akses == 'Admin') {
            $this->konsultasiOnlineModel->save([
                'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online'),
                'NIP' => $this->request->getVar('NIP'),
                'room_zoom' => $this->request->getVar('room_zoom')
            ]);
            $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online($this->request->getVar('id_konsultasi_online'));
            $detail_entry_pengguna_layanan = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($detail_jadwal_konsultasi['id_entry']);
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_jadwal_konsultasi['no_telp_pengguna']);
            $detail_konsultan = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
            $text_notifikasi = "*JADWAL KONSULTASI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nBerikut Jadwal Konsultasi Anda \nTanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . "\nPukul: " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . "\nKonsultan: " . $detail_konsultan['nama_kepala'] . "\nPerihal Konsultasi: " . $detail_entry_pengguna_layanan['perihal_konsultasi'] . "\nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $detail_jadwal_konsultasi['room_zoom'] . "\n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') .  "/" . $detail_jadwal_konsultasi['id_entry'];
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
            $text_notifikasi = "*JADWAL KONSULTASI* \n\nHai " . $detail_konsultan['nama_kepala'] . "! \nBerikut Jadwal Konsultasi Anda \nTanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . "\nPukul: " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . "\nNama Pengguna Layanan: " . $detail_pengguna['nama_pengguna'] . "\nPerihal Konsultasi: " . $detail_entry_pengguna_layanan['perihal_konsultasi'] . "\nLink Zoom: https://us02web.zoom.us/j/83302667995?pwd=V1VCMkZocW1lMUdtNGsyTzRRaC9wdz09 \nRoom Zoom: " . $detail_jadwal_konsultasi['room_zoom'] . "\n*Harap hadir pada waktu yang telah ditentukan, jadwal akan hangus jika Anda terlambat 15 menit.* \n\nLebih lengkap dapat dilihat pada: " . base_url('/detail-entry-pengguna/') .  "/" . $detail_jadwal_konsultasi['id_entry'];
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
        }
        echo "<script>
            alert('Data Berhasil Tersimpan');
            window.location.href='/kelola-konsultasi-online';
            </script>";
    }

    // HAPUS KONSULTASI ONLINE
    public function HapusKonsultasiOnline($id_konsultasi_online)
    {
        $detail_jadwal_konsultasi = $this->konsultasiOnlineModel->get_detail_konsultasi_online($id_konsultasi_online);
        if ($detail_jadwal_konsultasi['tanggal_konsultasi_online'] > date('Y-m-d')) {
            $detail_entry_pengguna_layanan = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($detail_jadwal_konsultasi['id_entry']);
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_jadwal_konsultasi['no_telp_pengguna']);
            $detail_konsultan = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
            $detail_user = $this->userModel->get_detail_user($detail_jadwal_konsultasi['user_id']);
            $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nJika Anda ingin melakukan Konsultasi Online kembali, silahkan input data diri Anda di: " . base_url('/tambah-entry-pengguna-umum') . "\n\nTerima kasih telah menggunakan layanan kami.";
            $this->notifikasiModel->insert([
                'id_broadcast' => $id_konsultasi_online,
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
                'id_broadcast' => $id_konsultasi_online,
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
            $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_user['nama_kepala'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nUntuk jadwal lainnya, silahkan lihat di: " . base_url('/') . "\n\nTerima kasih.";
            $this->notifikasiModel->insert([
                'id_broadcast' => $id_konsultasi_online,
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
            $this->entryPenggunaLayananModel->save([
                'id_entry' => $detail_jadwal_konsultasi['id_entry'],
                'jenis_konsultasi' => 'Langsung'
            ]);
            $this->konsultasiOnlineModel->delete($id_konsultasi_online);
            echo "<script>
            alert('Data Berhasil Dihapus dan Jenis Konsultasi diubah menjadi Langsung');
            window.location.href='/kelola-konsultasi-online';
            </script>";
        } else if ($detail_jadwal_konsultasi['tanggal_konsultasi_online'] == date('Y-m-d') && $detail_jadwal_konsultasi['jam_konsultasi_online'] > date('H:i:s')) {
            $detail_entry_pengguna_layanan = $this->entryPenggunaLayananModel->get_detail_entry_pengguna_layanan($detail_jadwal_konsultasi['id_entry']);
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($detail_jadwal_konsultasi['no_telp_pengguna']);
            $detail_konsultan = $this->userModel->get_detail_user($detail_jadwal_konsultasi['NIP']);
            $detail_user = $this->userModel->get_detail_user($detail_jadwal_konsultasi['user_id']);
            $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_pengguna['nama_pengguna'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nJika Anda ingin melakukan Konsultasi Online kembali, silahkan input data diri Anda di: " . base_url('/tambah-entry-pengguna-umum') . "\n\nTerima kasih telah menggunakan layanan kami.";
            $this->notifikasiModel->insert([
                'id_broadcast' => $id_konsultasi_online,
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
                'id_broadcast' => $id_konsultasi_online,
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
            $text_notifikasi = "*PERUBAHAN JADWAL KONSULTASI* \n\nHai " . $detail_user['nama_kepala'] . "! \nJadwal konsultasi Anda pada tanggal: " . $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online'] . " *dibatalkan* \n\nUntuk jadwal lainnya, silahkan lihat di: " . base_url('/') . "\n\nTerima kasih.";
            $this->notifikasiModel->insert([
                'id_broadcast' => $id_konsultasi_online,
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
            $this->entryPenggunaLayananModel->save([
                'id_entry' => $detail_jadwal_konsultasi['id_entry'],
                'jenis_konsultasi' => 'Langsung'
            ]);
            $this->konsultasiOnlineModel->delete($id_konsultasi_online);
            echo "<script>
            alert('Data Berhasil Dihapus dan Jenis Konsultasi diubah menjadi Langsung');
            window.location.href='/kelola-konsultasi-online';
            </script>";
        } else {
            $this->entryPenggunaLayananModel->save([
                'id_entry' => $detail_jadwal_konsultasi['id_entry'],
                'jenis_konsultasi' => 'Langsung'
            ]);
            $this->konsultasiOnlineModel->delete($id_konsultasi_online);
            echo "<script>
            alert('Data Berhasil Dihapus dan Jenis Konsultasi diubah menjadi Langsung');
            window.location.href='/kelola-konsultasi-online';
            </script>";
        }
    }

    // SAVE FEEDBACK KONSULTASI ONLINE
    public function SaveFeedbackKonsultasiOnline()
    {
        $this->konsultasiOnlineModel->save([
            'id_konsultasi_online' => $this->request->getVar('id_konsultasi_online'),
            'status_jalan_konsultasi' => $this->request->getVar('status_jalan_konsultasi'),
            'feedback_jalan_konsultasi' => $this->request->getVar('feedback_jalan_konsultasi')
        ]);
        echo "<script>
            alert('Data Berhasil Tersimpan');
            window.location.href='/detail-entry-pengguna/" . $this->request->getVar('id_entry') . "';
            </script>";
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
}
