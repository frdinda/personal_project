<?php

namespace App\Controllers\UKOM23\Kelola;

use App\Controllers\BaseController;
use App\Models\UKOM23\UKOM23_UserModel;
use App\Models\UKOM23\UKOM23_PesertaModel;

class KelolaUser extends BaseController
{
    protected $userModel;
    protected $pesertaModel;
    public function __construct()
    {
        $this->userModel = new UKOM23_UserModel;
        $this->pesertaModel = new UKOM23_PesertaModel;
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function index()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola User',
                    'nama_subpage' => 'Kelola User',
                    'akses' => $akses,
                    'data_user' => $this->userModel->get_user(),
                    'nama_user' => $this->session->nama_user
                ];
                return view('ukom23/kelola/kelola_user/kelola_user', $data);
            } else {
                echo "<script>
                alert('Anda Tidak Memiliki Akses, Silahkan Login');
                window.location.href='/';
                </script>";
            }
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
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola User',
                    'nama_subpage' => 'Tambah User',
                    'akses' => $akses,
                    'nama_user' => $this->session->nama_user
                ];
                return view('ukom23/kelola/kelola_user/tambah_user', $data);
            } else {
                echo "<script>
                alert('Anda Tidak Memiliki Akses, Silahkan Login');
                window.location.href='/';
                </script>";
            }
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
                if ($jenis_akses == 'pegawai') {
                    $this->asesiModel->insert([
                        'id_asesi' => $id_user,
                        'nama_asesi' => $nama_user,
                        'jenis_jabatan' => $jenis_akses,
                        'nama_jabatan' => $jabatan_user
                    ]);
                }
                echo "<script>
            alert('Berhasil Disimpan');
            window.location.href='/kelola-user-ukom23';
            </script>";
            } else if ($password != $konfirmasi_password) {
                echo "<script>
            alert('Password dan Konfirmasi Password Tidak Sama');
            window.location.href='/tambah-user-ukom23';
            </script>";
            }
        }
        echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-user-ukom23';
            </script>";
    }

    public function EditUser($id_user)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola User',
                    'nama_subpage' => 'Edit User',
                    'akses' => $akses,
                    'detail_user' => $this->userModel->get_detail_user($id_user),
                    'nama_user' => $this->session->nama_user
                ];
                return view('ukom23/kelola/kelola_user/edit_user', $data);
            } else {
                echo "<script>
                alert('Anda Tidak Memiliki Akses, Silahkan Login');
                window.location.href='/';
                </script>";
            }
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
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
                    if ($jenis_akses == 'pegawai') {
                        $this->asesiModel->save([
                            'id_asesi' => $id_user,
                            'nama_asesi' => $nama_user,
                            'jenis_jabatan' => $jenis_akses,
                            'nama_jabatan' => $jabatan_user
                        ]);
                    }
                    echo "<script>
                alert('Berhasil Disimpan');
                window.location.href='/kelola-user-ukom23';
                </script>";
                } else if ($password != $konfirmasi_password) {
                    echo "<script>
                alert('Password dan Konfirmasi Password Tidak Sama');
                window.location.href='/tambah-user-ukom23';
                </script>";
                }
            } else {
                "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-user-ukom23';
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
                    window.location.href='/kelola-user-ukom23';
                    </script>";
    }
}
