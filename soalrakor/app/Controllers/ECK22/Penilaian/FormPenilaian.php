<?php

namespace App\Controllers\ECK22\Penilaian;

use App\Controllers\BaseController;
use App\Models\ECK22\NilaiModel;
use App\Models\ECK22\SatkerModel;
use App\Models\ECK22\SoalModel;

class FormPenilaian extends BaseController
{
    protected $nilaiModel;
    protected $satkerModel;
    protected $soalModel;
    public function __construct()
    {
        $this->nilaiModel = new NilaiModel;
        $this->satkerModel = new SatkerModel;
        $this->soalModel = new SoalModel;
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function FormPilihSatker()
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $data = [
                'nama_page' => 'form pilih satker',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'daftar_satker' => $this->satkerModel->get_satker()
            ];
            return view('eck22/soal_dan_penilaian/form_penilaian/form_pilih_satker', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function FormPemastianSatker()
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $id_satker = $this->request->getVar('id_satker');
            $soal_selanjutnya = $this->nilaiModel->get_soal_pertama($id_satker);
            if (isset($soal_selanjutnya)) {
                $id_soal_selanjutnya = $soal_selanjutnya['id_soal'];
                $data = [
                    'nama_page' => 'form pemastian satker',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $this->session->akses,
                    'detail_satker' =>  $this->satkerModel->get_detail_satker($id_satker),
                    'id_soal_selanjutnya' => $id_soal_selanjutnya
                ];
                return view('eck22/soal_dan_penilaian/form_penilaian/form_pemastian_satker', $data);
            } else {
                echo "<script>
            alert('Satker belum memiliki pembagian soal');
            window.location.href='/beranda';
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
        $id_satker = $this->request->getVar('id_satker');
        if (isset($akses)) {
            $id_soal_submit = $this->request->getVar('id_soal');
            $subformpenilaian = $this->SubFormPenilaian();
            if (isset($subformpenilaian)) {
                $soal_satker = $this->nilaiModel->get_pembagian_soal_satker($id_satker);
                $id_soal = $this->request->getVar('id_soal_selanjutnya');
                $id_user = $this->session->id_user;
                for ($i = 0; $i <= count($soal_satker); $i++) {
                    if ($i == (count($soal_satker))) {
                        echo "<script> alert('Berhasil Tersimpan, Evaluasi Selesai'); window.location.href='/beranda'; </script>";
                    } else {
                        if ($soal_satker[$i]['id_soal'] == $id_soal) {
                            if ($i == 0) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'pertama';
                                $id_soal_selanjutnya = $soal_satker[$i + 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_satker' => $soal_satker,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_satker_persoal' => $nilai_satker_persoal,
                                    'id_satker' => $id_satker
                                ];
                                return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else if ($i == (count($soal_satker) - 1)) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'terakhir';
                                $id_soal_sebelumnya = $soal_satker[$i - 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_satker' => $soal_satker,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'detail_soal' => $detail_soal,
                                    'nilai_satker_persoal' => $nilai_satker_persoal,
                                    'id_satker' => $id_satker,
                                    'id_soal_sebelumnya' => $id_soal_sebelumnya
                                ];
                                return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'tengah';
                                $id_soal_selanjutnya = $soal_satker[$i + 1]['id_soal'];
                                $id_soal_sebelumnya = $soal_satker[$i - 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_satker' => $soal_satker,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_satker_persoal' => $nilai_satker_persoal,
                                    'id_satker' => $id_satker,
                                    'id_soal_sebelumnya' => $id_soal_sebelumnya
                                ];
                                return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            }
                        }
                    }
                }
            } else {
                $soal_satker = $this->nilaiModel->get_pembagian_soal_satker($id_satker);
                $id_soal = $this->request->getVar('id_soal_selanjutnya');
                $id_user = $this->session->id_user;
                for ($i = 0; $i < count($soal_satker); $i++) {
                    if ($soal_satker[$i]['id_soal'] == $id_soal) {
                        if ($i == 0) {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'pertama';
                            $id_soal_selanjutnya = $soal_satker[$i + 1]['id_soal'];
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_satker' => $soal_satker,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                'detail_soal' => $detail_soal,
                                'nilai_satker_persoal' => $nilai_satker_persoal,
                                'id_satker' => $id_satker
                            ];
                            return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                        } else if ($i == (count($soal_satker) - 1)) {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'terakhir';
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_satker' => $soal_satker,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'detail_soal' => $detail_soal,
                                'nilai_satker_persoal' => $nilai_satker_persoal,
                                'id_satker' => $id_satker
                            ];
                            return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                        } else {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'tengah';
                            $id_soal_selanjutnya = $soal_satker[$i + 1]['id_soal'];
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_satker' => $soal_satker,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                'detail_soal' => $detail_soal,
                                'nilai_satker_persoal' => $nilai_satker_persoal,
                                'id_satker' => $id_satker
                            ];
                            return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
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
    }

    public function FormPenilaianSebelum()
    {
        $akses = $this->session->akses;
        $id_satker = $this->request->getVar('id_satker');
        if (isset($akses)) {
            $id_soal_submit = $this->request->getVar('id_soal');
            $subformpenilaian = $this->SubFormPenilaian();
            if (isset($subformpenilaian)) {
                $soal_satker = $this->nilaiModel->get_pembagian_soal_satker($id_satker);
                $id_soal = $this->request->getVar('id_soal_sebelum');
                $id_user = $this->session->id_user;
                for ($i = 0; $i <= count($soal_satker); $i++) {
                    if ($i == (count($soal_satker))) {
                        echo "<script> alert('Berhasil Tersimpan, Evaluasi Selesai'); window.location.href='/beranda'; </script>";
                    } else {
                        if ($soal_satker[$i]['id_soal'] == $id_soal) {
                            if ($i == 0) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'pertama';
                                $id_soal_selanjutnya = $soal_satker[$i + 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_satker' => $soal_satker,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_satker_persoal' => $nilai_satker_persoal,
                                    'id_satker' => $id_satker
                                ];
                                return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else if ($i == (count($soal_satker) - 1)) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'terakhir';
                                $id_soal_sebelumnya = $soal_satker[$i - 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_satker' => $soal_satker,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'detail_soal' => $detail_soal,
                                    'nilai_satker_persoal' => $nilai_satker_persoal,
                                    'id_satker' => $id_satker,
                                    'id_soal_sebelumnya' => $id_soal_sebelumnya
                                ];
                                return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'tengah';
                                $id_soal_selanjutnya = $soal_satker[$i + 1]['id_soal'];
                                $id_soal_sebelumnya = $soal_satker[$i - 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_satker' => $soal_satker,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_satker_persoal' => $nilai_satker_persoal,
                                    'id_satker' => $id_satker,
                                    'id_soal_sebelumnya' => $id_soal_sebelumnya
                                ];
                                return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            }
                        }
                    }
                }
            } else {
                $soal_satker = $this->nilaiModel->get_pembagian_soal_satker($id_satker);
                $id_soal = $this->request->getVar('id_soal_selanjutnya');
                $id_user = $this->session->id_user;
                for ($i = 0; $i < count($soal_satker); $i++) {
                    if ($soal_satker[$i]['id_soal'] == $id_soal) {
                        if ($i == 0) {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'pertama';
                            $id_soal_selanjutnya = $soal_satker[$i + 1]['id_soal'];
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_satker' => $soal_satker,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                'detail_soal' => $detail_soal,
                                'nilai_satker_persoal' => $nilai_satker_persoal,
                                'id_satker' => $id_satker
                            ];
                            return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                        } else if ($i == (count($soal_satker) - 1)) {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'terakhir';
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_satker' => $soal_satker,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'detail_soal' => $detail_soal,
                                'nilai_satker_persoal' => $nilai_satker_persoal,
                                'id_satker' => $id_satker
                            ];
                            return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                        } else {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'tengah';
                            $id_soal_selanjutnya = $soal_satker[$i + 1]['id_soal'];
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal, $id_satker, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_satker' => $soal_satker,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                'detail_soal' => $detail_soal,
                                'nilai_satker_persoal' => $nilai_satker_persoal,
                                'id_satker' => $id_satker
                            ];
                            return view('eck22/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
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
    }

    public function SubFormPenilaian()
    {
        $id_user = $this->session->id_user;
        $id_soal_submit = $this->request->getVar('id_soal');
        $id_satker = $this->request->getVar('id_satker');
        $nilai_submit = $this->request->getVar('nilai');
        $simpulan = $this->request->getVar('simpulan');
        if (isset($nilai_submit)) {
            $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal_submit, $id_satker, $id_user);
            if (isset($nilai_satker_persoal)) {
                $this->nilaiModel->save([
                    'id_penilaian' => $nilai_satker_persoal['id_penilaian'],
                    'id_soal' => $id_soal_submit,
                    'id_satker' => $id_satker,
                    'id_user' => $id_user,
                    'nilai' => $nilai_submit,
                    'simpulan' => $simpulan
                ]);
                $status_submit = "done";
                return $status_submit;
            } else {
                $this->nilaiModel->insert([
                    'id_soal' => $id_soal_submit,
                    'id_satker' => $id_satker,
                    'id_user' => $id_user,
                    'nilai' => $nilai_submit,
                    'simpulan' => $simpulan
                ]);
                $status_submit = "done";
                return $status_submit;
            }
        } else if (isset($simpulan)) {
            $nilai_satker_persoal = $this->nilaiModel->get_nilai_satker_persoal($id_soal_submit, $id_satker, $id_user);
            if (isset($nilai_satker_persoal)) {
                $this->nilaiModel->save([
                    'id_penilaian' => $nilai_satker_persoal['id_penilaian'],
                    'id_soal' => $id_soal_submit,
                    'id_satker' => $id_satker,
                    'id_user' => $id_user,
                    'nilai' => 0,
                    'simpulan' => $simpulan
                ]);
                $status_submit = "done";
                return $status_submit;
            } else {
                $this->nilaiModel->insert([
                    'id_soal' => $id_soal_submit,
                    'id_satker' => $id_satker,
                    'id_user' => $id_user,
                    'nilai' => 0,
                    'simpulan' => $simpulan
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
