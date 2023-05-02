<?php

namespace App\Controllers\ECK22\Beranda;

use App\Controllers\BaseController;
use App\Models\ECK22\NilaiModel;
use App\Models\ECK22\SatkerModel;

class Beranda extends BaseController
{
    protected $nilaiModel;
    protected $satkerModel;
    public function __construct()
    {
        $this->nilaiModel = new NilaiModel;
        $this->satkerModel = new SatkerModel;
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function index()
    {
        $akses = $this->session->akses;

        if (isset($akses)) {
            $nilai_dashboard = $this->nilaiModel->get_nilai_dashboard();
            $pembagian_soal = $this->nilaiModel->get_pembagian_soal();
            $daftar_satker = $this->satkerModel->get_satker();
            $data = [
                'nama_page' => 'beranda',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'nilai_dashboard' => $nilai_dashboard,
                'pembagian_soal' => $pembagian_soal,
                'daftar_satker' => $daftar_satker
            ];
            return view('eck22/beranda/beranda', $data);
        } else {
            $data = [
                'nama_page' => 'login'
            ];
            return view('login/login', $data);
        }
    }

    public function DetailPenilaian($id_satker)
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $nilai_satker = $this->nilaiModel->get_nilai_satker($id_satker);
            $pembagian_soal_satker = $this->nilaiModel->get_pembagian_soal_satker($id_satker);
            $detail_satker = $this->satkerModel->get_detail_satker($id_satker);
            $data = [
                'nama_page' => 'beranda',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'nilai_satker' => $nilai_satker,
                'pembagian_soal_satker' => $pembagian_soal_satker,
                'id_satker' => $id_satker,
                'detail_satker' => $detail_satker
            ];
            return view('eck22/beranda/detail_penilaian', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }
}
