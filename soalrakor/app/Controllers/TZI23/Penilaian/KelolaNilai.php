<?php

namespace App\Controllers\TZI23\Penilaian;

use App\Controllers\BaseController;
use App\Models\TZI23\TZI23_NilaiModel;
use App\Models\TZI23\TZI23_AsesiModel;

class KelolaNilai extends BaseController
{
    protected $nilaiModel;
    protected $asesiModel;
    public function __construct()
    {
        $this->nilaiModel = new TZI23_NilaiModel;
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
            $nilai_dashbooard = $this->nilaiModel->get_nilai_dashboard();
            $pembagian_soal = $this->nilaiModel->get_pembagian_soal();
            $daftar_asesi = $this->asesiModel->get_asesi();
            $data = [
                'nama_page' => 'Kelola Nilai',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'nilai_dashboard' => $nilai_dashbooard,
                'pembagian_soal' => $pembagian_soal,
                'daftar_asesi' => $daftar_asesi
            ];
            return view('tzi23/soal_dan_penilaian/kelola_nilai/kelola_nilai', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function EditNilai($id_asesi)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses) && $jenis_assessment == 'TZI23') {
            $nilai_asesi = $this->nilaiModel->get_nilai_asesi($id_asesi);
            $pembagian_soal_asesi = $this->nilaiModel->get_pembagian_soal_asesi($id_asesi);
            $detail_asesi = $this->asesiModel->get_detail_asesi($id_asesi);
            $data = [
                'nama_page' => 'kelola nilai',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'nilai_asesi' => $nilai_asesi,
                'pembagian_soal_asesi' => $pembagian_soal_asesi,
                'id_asesi' => $id_asesi,
                'detail_asesi' => $detail_asesi
            ];
            return view('tzi23/soal_dan_penilaian/kelola_nilai/edit_nilai', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function SubEditNilai($id_asesi)
    {
        $nilai_asesi = $this->nilaiModel->get_nilai_asesi($id_asesi);
        $detail_asesi = $this->asesiModel->get_detail_asesi($id_asesi);
        foreach ($nilai_asesi as $n) :
            $id_penilaian = $this->request->getVar($n['id_penilaian'] . '_id');
            $id_soal = $this->request->getVar($n['id_penilaian'] . '_soal');
            $id_user = $this->request->getVar($n['id_penilaian'] . '_user');
            $nilai_baru = $this->request->getVar($n['id_penilaian'] . '_nilai');
            $pokja_baru = $this->request->getVar($n['id_penilaian'] . '_pokja');
            $jawaban_program_baru = $this->request->getVar($n['id_penilaian'] . '_jawaban_program');
            if ($detail_asesi['jenis_jabatan'] == 'pegawai') {
                if ($n['kategori'] == 'pilgan') {
                    $this->nilaiModel->save([
                        'id_penilaian' => $id_penilaian,
                        'nilai' => $nilai_baru
                    ]);
                } else if ($n['kategori'] == 'wajib') {
                    $this->nilaiModel->save([
                        'id_penilaian' => $id_penilaian,
                        'pokja' => $pokja_baru
                    ]);
                } else if ($n['kategori'] == 'wajib2') {
                    $this->nilaiModel->save([
                        'id_penilaian' => $id_penilaian,
                        'jawaban_program' => $jawaban_program_baru
                    ]);
                }
            } else {
                if ($n['kategori'] == 'acak' || $n['kategori'] == 'wajib2') {
                    $this->nilaiModel->save([
                        'id_penilaian' => $id_penilaian,
                        'nilai' => $nilai_baru
                    ]);
                } else if ($n['kategori'] == 'wajib') {
                    $this->nilaiModel->save([
                        'id_penilaian' => $id_penilaian,
                        'pokja' => $pokja_baru
                    ]);
                }
            }

        endforeach;
        echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/edit-nilai-tzi23/" . $id_asesi . "';
                    </script>";
    }
}
