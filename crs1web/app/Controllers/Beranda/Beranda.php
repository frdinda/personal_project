<?php

namespace App\Controllers\Beranda;

use App\Controllers\BaseController;
use App\Models\BroadcastModel;
use App\Models\EntryPenggunaLayananModel;
use App\Models\PenggunaLayananModel;
use App\Models\NotifikasiModel;
use App\Models\KonsultasiOnlineModel;
use App\Models\UserModel;
use App\Models\JenisLayananModel;

class Beranda extends BaseController
{

    protected $broadcastModel;
    protected $entryPenggunaLayananModel;
    protected $penggunaLayananModel;
    protected $notifikasiModel;
    protected $konsultasiOnlineModel;
    protected $userModel;
    protected $jenisLayananModel;

    public function __construct()
    {
        $this->broadcastModel = new BroadcastModel();
        $this->entryPenggunaLayananModel = new EntryPenggunaLayananModel();
        $this->penggunaLayananModel = new PenggunaLayananModel();
        $this->notifikasiModel = new NotifikasiModel();
        $this->konsultasiOnlineModel = new KonsultasiOnlineModel();
        $this->userModel = new UserModel();
        $this->jenisLayananModel = new JenisLayananModel();
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
        $akses = $this->session->akses;
        if (isset($akses)) {
            $data_entry_pengguna = $this->entryPenggunaLayananModel->get_entry_pengguna_layanan();
            $data_entry_hitungan = $this->HitungEntry();
            $data_broadcast_hitungan = $this->HitungBroadcast();
            $data_jenis_layanan_hitungan = $this->HitungJenisLayanan();
            $data_konsultasi_online_selesai = $this->HitungKonsultasiOnline();
            if ($this->session->akses == 'Unit Kerja') {
                $data_broadcast_terkirim = $this->broadcastModel->get_detail_broadcast_sudah_kirim_total_unit_kerja($this->session->user_id);
                $jumlah_broadcast_belum_terkirim = $this->broadcastModel->get_detail_broadcast_belum_kirim_total_unit_kerja($this->session->user_id);
                $jumlah_broadcast_total = $this->broadcastModel->get_data_broadcast_unit_kerja($this->session->user_id);
            } else {
                $data_broadcast_terkirim = $this->broadcastModel->get_detail_broadcast_sudah_kirim_total();
                $jumlah_broadcast_belum_terkirim = $this->broadcastModel->get_detail_broadcast_belum_kirim_total();
                $jumlah_broadcast_total = $this->broadcastModel->get_data_broadcast();
            }
            $data = [
                'nama_page' => 'Beranda',
                'nama_user' => $this->session->nama_unit_kerja,
                'jumlah_entry_pertahun' => $data_entry_hitungan['jumlah_entry_pertahun'],
                'jumlah_entry_perbulan' => $data_entry_hitungan['jumlah_entry_perbulan'],
                'jumlah_entry_perhari' => $data_entry_hitungan['jumlah_entry_perhari'],
                'jumlah_entry_total' => count($data_entry_pengguna),
                'jumlah_broadcast_terkirim' => count($this->broadcastModel->get_detail_broadcast_sudah_kirim_total()),
                'jumlah_broadcast_belum_terkirim' => count($this->broadcastModel->get_detail_broadcast_belum_kirim_total()),
                'jumlah_broadcast_total' => count($this->broadcastModel->get_data_broadcast()),
                'json_jumlah_entry_bulanan' => $data_entry_hitungan['json_jumlah_entry_bulanan'],
                'json_jumlah_broadcast' => $data_broadcast_hitungan['json_jumlah_broadcast_bulanan'],
                'json_jumlah_broadcast_whatsapp' => $data_broadcast_hitungan['json_jumlah_broadcast_whatsapp_bulanan'],
                'json_jumlah_broadcast_email' => $data_broadcast_hitungan['json_jumlah_broadcast_email_bulanan'],
                'json_data_jenis_layanan' => $data_jenis_layanan_hitungan['json_data_jenis_layanan'],
                'json_jumlah_per_jenis_layanan' => $data_jenis_layanan_hitungan['json_jumlah_per_jenis_layanan'],
                'json_warna_jenis_layanan' => $data_jenis_layanan_hitungan['json_warna_jenis_layanan'],
                'json_jumlah_konsultasi_online' => $data_konsultasi_online_selesai['json_jumlah_konsultasi_online'],
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id,
                'data_jenis_layanan' => $this->jenisLayananModel->get_jenis_layanan()
            ];

            return view('beranda/beranda', $data);
        } else {
            return redirect()->to('/login');
        }
    }

