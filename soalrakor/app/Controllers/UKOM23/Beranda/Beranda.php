<?php

namespace App\Controllers\UKOM23\Beranda;

use App\Controllers\BaseController;
use App\Models\UKOM23\UKOM23_NilaiModel;
use App\Models\UKOM23\UKOM23_PesertaModel;
use App\Models\UKOM23\UKOM23_PesertaPeriodeModel;
use App\Models\UKOM23\UKOM23_PeriodeBerjalanModel;
use App\Models\UKOM23\UKOM23_PeriodeModel;

class Beranda extends BaseController
{
    protected $nilaiModel;
    protected $pesertaModel;
    protected $periodeBerjalanModel;
    protected $periodeModel;
    protected $pesertaPeriodeModel;
    public function __construct()
    {
        $this->nilaiModel = new UKOM23_NilaiModel;
        $this->pesertaModel = new UKOM23_PesertaModel;
        $this->periodeBerjalanModel = new UKOM23_PeriodeBerjalanModel;
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
                $periode_berjalan = $this->periodeBerjalanModel->get_periode_berjalan();
                $periode_berjalan_sementara = $this->session->periode_berjalan_sementara;
                $data_periode = $this->periodeModel->get_periode();
                $nilai_dashboard = $this->nilaiModel->get_nilai_dashboard($periode_berjalan['id_periode']);
                $pembagian_soal = $this->nilaiModel->get_pembagian_soal($periode_berjalan['id_periode']);
                // UNTUK SEKARANG AMBIL SELURUH DATA PESERTA
                $daftar_peserta_periode = $this->pesertaPeriodeModel->get_peserta_periode_per_periode($periode_berjalan_sementara['id_periode']);
                $data = [
                    'nama_page' => 'Beranda',
                    'nama_subpage' => 'Beranda',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'nilai_dashboard' => $nilai_dashboard,
                    'pembagian_soal' => $pembagian_soal,
                    'daftar_peserta' => $daftar_peserta_periode,
                    'periode_berjalan_sementara' => $periode_berjalan_sementara,
                    'data_periode' => $data_periode
                ];
                return view('ukom23/beranda/beranda', $data);
            } else {
                echo "<script>
                alert('Anda Tidak Memiliki Akses, Silahkan Login');
                window.location.href='/';
                </script>";
            }
        } else {
            $data = [
                'nama_page' => 'login'
            ];
            return view('login/login', $data);
        }
    }

    public function PilihanPeriode()
    {
        $pilihan_periode = $this->request->getVar('pilihan_periode');
        $periode_berjalan_sementara = $this->periodeModel->get_detail_periode($pilihan_periode);
        $this->session->set('periode_berjalan_sementara', $periode_berjalan_sementara);
        return redirect()->to('/beranda-ukom23');
    }

    public function DetailPenilaian($id_peserta_dan_periode)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $id_peserta_dan_periode = explode("-", $id_peserta_dan_periode);
                $id_peserta = $id_peserta_dan_periode[0];
                $id_periode = $id_peserta_dan_periode[1];
                $nilai_peserta = $this->nilaiModel->get_nilai_peserta($id_peserta, $id_periode);
                if (isset($nilai_peserta)) {
                    $pembagian_soal_peserta = $this->nilaiModel->get_pembagian_soal_peserta($id_peserta, $id_periode);
                    $detail_peserta = $this->pesertaModel->get_detail_peserta($id_peserta);
                    $data = [
                        'nama_page' => 'Beranda',
                        'nama_subpage' => 'Detail Penilaian',
                        'nama_user' => $this->session->nama_user,
                        'akses' => $akses,
                        'nilai_peserta' => $nilai_peserta,
                        'pembagian_soal_peserta' => $pembagian_soal_peserta,
                        'detail_peserta' => $detail_peserta,
                        'id_peserta' => $id_peserta
                    ];
                    return view('ukom23/beranda/detail_penilaian', $data);
                } else {
                    echo "<script>
                    alert('Peserta Belum Diuji');
                    window.location.href='/beranda-ukom23';
                    </script>";
                }
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
}
