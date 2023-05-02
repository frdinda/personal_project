<?php

namespace App\Controllers\PollingPegawai;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PenilaianAtasanLangsungModel;
use App\Models\PertanyaanModel;
use App\Models\PollingPegawaiModel;

class PollingPegawai extends BaseController
{
    protected $pegawaiModel;
    protected $penilaianAtasanLangsungModel;
    protected $pertanyaanModel;
    protected $pollingPegawaiModel;
    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->penilaianAtasanLangsungModel = new PenilaianAtasanLangsungModel();
        $this->pertanyaanModel = new PertanyaanModel();
        $this->pollingPegawaiModel = new PollingPegawaiModel();
    }

    public function index()
    {
        // get data yang struktural, terus ambil data pegawai di bawahnya masing-masing, terus ambil data nilainya untuk periode itu untuk masing-masing pegawai, terus kalkulasiin nilainya, masukin ke array sama nip pegawainya, terus ambil nilai tertinggi, yang diusulin masukin array baru
        if (isset($this->session->jenis_user)) {
            if (date('d') == '23' || $this->session->jenis_user == 'Admin') {
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
                // dd($pegawai_yang_diusulkan);
                // get data pegawai yang diusulin
                $pegawai_usulan_sebelumnya = $this->pollingPegawaiModel->get_polling_per_pegawai_dan_periode($this->session->nip_pegawai, date('M, Y'));

                if ($pegawai_usulan_sebelumnya != null) {
                    $detail_pegawai_usulan_sebelumnya = $this->pegawaiModel->get_detail_pegawai($pegawai_usulan_sebelumnya['nip_pegawai_usulan']);
                    $data = [
                        'nama_page' => 'Polling Pegawai',
                        'nama_sub_page' => 'Polling Pegawai',
                        'nama_pegawai' => $this->session->nama_pegawai,
                        'jenis_user' => $this->session->jenis_user,
                        'nama_jabatan' => $this->session->nama_jabatan,
                        'nip_pegawai' => $this->session->nip_pegawai,
                        'pegawai_yang_diusulkan' => $pegawai_yang_diusulkan,
                        'data_pegawai' => $data_pegawai,
                        'voted' => 'yes',
                        'pegawai_usulan_sebelumnya' => $pegawai_usulan_sebelumnya,
                        'detail_pegawai_usulan_sebelumnya' => $detail_pegawai_usulan_sebelumnya
                    ];
                } else {
                    $data = [
                        'nama_page' => 'Polling Pegawai',
                        'nama_sub_page' => 'Polling Pegawai',
                        'nama_pegawai' => $this->session->nama_pegawai,
                        'jenis_user' => $this->session->jenis_user,
                        'nama_jabatan' => $this->session->nama_jabatan,
                        'nip_pegawai' => $this->session->nip_pegawai,
                        'pegawai_yang_diusulkan' => $pegawai_yang_diusulkan,
                        'data_pegawai' => $data_pegawai,
                        'voted' => 'no'
                    ];
                }

                return view('polling_pegawai/polling_pegawai', $data);
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

    public function ProsesPollingPegawai()
    {
        $nip_pegawai_usulan = $this->request->getVar('nip_pegawai');
        $nip_pegawai = $this->session->nip_pegawai;
        $nilai_polling = 1;

        $pegawai_usulan_sebelumnya = $this->pollingPegawaiModel->get_polling_per_pegawai_dan_periode($this->session->nip_pegawai, date('M, Y'));
        if ($pegawai_usulan_sebelumnya != null) {
            $this->pollingPegawaiModel->save([
                'id_polling' => $pegawai_usulan_sebelumnya['id_polling'],
                'nip_pegawai_usulan' => $nip_pegawai_usulan,
                'nilai_polling' => $nilai_polling
            ]);
            echo "<script>
                    alert('Data Berhasil Disimpan');
                    window.location.href='/polling-pegawai';
                    </script>";
        } else {

            $id_polling = md5($nip_pegawai . date('M, Y') . 'polling');
            $this->pollingPegawaiModel->insert([
                'id_polling' => $id_polling,
                'nip_pegawai' => $nip_pegawai,
                'nip_pegawai_usulan' => $nip_pegawai_usulan,
                'periode_polling' => date('M, Y'),
                'nilai_polling' => $nilai_polling
            ]);
            echo "<script>
                    alert('Data Berhasil Disimpan');
                    window.location.href='/polling-pegawai';
                    </script>";
        }
    }
}
