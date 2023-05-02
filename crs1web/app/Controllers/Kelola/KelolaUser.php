<?php

namespace App\Controllers\Kelola;

use App\Controllers\BaseController;
use App\Models\PenggunaLayananModel;
use App\Models\JenisLayananModel;
use App\Models\UserModel;
use App\Models\EntryPenggunaLayananModel;

class KelolaUser extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (isset($this->session->akses) && $this->session->user_id == 'super_adm') {
            $data_user = $this->userModel->get_user();
            $data = [
                'nama_page' => 'Kelola User',
                'nama_user' => $this->session->nama_unit_kerja,
                'data_user' => $data_user,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
            ];
            return view('kelola/kelola_user/kelola_user', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    // TAMBAH USER
    public function TambahUser()
    {
        if (isset($this->session->akses) && $this->session->user_id == 'super_adm') {
            $data = [
                'nama_page' => 'Tambah User',
                'nama_user' => $this->session->nama_unit_kerja,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
            ];
            return view('kelola/kelola_user/tambah_user', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveTambahUser()
    {
        $password = $this->request->getVar('password');
        $konfirmasi_password = $this->request->getVar('konfirmasi_password');
        if ($password == $konfirmasi_password) {
            $user_id = $this->request->getVar('user_id');
            $detail_user = $this->userModel->get_detail_user($user_id);
            if (isset($detail_user)) {
                $this->userModel->save([
                    'user_id' => $user_id,
                    'nama_unit_kerja' => $this->request->getVar('nama_unit_kerja'),
                    'nama_kepala' => $this->request->getVar('nama_kepala'),
                    'nip_kepala' => $this->request->getVar('nip_kepala'),
                    'jenis_akses' => $this->request->getVar('jenis_akses'),
                    'password' => md5($password),
                    'no_telp_representatif' => $this->request->getVar('no_telp_representatif')
                ]);
                echo "<script>
                alert('User Sudah Ada, Data Akan Tersimpan Sebagai Update');
                window.location.href='/kelola-user';
                </script>";
            } else {
                $this->userModel->insert([
                    'user_id' => $user_id,
                    'nama_unit_kerja' => $this->request->getVar('nama_unit_kerja'),
                    'nama_kepala' => $this->request->getVar('nama_kepala'),
                    'nip_kepala' => $this->request->getVar('nip_kepala'),
                    'jenis_akses' => $this->request->getVar('jenis_akses'),
                    'password' => md5($password),
                    'no_telp_representatif' => $this->request->getVar('no_telp_representatif')
                ]);
                echo "<script>
                alert('Data Berhasil Tersimpan');
                window.location.href='/kelola-user';
                </script>";
            }
        } else {
            echo "<script>
            alert('Password dan Konfirmasi Password Tidak Sama');
            window.location.href='/tambah-user';
            </script>";
        }
    }

    // EDIT USER
    public function EditUser($user_id)
    {
        if (isset($this->session->akses) && $this->session->user_id == 'super_adm') {
            $detail_user = $this->userModel->get_detail_user($user_id);
            $data = [
                'nama_page' => 'Edit User',
                'nama_user' => $this->session->nama_unit_kerja,
                'jenis_akses' => $this->session->akses,
                'detail_user' => $detail_user,
                'user_id' => $this->session->user_id
            ];
            return view('kelola/kelola_user/edit_user', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveEditUser()
    {
        $password = $this->request->getVar('password');
        $konfirmasi_password = $this->request->getVar('konfirmasi_password');
        if ($password == $konfirmasi_password) {
            $this->userModel->save([
                'user_id' => $this->request->getVar('user_id'),
                'nama_unit_kerja' => $this->request->getVar('nama_unit_kerja'),
                'nama_kepala' => $this->request->getVar('nama_kepala'),
                'nip_kepala' => $this->request->getVar('nip_kepala'),
                'jenis_akses' => $this->request->getVar('jenis_akses'),
                'password' => md5($password),
                'no_telp_representatif' => $this->request->getVar('no_telp_representatif')
            ]);
            echo "<script>
            alert('Data Berhasil Tersimpan');
            window.location.href='/kelola-user';
            </script>";
        } else {
            echo "<script>
            alert('Password dan Konfirmasi Password Tidak Sama');
            window.location.href='/edit-user/" . $this->request->getVar('user_id') . "';
            </script>";
        }
    }

    // DELETE USER
    public function HapusUser($user_id)
    {
        $this->userModel->delete($user_id);
        echo "<script>
            alert('Data Berhasil Dihapus');
            window.location.href='/kelola-user';
            </script>";
    }

    // EDIT PROFIL
    public function EditProfil()
    {
        $user_id = $this->session->user_id;
        if (isset($user_id)) {
            $detail_user =  $this->userModel->get_detail_user($user_id);
            $data = [
                'nama_page' => 'Edit Profil',
                'nama_user' => $this->session->nama_unit_kerja,
                'user_id' => $user_id,
                'detail_user' => $detail_user,
                'jenis_akses' => $this->session->akses
            ];
            return view('kelola/kelola_user/edit_profil', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveEditProfil()
    {
        $password = $this->request->getVar('password');
        $konfirmasi_password = $this->request->getVar('konfirmasi_password');
        if ($password == $konfirmasi_password) {
            $this->userModel->save([
                'user_id' => $this->request->getVar('user_id'),
                'nama_unit_kerja' => $this->request->getVar('nama_unit_kerja'),
                'nama_kepala' => $this->request->getVar('nama_kepala'),
                'nip_kepala' => $this->request->getVar('nip_kepala'),
                'password' => md5($password),
                'no_telp_representatif' => $this->request->getVar('no_telp_representatif')
            ]);
            $detail_user = $this->userModel->get_detail_user($this->request->getVar('user_id'));
            $this->session->set('akses', $detail_user['jenis_akses']);
            $this->session->set('nama_unit_kerja', $detail_user['nama_unit_kerja']);
            $this->session->set('no_telp_representatif', $detail_user['no_telp_representatif']);
            $this->session->set('user_id', $detail_user['user_id']);

            echo "<script>
            alert('Data Berhasil Tersimpan');
            window.location.href='/';
            </script>";
        } else {
            echo "<script>
            alert('Password dan Konfirmasi Password Tidak Sama');
            window.location.href='/edit-profil';
            </script>";
        }
    }
}
