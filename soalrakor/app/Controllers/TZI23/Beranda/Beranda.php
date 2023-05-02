<?php

namespace App\Controllers\TZI23\Beranda;

use App\Controllers\BaseController;
use App\Models\TZI23\TZI23_NilaiModel;
use App\Models\TZI23\TZI23_AsesiModel;

class Beranda extends BaseController
{
    protected $nilaiModel;
    protected $asesiModel;
    public function __construct()
    {
        $this->nilaiModel = new TZI23_NilaiModel;
        $this->asesiModel = new TZI23_AsesiModel();
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
            if ($jenis_assessment == 'TZI23') {
                $nilai_dashboard = $this->nilaiModel->get_nilai_dashboard();
                $pembagian_soal = $this->nilaiModel->get_pembagian_soal();
                $daftar_asesi = $this->asesiModel->get_asesi();
                $data_nilai_asesi = $this->DataNilaiAsesi();
                $data_pokja_pilihan_asesi = $this->DataPokjaPilihanAsesi();
                $data_nilai_pegawai = $this->DataNilaiPegawai();
                $data_pokja_pilihan_pegawai = $this->DataPokjaPilihanPegawai();
                $json_data_pokja_pilihan_asesi = json_encode($data_pokja_pilihan_asesi);
                $json_nilai_asesi = json_encode($data_nilai_asesi);
                $json_nilai_pegawai = json_encode($data_nilai_pegawai);
                $json_data_pokja_pilihan_pegawai = json_encode($data_pokja_pilihan_pegawai);
                $data = [
                    'nama_page' => 'Beranda',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'nilai_dashboard' => $nilai_dashboard,
                    'pembagian_soal' => $pembagian_soal,
                    'daftar_asesi' => $daftar_asesi,
                    'id_user'  => $this->session->id_user,
                    'data_nilai_asesi' => $data_nilai_asesi,
                    'json_nilai_asesi' => $json_nilai_asesi,
                    'json_data_pokja_pilihan_asesi' => $json_data_pokja_pilihan_asesi,
                    'json_nilai_pegawai' => $json_nilai_pegawai,
                    'json_data_pokja_pilihan_pegawai' => $json_data_pokja_pilihan_pegawai
                ];
                return view('tzi23/beranda/beranda', $data);
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

    public function DetailPenilaian($id_asesi)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'TZI23') {
                $nilai_asesi = $this->nilaiModel->get_nilai_asesi($id_asesi);
                if (isset($nilai_asesi)) {
                    $pembagian_soal_asesi = $this->nilaiModel->get_pembagian_soal_asesi($id_asesi);
                    $detail_asesi = $this->asesiModel->get_detail_asesi($id_asesi);
                    $data = [
                        'nama_page' => 'Detail Penilaian',
                        'nama_user' => $this->session->nama_user,
                        'akses' => $akses,
                        'nilai_asesi' => $nilai_asesi,
                        'pembagian_soal_asesi' => $pembagian_soal_asesi,
                        'id_asesi' => $id_asesi,
                        'detail_asesi' => $detail_asesi
                    ];
                    return view('tzi23/beranda/detail_penilaian', $data);
                } else {
                    echo "<script>
                    alert('Asesi Belum Dinilai');
                    window.location.href='/beranda-tzi23';
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

    public function DataNilaiAsesi()
    {
        $data_asesi = $this->asesiModel->get_asesi();
        $nol = 0;
        $sepuluh = 0;
        $duapuluh = 0;
        $tigapuluh = 0;
        $empatpuluh = 0;
        $limapuluh = 0;
        $enampuluh = 0;
        $tujuhpuluh = 0;
        $delapanpuluh = 0;
        $sembilanpuluh = 0;
        $seratus = 0;
        foreach ($data_asesi as $d) :
            $pembagian_soal = $this->nilaiModel->get_pembagian_soal_asesi($d['id_asesi']);
            $nilai_asesi = $this->nilaiModel->get_nilai_asesi($d['id_asesi']);
            $nilai_akhir = 0;
            $total_keseluruhan = 0;
            $a = 0;
            if ($d['jenis_jabatan'] != 'pegawai') {
                foreach ($pembagian_soal as $p) :
                    $total_persoal = 0;
                    foreach ($nilai_asesi as $n) :
                        if ($p['id_soal'] == $n['id_soal'] && $d['id_asesi'] == $n['id_asesi']) {
                            if ($n['kategori'] == 'wajib') {
                                $pokja[$a] = $n['pokja'];
                            } else if ($n['kategori'] == 'acak' || $n['kategori'] == 'wajib2') {
                                $total_persoal = $total_persoal + $n['nilai'];
                            }
                        }
                    endforeach;
                    $total_keseluruhan = $total_keseluruhan + $total_persoal;
                endforeach;
                $a++;
                $nilai_akhir = $total_keseluruhan / 4;
                if ($nilai_akhir < 10) {
                    $nol++;
                } else if ($nilai_akhir >= 10 && $nilai_akhir < 20) {
                    $sepuluh++;
                } else if ($nilai_akhir >= 20 && $nilai_akhir < 30) {
                    $duapuluh++;
                } else if ($nilai_akhir >= 30 && $nilai_akhir < 40) {
                    $tigapuluh++;
                } else if ($nilai_akhir >= 40 && $nilai_akhir < 50) {
                    $empatpuluh++;
                } else if ($nilai_akhir >= 50 && $nilai_akhir < 60) {
                    $limapuluh++;
                } else if ($nilai_akhir >= 60 && $nilai_akhir < 70) {
                    $enampuluh++;
                } else if ($nilai_akhir >= 70 && $nilai_akhir < 80) {
                    $tujuhpuluh++;
                } else if ($nilai_akhir >= 80 && $nilai_akhir < 90) {
                    $delapanpuluh++;
                } else if ($nilai_akhir >= 90 && $nilai_akhir < 100) {
                    $sembilanpuluh++;
                } else if ($nilai_akhir == 100) {
                    $seratus++;
                }
            }
        endforeach;

        for ($i = 0; $i < 11; $i++) {
            if ($i == 0) {
                $data_nilai_asesi[$i] = $nol;
            } else if ($i == 1) {
                $data_nilai_asesi[$i] = $sepuluh;
            } else if ($i == 2) {
                $data_nilai_asesi[$i] = $duapuluh;
            } else if ($i == 3) {
                $data_nilai_asesi[$i] = $tigapuluh;
            } else if ($i == 4) {
                $data_nilai_asesi[$i] = $empatpuluh;
            } else if ($i == 5) {
                $data_nilai_asesi[$i] = $limapuluh;
            } else if ($i == 6) {
                $data_nilai_asesi[$i] = $enampuluh;
            } else if ($i ==  7) {
                $data_nilai_asesi[$i] = $tujuhpuluh;
            } else if ($i == 8) {
                $data_nilai_asesi[$i] = $delapanpuluh;
            } else if ($i == 9) {
                $data_nilai_asesi[$i] = $sembilanpuluh;
            } else if ($i == 10) {
                $data_nilai_asesi[$i] = $seratus;
            }
        }
        return $data_nilai_asesi;
    }

    public function DataPokjaPilihanAsesi()
    {
        $data_asesi = $this->asesiModel->get_asesi();
        $P1 = 0;
        $P2 = 0;
        $P3 = 0;
        $P4 = 0;
        $P5 = 0;
        $P6 = 0;
        $SK = 0;
        $a = 0;
        foreach ($data_asesi as $d) :
            $pembagian_soal = $this->nilaiModel->get_pembagian_soal_asesi($d['id_asesi']);
            $nilai_asesi = $this->nilaiModel->get_nilai_asesi($d['id_asesi']);
            $s = 0;
            if ($d['jenis_jabatan'] != 'pegawai') {
                foreach ($pembagian_soal as $p) :
                    foreach ($nilai_asesi as $n) :
                        if ($p['id_soal'] == $n['id_soal'] && $d['id_asesi'] == $n['id_asesi']) {
                            if ($n['kategori'] == 'wajib') {
                                $pokja[$a] = $n['pokja'];
                                $s++;
                                if ($s == 0) {
                                    $a++;
                                }
                            } else if ($n['kategori'] == 'acak') {
                            }
                        }
                    endforeach;
                endforeach;
            }
        endforeach;
        if ($a == 0) {
            for ($i = 0; $i <= $a; $i++) {
                if (isset($pokja[$i])) {
                    if ($pokja[$i] == 'P1') {
                        $P1++;
                    } else if ($pokja[$i] == 'P2') {
                        $P2++;
                    } else if ($pokja[$i] == 'P3') {
                        $P3++;
                    } else if ($pokja[$i] == 'P4') {
                        $P4++;
                    } else if ($pokja[$i] == 'P5') {
                        $P5++;
                    } else if ($pokja[$i] == 'P6') {
                        $P6++;
                    } else if ($pokja[$i] == 'SK') {
                        $SK++;
                    }
                }
            }
        } else {
            for ($i = 0; $i < $a; $i++) {
                if (isset($pokja[$i])) {
                    if ($pokja[$i] == 'P1') {
                        $P1++;
                    } else if ($pokja[$i] == 'P2') {
                        $P2++;
                    } else if ($pokja[$i] == 'P3') {
                        $P3++;
                    } else if ($pokja[$i] == 'P4') {
                        $P4++;
                    } else if ($pokja[$i] == 'P5') {
                        $P5++;
                    } else if ($pokja[$i] == 'P6') {
                        $P6++;
                    } else if ($pokja[$i] == 'SK') {
                        $SK++;
                    }
                }
            }
        }


        for ($i = 0; $i < 7; $i++) {
            if ($i == 0) {
                $data_pokja_pilihan_asesi[$i] = $P1;
            } else if ($i == 1) {
                $data_pokja_pilihan_asesi[$i] = $P2;
            } else if ($i == 2) {
                $data_pokja_pilihan_asesi[$i] = $P3;
            } else if ($i == 3) {
                $data_pokja_pilihan_asesi[$i] = $P4;
            } else if ($i == 4) {
                $data_pokja_pilihan_asesi[$i] = $P5;
            } else if ($i == 5) {
                $data_pokja_pilihan_asesi[$i] = $P6;
            } else if ($i == 6) {
                $data_pokja_pilihan_asesi[$i] = $SK;
            }
        }
        return $data_pokja_pilihan_asesi;
    }

    public function DataNilaiPegawai()
    {
        $data_asesi = $this->asesiModel->get_asesi();
        $nol = 0;
        $sepuluh = 0;
        $duapuluh = 0;
        $tigapuluh = 0;
        $empatpuluh = 0;
        $limapuluh = 0;
        $enampuluh = 0;
        $tujuhpuluh = 0;
        $delapanpuluh = 0;
        $sembilanpuluh = 0;
        $seratus = 0;
        foreach ($data_asesi as $d) :
            $pembagian_soal = $this->nilaiModel->get_pembagian_soal_asesi($d['id_asesi']);
            $nilai_asesi = $this->nilaiModel->get_nilai_asesi($d['id_asesi']);
            $nilai_akhir = 0;
            $total_keseluruhan = 0;
            $total_persoal = 0;
            $a = 0;
            if ($d['jenis_jabatan'] == 'pegawai') {
                foreach ($nilai_asesi as $n) :
                    if ($n['kategori'] == 'pilgan') {
                        $total_persoal = $total_persoal + (int)$n['nilai'];
                    }
                endforeach;
                $nilai_akhir = ($total_persoal * 4) / 10;
                if ($nilai_akhir < 10) {
                    $nol++;
                } else if ($nilai_akhir >= 10 && $nilai_akhir < 20) {
                    $sepuluh++;
                } else if ($nilai_akhir >= 20 && $nilai_akhir < 30) {
                    $duapuluh++;
                } else if ($nilai_akhir >= 30 && $nilai_akhir < 40) {
                    $tigapuluh++;
                } else if ($nilai_akhir >= 40 && $nilai_akhir < 50) {
                    $empatpuluh++;
                } else if ($nilai_akhir >= 50 && $nilai_akhir < 60) {
                    $limapuluh++;
                } else if ($nilai_akhir >= 60 && $nilai_akhir < 70) {
                    $enampuluh++;
                } else if ($nilai_akhir >= 70 && $nilai_akhir < 80) {
                    $tujuhpuluh++;
                } else if ($nilai_akhir >= 80 && $nilai_akhir < 90) {
                    $delapanpuluh++;
                } else if ($nilai_akhir >= 90 && $nilai_akhir < 100) {
                    $sembilanpuluh++;
                } else if ($nilai_akhir == 100) {
                    $seratus++;
                }
            }
        endforeach;

        for ($i = 0; $i < 11; $i++) {
            if ($i == 0) {
                $data_nilai_pegawai[$i] = $nol;
            } else if ($i == 1) {
                $data_nilai_pegawai[$i] = $sepuluh;
            } else if ($i == 2) {
                $data_nilai_pegawai[$i] = $duapuluh;
            } else if ($i == 3) {
                $data_nilai_pegawai[$i] = $tigapuluh;
            } else if ($i == 4) {
                $data_nilai_pegawai[$i] = $empatpuluh;
            } else if ($i == 5) {
                $data_nilai_pegawai[$i] = $limapuluh;
            } else if ($i == 6) {
                $data_nilai_pegawai[$i] = $enampuluh;
            } else if ($i ==  7) {
                $data_nilai_pegawai[$i] = $tujuhpuluh;
            } else if ($i == 8) {
                $data_nilai_pegawai[$i] = $delapanpuluh;
            } else if ($i == 9) {
                $data_nilai_pegawai[$i] = $sembilanpuluh;
            } else if ($i == 10) {
                $data_nilai_pegawai[$i] = $seratus;
            }
        }
        return $data_nilai_pegawai;
    }

    public function DataPokjaPilihanPegawai()
    {
        $data_asesi = $this->asesiModel->get_asesi();
        $P1 = 0;
        $P2 = 0;
        $P3 = 0;
        $P4 = 0;
        $P5 = 0;
        $P6 = 0;
        $SK = 0;
        $a = 0;
        foreach ($data_asesi as $d) :
            $pembagian_soal = $this->nilaiModel->get_pembagian_soal_asesi($d['id_asesi']);
            $nilai_asesi = $this->nilaiModel->get_nilai_asesi($d['id_asesi']);
            $s = 0;
            if ($d['jenis_jabatan'] == 'pegawai') {
                foreach ($pembagian_soal as $p) :
                    foreach ($nilai_asesi as $n) :
                        if ($p['id_soal'] == $n['id_soal'] && $d['id_asesi'] == $n['id_asesi']) {
                            if ($n['kategori'] == 'wajib') {
                                $pokja[$a] = $n['pokja'];
                                $s++;
                                if ($s == 0) {
                                    $a++;
                                }
                            } else if ($n['kategori'] == 'acak') {
                            }
                        }
                    endforeach;

                endforeach;
            }
        endforeach;
        if ($a == 0) {
            for ($i = 0; $i <= $a; $i++) {
                if (isset($pokja[$i])) {
                    if ($pokja[$i] == 'P1') {
                        $P1++;
                    } else if ($pokja[$i] == 'P2') {
                        $P2++;
                    } else if ($pokja[$i] == 'P3') {
                        $P3++;
                    } else if ($pokja[$i] == 'P4') {
                        $P4++;
                    } else if ($pokja[$i] == 'P5') {
                        $P5++;
                    } else if ($pokja[$i] == 'P6') {
                        $P6++;
                    } else if ($pokja[$i] == 'SK') {
                        $SK++;
                    }
                }
            }
        } else {
            for ($i = 0; $i < $a; $i++) {
                if (isset($pokja[$i])) {
                    if ($pokja[$i] == 'P1') {
                        $P1++;
                    } else if ($pokja[$i] == 'P2') {
                        $P2++;
                    } else if ($pokja[$i] == 'P3') {
                        $P3++;
                    } else if ($pokja[$i] == 'P4') {
                        $P4++;
                    } else if ($pokja[$i] == 'P5') {
                        $P5++;
                    } else if ($pokja[$i] == 'P6') {
                        $P6++;
                    } else if ($pokja[$i] == 'SK') {
                        $SK++;
                    }
                }
            }
        }


        for ($i = 0; $i < 7; $i++) {
            if ($i == 0) {
                $data_pokja_pilihan_pegawai[$i] = $P1;
            } else if ($i == 1) {
                $data_pokja_pilihan_pegawai[$i] = $P2;
            } else if ($i == 2) {
                $data_pokja_pilihan_pegawai[$i] = $P3;
            } else if ($i == 3) {
                $data_pokja_pilihan_pegawai[$i] = $P4;
            } else if ($i == 4) {
                $data_pokja_pilihan_pegawai[$i] = $P5;
            } else if ($i == 5) {
                $data_pokja_pilihan_pegawai[$i] = $P6;
            } else if ($i == 6) {
                $data_pokja_pilihan_pegawai[$i] = $SK;
            }
        }
        return $data_pokja_pilihan_pegawai;
    }
}
