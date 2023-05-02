<?php

namespace App\Controllers\Kelola;

use App\Controllers\BaseController;
use App\Models\PenggunaLayananModel;
use App\Models\JenisLayananModel;
use App\Models\UserModel;
use App\Models\EntryPenggunaLayananModel;
use App\Models\BroadcastModel;

class Numpang extends BaseController
{
    protected $penggunaLayananModel;
    protected $jenisLayananModel;
    protected $userModel;
    protected $entryPenggunaLayananModel;
    protected $broadcastModel;

    public function __construct()
    {
        $this->penggunaLayananModel = new PenggunaLayananModel();
        $this->jenisLayananModel = new JenisLayananModel();
        $this->userModel = new UserModel();
        $this->entryPenggunaLayananModel = new EntryPenggunaLayananModel();
        $this->broadcastModel = new BroadcastModel();
    }

    public function index()
    {
        // DATA_BROADCASTNYA MASIH GATAU BETUL APA NGGAK :""
        if (isset($this->session->akses)) {
            // NGECEK BC-AN YANG BELUM
            $data_broadcast_belum_terkirim = $this->broadcastModel->get_detail_broadcast_belum_kirim();
            if (isset($data_broadcast_belum_terkirim)) {
                foreach ($data_broadcast_belum_terkirim as $d) :
                    $data = [
                        'id_broadcast' => $d['id_broadcast'],
                        'platform_broadcast' => $d['platform_broadcast'],
                        'tanggal_broadcast' => $d['tanggal_broadcast'],
                        'judul_broadcast' => $d['judul_broadcast'],
                        'text_broadcast' => $d['text_broadcast'],
                        'thumbnail_broadcast' => $d['thumbnail_broadcast'],
                        'tujuan_broadcast' => $d['tujuan_broadcast'],
                        'status_terkirim' => $d['status_terkirim']
                    ];
                    if ($d['platform_broadcast'] == 'Whatsapp') {
                        $this->KirimBroadcastWhatsappBelum($data);
                    } else if ($d['platform_broadcast'] == 'Email') {
                        $this->KirimBroadcastEmailBelum($data);
                    }
                endforeach;
            } else {
            }
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
            $data = [
                'jenis_layanan' => $jenis_layanan,
                'nama_page' => 'Tambah Broadcast',
                'nama_user' => $this->session->nama_unit_kerja,
                'data_user' => $data_user,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
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
            if (strtotime($this->request->getVar('tanggal_broadcast')) <= date('Y-m-d H:i:s')) {
                if ($this->request->getVar('platform_broadcast') == 'Whatsapp') {
                    $whatsapp_success = $this->KirimBroadcastWhatsapp();
                    if ($whatsapp_success == 'success') {
                        $this->broadcastModel->insert([
                            'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                            'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                            'user_id' => $this->request->getVar('user_id'),
                            'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                            'text_broadcast' => $this->request->getVar('text_broadcast'),
                            'status_terkirim' => 'Sudah',
                            'tujuan_broadcast' => implode(",", $tujuan_broadcast),
                            'thumbnail_broadcast' => $this->request->getVar('thumbnail_broadcast')
                        ]);
                        echo "<script>
                        alert('Broadcast Berhasil Terkirim');
                        window.location.href='/kelola-broadcast';
                        </script>";
                    } else {
                        $this->broadcastModel->insert([
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
                        alert('Broadcast Gagal Terkirim, Mohon Tunggu Kembali');
                        window.location.href='/kelola-broadcast';
                        </script>";
                    }
                } else if ($this->request->getVar('platform_broadcast') == 'Email') {
                    $email_success = $this->KirimBroadcastEmail();
                    if ($email_success == 'success') {
                        $this->broadcastModel->insert([
                            'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                            'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                            'user_id' => $this->request->getVar('user_id'),
                            'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                            'text_broadcast' => $this->request->getVar('text_broadcast'),
                            'status_terkirim' => 'Sudah',
                            'tujuan_broadcast' => implode(",", $tujuan_broadcast)
                        ]);
                        echo "<script>
                        alert('Broadcast Berhasil Terkirim');
                        window.location.href='/kelola-broadcast';
                        </script>";
                    } else {
                        $this->broadcastModel->insert([
                            'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                            'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                            'user_id' => $this->request->getVar('user_id'),
                            'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                            'text_broadcast' => $this->request->getVar('text_broadcast'),
                            'status_terkirim' => 'Belum',
                            'tujuan_broadcast' => implode(",", $tujuan_broadcast)
                        ]);
                        echo "<script>
                        alert('Broadcast Gagal Terkirim, Mohon Tunggu Kembali');
                        window.location.href='/kelola-broadcast';
                        </script>";
                    }
                }
            } else {
                $this->broadcastModel->insert([
                    'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                    'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                    'user_id' => $this->request->getVar('user_id'),
                    'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                    'text_broadcast' => $this->request->getVar('text_broadcast'),
                    'status_terkirim' => 'Belum',
                    'tujuan_broadcast' => implode(",", $tujuan_broadcast)
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
            $data = [
                'jenis_layanan' => $jenis_layanan,
                'nama_page' => 'Edit Broadcast',
                'nama_user' => $this->session->nama_unit_kerja,
                'data_user' => $data_user,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id,
                'detail_broadcast' => $detail_broadcast
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
                if ($this->request->getVar('platform_broadcast') == 'Whatsapp') {
                    $whatsapp_success = $this->KirimBroadcastWhatsapp();
                    $this->broadcastModel->save([
                        'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                        'id_broadcast' => $this->request->getVar('id_broadcast'),
                        'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                        'user_id' => $this->request->getVar('user_id'),
                        'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                        'text_broadcast' => $this->request->getVar('text_broadcast'),
                        'status_terkirim' => 'Sudah',
                        'tujuan_broadcast' => implode(",", $this->request->getVar('tujuan_broadcast')),
                        'thumbnail_broadcast' => $this->request->getVar('thumbnail_broadcast')
                    ]);
                } else if ($this->request->getVar('platform_broadcast') == 'Email') {
                    $email_success = $this->KirimBroadcastEmail();
                    $this->broadcastModel->save([
                        'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                        'id_broadcast' => $this->request->getVar('id_broadcast'),
                        'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                        'user_id' => $this->request->getVar('user_id'),
                        'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                        'text_broadcast' => $this->request->getVar('text_broadcast'),
                        'status_terkirim' => 'Sudah',
                        'tujuan_broadcast' => implode(",", $this->request->getVar('tujuan_broadcast'))
                    ]);
                }
            } else {
                $this->broadcastModel->save([
                    'platform_broadcast' => $this->request->getVar('platform_broadcast'),
                    'id_broadcast' => $this->request->getVar('id_broadcast'),
                    'tanggal_broadcast' => $this->request->getVar('tanggal_broadcast'),
                    'user_id' => $this->request->getVar('user_id'),
                    'judul_broadcast' => $this->request->getVar('judul_broadcast'),
                    'text_broadcast' => $this->request->getVar('text_broadcast'),
                    'status_terkirim' => 'Belum',
                    'tujuan_broadcast' => implode(",", $this->request->getVar('tujuan_broadcast'))
                ]);
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
            $data = [
                'detail_broadcast' => $detail_broadcast,
                'jenis_layanan' => $jenis_layanan,
                'nama_page' => 'Detail Broadcast',
                'nama_user' => $this->session->nama_unit_kerja,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
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

    // KIRIM BROADCAST EMAIL
    public function KirimBroadcastEmail()
    {
        $judul_broadcast = $this->request->getVar('judul_broadcast');
        $text_broadcast = $this->request->getVar('text_broadcast');
        $tujuan_broadcast = $this->request->getVar('tujuan_broadcast');
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
            $text_broadcast = $this->request->getVar('text_broadcast');
            $text_broadcast_exploded = explode(" ", $text_broadcast);
            for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
                if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;,') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . ',';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;.') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '.';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;!') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '!';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;;') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . ';';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;?') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '?';
                } else if ($text_broadcast_exploded[$i] == '(&lt;nama_pengguna&gt;)') {
                    $text_broadcast_exploded[$i] = '(' . $detail_pengguna['nama_pengguna'] . ')';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;') {
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
        <div align="center" class="alignment" style="line-height:10px"><img class="big" src="https://i.ibb.co/HxZsxys/Untitled-1.jpg" style="display: block; height: auto; border: 0; width: 500px; max-width: 100%;" width="500"/></div>
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

    private function _sendEmail($data)
    {
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
        <div align="center" class="alignment" style="line-height:10px"><img class="big" src="https://i.ibb.co/HxZsxys/Untitled-1.jpg" style="display: block; height: auto; border: 0; width: 500px; max-width: 100%;" width="500"/></div>
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
        if ($email->send()) {
            return "success";
        } else {
            return "failed";
        }
    }

    // KIRIM BROADCAST WHATSAPP
    public function KirimBroadcastWhatsapp()
    {
        $judul_broadcast = $this->request->getVar('judul_broadcast');
        $text_broadcast = $this->request->getVar('text_broadcast');
        $tujuan_broadcast = $this->request->getVar('tujuan_broadcast');
        $thumbnail_broadcast = $this->request->getVar('thumbnail_broadcast');
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
            $text_broadcast = $this->request->getVar('text_broadcast');
            $text_broadcast_exploded = explode(" ", $text_broadcast);
            for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
                if ($text_broadcast_exploded[$i] == '<nama_pengguna>,') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ',';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>.') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . '.';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>!') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . '!';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>;') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ';';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>?') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . '?';
                } else if ($text_broadcast_exploded[$i] == '(<nama_pengguna>)') {
                    $text_broadcast_exploded[$i] = '(' . $n1['nama_pengguna'] . ')';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . '*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>,*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . ',*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>.*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . '.*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>!*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . '!*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>;*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . ';*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>?*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . '?*';
                } else if ($text_broadcast_exploded[$i] == '*(<nama_pengguna>)*') {
                    $text_broadcast_exploded[$i] = '*(' . $n1['nama_pengguna'] . ')*';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'];
                }
            }
            $text_broadcast = implode(" ", $text_broadcast_exploded);
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
    }

    // KIRIM BROADCAST EMAIL BELUM
    public function KirimBroadcastEmailBelum($data)
    {
        $id_broadcast = $data['id_broadcast'];
        $judul_broadcast = $data['judul_broadcast'];
        $text_broadcast = $data['text_broadcast'];
        $tujuan_broadcast = explode(",", $data['tujuan_broadcast']);
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
            $detail_pengguna = $this->penggunaLayananModel->get_detail_pengguna_layanan($e1['email_pengguna']);
            $text_broadcast = $data['text_broadcast'];
            $text_broadcast_exploded = explode(" ", $text_broadcast);
            for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
                if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;,') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . ',';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;.') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '.';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;!') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '!';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;;') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . ';';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;?') {
                    $text_broadcast_exploded[$i] = $detail_pengguna['nama_pengguna'] . '?';
                } else if ($text_broadcast_exploded[$i] == '(&lt;nama_pengguna&gt;)') {
                    $text_broadcast_exploded[$i] = '(' . $detail_pengguna['nama_pengguna'] . ')';
                } else if ($text_broadcast_exploded[$i] == '&lt;nama_pengguna&gt;') {
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
        <div align="center" class="alignment" style="line-height:10px"><img class="big" src="https://i.ibb.co/HxZsxys/Untitled-1.jpg" style="display: block; height: auto; border: 0; width: 500px; max-width: 100%;" width="500"/></div>
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
        // UPDATE STATUS_TERKIRIM
        $this->broadcastModel->save([
            'id_broadcast' => $id_broadcast,
            'status_terkirim' => 'Sudah'
        ]);
        return 'success';
    }

    // KIRIM BROADCAST WHATSAPP BELUM
    public function KirimBroadcastWhatsappBelum($data)
    {
        $id_broadcast = $data['id_broadcast'];
        $judul_broadcast = $data['judul_broadcast'];
        $text_broadcast = $data['text_broadcast'];
        $tujuan_broadcast = explode(",", $data['tujuan_broadcast']);
        $thumbnail_broadcast = $this->request->getVar('thumbnail_broadcast');
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
            $text_broadcast = $data['text_broadcast'];
            $text_broadcast_exploded = explode(" ", $text_broadcast);
            for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
                if ($text_broadcast_exploded[$i] == '<nama_pengguna>,') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ',';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>.') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . '.';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>!') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . '!';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>;') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ';';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>?') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . '?';
                } else if ($text_broadcast_exploded[$i] == '(<nama_pengguna>)') {
                    $text_broadcast_exploded[$i] = '(' . $n1['nama_pengguna'] . ')';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . '*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>,*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . ',*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>.*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . '.*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>!*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . '!*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>;*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . ';*';
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>?*') {
                    $text_broadcast_exploded[$i] = '*' . $n1['nama_pengguna'] . '?*';
                } else if ($text_broadcast_exploded[$i] == '*(<nama_pengguna>)*') {
                    $text_broadcast_exploded[$i] = '*(' . $n1['nama_pengguna'] . ')*';
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'];
                }
            }
            $text_broadcast = implode(" ", $text_broadcast_exploded);
            $data = [
                'no_telp_pengguna' => $n1['no_telp_pengguna'],
                'nama' => $n1['nama_pengguna'],
                'message' => $text_broadcast,
                'subject' => $judul_broadcast,
                'image' => $thumbnail_broadcast
            ];
            $this->_sendWhatsapp($data);
        endforeach;
        // UPDATE STATUS_TERKIRIM
        $this->broadcastModel->save([
            'id_broadcast' => $id_broadcast,
            'status_terkirim' => 'Sudah'
        ]);
        return 'success';

