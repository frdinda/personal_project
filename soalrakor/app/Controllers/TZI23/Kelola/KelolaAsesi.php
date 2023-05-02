<?php

namespace App\Controllers\TZI23\Kelola;

use App\Controllers\BaseController;
use App\Models\TZI23\TZI23_AsesiModel;

class KelolaAsesi extends BaseController
{
    protected $asesiModel;
    public function __construct()
    {
        $this->asesiModel = new TZI23_AsesiModel;
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function index()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses) && $jenis_assessment == 'TZI23') {
            $data = [
                'nama_page' => 'Kelola Asesi',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'data_asesi' => $this->asesiModel->get_asesi()
            ];
            return view('tzi23/kelola/kelola_asesi/kelola_asesi', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function TambahAsesi()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses) && $jenis_assessment == 'TZI23') {
            $data = [
                'nama_page' => 'Kelola Asesi',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
            ];
            return view('tzi23/kelola/kelola_asesi/tambah_asesi', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function EditAsesi($id_asesi)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses) && $jenis_assessment == 'TZI23') {
            $data = [
                'nama_page' => 'Kelola Asesi',
                'nama_user' => $this->session->nama_user,
                'akses' => $this->session->akses,
                'detail_asesi' => $this->asesiModel->get_detail_asesi($id_asesi)
            ];
            return view('tzi23/kelola/kelola_asesi/edit_asesi', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SubTambahAsesi()
    {
        $id_asesi = $this->request->getVar('id_asesi');
        $nama_asesi = $this->request->getVar('nama_asesi');
        $jenis_jabatan = $this->request->getVar('jenis_jabatan');
        $nama_jabatan = $this->request->getVar('nama_jabatan');

        if (isset($id_asesi)) {
            $this->asesiModel->insert([
                'id_asesi' => $id_asesi,
                'nama_asesi' => $nama_asesi,
                'jenis_jabatan' => $jenis_jabatan,
                'nama_jabatan' => $nama_jabatan
            ]);
            echo "<script>
            alert('Berhasil Disimpan');
            window.location.href='/kelola-asesi-tzi23';
            </script>";
        } else {
            echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-asesi-tzi23';
            </script>";
        }
    }

    public function SubEditAsesi()
    {
        $id_asesi = $this->request->getVar('id_asesi');
        $nama_asesi = $this->request->getVar('nama_asesi');
        $jenis_jabatan = $this->request->getVar('jenis_jabatan');
        $nama_jabatan = $this->request->getVar('nama_jabatan');

        if (isset($nama_asesi)) {
            $this->asesiModel->save([
                'id_asesi' => $id_asesi,
                'nama_asesi' => $nama_asesi,
                'jenis_jabatan' => $jenis_jabatan,
                'nama_jabatan' => $nama_jabatan
            ]);
            echo "<script>
            alert('Berhasil Disimpan');
            window.location.href='/kelola-asesi-tzi23';
            </script>";
        } else {
            echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-asesi-tzi23';
            </script>";
        }
    }

    public function HapusAsesi($id_asesi)
    {
        $this->asesiModel->delete([
            'id_asesi' => $id_asesi
        ]);
        echo "<script>
                    alert('Berhasil Dihapus');
                    window.location.href='/kelola-asesi-tzi23';
                    </script>";
    }
}
