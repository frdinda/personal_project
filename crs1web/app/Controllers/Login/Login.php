<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\BroadcastModel;
use App\Models\EntryPenggunaLayananModel;
use App\Models\PenggunaLayananModel;
use App\Models\NotifikasiModel;
use App\Models\KonsultasiOnlineModel;

class Login extends BaseController
{
    protected $userModel;
    protected $broadcastModel;
    protected $entryPenggunaLayananModel;
    protected $penggunaLayananModel;
    protected $notifikasiModel;
    protected $konsultasiOnlineModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->broadcastModel = new BroadcastModel();
        $this->entryPenggunaLayananModel = new EntryPenggunaLayananModel();
        $this->penggunaLayananModel = new PenggunaLayananModel();
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
        return view('login/login');
    }

    public function ProsLogin()
    {
        $user_id = $this->request->getVar('user_id');
        $password = md5($this->request->getVar('password'));
        $detail_user = $this->userModel->get_detail_user($user_id);
        if (isset($detail_user) && $password == $detail_user['password']) {
            $this->session->set('akses', $detail_user['jenis_akses']);
            $this->session->set('nama_unit_kerja', $detail_user['nama_kepala']);
            $this->session->set('no_telp_representatif', $detail_user['no_telp_representatif']);
            $this->session->set('user_id', $detail_user['user_id']);
            return redirect()->to('/');
        } else {
            echo "<script>
                alert('User ID atau Password Salah, Silahkan Login Kembali');
                window.location.href='/login';
                </script>";
        }
    }

    public function logout()
    {
        unset($_SESSION['akses']);
        unset($_SESSION['nama_unit_kerja']);
        unset($_SESSION['no_telp_representatif']);
        return redirect()->to('/');
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
