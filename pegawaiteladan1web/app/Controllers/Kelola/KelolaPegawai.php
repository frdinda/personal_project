<?php

namespace App\Controllers\Kelola;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;

class KelolaPegawai extends BaseController
{
    protected $pegawaiModel;
    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    public function index()
    {
        if (isset($this->session->jenis_user) && $this->session->jenis_user == 'Admin') {
            $data = [
                'nama_page' => 'Kelola Pegawai',
                'nama_sub_page' => 'Kelola Pegawai',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'data_pegawai' => $this->pegawaiModel->get_pegawai()
            ];
            return view('kelola/kelola_pegawai/kelola_pegawai', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function TambahPegawai()
    {
        if (isset($this->session->jenis_user) && $this->session->jenis_user == 'Admin') {
            $data = [
                'nama_page' => 'Kelola Pegawai',
                'nama_sub_page' => 'Tambah Pegawai',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai
            ];
            return view('kelola/kelola_pegawai/tambah_pegawai', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function ProsesTambahPegawai()
    {
        $nip = $this->request->getVar('nip');
        $password = md5($this->request->getVar('password'));
        $konfirmasi_password = md5($this->request->getVar('konfirmasi_password'));
        if ($password == $konfirmasi_password) {
            $detail_pegawai = $this->pegawaiModel->get_detail_pegawai($nip);
            if ($detail_pegawai != null) {
                $foto_profil = $this->request->getFile('foto_profil');
                $foto_profil->move('img\foto_pegawai', md5($this->request->getVar('nip') . date('YmdHis')) . '.jpg');
                $this->pegawaiModel->save([
                    'nip' => $nip,
                    'nama_pegawai' => $this->request->getVar('nama_pegawai'),
                    'nama_jabatan' => $this->request->getVar('nama_jabatan'),
                    'jenis_user' => $this->request->getVar('jenis_user'),
                    'struktural' => $this->request->getVar('struktural'),
                    'nip_atasan_langsung' => $this->request->getVar('nip_atasan_langsung'),
                    'foto_profil' => md5($this->request->getVar('nip') . date('YmdHis')) . '.jpg',
                    'password' => $password
                ]);
                echo "<script>
                    alert('NIP telah terdata, data yang diinput akan disimpan sebagai update');
                    window.location.href='/kelola-pegawai';
                    </script>";
            } else {
                $foto_profil = $this->request->getFile('foto_profil');
                $foto_profil->move('img\foto_pegawai', md5($this->request->getVar('nip') . date('YmdHis')) . '.jpg');
                $this->pegawaiModel->insert([
                    'nip' => $nip,
                    'nama_pegawai' => $this->request->getVar('nama_pegawai'),
                    'nama_jabatan' => $this->request->getVar('nama_jabatan'),
                    'jenis_user' => $this->request->getVar('jenis_user'),
                    'struktural' => $this->request->getVar('struktural'),
                    'nip_atasan_langsung' => $this->request->getVar('nip_atasan_langsung'),
                    'foto_profil' => md5($this->request->getVar('nip') . date('YmdHis')) . '.jpg',
                    'password' => $password
                ]);
                echo "<script>
                    alert('Data berhasil ditambahkan');
                    window.location.href='/kelola-pegawai';
                    </script>";
            }
        } else {
            echo "<script>
                    alert('Password dan Konfirmasi Password Tidak Sama, Silahkan Ulangi');
                    window.location.href='/tambah-pegawai';
                    </script>";
        }
    }

    public function EditPegawai($nip)
    {
        if (isset($this->session->jenis_user) && $this->session->jenis_user == 'Admin') {
            $data = [
                'nama_page' => 'Kelola Pegawai',
                'nama_sub_page' => 'Edit Pegawai',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'detail_pegawai' => $this->pegawaiModel->get_detail_pegawai($nip)
            ];
            return view('kelola/kelola_pegawai/edit_pegawai', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function ProsesEditPegawai()
    {
        $password = md5($this->request->getVar('password'));
        $konfirmasi_password = md5($this->request->getVar('konfirmasi_password'));
        if ($password == $konfirmasi_password) {
            $foto_profil = $this->request->getFile('foto_profil');
            if ($foto_profil != null) {
                $foto_profil->move('img\foto_pegawai', md5($this->request->getVar('nip') . date('YmdHis')) . '.jpg');
            }
            $this->pegawaiModel->save([
                'nip' => $this->request->getVar('nip'),
                'nama_pegawai' => $this->request->getVar('nama_pegawai'),
                'nama_jabatan' => $this->request->getVar('nama_jabatan'),
                'jenis_user' => $this->request->getVar('jenis_user'),
                'struktural' => $this->request->getVar('struktural'),
                'nip_atasan_langsung' => $this->request->getVar('nip_atasan_langsung'),
                'foto_profil' => md5($this->request->getVar('nip') . date('YmdHis')) . '.jpg',
                'password' => $password
            ]);
            echo "<script>
                alert('Data Telah Terupdate');
                window.location.href='/kelola-pegawai';
                </script>";
        } else {
            echo "<script>
                    alert('Password dan Konfirmasi Password Tidak Sama, Silahkan Ulangi');
                    window.location.href='/edit-pegawai/" . $this->request->getVar('nip') . "';
                    </script>";
        }
    }

    public function HapusPegawai($nip)
    {
        $this->pegawaiModel->delete([
            'nip' => $nip
        ]);
        echo "<script>
            alert('Data Berhasil Dihapus');
            window.location.href='/kelola-pegawai';
            </script>";
    }

    public function EditProfil()
    {
        if (isset($this->session->jenis_user)) {
            $data = [
                'nama_page' => 'Edit Profil',
                'nama_sub_page' => 'Edit Profil',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'detail_pegawai' => $this->pegawaiModel->get_detail_pegawai($this->session->nip_pegawai)
            ];
            return view('kelola/kelola_pegawai/edit_profil', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function ProsesEditProfil()
    {
        $password = md5($this->request->getVar('password'));
        $konfirmasi_password = md5($this->request->getVar('konfirmasi_password'));
        if ($password == $konfirmasi_password) {
            $foto_profil = $this->request->getFile('foto_profil');
            if ($foto_profil != null) {
                $foto_profil->move('img\foto_pegawai', md5($this->request->getVar('nip') . date('YmdHis')) . '.jpg');
            }
            $this->pegawaiModel->save([
                'nip' => $this->request->getVar('nip'),
                'nama_pegawai' => $this->request->getVar('nama_pegawai'),
                'nama_jabatan' => $this->request->getVar('nama_jabatan'),
                'nip_atasan_langsung' => $this->request->getVar('nip_atasan_langsung'),
                'foto_profil' => md5($this->request->getVar('nip') . date('YmdHis')) . '.jpg',
                'password' => $password
            ]);
            $detail_pegawai = $this->pegawaiModel->get_detail_pegawai($this->request->getVar('nip'));
            $this->session->set('jenis_user', $detail_pegawai['jenis_user']);
            $this->session->set('nip_pegawai', $detail_pegawai['nip']);
            $this->session->set('nama_pegawai', $detail_pegawai['nama_pegawai']);
            $this->session->set('nama_jabatan', $detail_pegawai['nama_jabatan']);
            $this->session->set('nip_atasan_langsung', $detail_pegawai['nip_atasan_langsung']);
            echo "<script>
                alert('Data Telah Terupdate');
                window.location.href='/';
                </script>";
        } else {
            echo "<script>
                    alert('Password dan Konfirmasi Password Tidak Sama, Silahkan Ulangi');
                    window.location.href='/edit-profil';
                    </script>";
        }
    }
}
