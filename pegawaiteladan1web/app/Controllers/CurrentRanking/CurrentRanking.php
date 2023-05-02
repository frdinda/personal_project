<?php

namespace App\Controllers\CurrentRanking;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PenilaianAtasanLangsungModel;
use App\Models\PertanyaanModel;
use App\Models\PollingPegawaiModel;
use App\Models\PegawaiTeladanModel;

class CurrentRanking extends BaseController
{
    protected $pegawaiModel;
    protected $penilaianAtasanLangsungModel;
    protected $pertanyaanModel;
    protected $pollingPegawaiModel;
    protected $pegawaiTeladanModel;
    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->penilaianAtasanLangsungModel = new PenilaianAtasanLangsungModel();
        $this->pertanyaanModel = new PertanyaanModel();
        $this->pollingPegawaiModel = new PollingPegawaiModel();
        $this->pegawaiTeladanModel = new PegawaiTeladanModel();
    }

    public function index()
    {
        // yang perlu diambil, nama-nama yang diusulkan (yang di polling pegawai), terus ambil data pegawai keseluruhannya terus buat kayak yang polling pegawai, tapi dia diranking by nilai yang ada di kolom terakhir nanti pas di tabelnya. gausah ada nomornya lah, biarin aja. 

        if (isset($this->session->jenis_user)) {
            $struktural = $this->pegawaiModel->get_atasan_langsung();
            $d = 0;
            foreach ($struktural as $s) :
                $a = 0;
                $pegawai_per_atasan_langsung = $this->pegawaiModel->get_pegawai_per_atasan_langsung($s['nip']);
                // $pegawai_per_atasan_langsung = $this->pegawaiModel->get_pegawai_per_atasan_langsung('198212102010121002');

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
                    // if ($s['nip'] == '196509021985031001') {
                    //     dd($nilai_pegawai);
                    // }
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
                                if (count($nilai_tertinggi) > 1) {
                                    $nilai_tertinggi[0]['nip_pegawai'] = $nilai_pegawai[$i]['nip_pegawai'];
                                    $nilai_tertinggi[0]['nilai'] = $nilai_pegawai[$i]['nilai'];
                                    $b = 0;
                                    for ($c = 1; $c < count($nilai_tertinggi); $c++) {
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

                    for ($i = 0; $i < count($nilai_pegawai); $i++) {
                        $nilai_pegawai[$i]['nip_pegawai'] = null;
                        $nilai_pegawai[$i]['nilai'] = null;
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
            endforeach;
            $data_pegawai = $this->pegawaiModel->get_pegawai();
            // udah dapat pegawai yang diusulkan, sekarang ambil data votenya per pegawai. jadi for pegawai_yang_diusulkan, terus ambil data votenya di periode polling itu, terus jumlahin dan bagi total pegawai dikali 100. abis itu dikalkulasi 60:40. baru masukkan ke array pegawai_yang_diusulkan, nilainya tambah nilai polling dan nilai total
            for ($i = 0; $i < count($pegawai_yang_diusulkan); $i++) {
                $total_vote = 0;
                $nilai_vote = 0;
                $nilai_total = 0;
                $hasil_polling_pegawai = $this->pollingPegawaiModel->get_polling_per_pegawai_yang_diusulkan_dan_periode($pegawai_yang_diusulkan[$i]['nip_pegawai'], date('M, Y'));
                foreach ($hasil_polling_pegawai as $h) :
                    $total_vote = $total_vote + $h['nilai_polling'];
                endforeach;
                $nilai_vote = ($total_vote / count($data_pegawai)) * 100;
                $pegawai_yang_diusulkan[$i]['nilai_vote'] = $nilai_vote;
                $nilai_total = ((40 * $pegawai_yang_diusulkan[$i]['nilai_atasan_langsung']) / 100) + ((60 * $nilai_vote) / 100);
                $pegawai_yang_diusulkan[$i]['nilai_total'] = $nilai_total;
            }
            $data = [
                'nama_page' => 'Current Ranking',
                'nama_sub_page' => 'Current Ranking (' . date('M, Y') . ')',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'pegawai_yang_diusulkan' => $pegawai_yang_diusulkan,
                'data_pegawai' => $data_pegawai
            ];

            return view('current_ranking/current_ranking', $data);
        } else {
            echo "<script>
                    alert('Anda Tidak Punya Akses, Silahkan Login');
                    window.location.href='/';
                    </script>";
        }
    }

    public function TentukanPegawaiTeladan()
    {
        // disini cari yang nilai totalnya paling tinggi, functionnya sama kayak yang di index, cuma nambah for lagi untuk cari nilai paling tinggi. 

        if (isset($this->session->jenis_user)) {
            if (date('d') == '24') {
                $struktural = $this->pegawaiModel->get_atasan_langsung();
                $d = 0;
                foreach ($struktural as $s) :
                    $a = 0;
                    $pegawai_per_atasan_langsung = $this->pegawaiModel->get_pegawai_per_atasan_langsung($s['nip']);
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
                                    $pegawai_yang_diusulkan[$d]['nilai_atasan_langsung'] = $nilai_tertinggi[$c]['nilai'];
                                    $d++;
                                }
                            }
                        } else {
                            $pegawai_yang_diusulkan[$d]['nip_pegawai'] = $nilai_tertinggi[0]['nip_pegawai'];
                            $pegawai_yang_diusulkan[$d]['nilai_atasan_langsung'] = $nilai_tertinggi[0]['nilai'];
                            $d++;
                        }
                    }
                endforeach;
                $data_pegawai = $this->pegawaiModel->get_pegawai();
                // udah dapat pegawai yang diusulkan, sekarang ambil data votenya per pegawai. jadi for pegawai_yang_diusulkan, terus ambil data votenya di periode polling itu, terus jumlahin dan bagi total pegawai dikali 100. abis itu dikalkulasi 60:40. baru masukkan ke array pegawai_yang_diusulkan, nilainya tambah nilai polling dan nilai total
                for ($i = 0; $i < count($pegawai_yang_diusulkan); $i++) {
                    $total_vote = 0;
                    $nilai_vote = 0;
                    $nilai_total = 0;
                    $hasil_polling_pegawai = $this->pollingPegawaiModel->get_polling_per_pegawai_yang_diusulkan_dan_periode($pegawai_yang_diusulkan[$i]['nip_pegawai'], date('M, Y'));
                    foreach ($hasil_polling_pegawai as $h) :
                        $total_vote = $total_vote + $h['nilai_polling'];
                    endforeach;
                    $nilai_vote = ($total_vote / count($data_pegawai)) * 100;
                    $pegawai_yang_diusulkan[$i]['nilai_vote'] = $nilai_vote;
                    $nilai_total = ((40 * $pegawai_yang_diusulkan[$i]['nilai_atasan_langsung']) / 100) + ((60 * $nilai_vote) / 100);
                    $pegawai_yang_diusulkan[$i]['nilai_total'] = $nilai_total;
                }
                $b = 0;
                $pegawai_teladan[0]['nip_pegawai'] = $pegawai_yang_diusulkan[0]['nip_pegawai'];
                $pegawai_teladan[0]['nilai_atasan_langsung'] = $pegawai_yang_diusulkan[0]['nilai_atasan_langsung'];
                $pegawai_teladan[0]['nilai_vote'] = $pegawai_yang_diusulkan[0]['nilai_vote'];
                $pegawai_teladan[0]['nilai_total'] = $pegawai_yang_diusulkan[0]['nilai_total'];
                for ($i = 0; $i < count($pegawai_yang_diusulkan); $i++) {
                    if ($i == 0) {
                        $pegawai_teladan[$b]['nip_pegawai'] = $pegawai_yang_diusulkan[$i]['nip_pegawai'];
                        $pegawai_teladan[$b]['nilai_atasan_langsung'] = $pegawai_yang_diusulkan[$i]['nilai_atasan_langsung'];
                        $pegawai_teladan[$b]['nilai_vote'] = $pegawai_yang_diusulkan[$i]['nilai_vote'];
                        $pegawai_teladan[$b]['nilai_total'] = $pegawai_yang_diusulkan[$i]['nilai_total'];
                        $b++;
                    } else {
                        if ($pegawai_yang_diusulkan[$i]['nilai'] > $pegawai_teladan[0]['nilai']) {
                            if (count($pegawai_yang_diusulkan) > 1) {
                                $pegawai_teladan[0]['nip_pegawai'] = $pegawai_yang_diusulkan[$i]['nip_pegawai'];
                                $pegawai_teladan[0]['nilai_atasan_langsung'] = $pegawai_yang_diusulkan[$i]['nilai_atasan_langsung'];
                                $pegawai_teladan[0]['nilai_vote'] = $pegawai_yang_diusulkan[$i]['nilai_vote'];
                                $pegawai_teladan[0]['nilai_total'] = $pegawai_yang_diusulkan[$i]['nilai_total'];
                                $b = 0;
                                for ($c = 1; $c < count($pegawai_yang_diusulkan); $c++) {
                                    $pegawai_teladan[$c]['nip_pegawai'] = null;
                                    $pegawai_teladan[$c]['nilai_atasan_langsung'] = null;
                                    $pegawai_teladan[$c]['nilai_vote'] = null;
                                    $pegawai_teladan[$c]['nilai_total'] = null;
                                }
                            } else {
                                $pegawai_teladan[0]['nip_pegawai'] = $pegawai_yang_diusulkan[$i]['nip_pegawai'];
                                $pegawai_teladan[0]['nilai_atasan_langsung'] = $pegawai_yang_diusulkan[$i]['nilai_atasan_langsung'];
                                $pegawai_teladan[0]['nilai_vote'] = $pegawai_yang_diusulkan[$i]['nilai_vote'];
                                $pegawai_teladan[0]['nilai_total'] = $pegawai_yang_diusulkan[$i]['nilai_total'];
                            }
                        } else if ($pegawai_yang_diusulkan[$i]['nilai'] == $pegawai_teladan[0]['nilai']) {
                            $pegawai_teladan[$b]['nip_pegawai'] = $pegawai_yang_diusulkan[$i]['nip_pegawai'];
                            $pegawai_teladan[$b]['nilai_atasan_langsung'] = $pegawai_yang_diusulkan[$i]['nilai_atasan_langsung'];
                            $pegawai_teladan[$b]['nilai_vote'] = $pegawai_yang_diusulkan[$i]['nilai_vote'];
                            $pegawai_teladan[$b]['nilai_total'] = $pegawai_yang_diusulkan[$i]['nilai_total'];
                            $b++;
                        }
                    }
                }


                // MASUKKAN DATA KE TABEL PEGAWAI TELADAN 'id_pegawai_teladan', 'nip_pegawai', 'bulan_ditetapkan'
                $pegawai_teladan_bulan_ini = $this->pegawaiTeladanModel->get_pegawai_teladan_per_periode(date('M, Y'));
                if ($pegawai_teladan_bulan_ini != null) {
                    // hapus data yang sebelumnya, insert baru
                    foreach ($pegawai_teladan_bulan_ini as $p) :
                        $this->pegawaiTeladanModel->delete([
                            'id_pegawai_teladan' => $p['id_pegawai_teladan']
                        ]);
                    endforeach;
                    $e = 1;
                    foreach ($pegawai_teladan as $p) :
                        $id_pegawai_teladan_bulan_ini = md5(date('M, Y') . 'pegawai_teladan' . $e);
                        $e++;
                        $this->pegawaiTeladanModel->insert([
                            'id_pegawai_teladan' => $id_pegawai_teladan_bulan_ini,
                            'nip_pegawai' => $p['nip_pegawai'],
                            'periode_pegawai_teladan' => date('M, Y'),
                            'bulan_ditetapkan' => date('Y-m-d')
                        ]);
                    endforeach;
                } else {
                    $e = 1;
                    foreach ($pegawai_teladan as $p) :
                        $id_pegawai_teladan_bulan_ini = md5(date('M, Y') . 'pegawai_teladan' . $e);
                        $e++;
                        $this->pegawaiTeladanModel->insert([
                            'id_pegawai_teladan' => $id_pegawai_teladan_bulan_ini,
                            'nip_pegawai' => $p['nip_pegawai'],
                            'periode_pegawai_teladan' => date('M, Y'),
                            'bulan_ditetapkan' => date('Y-m-d')
                        ]);
                    endforeach;
                }

                $data = [
                    'nama_page' => 'Current Ranking',
                    'nama_sub_page' => 'Current Ranking',
                    'nama_pegawai' => $this->session->nama_pegawai,
                    'jenis_user' => $this->session->jenis_user,
                    'nama_jabatan' => $this->session->nama_jabatan,
                    'nip_pegawai' => $this->session->nip_pegawai,
                    'pegawai_teladan' => $pegawai_teladan,
                    'data_pegawai' => $data_pegawai
                ];

                return view('current_ranking/congratulatory_page', $data);
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
    }
}
