<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use App\Models\ECK22\UserModel;
use App\Models\TZI23\TZI23_UserModel;
use App\Models\UKOM23\UKOM23_UserModel;
use App\Models\UKOM23\UKOM23_PeriodeBerjalanModel;

class Login extends BaseController
{
    protected $userModelECK22;
    protected $userModelTZI23;
    protected $userModelUKOM23;
    protected $periodeBerjalanModelUKOM23;
    public function __construct()
    {
        $this->userModelECK22 = new UserModel();
        $this->userModelTZI23 = new TZI23_UserModel();
        $this->userModelUKOM23 = new UKOM23_UserModel();
        $this->periodeBerjalanModelUKOM23 = new UKOM23_PeriodeBerjalanModel();
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function index()
    {
        $data = [
            'nama_page' => 'login'
        ];
        return view('login/login', $data);
    }

    public function ProsLogin()
    {
        $id_user = $this->request->getVar('id_user');
        $password = md5($this->request->getVar('password'));
        $jenis_assessment = $this->request->getVar('jenis_assessment');
        if ($jenis_assessment == 'Evaluasi Capaian Kinerja Tahun 2022') {
            $user = $this->userModelECK22->get_detail_user($id_user);
            if (isset($user)) {
                if ($user['password'] == $password) {
                    $this->session->set('akses', $user['jenis_akses']);
                    $this->session->set('nama_user', $user['nama_user']);
                    $this->session->set('id_user', $user['id_user']);
                    $this->session->set('jenis_assessment', 'ECK22');
                    return redirect()->to('/beranda');
                } else if (empty($user['id_user']) || $user['password'] != $password) {
                    echo "<script>
                    alert('User ID Atau Password Salah, Silahkan Login Kembali');
                    window.location.href='/';
                    </script>";
                }
            } else {
                echo "<script>
                alert('Anda Tidak Memiliki Akses');
                window.location.href='/';
                </script>";
            }
        } else if ($jenis_assessment == 'Assessment Pembangunan Zona Integritas 2023') {
            $user = $this->userModelTZI23->get_detail_user($id_user);
            if (isset($user)) {
                if ($user['password'] == $password) {
                    $this->session->set('akses', $user['jenis_akses']);
                    $this->session->set('nama_user', $user['nama_user']);
                    $this->session->set('id_user', $user['id_user']);
                    $this->session->set('jenis_assessment', 'TZI23');
                    return redirect()->to('/beranda-tzi23');
                } else if (empty($user['id_user']) || $user['password'] != $password) {
                    echo "<script>
                    alert('User ID Atau Password Salah, Silahkan Login Kembali');
                    window.location.href='/';
                    </script>";
                }
            } else {
                echo "<script>
                alert('Anda Tidak Memiliki Akses');
                window.location.href='/';
                </script>";
            }
        } else if ($jenis_assessment == 'Uji Kompetensi Pengisian Jabatan Tahun 2023') {
            $user = $this->userModelUKOM23->get_detail_user($id_user);
            $periode_berjalan = $this->periodeBerjalanModelUKOM23->get_periode_berjalan();
            if (isset($user)) {
                if ($user['password'] == $password) {
                    $this->session->set('akses', $user['jenis_akses']);
                    $this->session->set('nama_user', $user['nama_user']);
                    $this->session->set('id_user', $user['id_user']);
                    $this->session->set('jenis_assessment', 'UKOM23');
                    $this->session->set('periode_berjalan', $periode_berjalan);
                    $this->session->set('periode_berjalan_sementara', $periode_berjalan);
                    return redirect()->to('/beranda-ukom23');
                } else if (empty($user['id_user']) || $user['password'] != $password) {
                    echo "<script>
                    alert('User ID Atau Password Salah, Silahkan Login Kembali');
                    window.location.href='/';
                    </script>";
                }
            } else {
                echo "<script>
                    alert('User ID Atau Password Salah, Silahkan Login Kembali');
                    window.location.href='/';
                    </script>";
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['nama_user']);
        unset($_SESSION['akses']);
        unset($_SESSION['id_user']);
        unset($_SESSION['nama_page']);
        return redirect()->to('/');
    }
}
