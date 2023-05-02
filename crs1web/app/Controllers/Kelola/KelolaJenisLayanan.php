<?php

namespace App\Controllers\Kelola;

use App\Controllers\BaseController;
use App\Models\JenisLayananModel;

class KelolaJenisLayanan extends BaseController
{
    protected $jenisLayananModel;

    public function __construct()
    {
        $this->jenisLayananModel = new JenisLayananModel();
    }

    public function index()
    {
        if (isset($this->session->akses)) {
            $data_jenis_layanan = $this->jenisLayananModel->get_jenis_layanan();
            $data = [
                'nama_page' => 'Kelola Jenis Layanan',
                'nama_user' => $this->session->nama_unit_kerja,
                'data_jenis_layanan' => $data_jenis_layanan,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
            ];
            return view('kelola/kelola_jenis_layanan/kelola_jenis_layanan', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    // TAMBAH JENIS LAYANAN
    public function TambahJenisLayanan()
    {
        if (isset($this->session->akses)) {
            $data = [
                'nama_page' => 'Tambah Jenis Layanan',
                'nama_user' => $this->session->nama_unit_kerja,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
            ];
            return view('kelola/kelola_jenis_layanan/tambah_jenis_layanan', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveTambahJenisLayanan()
    {
        $detail_jenis_layanan = $this->jenisLayananModel->get_detail_jenis_layanan($this->request->getVar('jenis_layanan'));
        if (isset($detail_jenis_layanan)) {
            $this->jenisLayananModel->save([
                'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                'nama_jenis_layanan' => $this->request->getVar('nama_jenis_layanan'),
                'warna_jenis_layanan' => $this->request->getVar('warna_jenis_layanan')
            ]);
            echo "<script>
            alert('Jenis Layanan Sudah Ada, Data Tersimpan Sebagai Update');
            window.location.href='/kelola-jenis-layanan';
            </script>";
        } else {
            $this->jenisLayananModel->insert([
                'jenis_layanan' => $this->request->getVar('jenis_layanan'),
                'nama_jenis_layanan' => $this->request->getVar('nama_jenis_layanan'),
                'warna_jenis_layanan' => $this->request->getVar('warna_jenis_layanan')
            ]);
            echo "<script>
            alert('Data Berhasil Tersimpan');
            window.location.href='/kelola-jenis-layanan';
            </script>";
        }
    }

    // EDIT JENIS LAYANAN
    public function EditJenisLayanan($jenis_layanan)
    {
        if (isset($this->session->akses)) {
            $detail_jenis_layanan = $this->jenisLayananModel->get_detail_jenis_layanan($jenis_layanan);
            $data = [
                'nama_page' => 'Edit Jenis Layanan',
                'nama_user' => $this->session->nama_unit_kerja,
                'detail_jenis_layanan' => $detail_jenis_layanan,
                'jenis_akses' => $this->session->akses,
                'user_id' => $this->session->user_id
            ];
            return view('kelola/kelola_jenis_layanan/edit_jenis_layanan', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SaveEditJenisLayanan()
    {
        $this->jenisLayananModel->save([
            'jenis_layanan' => $this->request->getVar('jenis_layanan'),
            'nama_jenis_layanan' => $this->request->getVar('nama_jenis_layanan'),
            'warna_jenis_layanan' => $this->request->getVar('warna_jenis_layanan')
        ]);
        echo "<script>
        alert('Data Berhasil Tersimpan');
        window.location.href='/kelola-jenis-layanan';
        </script>";
    }

    // DELETE USER
    public function HapusJenisLayanan($jenis_layanan)
    {
        $this->jenisLayananModel->delete($jenis_layanan);
        echo "<script>
            alert('Data Berhasil Dihapus');
            window.location.href='/kelola-jenis-layanan';
            </script>";
    }
}
