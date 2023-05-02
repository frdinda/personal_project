<?php

namespace App\Controllers\ECK22\Kelola;

use App\Controllers\BaseController;
use App\Models\ECK22\UserModel;

class KelolaUser extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function index()
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $data = [
                'nama_page' => 'kelola user',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'data_user' => $this->userModel->get_user()
            ];
            return view('eck22/kelola/kelola_user/kelola_user', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function TambahUser()
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $data = [
                'nama_page' => 'kelola user',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
            ];
            return view('eck22/kelola/kelola_user/tambah_user', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function EditUser($id_user)
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $data = [
                'nama_page' => 'kelola user',
                'nama_user' => $this->session->nama_user,
                'akses' => $this->session->akses,
                'detail_user' => $this->userModel->get_detail_user($id_user)
            ];
            return view('eck22/kelola/kelola_user/edit_user', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SubTambahUser()
    {
        $id_user = $this->request->getVar('id_user');
        $nama_user = $this->request->getVar('nama_user');
        $jenis_akses = $this->request->getVar('jenis_akses');
        $jabatan_user = $this->request->getVar('jabatan_user');
        $password = md5($this->request->getVar('password'));
        $konfirmasi_password = md5($this->request->getVar('konfirmasi_password'));

        if (isset($id_user)) {
            if ($password == $konfirmasi_password) {
                $this->userModel->insert([
                    'id_user' => $id_user,
                    'nama_user' => $nama_user,
                    'jenis_akses' => $jenis_akses,
                    'jabatan' => $jabatan_user,
                    'password' => $password
                ]);
                echo "<script>
            alert('Berhasil Disimpan');
            window.location.href='/kelola-user';
            </script>";
            } else if ($password != $konfirmasi_password) {
                echo "<script>
            alert('Password dan Konfirmasi Password Tidak Sama');
            window.location.href='/tambah-user';
            </script>";
            }
        }
        echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-user';
            </script>";
    }

    public function SubEditUser()
    {
        $id_user = $this->request->getVar('id_user');
        $nama_user = $this->request->getVar('nama_user');
        $jenis_akses = $this->request->getVar('jenis_akses');
        $jabatan_user = $this->request->getVar('jabatan_user');
        $password = md5($this->request->getVar('password'));
        $konfirmasi_password = md5($this->request->getVar('konfirmasi_password'));

        if (isset($id_user)) {
            if ($password == $konfirmasi_password) {
                if ($password == $konfirmasi_password) {
                    $this->userModel->save([
                        'id_user' => $id_user,
                        'nama_user' => $nama_user,
                        'jenis_akses' => $jenis_akses,
                        'jabatan' => $jabatan_user,
                        'password' => $password
                    ]);
                    echo "<script>
                alert('Berhasil Disimpan');
                window.location.href='/kelola-user';
                </script>";
                } else if ($password != $konfirmasi_password) {
                    echo "<script>
                alert('Password dan Konfirmasi Password Tidak Sama');
                window.location.href='/tambah-user';
                </script>";
                }
            } else {
                "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-user';
            </script>";
            }
        }
    }

    public function HapusUser($id_user)
    {
        $this->userModel->delete([
            'id_user' => $id_user
        ]);
        echo "<script>
                    alert('Berhasil Dihapus');
                    window.location.href='/kelola-user';
                    </script>";
    }
}
