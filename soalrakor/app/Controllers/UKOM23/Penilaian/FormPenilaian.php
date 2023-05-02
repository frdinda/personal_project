<?php

namespace App\Controllers\UKOM23\Penilaian;

use App\Controllers\BaseController;
use App\Models\UKOM23\UKOM23_NilaiModel;
use App\Models\UKOM23\UKOM23_PesertaModel;
use App\Models\UKOM23\UKOM23_PesertaPeriodeModel;
use App\Models\UKOM23\UKOM23_SoalModel;
use App\Models\UKOM23\UKOM23_SatkerModel;

class FormPenilaian extends BaseController
{
    protected $nilaiModel;
    protected $pesertaModel;
    protected $satkerModel;
    protected $soalModel;
    protected $pesertaPeriodeModel;
    public function __construct()
    {
        $this->nilaiModel = new UKOM23_NilaiModel;
        $this->pesertaModel = new UKOM23_PesertaModel;
        $this->satkerModel = new UKOM23_SatkerModel;
        $this->soalModel = new UKOM23_SoalModel;
        $this->pesertaPeriodeModel = new UKOM23_PesertaPeriodeModel;
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function FormPilihPeserta()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        $periode = $this->session->periode_berjalan;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Form Penilaian',
                    'nama_subpage' => 'Form Pilih Peserta',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'daftar_peserta' => $this->pesertaPeriodeModel->get_peserta_periode_per_periode($periode['id_periode'])
                ];
                return view('ukom23/soal_dan_penilaian/form_penilaian/form_pilih_peserta', $data);
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

