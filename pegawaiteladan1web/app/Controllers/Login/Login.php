<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;

class Login extends BaseController
{
    protected $pegawaiModel;
    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    public function index()
    {
        $data = ['nama_page' => 'Login'];
        return view('login/login', $data);
    }

    public function ProsLogin()
    {
        $nip = $this->request->getVar('nip');
        $password = md5($this->request->getVar('password'));
        $detail_pegawai = $this->pegawaiModel->get_detail_pegawai($nip);
        if (isset($detail_pegawai)) {
            if ($detail_pegawai['password'] == $password) {
                $this->session->set('jenis_user', $detail_pegawai['jenis_user']);
                $this->session->set('nip_pegawai', $detail_pegawai['nip']);
                $this->session->set('nama_pegawai', $detail_pegawai['nama_pegawai']);
                $this->session->set('nama_jabatan', $detail_pegawai['nama_jabatan']);
                $this->session->set('nip_atasan_langsung', $detail_pegawai['nip_atasan_langsung']);
                return redirect()->to('/beranda');
            } else if (empty($detail_pegawai['id_user']) || $detail_pegawai['password'] != $password) {
                echo "<script>
                    alert('NIP Atau Password Salah, Silahkan Login Kembali');
                    window.location.href='/';
                    </script>";
            }
        } else {
            echo "<script>
                    alert('NIP Atau Password Salah, Silahkan Login Kembali');
                    window.location.href='/';
                    </script>";
        }
    }

    public function Logout()
    {
        unset($_SESSION['jenis_user']);
        unset($_SESSION['nip_pegawai']);
        unset($_SESSION['nama_pegawai']);
        unset($_SESSION['nama_jabatan']);
        unset($_SESSION['nip_atasan_langsung']);
        return redirect()->to('/');
    }
}
