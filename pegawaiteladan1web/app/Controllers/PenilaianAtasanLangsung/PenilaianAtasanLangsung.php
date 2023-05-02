<?php

namespace App\Controllers\PenilaianAtasanLangsung;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PenilaianAtasanLangsungModel;
use App\Models\PertanyaanModel;

class PenilaianAtasanLangsung extends BaseController
{
    protected $pegawaiModel;
    protected $penilaianAtasanLangsungModel;
    protected $pertanyaanModel;
    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->penilaianAtasanLangsungModel = new PenilaianAtasanLangsungModel();
        $this->pertanyaanModel = new PertanyaanModel();
    }

    public function PilihAtasanLangsung()
    {
        if (isset($this->session->jenis_user) && $this->session->jenis_user == 'Admin') {
            $data_atasan_langsung = $this->pegawaiModel->get_atasan_langsung();
            $data = [
                'nama_page' => 'Penilaian Atasan Langsung',
                'nama_sub_page' => 'Pilih Atasan Langsung',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'data_atasan_langsung' => $data_atasan_langsung
            ];
            return view('penilaian_atasan_langsung/pilih_atasan_langsung', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function ProsesPilihAtasanLangsung()
    {
        if (isset($this->session->jenis_user) && $this->session->jenis_user == 'Admin') {
            $nip_atasan_langsung = $this->request->getVar('nip_atasan_langsung');
            $pegawai_per_atasan_langsung = $this->pegawaiModel->get_pegawai_per_atasan_langsung($nip_atasan_langsung);

            $d = 0;
            $a = 0;
            if (isset($pegawai_per_atasan_langsung)) {
                foreach ($pegawai_per_atasan_langsung as $p) :
                    $periode_penilaian = date('M, Y');
                    $nilai_pegawai_per_pertanyaan = $this->penilaianAtasanLangsungModel->get_nilai_per_pegawai_per_periode($p['nip'], $periode_penilaian);
                    $total_profesional = 0;
                    $total_akuntabel = 0;
                    $total_sinergi = 0;
                    $total_transparan = 0;
                    $total_inovatif = 0;
                    foreach ($nilai_pegawai_per_pertanyaan as $n) :
                        if ($n['kategori_pertanyaan'] == 'Profesional') {
                            $total_profesional = $total_profesional + $n['nilai'];
                        } else if ($n['kategori_pertanyaan'] == 'Akuntabel') {
                            $total_akuntabel = $total_akuntabel + $n['nilai'];
                        } else if ($n['kategori_pertanyaan'] == 'Sinergi') {
                            $total_sinergi = $total_sinergi + $n['nilai'];
                        } else if ($n['kategori_pertanyaan'] == 'Transparan') {
                            $total_transparan = $total_transparan + $n['nilai'];
                        } else if ($n['kategori_pertanyaan'] == 'Inovatif') {
                            $total_inovatif = $total_inovatif + $n['nilai'];
                        }
                    endforeach;
                    $profesional = $total_profesional / 6;
                    $akuntabel = $total_akuntabel / 5;
                    $sinergi = $total_sinergi / 5;
                    $transparan = $total_transparan / 5;
                    $inovatif = $total_inovatif / 5;
                    $nilai_total = ($profesional + $akuntabel + $sinergi + $transparan + $inovatif) / 5;
                    $nilai_pegawai[$a]['nip_pegawai'] = $p['nip'];
                    $nilai_pegawai[$a]['nilai'] = $nilai_total;
                    $a++;
                endforeach;
                $b = 0;
                $nilai_tertinggi[0]['nip_pegawai'] = $nilai_pegawai[0]['nip_pegawai'];
                $nilai_tertinggi[0]['nilai'] = $nilai_pegawai[0]['nilai'];
                // NENTUKAN NILAI TERTINGGI YANG DIUSULKAN ATASAN LANGSUNG
                // kalau nilainya sama, dia nambah di selanjutnya, tapi kalau ternyata dia lebih besar, hapus semua yang di selanjutnya, terus jadiin dia satu-satunya data
                for ($i = 0; $i < count($nilai_pegawai); $i++) {
                    if ($i == 0) {
                        $nilai_tertinggi[$b]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                        $nilai_tertinggi[$b]['nilai'] = $nilai_pegawai[$i]['nilai'];
                        $b++;
                    } else {
                        if ($nilai_pegawai[$i]['nilai'] > $nilai_tertinggi[0]['nilai']) {
                            if (count($nilai_pegawai) > 1) {
                                $nilai_tertinggi[0]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                                $nilai_tertinggi[0]['nilai'] = $nilai_pegawai[$i]['nilai'];
                                $b = 0;
                                for ($c = 1; $c < count($nilai_pegawai); $c++) {
                                    $nilai_tertinggi[$c]['nip_pegawai'] = null;
                                    $nilai_tertinggi[$c]['nilai'] = null;
                                }
                            } else {
                                $nilai_tertinggi[0]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                                $nilai_tertinggi[0]['nilai'] = $nilai_pegawai[$i]['nilai'];
                            }
                        } else if ($nilai_pegawai[$i]['nilai'] == $nilai_tertinggi[0]['nilai']) {
                            $nilai_tertinggi[$b]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                            $nilai_tertinggi[$b]['nilai'] = $nilai_pegawai[$i]['nilai'];
                            $b++;
                        }
                    }
                }
                if (count($nilai_tertinggi) > 1) {
                    for ($c = 0; $c < count($nilai_tertinggi); $c++) {
                        if ($nilai_tertinggi[$c]['nip_pegawai'] != null) {
                            $pegawai_yang_diusulkan[$d]['nip_pegawai'] = $nilai_tertinggi[$c]['nip_pegawai'];
                            $pegawai_yang_diusulkan[$d]['nilai'] = $nilai_tertinggi[$c]['nilai'];
                            $d++;
                        }
                    }
                } else {
                    $pegawai_yang_diusulkan[$d]['nip_pegawai'] = $nilai_tertinggi[0]['nip_pegawai'];
                    $pegawai_yang_diusulkan[$d]['nilai'] = $nilai_tertinggi[0]['nilai'];
                    $d++;
                }
            }

            if ($pegawai_yang_diusulkan != null && $pegawai_yang_diusulkan[0]['nilai'] != 0) {
                $detail_pegawai_yang_diusulkan = $this->pegawaiModel->get_detail_pegawai($pegawai_yang_diusulkan[0]['nip_pegawai']);
            } else if ($pegawai_yang_diusulkan[0]['nilai'] == 0) {
                $detail_pegawai_yang_diusulkan = null;
            }

            $data = [
                'nama_page' => 'Penilaian Atasan Langsung',
                'nama_sub_page' => 'Pilih Pegawai',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'pegawai_per_atasan_langsung' => $pegawai_per_atasan_langsung,
                'detail_pegawai_yang_diusulkan' => $detail_pegawai_yang_diusulkan
            ];
            return view('penilaian_atasan_langsung/pilih_pegawai', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function PilihPegawai()
    {
        // cari pegawai dengan nilai tertinggi yang diusulkan, ambil detail pegawainya, nanti yang ditampilin yang nilainya tertinggi aja

        if (isset($this->session->jenis_user)) {
            $nip_atasan_langsung = $this->session->nip_pegawai;
            $data_atasan_langsung = $this->pegawaiModel->get_detail_pegawai($nip_atasan_langsung);
            if ($data_atasan_langsung['struktural'] == 'Y') {
                if (date('d') == '22') {
                    $pegawai_per_atasan_langsung = $this->pegawaiModel->get_pegawai_per_atasan_langsung($nip_atasan_langsung);

                    $d = 0;
                    $a = 0;
                    if (isset($pegawai_per_atasan_langsung)) {
                        foreach ($pegawai_per_atasan_langsung as $p) :
                            $periode_penilaian = date('M, Y');
                            $nilai_pegawai_per_pertanyaan = $this->penilaianAtasanLangsungModel->get_nilai_per_pegawai_per_periode($p['nip'], $periode_penilaian);
                            $total_profesional = 0;
                            $total_akuntabel = 0;
                            $total_sinergi = 0;
                            $total_transparan = 0;
                            $total_inovatif = 0;
                            foreach ($nilai_pegawai_per_pertanyaan as $n) :
                                if ($n['kategori_pertanyaan'] == 'Profesional') {
                                    $total_profesional = $total_profesional + $n['nilai'];
                                } else if ($n['kategori_pertanyaan'] == 'Akuntabel') {
                                    $total_akuntabel = $total_akuntabel + $n['nilai'];
                                } else if ($n['kategori_pertanyaan'] == 'Sinergi') {
                                    $total_sinergi = $total_sinergi + $n['nilai'];
                                } else if ($n['kategori_pertanyaan'] == 'Transparan') {
                                    $total_transparan = $total_transparan + $n['nilai'];
                                } else if ($n['kategori_pertanyaan'] == 'Inovatif') {
                                    $total_inovatif = $total_inovatif + $n['nilai'];
                                }
                            endforeach;
                            $profesional = $total_profesional / 6;
                            $akuntabel = $total_akuntabel / 5;
                            $sinergi = $total_sinergi / 5;
                            $transparan = $total_transparan / 5;
                            $inovatif = $total_inovatif / 5;
                            $nilai_total = ($profesional + $akuntabel + $sinergi + $transparan + $inovatif) / 5;
                            $nilai_pegawai[$a]['nip_pegawai'] = $p['nip'];
                            $nilai_pegawai[$a]['nilai'] = $nilai_total;
                            $a++;
                        endforeach;
                        $b = 0;
                        $nilai_tertinggi[0]['nip_pegawai'] = $nilai_pegawai[0]['nip_pegawai'];
                        $nilai_tertinggi[0]['nilai'] = $nilai_pegawai[0]['nilai'];
                        // NENTUKAN NILAI TERTINGGI YANG DIUSULKAN ATASAN LANGSUNG
                        // kalau nilainya sama, dia nambah di selanjutnya, tapi kalau ternyata dia lebih besar, hapus semua yang di selanjutnya, terus jadiin dia satu-satunya data
                        for ($i = 0; $i < count($nilai_pegawai); $i++) {
                            if ($i == 0) {
                                $nilai_tertinggi[$b]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                                $nilai_tertinggi[$b]['nilai'] = $nilai_pegawai[$i]['nilai'];
                                $b++;
                            } else {
                                if ($nilai_pegawai[$i]['nilai'] > $nilai_tertinggi[0]['nilai']) {
                                    if (count($nilai_pegawai) > 1) {
                                        $nilai_tertinggi[0]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                                        $nilai_tertinggi[0]['nilai'] = $nilai_pegawai[$i]['nilai'];
                                        $b = 0;
                                        for ($c = 1; $c < count($nilai_pegawai); $c++) {
                                            $nilai_tertinggi[$c]['nip_pegawai'] = null;
                                            $nilai_tertinggi[$c]['nilai'] = null;
                                        }
                                    } else {
                                        $nilai_tertinggi[0]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                                        $nilai_tertinggi[0]['nilai'] = $nilai_pegawai[$i]['nilai'];
                                    }
                                } else if ($nilai_pegawai[$i]['nilai'] == $nilai_tertinggi[0]['nilai']) {
                                    $nilai_tertinggi[$b]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                                    $nilai_tertinggi[$b]['nilai'] = $nilai_pegawai[$i]['nilai'];
                                    $b++;
                                }
                            }
                        }
                        if (count($nilai_tertinggi) > 1) {
                            for ($c = 0; $c < count($nilai_tertinggi); $c++) {
                                if ($nilai_tertinggi[$c]['nip_pegawai'] != null) {
                                    $pegawai_yang_diusulkan[$d]['nip_pegawai'] = $nilai_tertinggi[$c]['nip_pegawai'];
                                    $pegawai_yang_diusulkan[$d]['nilai'] = $nilai_tertinggi[$c]['nilai'];
                                    $d++;
                                }
                            }
                        } else {
                            $pegawai_yang_diusulkan[$d]['nip_pegawai'] = $nilai_tertinggi[0]['nip_pegawai'];
                            $pegawai_yang_diusulkan[$d]['nilai'] = $nilai_tertinggi[0]['nilai'];
                            $d++;
                        }
                    }

                    if ($pegawai_yang_diusulkan != null && $pegawai_yang_diusulkan[0]['nilai'] != 0) {
                        $detail_pegawai_yang_diusulkan = $this->pegawaiModel->get_detail_pegawai($pegawai_yang_diusulkan[0]['nip_pegawai']);
                    } else if ($pegawai_yang_diusulkan[0]['nilai'] == 0) {
                        $detail_pegawai_yang_diusulkan = null;
                    }

                    $data = [
                        'nama_page' => 'Penilaian Atasan Langsung',
                        'nama_sub_page' => 'Pilih Pegawai',
                        'nama_pegawai' => $this->session->nama_pegawai,
                        'jenis_user' => $this->session->jenis_user,
                        'nama_jabatan' => $this->session->nama_jabatan,
                        'nip_pegawai' => $this->session->nip_pegawai,
                        'pegawai_per_atasan_langsung' => $pegawai_per_atasan_langsung,
                        'detail_pegawai_yang_diusulkan' => $detail_pegawai_yang_diusulkan
                    ];
                    return view('penilaian_atasan_langsung/pilih_pegawai', $data);
                } else {
                    echo "<script>
                    alert('Belum Memasuki Waktu Pengerjaan');
                    window.location.href='/';
                    </script>";
                }
            } else {
                echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
            }
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function PenilaianAtasanLangsung($nip_pegawai)
    {
        if (isset($this->session->jenis_user)) {
            $detail_pegawai = $this->pegawaiModel->get_detail_pegawai($nip_pegawai);
            if ($detail_pegawai['nip_atasan_langsung'] == $this->session->nip_pegawai || $this->session->jenis_user == 'Admin') {
                $periode_penilaian = date('M, Y');
                $nilai_atasan_langsung = $this->penilaianAtasanLangsungModel->get_nilai_per_pegawai_per_periode($nip_pegawai, $periode_penilaian);
                $pertanyaan = $this->pertanyaanModel->get_pertanyaan();
                $nip_atasan_langsung = $detail_pegawai['nip_atasan_langsung'];
                $data = [
                    'nama_page' => 'Penilaian Atasan Langsung',
                    'nama_sub_page' => 'Penilaian Atasan',
                    'nama_pegawai' => $this->session->nama_pegawai,
                    'jenis_user' => $this->session->jenis_user,
                    'nama_jabatan' => $this->session->nama_jabatan,
                    'nip_pegawai' => $this->session->nip_pegawai,
                    'nip_pegawai_yang_dinilai' => $detail_pegawai['nip'],
                    'nip_atasan_langsung' => $nip_atasan_langsung,
                    'detail_pegawai' => $detail_pegawai,
                    'nilai_atasan_langsung' => $nilai_atasan_langsung,
                    'periode_penilaian' => $periode_penilaian,
                    'pertanyaan' => $pertanyaan
                ];
                return view('penilaian_atasan_langsung/penilaian_atasan_langsung', $data);
            } else {
                echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
            }
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function ProsesPenilaianAtasanLangsung()
    {
        // ambil data, kalau disebelah dia foreach nilai asesi 
        $nip_pegawai = $this->request->getVar('nip_pegawai');
        $nip_atasan_langsung = $this->request->getVar('nip_atasan_langsung');
        $save = $this->request->getVar('save');
        if ($save == 'Save') {
            // berarti dia ngambilnya nilai_atasan_langsung
            $periode_penilaian = date('M, Y');
            $nilai_atasan_langsung = $this->penilaianAtasanLangsungModel->get_nilai_per_pegawai_per_periode($nip_pegawai, $periode_penilaian);
            foreach ($nilai_atasan_langsung as $n) :
                $id_penilaian_atasan_langsung = $this->request->getVar($n['id_penilaian_atasan_langsung'] . '_id');
                $nilai = $this->request->getVar($n['id_penilaian_atasan_langsung'] . '_nilai');
                $this->penilaianAtasanLangsungModel->save([
                    'id_penilaian_atasan_langsung' => $id_penilaian_atasan_langsung,
                    'nilai' => $nilai
                ]);
            endforeach;
            if ($this->session->jenis_user == 'Admin') {
                echo "<script>
                alert('Data Berhasil Disimpan');
                window.location.href='/pilih-atasan-langsung';
                </script>";
            } else {
                echo "<script>
                    alert('Data Berhasil Disimpan');
                    window.location.href='/pilih-pegawai';
                    </script>";
            }
        } else {
            // berarti dia ngambilnya pertanyaan
            $pertanyaan = $this->pertanyaanModel->get_pertanyaan();
            $periode_penilaian = date('M, Y');
            foreach ($pertanyaan as $p) :
                $id_pertanyaan = $this->request->getVar($p['id_pertanyaan'] . '_id');
                $nilai = $this->request->getVar($p['id_pertanyaan'] . '_nilai');
                $id_penilaian_atasan_langsung = md5($nip_pegawai . $id_pertanyaan . $periode_penilaian . 'atasan');
                $this->penilaianAtasanLangsungModel->insert([
                    'id_penilaian_atasan_langsung' => $id_penilaian_atasan_langsung,
                    'nip_pegawai' => $nip_pegawai,
                    'nip_atasan_langsung' => $nip_atasan_langsung,
                    'id_pertanyaan' => $id_pertanyaan,
                    'periode_penilaian' => $periode_penilaian,
                    'nilai' => $nilai
                ]);
            endforeach;
            if ($this->session->jenis_user == 'Admin') {
                echo "<script>
                alert('Data Berhasil Disimpan');
                window.location.href='/pilih-atasan-langsung';
                </script>";
            } else {
                echo "<script>
                    alert('Data Berhasil Disimpan');
                    window.location.href='/pilih-pegawai';
                    </script>";
            }
        }
    }
}
