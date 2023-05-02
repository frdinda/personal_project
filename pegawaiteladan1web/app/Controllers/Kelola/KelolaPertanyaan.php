<?php

namespace App\Controllers\Kelola;

use App\Controllers\BaseController;
use App\Models\PertanyaanModel;

class KelolaPertanyaan extends BaseController
{
    protected $pertanyaanModel;
    public function __construct()
    {
        $this->pertanyaanModel = new PertanyaanModel();
    }

    public function index()
    {
        if (isset($this->session->jenis_user) && $this->session->jenis_user == 'Admin') {
            $data = [
                'nama_page' => 'Kelola Pertanyaan',
                'nama_sub_page' => 'Kelola Pertanyaan',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'data_pertanyaan' => $this->pertanyaanModel->get_pertanyaan()
            ];
            return view('kelola/kelola_pertanyaan/kelola_pertanyaan', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function TambahPertanyaan()
    {
        if (isset($this->session->jenis_user) && $this->session->jenis_user == 'Admin') {
            $data = [
                'nama_page' => 'Kelola Pertanyaan',
                'nama_sub_page' => 'Kelola Pertanyaan',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai
            ];
            return view('kelola/kelola_pertanyaan/tambah_pertanyaan', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function ProsesTambahPertanyaan()
    {
        $this->pertanyaanModel->insert([
            'jabaran_pertanyaan' => $this->request->getVar('jabaran_pertanyaan'),
            'kategori_pertanyaan' => $this->request->getVar(('kategori_pertanyaan'))
        ]);
        echo "<script>
            alert('Data berhasil ditambahkan');
            window.location.href='/kelola-pertanyaan';
            </script>";
    }

    public function EditPertanyaan($id_pertanyaan)
    {
        if (isset($this->session->jenis_user) && $this->session->jenis_user == 'Admin') {
            $detail_pertanyaan = $this->pertanyaanModel->get_detail_pertanyaan($id_pertanyaan);
            $data = [
                'nama_page' => 'Kelola Pertanyaan',
                'nama_sub_page' => 'Kelola Pertanyaan',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'detail_pertanyaan' => $detail_pertanyaan
            ];
            return view('kelola/kelola_pertanyaan/edit_pertanyaan', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function ProsesEditPertanyaan()
    {
        $this->pertanyaanModel->save([
            'id_pertanyaan' => $this->request->getVar('id_pertanyaan'),
            'jabaran_pertanyaan' => $this->request->getVar('jabaran_pertanyaan'),
            'kategori_pertanyaan' => $this->request->getVar(('kategori_pertanyaan'))
        ]);
        echo "<script>
            alert('Data berhasil diupdate');
            window.location.href='/kelola-pertanyaan';
            </script>";
    }

    public function HapusPertanyaan($id_pertanyaan)
    {
        $this->pertanyaanModel->delete([
            'id_pertanyaan' => $id_pertanyaan
        ]);
        echo "<script>
            alert('Data Berhasil Dihapus');
            window.location.href='/kelola-pertanyaan';
            </script>";
    }
}