        $delimiters = [" ", "\r\n", "="];
        $newStr = str_replace($delimiters, $delimiters[1], $text_broadcast);
        $text_broadcast_exploded = explode(" ", $text_broadcast);
        for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
            $text_broadcast_exploded[$i] = explode("\r\n", $text_broadcast_exploded[$i]);
        }
        for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
            if (count($text_broadcast_exploded[$i]) == 1) {
                if ($text_broadcast_exploded[$i] == '<nama_pengguna>,') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ",";
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>.') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ".";
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>!') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "!";
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>;') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . ";";
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>?') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'] . "?";
                } else if ($text_broadcast_exploded[$i] == '(<nama_pengguna>)') {
                    $text_broadcast_exploded[$i] = "(" . $n1['nama_pengguna'] . ")";
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>*') {
                    $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "*";
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>,*') {
                    $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ",*";
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>.*') {
                    $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ".*";
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>!*') {
                    $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "!*";
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>;*') {
                    $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . ";*";
                } else if ($text_broadcast_exploded[$i] == '*<nama_pengguna>?*') {
                    $text_broadcast_exploded[$i] = "*" . $n1['nama_pengguna'] . "?*";
                } else if ($text_broadcast_exploded[$i] == '*(<nama_pengguna>)*') {
                    $text_broadcast_exploded[$i] = '*(' . $n1['nama_pengguna'] . ")*";
                } else if ($text_broadcast_exploded[$i] == '<nama_pengguna>') {
                    $text_broadcast_exploded[$i] = $n1['nama_pengguna'];
                }
            } else if (count($text_broadcast_exploded[$i]) > 1) {
                for ($a = 0; $a < count($text_broadcast_exploded[$i]); $a++) {
                    if ($text_broadcast_exploded[$i][$a] == '<nama_pengguna>,') {
                        $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ",";
                    } else if ($text_broadcast_exploded[$i][$a] == '<nama_pengguna>.') {
                        $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ".";
                    } else if ($text_broadcast_exploded[$i][$a] == '<nama_pengguna>!') {
                        $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "!";
                    } else if ($text_broadcast_exploded[$i][$a] == '<nama_pengguna>;') {
                        $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . ";";
                    } else if ($text_broadcast_exploded[$i][$a] == '<nama_pengguna>?') {
                        $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'] . "?";
                    } else if ($text_broadcast_exploded[$i][$a] == '(<nama_pengguna>)') {
                        $text_broadcast_exploded[$i][$a] = "(" . $n1['nama_pengguna'] . ")";
                    } else if ($text_broadcast_exploded[$i][$a] == '*<nama_pengguna>*') {
                        $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "*";
                    } else if ($text_broadcast_exploded[$i][$a] == '*<nama_pengguna>,*') {
                        $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ",*";
                    } else if ($text_broadcast_exploded[$i][$a] == '*<nama_pengguna>.*') {
                        $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ".*";
                    } else if ($text_broadcast_exploded[$i][$a] == '*<nama_pengguna>!*') {
                        $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "!*";
                    } else if ($text_broadcast_exploded[$i][$a] == '*<nama_pengguna>;*') {
                        $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . ";*";
                    } else if ($text_broadcast_exploded[$i][$a] == '*<nama_pengguna>?*') {
                        $text_broadcast_exploded[$i][$a] = "*" . $n1['nama_pengguna'] . "?*";
                    } else if ($text_broadcast_exploded[$i][$a] == '*(<nama_pengguna>)*') {
                        $text_broadcast_exploded[$i][$a] = '*(' . $n1['nama_pengguna'] . ")*";
                    } else if ($text_broadcast_exploded[$i][$a] == '<nama_pengguna>') {
                        $text_broadcast_exploded[$i][$a] = $n1['nama_pengguna'];
                    }
                }
            }
        }
        for ($i = 0; $i < count($text_broadcast_exploded); $i++) {
            if (count($text_broadcast_exploded[$i]) == 1) {
                $text_broadcast_exploded[$i] = implode("", $text_broadcast_exploded[$i]);
            } else if (count($text_broadcast_exploded[$i]) > 1) {
                $text_broadcast_exploded[$i] = implode("\r\n", $text_broadcast_exploded[$i]);
            }
        }
        $text_broadcast = implode(" ", $text_broadcast_exploded);
    }
}
