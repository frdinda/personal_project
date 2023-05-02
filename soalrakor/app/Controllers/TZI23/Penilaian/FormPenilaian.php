<?php

namespace App\Controllers\TZI23\Penilaian;

use App\Controllers\BaseController;
use App\Models\TZI23\TZI23_NilaiModel;
use App\Models\TZI23\TZI23_AsesiModel;
use App\Models\TZI23\TZI23_SoalModel;

class FormPenilaian extends BaseController
{
    protected $nilaiModel;
    protected $asesiModel;
    protected $soalModel;
    public function __construct()
    {
        $this->nilaiModel = new TZI23_NilaiModel;
        $this->asesiModel = new TZI23_AsesiModel;
        $this->soalModel = new TZI23_SoalModel;
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function FormPilihAsesi()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses) && $jenis_assessment == 'TZI23') {
            if ($akses == 'pegawai') {
                $id_user = $this->session->id_user;
                $soal_selanjutnya = $this->nilaiModel->get_soal_pertama($id_user);
                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($soal_selanjutnya['id_soal'], $soal_selanjutnya['id_asesi'], $id_user);
                // YANG UDAH GABISA LAGI
                if (isset($nilai_asesi_persoal['nilai']) || isset($nilai_asesi_persoal['jawaban_dipilih'])) {
                    echo "<script>
                    alert('Anda Telah Melakukan Pengisian');
                    window.location.href='/beranda-tzi23';
                    </script>";
                } else {
                    if (isset($soal_selanjutnya)) {
                        $id_soal_selanjutnya = $soal_selanjutnya['id_soal'];
                        $data = [
                            'nama_page' => 'Form Pemastian Asesi',
                            'nama_user' => $this->session->nama_user,
                            'akses' => $this->session->akses,
                            'detail_asesi' => $this->asesiModel->get_detail_asesi($id_user),
                            'id_soal_selanjutnya' => $id_soal_selanjutnya
                        ];
                        return view('tzi23/soal_dan_penilaian/form_penilaian/form_pemastian_asesi', $data);
                    } else {
                        echo "<script>
                alert('Asesi belum memiliki pembagian soal');
                window.location.href='/beranda-tzi23';
                </script>";
                    }
                }
            } else {
                $data = [
                    'nama_page' => 'Form Pilih Asesi',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'daftar_asesi' => $this->asesiModel->get_asesi()
                ];
                return view('tzi23/soal_dan_penilaian/form_penilaian/form_pilih_asesi', $data);
            }
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function FormPemastianAsesi()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses) && $jenis_assessment == 'TZI23') {
            $id_asesi = $this->request->getVar('id_asesi');
            $soal_selanjutnya = $this->nilaiModel->get_soal_pertama($id_asesi);
            if (isset($soal_selanjutnya)) {
                $id_soal_selanjutnya = $soal_selanjutnya['id_soal'];
                $data = [
                    'nama_page' => 'Form Pemastian Asesi',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $this->session->akses,
                    'detail_asesi' => $this->asesiModel->get_detail_asesi($id_asesi),
                    'id_soal_selanjutnya' => $id_soal_selanjutnya
                ];
                return view('tzi23/soal_dan_penilaian/form_penilaian/form_pemastian_asesi', $data);
            } else {
                echo "<script>
            alert('Asesi belum memiliki pembagian soal');
            window.location.href='/beranda-tzi23';
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
        $id_asesi = $this->request->getVar('id_asesi');
        if (isset($akses)) {
            $id_soal_submit = $this->request->getVar('id_soal');
            $subformpenilaian = $this->SubFormPenilaian();
            if (isset($subformpenilaian)) {
                $soal_asesi = $this->nilaiModel->get_pembagian_soal_asesi($id_asesi);
                $id_soal = $this->request->getVar('id_soal_selanjutnya');
                $id_user = $this->session->id_user;
                for ($i = 0; $i <= count($soal_asesi); $i++) {
                    if ($i == (count($soal_asesi))) {
                        echo "<script> alert('Berhasil Tersimpan, Evaluasi Selesai'); window.location.href='/beranda-tzi23'; </script>";
                    } else {
                        if ($soal_asesi[$i]['id_soal'] == $id_soal) {
                            if ($i == 0) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'pertama';
                                $id_soal_selanjutnya = $soal_asesi[$i + 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_asesi' => $soal_asesi,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                    'id_asesi' => $id_asesi
                                ];
                                return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else if ($i == (count($soal_asesi) - 1)) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'terakhir';
                                $id_soal_sebelumnya = $soal_asesi[$i - 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_asesi' => $soal_asesi,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'detail_soal' => $detail_soal,
                                    'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                    'id_asesi' => $id_asesi,
                                    'id_soal_sebelumnya' => $id_soal_sebelumnya
                                ];
                                return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'tengah';
                                $id_soal_selanjutnya = $soal_asesi[$i + 1]['id_soal'];
                                $id_soal_sebelumnya = $soal_asesi[$i - 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_asesi' => $soal_asesi,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                    'id_asesi' => $id_asesi,
                                    'id_soal_sebelumnya' => $id_soal_sebelumnya
                                ];
                                return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            }
                        }
                    }
                }
            } else {
                $soal_asesi = $this->nilaiModel->get_pembagian_soal_asesi($id_asesi);
                $id_soal = $this->request->getVar('id_soal_selanjutnya');
                $id_user = $this->session->id_user;
                for ($i = 0; $i < count($soal_asesi); $i++) {
                    if ($soal_asesi[$i]['id_soal'] == $id_soal) {
                        if ($i == 0) {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'pertama';
                            $id_soal_selanjutnya = $soal_asesi[$i + 1]['id_soal'];
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_asesi' => $soal_asesi,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                'detail_soal' => $detail_soal,
                                'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                'id_asesi' => $id_asesi
                            ];
                            return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                        } else if ($i == (count($soal_asesi) - 1)) {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'terakhir';
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_asesi' => $soal_asesi,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'detail_soal' => $detail_soal,
                                'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                'id_asesi' => $id_asesi
                            ];
                            return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                        } else {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'tengah';
                            $id_soal_selanjutnya = $soal_asesi[$i + 1]['id_soal'];
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_asesi' => $soal_asesi,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                'detail_soal' => $detail_soal,
                                'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                'id_asesi' => $id_asesi
                            ];
                            return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
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
        $id_asesi = $this->request->getVar('id_asesi');
        if (isset($akses)) {
            $id_soal_submit = $this->request->getVar('id_soal');
            $subformpenilaian = $this->SubFormPenilaian();
            if (isset($subformpenilaian)) {
                $soal_asesi = $this->nilaiModel->get_pembagian_soal_asesi($id_asesi);
                $id_soal = $this->request->getVar('id_soal_sebelum');
                $id_user = $this->session->id_user;
                for ($i = 0; $i <= count($soal_asesi); $i++) {
                    if ($i == (count($soal_asesi))) {
                        echo "<script> alert('Berhasil Tersimpan, Evaluasi Selesai'); window.location.href='/beranda-tzi23'; </script>";
                    } else {
                        if ($soal_asesi[$i]['id_soal'] == $id_soal) {
                            if ($i == 0) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'pertama';
                                $id_soal_selanjutnya = $soal_asesi[$i + 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_asesi' => $soal_asesi,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                    'id_asesi' => $id_asesi
                                ];
                                return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else if ($i == (count($soal_asesi) - 1)) {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'terakhir';
                                $id_soal_sebelumnya = $soal_asesi[$i - 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_asesi' => $soal_asesi,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'detail_soal' => $detail_soal,
                                    'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                    'id_asesi' => $id_asesi,
                                    'id_soal_sebelumnya' => $id_soal_sebelumnya
                                ];
                                return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            } else {
                                $nomor_soal = $i + 1;
                                $soal_ke = 'tengah';
                                $id_soal_selanjutnya = $soal_asesi[$i + 1]['id_soal'];
                                $id_soal_sebelumnya = $soal_asesi[$i - 1]['id_soal'];
                                $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                                $data = [
                                    'nama_page' => 'form penilaian',
                                    'nama_user' => $this->session->nama_user,
                                    'akses' => $akses,
                                    'soal_asesi' => $soal_asesi,
                                    'nomor_soal' => $nomor_soal,
                                    'soal_ke' => $soal_ke,
                                    'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                    'detail_soal' => $detail_soal,
                                    'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                    'id_asesi' => $id_asesi,
                                    'id_soal_sebelumnya' => $id_soal_sebelumnya
                                ];
                                return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                            }
                        }
                    }
                }
            } else {
                $soal_asesi = $this->nilaiModel->get_pembagian_soal_asesi($id_asesi);
                $id_soal = $this->request->getVar('id_soal_selanjutnya');
                $id_user = $this->session->id_user;
                for ($i = 0; $i < count($soal_asesi); $i++) {
                    if ($soal_asesi[$i]['id_soal'] == $id_soal) {
                        if ($i == 0) {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'pertama';
                            $id_soal_selanjutnya = $soal_asesi[$i + 1]['id_soal'];
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_asesi' => $soal_asesi,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                'detail_soal' => $detail_soal,
                                'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                'id_asesi' => $id_asesi
                            ];
                            return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                        } else if ($i == (count($soal_asesi) - 1)) {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'terakhir';
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_asesi' => $soal_asesi,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'detail_soal' => $detail_soal,
                                'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                'id_asesi' => $id_asesi
                            ];
                            return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
                        } else {
                            $nomor_soal = $i + 1;
                            $soal_ke = 'tengah';
                            $id_soal_selanjutnya = $soal_asesi[$i + 1]['id_soal'];
                            $detail_soal = $this->soalModel->get_detail_soal($id_soal);
                            $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user);
                            $data = [
                                'nama_page' => 'form penilaian',
                                'nama_user' => $this->session->nama_user,
                                'akses' => $akses,
                                'soal_asesi' => $soal_asesi,
                                'nomor_soal' => $nomor_soal,
                                'soal_ke' => $soal_ke,
                                'id_soal_selanjutnya' => $id_soal_selanjutnya,
                                'detail_soal' => $detail_soal,
                                'nilai_asesi_persoal' => $nilai_asesi_persoal,
                                'id_asesi' => $id_asesi
                            ];
                            return view('tzi23/soal_dan_penilaian/form_penilaian/form_penilaian', $data);
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
        $id_asesi = $this->request->getVar('id_asesi');
        $nilai_submit = $this->request->getVar('nilai');
        $pokja = $this->request->getVar('pokja');
        $jawaban_program = $this->request->getVar('jawaban_program');
        if ($this->session->akses == 'pegawai') {
            $id_asesi = $this->session->id_user;
            $jawaban_pilgan = $this->request->getVar('customRadio');
            if (isset($jawaban_pilgan)) {
                $detail_soal = $this->soalModel->get_detail_soal($id_soal_submit);
                if ($jawaban_pilgan == $detail_soal['jawaban']) {
                    $nilai_submit = 10;
                } else {
                    $nilai_submit = 0;
                }
                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal_submit, $id_asesi, $id_user);
                if (isset($nilai_asesi_persoal)) {
                    $this->nilaiModel->save([
                        'id_penilaian' => $nilai_asesi_persoal['id_penilaian'],
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => $nilai_submit,
                        'pokja' => $pokja,
                        'jawaban_dipilih' => $jawaban_pilgan
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                } else {
                    $this->nilaiModel->insert([
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => $nilai_submit,
                        'pokja' => $pokja,
                        'jawaban_dipilih' => $jawaban_pilgan
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                }
            } else if (isset($pokja)) {
                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal_submit, $id_asesi, $id_user);
                if (isset($nilai_asesi_persoal)) {
                    $this->nilaiModel->save([
                        'id_penilaian' => $nilai_asesi_persoal['id_penilaian'],
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => 0,
                        'pokja' => $pokja,
                        'jawaban_dipilih' => null
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                } else {
                    $this->nilaiModel->insert([
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => 0,
                        'pokja' => $pokja,
                        'jawaban_dipilih' => null
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                }
            } else if (isset($jawaban_program)) {
                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal_submit, $id_asesi, $id_user);
                if (isset($nilai_asesi_persoal)) {
                    $this->nilaiModel->save([
                        'id_penilaian' => $nilai_asesi_persoal['id_penilaian'],
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => 0,
                        'pokja' => $pokja,
                        'jawaban_dipilih' => null,
                        'jawaban_program' => $jawaban_program
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                } else {
                    $this->nilaiModel->insert([
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => 0,
                        'pokja' => $pokja,
                        'jawaban_dipilih' => null,
                        'jawaban_program' => $jawaban_program
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                }
            } else {
                $status_submit = "soal pertama";
                return $status_submit;
            }
        } else {
            if (isset($nilai_submit)) {
                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal_submit, $id_asesi, $id_user);
                if (isset($nilai_asesi_persoal)) {
                    $this->nilaiModel->save([
                        'id_penilaian' => $nilai_asesi_persoal['id_penilaian'],
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => $nilai_submit,
                        'pokja' => $pokja
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                } else {
                    $this->nilaiModel->insert([
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => $nilai_submit,
                        'pokja' => $pokja
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                }
            } else if (isset($pokja)) {
                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal_submit, $id_asesi, $id_user);
                if (isset($nilai_asesi_persoal)) {
                    $this->nilaiModel->save([
                        'id_penilaian' => $nilai_asesi_persoal['id_penilaian'],
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => 0,
                        'pokja' => $pokja
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                } else {
                    $this->nilaiModel->insert([
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => 0,
                        'pokja' => $pokja
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                }
            } else if (isset($jawaban_program)) {
                $nilai_asesi_persoal = $this->nilaiModel->get_nilai_asesi_persoal($id_soal_submit, $id_asesi, $id_user);
                if (isset($nilai_asesi_persoal)) {
                    $this->nilaiModel->save([
                        'id_penilaian' => $nilai_asesi_persoal['id_penilaian'],
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => 0,
                        'pokja' => $pokja,
                        'jawaban_dipilih' => null,
                        'jawaban_program' => $jawaban_program
                    ]);
                    $status_submit = "done";
                    return $status_submit;
                } else {
                    $this->nilaiModel->insert([
                        'id_soal' => $id_soal_submit,
                        'id_asesi' => $id_asesi,
                        'id_user' => $id_user,
                        'nilai' => 0,
                        'pokja' => $pokja,
                        'jawaban_dipilih' => null,
                        'jawaban_program' => $jawaban_program
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
}