    public function FormPemastianPeserta()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $id_peserta = $this->request->getVar('id_peserta');
                $periode = $this->session->periode_berjalan;
                $soal_selanjutnya = $this->nilaiModel->get_soal_pertama($id_peserta, $periode['id_periode']);
                if (isset($soal_selanjutnya)) {
                    $id_soal_selanjutnya = $soal_selanjutnya['id_soal'];
                    $data = [
                        'nama_page' => 'Form Penilaian',
                        'nama_subpage' => 'Form Pemastian Peserta',
                        'nama_user' => $this->session->nama_user,
                        'akses' => $akses,
                        'detail_peserta' => $this->pesertaModel->get_detail_peserta($id_peserta),
                        'id_soal_selanjutnya' => $id_soal_selanjutnya
                    ];
                    return view('ukom23/soal_dan_penilaian/form_penilaian/form_pemastian_peserta', $data);
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

    public function FormPenilaian()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $id_peserta = $this->request->getVar('id_peserta');
                $periode = $this->session->periode_berjalan;
                $subformpenilaian = $this->SubFormPenilaian();
                if (isset($subformpenilaian)) {
                    $soal_peserta = $this->nilaiModel->get_pembagian_soal_peserta($id_peserta, $periode['id_periode']);
                    $id_soal = $this->request->getVar('id_soal_selanjutnya');
                    $id_user = $this->session->id_user;
                    for ($i = 0; $i <= count($soal_peserta); $i++) {
                        if ($i == (count($soal_peserta))) {
                            echo "<script> alert('Berhasil Tersimpan, Evaluasi Selesai'); window.location.href='/beranda-ukom23'; </script>";
                        } else {
                            if ($soal_peserta[$i]['id_soal'] == $id_soal) {
                                if ($i == 0) {
                                    $nomor_soal = $i + 1;
                                    $soal_ke = 'pertama';
                                    $id_soal_selanjutnya = $soal_peserta[$i + 1]['id_soal'];
                                    $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                    $periode = $this->session->periode_berjalan;
                                    $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                    $data = [
                                        'nama_page' => 'Form Penilaian',
                                        'nama_subpage' => 'Form Penilaian',
                                        'nama_user' => $this->session->nama_user,
                                        'akses' => $akses,
                                        'soal_peserta' => $soal_peserta,
                                        'nomor_soal' => $nomor_soal,
                                        'soal_ke' => $soal_ke,
                                        'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                        'detail_soal' => $detail_soal,
                                        'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                        'id_peserta' => $id_peserta
                                    ];
                                    return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                                } else if ($i == (count($soal_peserta) - 1)) {
                                    $nomor_soal = $i + 1;
                                    $soal_ke = 'terakhir';
                                    $id_soal_sebelumnya = $soal_peserta[$i - 1]['id_soal'];
                                    $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                    $periode = $this->session->periode_berjalan;
                                    $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                    $data = [
                                        'nama_page' => 'Form Penilaian',
                                        'nama_subpage' => 'Form Penilaian',
                                        'nama_user' => $this->session->nama_user,
                                        'akses' => $akses,
                                        'soal_peserta' => $soal_peserta,
                                        'nomor_soal' => $nomor_soal,
                                        'soal_ke' => $soal_ke,
                                        'detail_soal' => $detail_soal,
                                        'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                        'id_peserta' => $id_peserta,
                                        'id_soal_sebelumnya' => $id_soal_sebelumnya
                                    ];
                                    return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                                } else {
                                    $nomor_soal = $i + 1;
                                    $soal_ke = 'tengah';
                                    $id_soal_selanjutnya = $soal_peserta[$i + 1]['id_soal'];
                                    $id_soal_sebelumnya = $soal_peserta[$i - 1]['id_soal'];
                                    $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                    $periode = $this->session->periode_berjalan;
                                    $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                    $data = [
                                        'nama_page' => 'Form Penilaian',
                                        'nama_subpage' => 'Form Penilaian',
                                        'nama_user' => $this->session->nama_user,
                                        'akses' => $akses,
                                        'soal_peserta' => $soal_peserta,
                                        'nomor_soal' => $nomor_soal,
                                        'soal_ke' => $soal_ke,
                                        'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                        'detail_soal' => $detail_soal,
                                        'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                        'id_peserta' => $id_peserta,
                                        'id_soal_sebelumnya' => $id_soal_sebelumnya
                                    ];
                                    return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                                }
                            }
                        }
                    }
                } else {
                    $soal_peserta = $this->nilaiModel->get_pembagian_soal_peserta($id_peserta, $periode['id_periode']);
                    $id_soal = $this->request->getVar('id_soal_selanjutnya');
                    $id_user = $this->session->id_user;
                    for ($i = 0; $i < count($soal_peserta); $i++) {
                        if ($soal_peserta[$i]['id_soal'] == $id_soal) {
                            if ($i == 0) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'pertama';
                                $id_soal_selanjutnya = $soal_peserta[$i + 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $periode = $this->session->periode_berjalan;
                                $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                $data = [
                                    'nama_page' => 'Form Penilaian',
                                    'nama_subpage' => 'Form Penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_peserta' => $soal_peserta,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                    'id_peserta' => $id_peserta
                                ];
                                return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else if ($i == (count($soal_peserta) - 1)) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'terakhir';
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $periode = $this->session->periode_berjalan;
                                $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                $data = [
                                    'nama_page' => 'Form Penilaian',
                                    'nama_subpage' => 'Form Penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_peserta' => $soal_peserta,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'detail_soal' => $detail_soal,
                                    'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                    'id_peserta' => $id_peserta
                                ];
                                return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'tengah';
                                $id_soal_selanjutnya = $soal_peserta[$i + 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $periode = $this->session->periode_berjalan;
                                $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                $data = [
                                    'nama_page' => 'Form Penilaian',
                                    'nama_subpage' => 'Form Penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_peserta' => $soal_peserta,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                    'id_peserta' => $id_peserta
                                ];
                                return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            }
                        }
                    }
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

    public function FormPenilaianSebelum()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $id_peserta = $this->request->getVar('id_peserta');
                $periode = $this->session->periode_berjalan;
                $subformpenilaian = $this->SubFormPenilaian();
                if (isset($subformpenilaian)) {
                    $soal_peserta = $this->nilaiModel->get_pembagian_soal_peserta($id_peserta, $periode['id_periode']);
                    $id_soal = $this->request->getVar('id_soal_sebelum');
                    $id_user = $this->session->id_user;
                    for ($i = 0; $i <= count($soal_peserta); $i++) {
                        if ($i == (count($soal_peserta))) {
                            echo "<script> alert('Berhasil Tersimpan, Evaluasi Selesai'); window.location.href='/beranda'; </script>";
                        } else {
                            if ($soal_peserta[$i]['id_soal'] == $id_soal) {
                                if ($i == 0) {
                                    $nomor_soal = $i + 1;
                                    $soal_ke = 'pertama';
                                    $id_soal_selanjutnya = $soal_peserta[$i + 1]['id_soal'];
                                    $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                    $periode = $this->session->periode_berjalan;
                                    $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                    $data = [
                                        'nama_page' => 'Form Penilaian',
                                        'nama_subpage' => 'Form Penilaian',
                                        'nama_user' => $this->session->nama_user,
                                        'akses' => $akses,
                                        'soal_peserta' => $soal_peserta,
                                        'nomor_soal' => $nomor_soal,
                                        'soal_ke' => $soal_ke,
                                        'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                        'detail_soal' => $detail_soal,
                                        'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                        'id_peserta' => $id_peserta
                                    ];
                                    return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                                } else if ($i == (count($soal_peserta) - 1)) {
                                    $nomor_soal = $i + 1;
                                    $soal_ke = 'terakhir';
                                    $id_soal_sebelumnya = $soal_peserta[$i - 1]['id_soal'];
                                    $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                    $periode = $this->session->periode_berjalan;
                                    $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                    $data = [
                                        'nama_page' => 'Form Penilaian',
                                        'nama_subpage' => 'Form Penilaian',
                                        'nama_user' => $this->session->nama_user,
                                        'akses' => $akses,
                                        'soal_peserta' => $soal_peserta,
                                        'nomor_soal' => $nomor_soal,
                                        'soal_ke' => $soal_ke,
                                        'detail_soal' => $detail_soal,
                                        'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                        'id_peserta' => $id_peserta,
                                        'id_soal_sebelumnya' => $id_soal_sebelumnya
                                    ];
                                    return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                                } else {
                                    $nomor_soal = $i + 1;
                                    $soal_ke = 'tengah';
                                    $id_soal_selanjutnya = $soal_peserta[$i + 1]['id_soal'];
                                    $id_soal_sebelumnya = $soal_peserta[$i - 1]['id_soal'];
                                    $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                    $periode = $this->session->periode_berjalan;
                                    $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                    $data = [
                                        'nama_page' => 'Form Penilaian',
                                        'nama_subpage' => 'Form Penilaian',
                                        'nama_user' => $this->session->nama_user,
                                        'akses' => $akses,
                                        'soal_peserta' => $soal_peserta,
                                        'nomor_soal' => $nomor_soal,
                                        'soal_ke' => $soal_ke,
                                        'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                        'detail_soal' => $detail_soal,
                                        'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                        'id_peserta' => $id_peserta,
                                        'id_soal_sebelumnya' => $id_soal_sebelumnya
                                    ];
                                    return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                                }
                            }
                        }
                    }
                } else {
                    $soal_peserta = $this->nilaiModel->get_pembagian_soal_peserta($id_peserta, $periode['id_periode']);
                    $id_soal = $this->request->getVar('id_soal_selanjutnya');
                    $id_user = $this->session->id_user;
                    for ($i = 0; $i < count($soal_peserta); $i++) {
                        if ($soal_peserta[$i]['id_soal'] == $id_soal) {
                            if ($i == 0) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'pertama';
                                $id_soal_selanjutnya = $soal_peserta[$i + 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $periode = $this->session->periode_berjalan;
                                $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                $data = [
                                    'nama_page' => 'Form Penilaian',
                                    'nama_subpage' => 'Form Penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_peserta' => $soal_peserta,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                    'id_peserta' => $id_peserta
                                ];
                                return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else if ($i == (count($soal_peserta) - 1)) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'terakhir';
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $periode = $this->session->periode_berjalan;
                                $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                $data = [
                                    'nama_page' => 'Form Penilaian',
                                    'nama_subpage' => 'Form Penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_peserta' => $soal_peserta,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'detail_soal' => $detail_soal,
                                    'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                    'id_peserta' => $id_peserta
                                ];
                                return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'tengah';
                                $id_soal_selanjutnya = $soal_peserta[$i + 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $periode = $this->session->periode_berjalan;
                                $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $periode['id_periode']);
                                $data = [
                                    'nama_page' => 'Form Penilaian',
                                    'nama_subpage' => 'Form Penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_peserta' => $soal_peserta,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_peserta_persoal' => $nilai_peserta_persoal,
                                    'id_peserta' => $id_peserta
                                ];
                                return view('ukom23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            }
                        }
                    }
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

    public function SubFormPenilaian()
    {
        $id_user = $this->session->id_user;
        $id_soal_submit = $this->request->getVar('id_soal');
        $id_peserta = $this->request->getVar('id_peserta');
        $nilai_submit = $this->request->getVar('nilai');
        $periode = $this->session->periode_berjalan;
        if (isset($nilai_submit)) {
            $nilai_peserta_persoal = $this->nilaiModel->get_nilai_peserta_persoal($id_soal_submit, $id_peserta, $id_user, $periode['id_periode']);
            if (isset($nilai_peserta_persoal)) {
                $this->nilaiModel->save([
                    'id_penilaian' => $nilai_peserta_persoal['id_penilaian'],
                    'id_soal' => $id_soal_submit,
                    'id_peserta' => $id_peserta,
                    'id_user' => $id_user,
                    'nilai' => $nilai_submit,
                    'id_periode' => $periode['id_periode']
                ]);
                $status_submit = "done";
                return $status_submit;
            } else {
                $this->nilaiModel->insert([
                    'id_soal' => $id_soal_submit,
                    'id_peserta' => $id_peserta,
                    'id_user' => $id_user,
                    'nilai' => $nilai_submit,
                    'id_periode' => $periode['id_periode']
                ]);
                $status_submit = "done";
                return $status_submit;
            }
        } else {
            $status_submit = "soal pertama";
            return $status_submit;
        }
    }
}
