<?php

namespace App\Controllers\ECK22\Penilaian;

use App\Controllers\BaseController;
use App\Models\ECK22\NilaiModel;
use App\Models\ECK22\SatkerModel;

class KelolaNilai extends BaseController
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
                'nama_page' => 'kelola nilai',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'nilai_dashboard' => $nilai_dashboard,
                'pembagian_soal' => $pembagian_soal,
                'daftar_satker' => $daftar_satker
            ];
            return view('eck22/soal_dan_penilaian/kelola_nilai/kelola_nilai', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function EditNilai($id_satker)
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $nilai_satker = $this->nilaiModel->get_nilai_satker($id_satker);
            $pembagian_soal_satker = $this->nilaiModel->get_pembagian_soal_satker($id_satker);
            $detail_satker = $this->satkerModel->get_detail_satker($id_satker);
            $data = [
                'nama_page' => 'kelola nilai',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'nilai_satker' => $nilai_satker,
                'pembagian_soal_satker' => $pembagian_soal_satker,
                'id_satker' => $id_satker,
                'detail_satker' => $detail_satker
            ];
            return view('eck22/soal_dan_penilaian/kelola_nilai/edit_nilai', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SubEditNilai($id_satker)
    {
        $nilai_satker = $this->nilaiModel->get_nilai_satker($id_satker);
        foreach ($nilai_satker as $n) :
            $id_penilaian = $this->request->getVar($n['id_penilaian'] . '_id');
            $id_soal = $this->request->getVar($n['id_penilaian'] . '_soal');
            $id_user = $this->request->getVar($n['id_penilaian'] . '_user');
            $nilai_baru = $this->request->getVar($n['id_penilaian'] . '_nilai');
            $this->nilaiModel->save([
                'id_penilaian' => $id_penilaian,
                'nilai' => $nilai_baru
            ]);
        endforeach;
        echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/edit-nilai/" . $id_satker . "';
                    </script>";
    }
}