    // HITUNG ENTRY
    public function HitungEntry()
    {
        $data_entry_pengguna = $this->entryPenggunaLayananModel->get_entry_pengguna_layanan();
        $jumlah_entry_pertahun = 0;
        $jumlah_entry_perbulan = 0;
        $jumlah_entry_perhari = 0;
        $je_jan = 0;
        $je_feb = 0;
        $je_mar = 0;
        $je_apr = 0;
        $je_mei = 0;
        $je_jun = 0;
        $je_jul = 0;
        $je_ags = 0;
        $je_sep = 0;
        $je_oct = 0;
        $je_nov = 0;
        $je_des = 0;
        foreach ($data_entry_pengguna as $d) :
            // INI HARUS DIUPDATE BERARTI PER TAHUN
            if (strtotime($d['tanggal_entry']) < strtotime('2023-12-31 23:59:59') && strtotime($d['tanggal_entry']) > strtotime('2023-01-01 00:00:01')) {
                $jumlah_entry_pertahun++;
                $tanggal = explode("-", $d['tanggal_entry']);
                if ($tanggal[0] == date('Y')) {
                    if ($tanggal[1] == date('m')) {
                        $jumlah_entry_perbulan++;
                        $tanggal_spesifik = explode(" ", $d['tanggal_entry']);
                        if ($tanggal_spesifik[0] == date('Y-m-d')) {
                            $jumlah_entry_perhari++;
                        }
                    }
                    if ($tanggal[1] == '01') {
                        $je_jan++;
                    } else if ($tanggal[1] == '02') {
                        $je_feb++;
                    } else if ($tanggal[1] == '03') {
                        $je_mar++;
                    } else if ($tanggal[1] == '04') {
                        $je_apr++;
                    } else if ($tanggal[1] == '05') {
                        $je_mei++;
                    } else if ($tanggal[1] == '06') {
                        $je_jun++;
                    } else if ($tanggal[1] == '07') {
                        $je_jul++;
                    } else if ($tanggal[1] == '08') {
                        $je_ags++;
                    } else if ($tanggal[1] == '09') {
                        $je_sep++;
                    } else if ($tanggal[1] == '10') {
                        $je_oct++;
                    } else if ($tanggal[1] == '11') {
                        $je_nov++;
                    } else if ($tanggal[1] == '12') {
                        $je_des++;
                    }
                }
            }
        endforeach;
        for ($i = 0; $i < 12; $i++) {
            if ($i == 0) {
                $jumlah_entry_bulanan[$i] = $je_jan;
            } else if ($i == 1) {
                $jumlah_entry_bulanan[$i] = $je_feb;
            } else if ($i == 2) {
                $jumlah_entry_bulanan[$i] = $je_mar;
            } else if ($i == 3) {
                $jumlah_entry_bulanan[$i] = $je_apr;
            } else if ($i == 4) {
                $jumlah_entry_bulanan[$i] = $je_mei;
            } else if ($i == 5) {
                $jumlah_entry_bulanan[$i] = $je_jun;
            } else if ($i == 6) {
                $jumlah_entry_bulanan[$i] = $je_jul;
            } else if ($i == 7) {
                $jumlah_entry_bulanan[$i] = $je_ags;
            } else if ($i == 8) {
                $jumlah_entry_bulanan[$i] = $je_sep;
            } else if ($i == 9) {
                $jumlah_entry_bulanan[$i] = $je_oct;
            } else if ($i == 10) {
                $jumlah_entry_bulanan[$i] = $je_nov;
            } else if ($i == 11) {
                $jumlah_entry_bulanan[$i] = $je_des;
            }
        }
        $json_jumlah_entry_bulanan = json_encode($jumlah_entry_bulanan);
        $data = [
            'jumlah_entry_pertahun' => $jumlah_entry_pertahun,
            'jumlah_entry_perbulan' => $jumlah_entry_perbulan,
            'jumlah_entry_perhari' => $jumlah_entry_perhari,
            'json_jumlah_entry_bulanan' => $json_jumlah_entry_bulanan
        ];
        return $data;
    }

