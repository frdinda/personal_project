<?php

namespace App\Controllers\UKOM23\Penilaian;

use App\Controllers\BaseController;
use App\Models\UKOM23\UKOM23_NilaiModel;
use App\Models\UKOM23\UKOM23_PesertaModel;
use App\Models\UKOM23\UKOM23_PesertaPeriodeModel;
use App\Models\UKOM23\UKOM23_PeriodeModel;

class KelolaNilai extends BaseController
{
    protected $nilaiModel;
    protected $pesertaModel;
    protected $periodeModel;
    protected $pesertaPeriodeModel;
    public function __construct()
    {
        $this->nilaiModel = new UKOM23_NilaiModel;
        $this->pesertaModel = new UKOM23_PesertaModel;
        $this->periodeModel = new UKOM23_PeriodeModel;
        $this->pesertaPeriodeModel = new UKOM23_PesertaPeriodeModel;
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
                $periode_berjalan_sementara = $this->session->periode_berjalan_sementara;
                $data_periode = $this->periodeModel->get_periode();
                $nilai_dashboard = $this->nilaiModel->get_nilai_dashboard($periode_berjalan_sementara['id_periode']);
                $pembagian_soal = $this->nilaiModel->get_pembagian_soal($periode_berjalan_sementara['id_periode']);
                $daftar_peserta = $this->pesertaPeriodeModel->get_peserta_periode_per_periode($periode_berjalan_sementara['id_periode']);

                $data = [
                    'nama_page' => 'Kelola Nilai',
                    'nama_subpage' => 'Kelola Nilai',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'nilai_dashboard' => $nilai_dashboard,
                    'pembagian_soal' => $pembagian_soal,
                    'daftar_peserta' => $daftar_peserta,
                    'periode_berjalan_sementara' => $periode_berjalan_sementara,
                    'data_periode' => $data_periode
                ];

                return view('ukom23/soal_dan_penilaian/kelola_nilai/kelola_nilai', $data);
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

    public function EditNilai($id_peserta)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $periode = $this->session->periode_berjalan;
                $nilai_peserta = $this->nilaiModel->get_nilai_peserta($id_peserta, $periode['id_periode']);
                $pembagian_soal_peserta = $this->nilaiModel->get_pembagian_soal_peserta($id_peserta, $periode['id_periode']);
                $detail_peserta = $this->pesertaModel->get_detail_peserta($id_peserta);

                $data = [
                    'nama_page' => 'Kelola Nilai',
                    'nama_subpage' => 'Edit Nilai',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'nilai_peserta' => $nilai_peserta,
                    'pembagian_soal_peserta' => $pembagian_soal_peserta,
                    'id_peserta' => $id_peserta,
                    'detail_peserta' => $detail_peserta
                ];
                return view('ukom23/soal_dan_penilaian/kelola_nilai/edit_nilai', $data);
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

    public function SubEditNilai($id_peserta)
    {
        $periode = $this->session->periode_berjalan;
        $nilai_peserta = $this->nilaiModel->get_nilai_peserta($id_peserta, $periode['id_periode']);
        foreach ($nilai_peserta as $n) :
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
                    window.location.href='/edit-nilai-ukom23/" . $id_peserta . "';
                    </script>";
    }

    public function PilihanPeriode()
    {
        $pilihan_periode = $this->request->getVar('pilihan_periode');
        $periode_berjalan_sementara = $this->periodeModel->get_detail_periode($pilihan_periode);
        $this->session->set('periode_berjalan_sementara', $periode_berjalan_sementara);
        return redirect()->to('/kelola-nilai-ukom23');
    }
}
