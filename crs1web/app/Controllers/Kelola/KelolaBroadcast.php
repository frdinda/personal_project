<?php

namespace App\Controllers\Kelola;

use App\Controllers\BaseController;
use App\Models\PenggunaLayananModel;
use App\Models\JenisLayananModel;
use App\Models\UserModel;
use App\Models\EntryPenggunaLayananModel;
use App\Models\BroadcastModel;
use App\Models\NotifikasiModel;
use App\Models\KonsultasiOnlineModel;

class KelolaBroadcast extends BaseController
{
    protected $penggunaLayananModel;
    protected $jenisLayananModel;
    protected $userModel;
    protected $entryPenggunaLayananModel;
    protected $broadcastModel;
    protected $notifikasiModel;
    protected $konsultasiOnlineModel;

    public function __construct()
    {
        $this->penggunaLayananModel = new PenggunaLayananModel();
        $this->jenisLayananModel = new JenisLayananModel();
        $this->userModel = new UserModel();
        $this->entryPenggunaLayananModel = new EntryPenggunaLayananModel();
        $this->broadcastModel = new BroadcastModel();
        $this->notifikasiModel = new NotifikasiModel();
        $this->konsultasiOnlineModel = new KonsultasiOnlineModel();
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
        if (isset($this->session->akses)) {
            if ($this->session->akses == 'Unit Kerja') {
                $data_broadcast = $this->broadcastModel->get_data_broadcast_unit_kerja($this->session->user_id);
                $data = [
                    'data_broadcast' => $data_broadcast,
                    'nama_page' => 'Kelola Broadcast',
                    'nama_user' => $this->session->nama_unit_kerja,
                    'jenis_akses' => $this->session->akses,
                    'user_id' => $this->session->user_id
                ];
                return view('kelola/kelola_broadcast/kelola_broadcast', $data);
            } else {
                $data_broadcast = $this->broadcastModel->get_data_broadcast();
                $data = [
                    'data_broadcast' => $data_broadcast,
                    'nama_page' => 'Kelola Broadcast',
                    'nama_user' => $this->session->nama_unit_kerja,
                    'jenis_akses' => $this->session->akses,
                    'user_id' => $this->session->user_id
                ];
                return view('kelola/kelola_broadcast/kelola_broadcast', $data);
            }
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    // TAMBAH BROADCAST
    public function TambahBroadcast()
    {
        if (isset($this->session->akses)) {
            $data_user = $this->userModel->get_user();
            $jenis_layanan = $this->jenisLayananModel->get_jenis_layanan();
            $detail_user = $this->userModel->get_detail_user($this->session->user_id);
            $data = [
                'jenis_layanan' => $jenis_layanan,
                'nama_page' => 'Tambah Broadcast',
                'nama_user' => $this->session->nama_unit_kerja,
                'data_user' => $data_user,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id,
                'nama_unit_kerja' => $detail_user['nama_unit_kerja']
            ];
            return view('kelola/kelola_broadcast/tambah_broadcast', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveTambahBroadcast()
    {
        if (isset($this->session->akses)) {
            $tujuan_broadcast = $this->request->getVar('tujuan_broadcast[]');
            $id_broadcast = md5($this->request->getVar('user_id') . $this->request->getVar('platform_broadcast')) . date('YmdHis');
            if (strtotime($this->request->getVar('tanggal_broadcast')) <= date('Y-m-d H:i:s')) {
                $this->broadcastModel->insert([
                    'id_broadcast' => $id_broadcast,
                    'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                    'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                    'user_id' => $this->request->getVar('user_id'),
                    'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                    'text_broadcast' => $this->request->getVar('text_broadcast'),
                    'status_terkirim' => 'Belum',
                    'tujuan_broadcast' => implode(",", $tujuan_broadcast),
                    'thumbnail_broadcast' => $this->request->getVar('thumbnail_broadcast')
                ]);
                echo "<script>
                alert('Data Berhasil Tersimpan');
                window.location.href='/detail-broadcast/" . $id_broadcast . "';
                </script>";
            } else {
                $this->broadcastModel->insert([
                    'id_broadcast' => $id_broadcast,
                    'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                    'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                    'user_id' => $this->request->getVar('user_id'),
                    'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                    'text_broadcast' => $this->request->getVar('text_broadcast'),
                    'status_terkirim' => 'Belum',
                    'tujuan_broadcast' => implode(",", $tujuan_broadcast),
                    'thumbnail_broadcast' => $this->request->getVar('thumbnail_broadcast')
                ]);
                $delimiters = ["T", " ", "="];
                $new_tanggal_broadcast = str_replace($delimiters, $delimiters[1], $this->request->getVar('tanggal_broadcast'));
                $text_notifikasi = "Hai " . $this->session->nama_unit_kerja . "! \n\nAda broadcast dengan judul " . $this->request->getVar('judul_broadcast') . " untuk tanggal " . $new_tanggal_broadcast . " yang *belum dikirim* nih. Yuk, segera kirim di " . base_url('/');
                $this->notifikasiModel->insert([
                    'id_broadcast' => $id_broadcast,
                    'user_id' => $this->session->user_id,
                    'text_notifikasi' => $text_notifikasi,
                    'tanggal_kirim_notifikasi' => $this->request->getVar('tanggal_broadcast'),
                    'status_kirim_notifikasi' => 'Belum'
                ]);
                echo "<script>
                alert('Data Berhasil Tersimpan');
                window.location.href='/kelola-broadcast';
                </script>";
            }
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    // EDIT BROADCAST
    public function EditBroadcast($id_broadcast)
    {
        if (isset($this->session->akses)) {
            $data_user = $this->userModel->get_user();
            $jenis_layanan = $this->jenisLayananModel->get_jenis_layanan();
            $detail_broadcast = $this->broadcastModel->get_detail_broadcast($id_broadcast);
            $detail_user = $this->userModel->get_detail_user($this->session->user_id);
            $data = [
                'jenis_layanan' => $jenis_layanan,
                'nama_page' => 'Edit Broadcast',
                'nama_user' => $this->session->nama_unit_kerja,
                'data_user' => $data_user,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id,
                'detail_broadcast' => $detail_broadcast,
                'nama_unit_kerja' => $detail_user['nama_unit_kerja']
            ];
            return view('kelola/kelola_broadcast/edit_broadcast', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveEditBroadcast()
    {
        if (isset($this->session->akses)) {
            if (strtotime($this->request->getVar('tanggal_broadcast')) <= date('Y-m-d H:i:s')) {
                $this->broadcastModel->save([
                    'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                    'id_broadcast' => $this->request->getVar('id_broadcast'),
                    'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                    'user_id' => $this->request->getVar('user_id'),
                    'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                    'text_broadcast' => $this->request->getVar('text_broadcast'),
                    'status_terkirim' => 'Belum',
                    'tujuan_broadcast' => implode(",", $this->request->getVar('tujuan_broadcast')),
                    'thumbnail_broadcast' => $this->request->getVar('thumbnail_broadcast')
                ]);
                $delimiters = ["T", " ", "="];
                $new_tanggal_broadcast = str_replace($delimiters, $delimiters[1], $this->request->getVar('tanggal_broadcast'));
                $text_notifikasi = "Hai " . $this->session->nama_unit_kerja . "! \n\nAda broadcast dengan judul " . $this->request->getVar('judul_broadcast') . " untuk tanggal " . $new_tanggal_broadcast . " yang *belum dikirim* nih. Yuk, segera kirim di " . base_url('/');
                $detail_notifikasi = $this->notifikasiModel->get_detail_notifikasi_by_broadcast($this->request->getVar('id_broadcast'));
                if ($detail_notifikasi != null) {
                    $this->notifikasiModel->save([
                        'id_notifikasi' => $detail_notifikasi['id_notifikasi'],
                        'text_notifikasi' => $text_notifikasi,
                        'tanggal_kirim_notifikasi' => $this->request->getVar('tanggal_broadcast'),
                        'status_kirim_notifikasi' => 'Sudah'
                    ]);
                }
                echo "<script>
                alert('Data Berhasil Tersimpan');
                window.location.href='/detail-broadcast/" . $this->request->getVar('id_broadcast') . "';
                </script>";
            } else {
                $this->broadcastModel->save([
                    'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                    'id_broadcast' => $this->request->getVar('id_broadcast'),
                    'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                    'user_id' => $this->request->getVar('user_id'),
                    'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                    'text_broadcast' => $this->request->getVar('text_broadcast'),
                    'status_terkirim' => 'Belum',
                    'tujuan_broadcast' => implode(",", $this->request->getVar('tujuan_broadcast')),
                    'thumbnail_broadcast' => $this->request->getVar('thumbnail_broadcast')
                ]);
                $delimiters = ["T", " ", "="];
                $new_tanggal_broadcast = str_replace($delimiters, $delimiters[1], $this->request->getVar('tanggal_broadcast'));
                $text_notifikasi = "Hai " . $this->session->nama_unit_kerja . "! \n\nAda broadcast dengan judul " . $this->request->getVar('judul_broadcast') . " untuk tanggal " . $new_tanggal_broadcast . " yang *belum dikirim* nih. Yuk, segera kirim di " . base_url('/');
                $detail_notifikasi = $this->notifikasiModel->get_detail_notifikasi_by_broadcast($this->request->getVar('id_broadcast'));
                if ($detail_notifikasi != null) {
                    $this->notifikasiModel->save([
                        'id_notifikasi' => $detail_notifikasi['id_notifikasi'],
                        'text_notifikasi' => $text_notifikasi,
                        'tanggal_kirim_notifikasi' => $this->request->getVar('tanggal_broadcast'),
                        'status_kirim_notifikasi' => 'Belum'
                    ]);
                } else {
                    $this->notifikasiModel->insert([
                        'text_notifikasi' => $text_notifikasi,
                        'tanggal_kirim_notifikasi' => $this->request->getVar('tanggal_broadcast'),
                        'status_kirim_notifikasi' => 'Belum'
                    ]);
                }
            }
            echo "<script>
            alert('Data Berhasil Tersimpan');
            window.location.href='/kelola-broadcast';
            </script>";
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    // DETAIL BROADCAST
    public function DetailBroadcast($id_broadcast)
    {
        if (isset($this->session->akses)) {
            $detail_broadcast = $this->broadcastModel->get_detail_broadcast($id_broadcast);
            $jenis_layanan = $this->jenisLayananModel->get_jenis_layanan();
            if ($detail_broadcast['platform_broadcast'] == 'Whatsapp') {
                $text_broadcast = "<p>" . $this->_delimitersWhatsappText($detail_broadcast['text_broadcast'], null) . "</p>";
            } else if ($detail_broadcast['platform_broadcast'] == 'Email') {
                $text_broadcast = '<!DOCTYPE html>

                <html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
                <head>
                <title></title>
                <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
                <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
                <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
                <style>
                        * {
                            box-sizing: border-box;
                        }
                
                        body {
                            margin: 0;
                            padding: 0;
                        }
                
                        a[x-apple-data-detectors] {
                            color: inherit !important;
                            text-decoration: inherit !important;
                        }
                
                        #MessageViewBody a {
                            color: inherit;
                            text-decoration: none;
                        }
                
                        p {
                            line-height: inherit
                        }
                
                        .desktop_hide,
                        .desktop_hide table {
                            mso-hide: all;
                            display: none;
                            max-height: 0px;
                            overflow: hidden;
                        }
                
                        @media (max-width:520px) {
                            .desktop_hide table.icons-inner {
                                display: inline-block !important;
                            }
                
                            .icons-inner {
                                text-align: center;
                            }
                
                            .icons-inner td {
                                margin: 0 auto;
                            }
                
                            .image_block img.big,
                            .row-content {
                                width: 100% !important;
                            }
                
                            .mobile_hide {
                                display: none;
                            }
                
                            .stack .column {
                                width: 100%;
                                display: block;
                            }
                
                            .mobile_hide {
                                min-height: 0;
                                max-height: 0;
                                max-width: 0;
                                overflow: hidden;
                                font-size: 0px;
                            }
                
                            .desktop_hide,
                            .desktop_hide table {
                                display: table !important;
                                max-height: none !important;
                            }
                        }
                    </style>
                </head>
                <body style="background-color: #FFFFFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
                <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;" width="100%">
                <tbody>
                <tr>
                <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                <tbody>
                <tr>
                <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
                <tbody>
                <tr>
                <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
                <table border="0" cellpadding="0" cellspacing="0" class="image_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                <tr>
                <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
                <div align="center" class="alignment" style="line-height:10px; margin-bottom:50px;"><img class="big" src="https://i.postimg.cc/ncbvLFt5/1.jpg" style="display: block; height: auto; border: 0; width: 1080px; max-width: 1080px;" width="1080"/></div>
                </td>
                </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" class="html_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                <tr>
                <td class="pad">
                <div align="center" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif;text-align:center; margin-bottom:50px;"><div class="our-class">' . $detail_broadcast['text_broadcast'] . '</div></div>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </tbody>
                </table>
                </td>
                </tr>
                </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                <tbody>
                <tr>
                <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
                <tbody>
                <tr>
                <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
                <table border="0" cellpadding="0" cellspacing="0" class="icons_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                <tr>
                <td class="pad" style="vertical-align: middle; color: #9d9d9d; font-family: inherit; font-size: 15px; padding-bottom: 5px; padding-top: 5px; text-align: center;">
                <table cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                <tr>
                <td class="alignment" style="vertical-align: middle; text-align: center;">
                <!--[if vml]><table align="left" cellpadding="0" cellspacing="0" role="presentation" style="display:inline-block;padding-left:0px;padding-right:0px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;"><![endif]-->
                <!--[if !vml]><!-->
                <table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;">
                <!--<![endif]-->
                <tr>
                <td style="vertical-align: middle; text-align: center; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; padding-right: 6px;"><a href="https://sumut.kemenkumham.go.id/" style="text-decoration: none;" target="_blank"><img align="center" alt="Created By Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara" class="icon" height="32" src="https://i.ibb.co/HnXgBSd/bee.png" style="display: block; height: auto; margin: 0 auto; border: 0;" width="1080px"/></a></td>
                <td style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 15px; color: #9d9d9d; vertical-align: middle; letter-spacing: undefined; text-align: center;"><a href="https://sumut.kemenkumham.go.id/" style="color: #9d9d9d; text-decoration: none;" target="_blank">Created By Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara</a></td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </tbody>
                </table>
                </td>
                </tr>
                </tbody>
                </table>
                </td>
                </tr>
                </tbody>
                </table><!-- End -->
                </body>
                </html>';
            }
            $data = [
                'detail_broadcast' => $detail_broadcast,
                'jenis_layanan' => $jenis_layanan,
                'nama_page' => 'Detail Broadcast',
                'nama_user' => $this->session->nama_unit_kerja,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id,
                'text_broadcast' => $text_broadcast
            ];
            return view('kelola/kelola_broadcast/detail_broadcast', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    // HAPUS BROADCAST
    public function HapusBroadcast($id_broadcast)
    {
        $this->broadcastModel->delete($id_broadcast);
        echo "<script>
            alert('Data Berhasil Dihapus');
            window.location.href='/kelola-broadcast';
            </script>";
    }

    // KIRIM BROADCAST
    public function KirimBroadcast($id_broadcast)
    {
        $detail_broadcast = $this->broadcastModel->get_detail_broadcast($id_broadcast);
        if ($detail_broadcast['platform_broadcast'] == 'Whatsapp') {
            $whatsapp_success = $this->KirimBroadcastWhatsapp($detail_broadcast);
            $email_success = null;
        } else if ($detail_broadcast['platform_broadcast'] == 'Email') {
            $email_success = $this->KirimBroadcastEmail($detail_broadcast);
            $whatsapp_success = null;
        }

        if ($whatsapp_success == 'success' || $email_success == 'success') {
            // SAVE DATA BROADCAST JADI SUDAH
            $this->broadcastModel->save([
                'id_broadcast' => $id_broadcast,
                'tanggal_broadcast' => date('Y-m-d H:i:s'),
                'status_terkirim' => 'Sudah'
            ]);
            $detail_notifikasi = $this->notifikasiModel->get_detail_notifikasi_by_broadcast($id_broadcast);
            if ($detail_notifikasi != null) {
                $this->notifikasiModel->save([
                    'id_notifikasi' => $detail_notifikasi['id_notifikasi'],
                    'status_kirim_notifikasi' => 'Sudah'
                ]);
            }
            echo "<script>
                alert('Broadcast Berhasil Terkirim');
                window.location.href='/kelola-broadcast';
                </script>";
        } else {
            echo "<script>
                    alert('Broadcast Gagal Terkirim');
                    window.location.href='/kelola-broadcast';
                    </script>";
        }
    }

    // KIRIM BROADCAST EMAIL
    public function KirimBroadcastEmail($detail_broadcast)
    {
        $judul_broadcast = $detail_broadcast['judul_broadcast'];
        $text_broadcast = $detail_broadcast['text_broadcast'];
        $tujuan_broadcast = explode(",", $detail_broadcast['tujuan_broadcast']);
        // NENTUKAN EMAILNYA APA AJA YANG MAU DIKIRIMIN
        for ($i = 0; $i < count($tujuan_broadcast); $i++) {
            if ($i == 0) {
                $email_tujuan_1 = $this->entryPenggunaLayananModel->get_detail_pengguna_per_jenis_layanan($tujuan_broadcast[$i]);
                $a = count($email_tujuan_1);
            }
            if ($i > 0) {
                $email_tujuan_2 = $this->entryPenggunaLayananModel->get_detail_pengguna_per_jenis_layanan($tujuan_broadcast[$i]);
                foreach ($email_tujuan_1 as $e1) :
                    for ($b = 0; $b < count($email_tujuan_2); $b++) {
                        if ($e1['email_pengguna'] == $email_tujuan_2[$b]['email_pengguna']) {
                            $email_tujuan_2[$b]['email_pengguna'] = null;
                        }
                    }
                endforeach;
                foreach ($email_tujuan_2 as $e2) :
                    if ($e2['email_pengguna'] == null) {
                    } else {
                        $email_tujuan_1[$a]['id_entry'] = $e2['id_entry'];
                        $email_tujuan_1[$a]['email_pengguna'] = $e2['email_pengguna'];
                        $email_tujuan_1[$a]['tanggal_entry'] = $e2['tanggal_entry'];
                        $email_tujuan_1[$a]['user_id'] = $e2['user_id'];
                        $email_tujuan_1[$a]['perihal_konsultasi'] = $e2['perihal_konsultasi'];
                        $email_tujuan_1[$a]['jenis_layanan'] = $e2['jenis_layanan'];
                        $a++;
                    }
                endforeach;
            }
        }
        // MULAI SENDING EMAIL
        foreach ($email_tujuan_1 as $e1) :
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($e1['no_telp_pengguna']);
            $text_broadcast = $detail_broadcast['text_broadcast'];
            $text_broadcast_exploded = explode(" ", $text_broadcast);
            for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
                if ($text_broadcast_exploded[$i] == 'nama_pengguna,') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . ',';
                } else if ($text_broadcast_exploded[$i] == 'nama_pengguna.') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '.';
                } else if ($text_broadcast_exploded[$i] == 'nama_pengguna!') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '!';
                } else if ($text_broadcast_exploded[$i] == 'nama_pengguna;') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . ';';
                } else if ($text_broadcast_exploded[$i] == 'nama_pengguna?') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '?';
                } else if ($text_broadcast_exploded[$i] == '(nama_pengguna)') {
                    $text_broadcast_exploded[$i] = '(' . $detail_pengguna['nama_pengguna'] . ')';
                } else if ($text_broadcast_exploded[$i] == 'nama_pengguna') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'];
                }
            }
            $text_broadcast = implode(" ", $text_broadcast_exploded);
            $data = [
                'email' => $detail_pengguna['email_pengguna'],
                'nama' => $detail_pengguna['nama_pengguna'],
                'message' => $text_broadcast,
                'subject' => $judul_broadcast
            ];
            $message = '<!DOCTYPE html>

        <html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
        <head>
        <title></title>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
        <style>
                * {
                    box-sizing: border-box;
                }
        
                body {
                    margin: 0;
                    padding: 0;
                }
        
                a[x-apple-data-detectors] {
                    color: inherit !important;
                    text-decoration: inherit !important;
                }
        
                #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                }
        
                p {
                    line-height: inherit
                }
        
                .desktop_hide,
                .desktop_hide table {
                    mso-hide: all;
                    display: none;
                    max-height: 0px;
                    overflow: hidden;
                }
        
                @media (max-width:520px) {
                    .desktop_hide table.icons-inner {
                        display: inline-block !important;
                    }
        
                    .icons-inner {
                        text-align: center;
                    }
        
                    .icons-inner td {
                        margin: 0 auto;
                    }
        
                    .image_block img.big,
                    .row-content {
                        width: 100% !important;
                    }
        
                    .mobile_hide {
                        display: none;
                    }
        
                    .stack .column {
                        width: 100%;
                        display: block;
                    }
        
                    .mobile_hide {
                        min-height: 0;
                        max-height: 0;
                        max-width: 0;
                        overflow: hidden;
                        font-size: 0px;
                    }
        
                    .desktop_hide,
                    .desktop_hide table {
                        display: table !important;
                        max-height: none !important;
                    }
                }
            </style>
        </head>
        <body style="background-color: #FFFFFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
        <tbody>
        <tr>
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
        <table border="0" cellpadding="0" cellspacing="0" class="image_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
        <div align="center" class="alignment" style="line-height:10px"><img class="big" src="https://i.postimg.cc/ncbvLFt5/1.jpg" style="display: block; height: auto; border: 0; width: 1080px; max-width: 100%;" width="1080"/></div>
        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="html_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad">
        <div align="center" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif;text-align:center;"><div class="our-class">' . $data['message'] . '</div></div>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
        <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
        <tbody>
        <tr>
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
        <table border="0" cellpadding="0" cellspacing="0" class="icons_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="pad" style="vertical-align: middle; color: #9d9d9d; font-family: inherit; font-size: 15px; padding-bottom: 5px; padding-top: 5px; text-align: center;">
        <table cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr>
        <td class="alignment" style="vertical-align: middle; text-align: center;">
        <!--[if vml]><table align="left" cellpadding="0" cellspacing="0" role="presentation" style="display:inline-block;padding-left:0px;padding-right:0px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;"><![endif]-->
        <!--[if !vml]><!-->
        <table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;">
        <!--<![endif]-->
        <tr>
        <td style="vertical-align: middle; text-align: center; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; padding-right: 6px;"><a href="https://sumut.kemenkumham.go.id/" style="text-decoration: none;" target="_blank"><img align="center" alt="Created By Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara" class="icon" height="32" src="https://i.ibb.co/HnXgBSd/bee.png" style="display: block; height: auto; margin: 0 auto; border: 0;" width="34"/></a></td>
        <td style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 15px; color: #9d9d9d; vertical-align: middle; letter-spacing: undefined; text-align: center;"><a href="https://sumut.kemenkumham.go.id/" style="color: #9d9d9d; text-decoration: none;" target="_blank">Created By Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara</a></td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table><!-- End -->
        </body>
        </html>';
            $email = \Config\Services::email();
            $email->setSubject($data['subject']);
            $email->setTo($data['email']);
            $email->setMessage($message);
            $email->SMTPKeepAlive = true;
            $email->send();
        endforeach;
        return 'success';
    }

    // KIRIM BROADCAST WHATSAPP
    public function KirimBroadcastWhatsapp($detail_broadcast)
    {
        $judul_broadcast = $detail_broadcast['judul_broadcast'];
        $text_broadcast = $detail_broadcast['text_broadcast'];
        $tujuan_broadcast = explode(",", $detail_broadcast['tujuan_broadcast']);
        $thumbnail_broadcast = $detail_broadcast['thumbnail_broadcast'];
        // NENTUKAN NOMOR TELEPONNYA APA AJA YANG MAU DIKIRIMIN
        for ($i = 0; $i < count($tujuan_broadcast); $i++) {
            if ($i == 0) {
                $no_telp_1 = $this->entryPenggunaLayananModel->get_detail_pengguna_per_jenis_layanan_no_telp($tujuan_broadcast[$i]);
                $a = count($no_telp_1);
            }
            if ($i > 0) {
                $no_telp_2 = $this->entryPenggunaLayananModel->get_detail_pengguna_per_jenis_layanan_no_telp($tujuan_broadcast[$i]);
                foreach ($no_telp_1 as $n1) :
                    for ($b = 0; $b < count($no_telp_2); $b++) {
                        if ($n1['no_telp_pengguna'] == $no_telp_2[$b]['no_telp_pengguna']) {
                            $no_telp_2[$b]['no_telp_pengguna'] = null;
                        }
                    }
                endforeach;
                foreach ($no_telp_2 as $n2) :
                    if ($n2['no_telp_pengguna'] == null) {
                    } else {
                        $no_telp_1[$a]['id_entry'] = $n2['id_entry'];
                        $no_telp_1[$a]['email_pengguna'] = $n2['email_pengguna'];
                        $no_telp_1[$a]['tanggal_entry'] = $n2['tanggal_entry'];
                        $no_telp_1[$a]['user_id'] = $n2['user_id'];
                        $no_telp_1[$a]['perihal_konsultasi'] = $n2['perihal_konsultasi'];
                        $no_telp_1[$a]['jenis_layanan'] = $n2['jenis_layanan'];
                        $no_telp_1[$a]['no_telp_pengguna'] = $n2['no_telp_pengguna'];
                        $no_telp_1[$a]['nama_pengguna'] = $n2['nama_pengguna'];
                        $no_telp_1[$a]['instansi_asal_pengguna'] = $n2['instansi_asal_pengguna'];
                        $a++;
                    }
                endforeach;
            }
        }
        // MULAI SENDING WHATSAPP
        foreach ($no_telp_1 as $n1) :
            $text_broadcast = $detail_broadcast['text_broadcast'];
            $text_broadcast = $this->_delimitersWhatsappText($text_broadcast, $n1);
            $data = [
                'no_telp_pengguna' => $n1['no_telp_pengguna'],
                'nama' => $n1['nama_pengguna'],
                'message' => $text_broadcast,
                'subject' => $judul_broadcast,
                'image' => $thumbnail_broadcast
            ];
            $this->_sendWhatsapp($data);
        endforeach;
        return 'success';
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

    private function _delimitersWhatsappText($text_broadcast, $n1)
    {
        $text_broadcast_exploded = explode(" ", $text_broadcast);
        for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
            $text_broadcast_exploded[$i] = explode("\n", $text_broadcast_exploded[$i]);
        }
        if ($n1 != null) {
            for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
                if (count($text_broadcast_exploded[$i]) == 1) {
                    if ($text_broadcast_exploded[$i] == 'nama_pengguna,') {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ",";
                    } else if ($text_broadcast_exploded[$i] == 'nama_pengguna.') {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ".";
                    } else if ($text_broadcast_exploded[$i] == 'nama_pengguna!') {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "!";
                    } else if ($text_broadcast_exploded[$i] == 'nama_pengguna;') {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ";";
                    } else if ($text_broadcast_exploded[$i] == 'nama_pengguna?') {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "?";
                    } else if ($text_broadcast_exploded[$i] == '(nama_pengguna)') {
                        $text_broadcast_exploded[$i] = "(" . $n1['nama_pengguna'] . ")";
                    } else if ($text_broadcast_exploded[$i] == '*nama_pengguna*') {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "*";
                    } else if ($text_broadcast_exploded[$i] == '*nama_pengguna,*') {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ",*";
                    } else if ($text_broadcast_exploded[$i] == '*nama_pengguna.*') {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ".*";
                    } else if ($text_broadcast_exploded[$i] == '*nama_pengguna!*') {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "!*";
                    } else if ($text_broadcast_exploded[$i] == '*nama_pengguna;*') {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ";*";
                    } else if ($text_broadcast_exploded[$i] == '*nama_pengguna?*') {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "?*";
                    } else if ($text_broadcast_exploded[$i] == '*(nama_pengguna)*') {
                        $text_broadcast_exploded[$i] = '*(' . $n1['nama_pengguna'] . ")*";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'];
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna ") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'];
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna\r") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "\r";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna\n") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "\n";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna,\r") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ",\r";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna.\r") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ".\r";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna!\r") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "!\r";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna;\r") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ";\r";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna?\r") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "?\r";
                    } else if ($text_broadcast_exploded[$i] == "(nama_pengguna)\r") {
                        $text_broadcast_exploded[$i] = "(" . $n1['nama_pengguna'] . ")\r";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna*\r") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "*\r";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna,*\r") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ",*\r";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna.*\r") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ".*\r";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna!*\r") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "!*\r";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna;*\r") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ";*\r";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna?*\r") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "?*\r";
                    } else if ($text_broadcast_exploded[$i] == "*(nama_pengguna)*\r") {
                        $text_broadcast_exploded[$i] = '*(' . $n1['nama_pengguna'] . ")*\r";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna\r") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "\r";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna \r") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . " \r";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna,\n") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ",\n";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna.\n") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ".\n";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna!\n") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "!\n";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna;\n") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ";\n";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna?\n") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "?\n";
                    } else if ($text_broadcast_exploded[$i] == "(nama_pengguna)\n") {
                        $text_broadcast_exploded[$i] = "(" . $n1['nama_pengguna'] . ")\n";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna*\n") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "*\n";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna,*\n") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ",*\n";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna.*\n") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ".*\n";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna!*\n") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "!*\n";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna;*\n") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ";*\n";
                    } else if ($text_broadcast_exploded[$i] == "*nama_pengguna?*\n") {
                        $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "?*\n";
                    } else if ($text_broadcast_exploded[$i] == "*(nama_pengguna)*\n") {
                        $text_broadcast_exploded[$i] = '*(' . $n1['nama_pengguna'] . ")*\n";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna\n") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "\n";
                    } else if ($text_broadcast_exploded[$i] == "nama_pengguna \n") {
                        $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . " \n";
                    }
                } else if (count($text_broadcast_exploded[$i]) > 1) {
                    for ($a = 0; $a < count($text_broadcast_exploded[$i]); $a++) {
                        if ($text_broadcast_exploded[$i][$a] == 'nama_pengguna,') {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ",";
                        } else if ($text_broadcast_exploded[$i][$a] == 'nama_pengguna.') {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ".";
                        } else if ($text_broadcast_exploded[$i][$a] == 'nama_pengguna!') {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "!";
                        } else if ($text_broadcast_exploded[$i][$a] == 'nama_pengguna;') {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ";";
                        } else if ($text_broadcast_exploded[$i][$a] == 'nama_pengguna?') {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "?";
                        } else if ($text_broadcast_exploded[$i][$a] == '(nama_pengguna)') {
                            $text_broadcast_exploded[$i][$a] = "(" . $n1['nama_pengguna'] . ")";
                        } else if ($text_broadcast_exploded[$i][$a] == '*nama_pengguna*') {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "*";
                        } else if ($text_broadcast_exploded[$i][$a] == '*nama_pengguna,*') {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ",*";
                        } else if ($text_broadcast_exploded[$i][$a] == '*nama_pengguna.*') {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ".*";
                        } else if ($text_broadcast_exploded[$i][$a] == '*nama_pengguna!*') {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "!*";
                        } else if ($text_broadcast_exploded[$i][$a] == '*nama_pengguna;*') {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ";*";
                        } else if ($text_broadcast_exploded[$i][$a] == '*nama_pengguna?*') {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "?*";
                        } else if ($text_broadcast_exploded[$i][$a] == '*(nama_pengguna)*') {
                            $text_broadcast_exploded[$i][$a] = '*(' . $n1['nama_pengguna'] . ")*";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'];
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna ") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'];
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna\r") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna\n") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna,\r") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ",\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna.\r") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ".\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna!\r") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "!\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna;\r") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ";\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna?\r") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "?\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "(nama_pengguna)\r") {
                            $text_broadcast_exploded[$i][$a] = "(" . $n1['nama_pengguna'] . ")\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna*\r") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "*\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna,*\r") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ",*\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna.*\r") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ".*\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna!*\r") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "!*\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna;*\r") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ";*\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna?*\r") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "?*\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "*(nama_pengguna)*\r") {
                            $text_broadcast_exploded[$i][$a] = '*(' . $n1['nama_pengguna'] . ")*\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna\r") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "\r";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna \r") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . " \r";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna,\n") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ",\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna.\n") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ".\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna!\n") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "!\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna;\n") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ";\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna?\n") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "?\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "(nama_pengguna)\n") {
                            $text_broadcast_exploded[$i][$a] = "(" . $n1['nama_pengguna'] . ")\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna*\n") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "*\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna,*\n") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ",*\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna.*\n") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ".*\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna!*\n") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "!*\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna;*\n") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ";*\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "*nama_pengguna?*\n") {
                            $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "?*\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "*(nama_pengguna)*\n") {
                            $text_broadcast_exploded[$i][$a] = '*(' . $n1['nama_pengguna'] . ")*\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna\n") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "\n";
                        } else if ($text_broadcast_exploded[$i][$a] == "nama_pengguna \n") {
                            $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . " \n";
                        }
                    }
                }
            }
        }
        if ($n1 != null) {
            for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
                if (count($text_broadcast_exploded[$i]) == 1) {
                    $text_broadcast_exploded[$i] = implode("", $text_broadcast_exploded[$i]);
                } else if (count($text_broadcast_exploded[$i]) > 1) {
                    $text_broadcast_exploded[$i] = implode("\n", $text_broadcast_exploded[$i]);
                }
            }
        } else {
            for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
                if (count($text_broadcast_exploded[$i]) == 1) {
                    $text_broadcast_exploded[$i] = implode("", $text_broadcast_exploded[$i]);
                } else if (count($text_broadcast_exploded[$i]) > 1) {
                    $text_broadcast_exploded[$i] = implode("<br>", $text_broadcast_exploded[$i]);
                }
            }
        }
        $text_broadcast = implode(" ", $text_broadcast_exploded);
        return $text_broadcast;
    }
}