    // HITUNG BROADCAST
    public function HitungBroadcast()
    {
        $be_jan = 0;
        $be_feb = 0;
        $be_mar = 0;
        $be_apr = 0;
        $be_mei = 0;
        $be_jun = 0;
        $be_jul = 0;
        $be_ags = 0;
        $be_sep = 0;
        $be_oct = 0;
        $be_nov = 0;
        $be_des = 0;
        $bw_jan = 0;
        $bw_feb = 0;
        $bw_mar = 0;
        $bw_apr = 0;
        $bw_mei = 0;
        $bw_jun = 0;
        $bw_jul = 0;
        $bw_ags = 0;
        $bw_sep = 0;
        $bw_oct = 0;
        $bw_nov = 0;
        $bw_des = 0;
        if ($this->session->akses == 'Unit Kerja') {
            $data_broadcast = $this->broadcastModel->get_detail_broadcast_sudah_kirim_total_unit_kerja($this->session->user_id);
        } else {
            $data_broadcast = $this->broadcastModel->get_detail_broadcast_sudah_kirim_total();
        }
        foreach ($data_broadcast as $d) :
            if ($d['platform_broadcast'] == 'Whatsapp') {
                $tanggal = explode("-", $d['tanggal_broadcast']);
                if ($tanggal[0] == date('Y')) {
                    if ($tanggal[1] == '01') {
                        $bw_jan++;
                    } else if ($tanggal[1] == '02') {
                        $bw_feb++;
                    } else if ($tanggal[1] == '03') {
                        $bw_mar++;
                    } else if ($tanggal[1] == '04') {
                        $bw_apr++;
                    } else if ($tanggal[1] == '05') {
                        $bw_mei++;
                    } else if ($tanggal[1] == '06') {
                        $bw_jun++;
                    } else if ($tanggal[1] == '07') {
                        $bw_jul++;
                    } else if ($tanggal[1] == '08') {
                        $bw_ags++;
                    } else if ($tanggal[1] == '09') {
                        $bw_sep++;
                    } else if ($tanggal[1] == '10') {
                        $bw_oct++;
                    } else if ($tanggal[1] == '11') {
                        $bw_nov++;
                    } else if ($tanggal[1] == '12') {
                        $bw_des++;
                    }
                }
            } else if ($d['platform_broadcast'] == 'Email') {
                $tanggal = explode("-", $d['tanggal_broadcast']);
                if ($tanggal[0] == date('Y')) {
                    if ($tanggal[1] == '01') {
                        $be_jan++;
                    } else if ($tanggal[1] == '02') {
                        $be_feb++;
                    } else if ($tanggal[1] == '03') {
                        $be_mar++;
                    } else if ($tanggal[1] == '04') {
                        $be_apr++;
                    } else if ($tanggal[1] == '05') {
                        $be_mei++;
                    } else if ($tanggal[1] == '06') {
                        $be_jun++;
                    } else if ($tanggal[1] == '07') {
                        $be_jul++;
                    } else if ($tanggal[1] == '08') {
                        $be_ags++;
                    } else if ($tanggal[1] == '09') {
                        $be_sep++;
                    } else if ($tanggal[1] == '10') {
                        $be_oct++;
                    } else if ($tanggal[1] == '11') {
                        $be_nov++;
                    } else if ($tanggal[1] == '12') {
                        $be_des++;
                    }
                }
            }
        endforeach;
        for ($i = 0; $i < 12; $i++) {
            if ($i == 0) {
                $jumlah_broadcast_bulanan[$i] = $bw_jan + $be_jan;
            } else if ($i == 1) {
                $jumlah_broadcast_bulanan[$i] = $bw_feb + $be_feb;
            } else if ($i == 2) {
                $jumlah_broadcast_bulanan[$i] = $bw_mar + $be_mar;
            } else if ($i == 3) {
                $jumlah_broadcast_bulanan[$i] = $bw_apr + $be_apr;
            } else if ($i == 4) {
                $jumlah_broadcast_bulanan[$i] = $bw_mei + $be_mei;
            } else if ($i == 5) {
                $jumlah_broadcast_bulanan[$i] = $bw_jun + $be_jun;
            } else if ($i == 6) {
                $jumlah_broadcast_bulanan[$i] = $bw_jul + $be_jul;
            } else if ($i == 7) {
                $jumlah_broadcast_bulanan[$i] = $bw_ags + $be_ags;
            } else if ($i == 8) {
                $jumlah_broadcast_bulanan[$i] = $bw_sep + $be_sep;
            } else if ($i == 9) {
                $jumlah_broadcast_bulanan[$i] = $bw_oct + $be_oct;
            } else if ($i == 10) {
                $jumlah_broadcast_bulanan[$i] = $bw_nov + $be_nov;
            } else if ($i == 11) {
                $jumlah_broadcast_bulanan[$i] = $bw_des + $be_des;
            }
        }
        for ($i = 0; $i < 12; $i++) {
            if ($i == 0) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_jan;
            } else if ($i == 1) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_feb;
            } else if ($i == 2) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_mar;
            } else if ($i == 3) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_apr;
            } else if ($i == 4) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_mei;
            } else if ($i == 5) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_jun;
            } else if ($i == 6) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_jul;
            } else if ($i == 7) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_ags;
            } else if ($i == 8) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_sep;
            } else if ($i == 9) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_oct;
            } else if ($i == 10) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_nov;
            } else if ($i == 11) {
                $jumlah_broadcast_whatsapp_bulanan[$i] = $bw_des;
            }
        }
        for ($i = 0; $i < 12; $i++) {
            if ($i == 0) {
                $jumlah_broadcast_email_bulanan[$i] = $be_jan;
            } else if ($i == 1) {
                $jumlah_broadcast_email_bulanan[$i] = $be_feb;
            } else if ($i == 2) {
                $jumlah_broadcast_email_bulanan[$i] = $be_mar;
            } else if ($i == 3) {
                $jumlah_broadcast_email_bulanan[$i] = $be_apr;
            } else if ($i == 4) {
                $jumlah_broadcast_email_bulanan[$i] = $be_mei;
            } else if ($i == 5) {
                $jumlah_broadcast_email_bulanan[$i] = $be_jun;
            } else if ($i == 6) {
                $jumlah_broadcast_email_bulanan[$i] = $be_jul;
            } else if ($i == 7) {
                $jumlah_broadcast_email_bulanan[$i] = $be_ags;
            } else if ($i == 8) {
                $jumlah_broadcast_email_bulanan[$i] = $be_sep;
            } else if ($i == 9) {
                $jumlah_broadcast_email_bulanan[$i] = $be_oct;
            } else if ($i == 10) {
                $jumlah_broadcast_email_bulanan[$i] = $be_nov;
            } else if ($i == 11) {
                $jumlah_broadcast_email_bulanan[$i] = $be_des;
            }
        }
        $json_jumlah_broadcast_email_bulanan = json_encode($jumlah_broadcast_email_bulanan);
        $json_jumlah_broadcast_whatsapp_bulanan = json_encode($jumlah_broadcast_whatsapp_bulanan);
        $json_jumlah_broadcast_bulanan = json_encode($jumlah_broadcast_bulanan);
        $data = [
            'json_jumlah_broadcast_email_bulanan' => $json_jumlah_broadcast_email_bulanan,
            'json_jumlah_broadcast_whatsapp_bulanan' => $json_jumlah_broadcast_whatsapp_bulanan,
            'json_jumlah_broadcast_bulanan' => $json_jumlah_broadcast_bulanan
        ];
        return $data;
    }

    // HITUNG ENTRY PER JENIS LAYANAN
    public function HitungJenisLayanan()
    {
        $data_jenis_layanan = $this->jenisLayananModel->get_jenis_layanan();
        $data_entry_pengguna = $this->entryPenggunaLayananModel->get_entry_pengguna_layanan();
        $a = 0;
        for ($i = 0; $i < count($data_jenis_layanan); $i++) {
            $jumlah_per_jenis_layanan[$i] = 0;
            $data_jenis_layanan_chart[$i] = $data_jenis_layanan[$i]['jenis_layanan'];
            $warna_jenis_layanan[$i] = $data_jenis_layanan[$i]['warna_jenis_layanan'];
        }
        foreach ($data_jenis_layanan as $j) :
            foreach ($data_entry_pengguna as $e) :
                if ($j['jenis_layanan'] == $e['jenis_layanan']) {
                    $jumlah_per_jenis_layanan[$a] = $jumlah_per_jenis_layanan[$a] + 1;
                }
            endforeach;
            $a++;
        endforeach;
        $json_data_jenis_layanan = json_encode($data_jenis_layanan_chart);
        $json_jumlah_per_jenis_layanan = json_encode($jumlah_per_jenis_layanan);
        $json_warna_jenis_layanan = json_encode($warna_jenis_layanan);
        $data = [
            'json_data_jenis_layanan' => $json_data_jenis_layanan,
            'json_jumlah_per_jenis_layanan' => $json_jumlah_per_jenis_layanan,
            'json_warna_jenis_layanan' => $json_warna_jenis_layanan
        ];
        return $data;
    }

    // HITUNG KONSULTASI ONLINE
    public function HitungKonsultasiOnline()
    {
        $data_konsultasi_online = $this->konsultasiOnlineModel->get_data_konsultasi_online();
        $ko_jan = 0;
        $ko_feb = 0;
        $ko_mar = 0;
        $ko_apr = 0;
        $ko_mei = 0;
        $ko_jun = 0;
        $ko_jul = 0;
        $ko_ags = 0;
        $ko_sep = 0;
        $ko_oct = 0;
        $ko_nov = 0;
        $ko_des = 0;

        foreach ($data_konsultasi_online as $d) :
            if ($d['status_jalan_konsultasi'] == 'Selesai' || $d['status_jalan_konsultasi'] == 'Pengguna Layanan Tidak Join') {
                $bulan = explode("-", $d['tanggal_konsultasi_online']);
                if ($bulan[0] == '2023') {
                    if ($bulan[1] == '01') {
                        $ko_jan++;
                    } else if ($bulan[1] == '02') {
                        $ko_feb++;
                    } else if ($bulan[1] == '03') {
                        $ko_mar++;
                    } else if ($bulan[1] == '04') {
                        $ko_apr++;
                    } else if ($bulan[1] == '05') {
                        $ko_mei++;
                    } else if ($bulan[1] == '06') {
                        $ko_jun++;
                    } else if ($bulan[1] == '07') {
                        $ko_jul++;
                    } else if ($bulan[1] == '08') {
                        $ko_ags++;
                    } else if ($bulan[1] == '09') {
                        $ko_sep++;
                    } else if ($bulan[1] == '10') {
                        $ko_oct++;
                    } else if ($bulan[1] == '11') {
                        $ko_nov++;
                    } else if ($bulan[1] == '12') {
                        $ko_des++;
                    }
                }
            }
        endforeach;
        for ($i = 0; $i < 12; $i++) {
            if ($i == 0) {
                $jumlah_konsultasi_online[$i] = $ko_jan;
            } else if ($i == 1) {
                $jumlah_konsultasi_online[$i] = $ko_feb;
            } else if ($i == 2) {
                $jumlah_konsultasi_online[$i] = $ko_mar;
            } else if ($i == 3) {
                $jumlah_konsultasi_online[$i] = $ko_apr;
            } else if ($i == 4) {
                $jumlah_konsultasi_online[$i] = $ko_mei;
            } else if ($i == 5) {
                $jumlah_konsultasi_online[$i] = $ko_jun;
            } else if ($i == 6) {
                $jumlah_konsultasi_online[$i] = $ko_jul;
            } else if ($i == 7) {
                $jumlah_konsultasi_online[$i] = $ko_ags;
            } else if ($i == 8) {
                $jumlah_konsultasi_online[$i] = $ko_sep;
            } else if ($i == 9) {
                $jumlah_konsultasi_online[$i] = $ko_oct;
            } else if ($i == 10) {
                $jumlah_konsultasi_online[$i] = $ko_nov;
            } else if ($i == 11) {
                $jumlah_konsultasi_online[$i] = $ko_des;
            }
        }
        $json_jumlah_konsultasi_online = json_encode($jumlah_konsultasi_online);
        $data = [
            'json_jumlah_konsultasi_online' => $json_jumlah_konsultasi_online
        ];
        return $data;
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
