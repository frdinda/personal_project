<?php

namespace App\Controllers\UKOM23\KelolaSoal;

use App\Controllers\BaseController;
use App\Models\UKOM23\UKOM23_SoalModel;
use App\Models\UKOM23\UKOM23_SatkerModel;
use App\Models\UKOM23\UKOM23_PembagianSoalModel;
use App\Models\UKOM23\UKOM23_PesertaModel;
use App\Models\UKOM23\UKOM23_PesertaPeriodeModel;

class KelolaSoal extends BaseController
{
    protected $soalModel;
    protected $satkerModel;
    protected $pembagiansoalModel;
    protected $pesertaModel;
    protected $pesertaPeriodeModel;
    public function __construct()
    {
        $this->soalModel = new UKOM23_SoalModel;
        $this->satkerModel = new UKOM23_SatkerModel;
        $this->pembagiansoalModel = new UKOM23_PembagianSoalModel;
        $this->pesertaModel = new UKOM23_PesertaModel;
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
                $data = [
                    'nama_page' => 'Kelola Soal',
                    'nama_subpage' => 'Kelola Soal',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'soal' => $this->soalModel->get_soal()
                ];
                return view('ukom23/soal_dan_penilaian/kelola_soal/kelola_soal', $data);
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

    public function TambahSoal()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Soal',
                    'nama_subpage' => 'Tambah Soal',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses
                ];
                return view('ukom23/soal_dan_penilaian/kelola_soal/tambah_soal', $data);
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

    public function SubTambahSoal()
    {
        $soal = $this->request->getVar('soal');
        $jawaban = $this->request->getVar('jawaban');
        $kategori = $this->request->getVar('kategori');
        if (isset($soal)) {
            $this->soalModel->insert([
                'soal' => $soal,
                'jawaban' => $jawaban,
                'kategori' => $kategori
            ]);
            echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/kelola-soal-ukom23';
                    </script>";
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-soal-ukom23';
                    </script>";
        }
    }

    public function EditSoal($id_soal)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Soal',
                    'nama_subpage' => 'Edit Soal',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'detail_soal' => $this->soalModel->get_detail_soal($id_soal)
                ];

                return view('ukom23/soal_dan_penilaian/kelola_soal/edit_soal', $data);
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

    public function SubEditSoal()
    {
        $id_soal = $this->request->getVar('id_soal');
        $soal = $this->request->getVar('soal');
        $jawaban = $this->request->getVar('jawaban');
        $kategori = $this->request->getVar('kategori');
        if (isset($id_soal)) {
            $this->soalModel->save([
                'id_soal' => $id_soal,
                'soal' => $soal,
                'jawaban' => $jawaban,
                'kategori' => $kategori
            ]);
            echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/kelola-soal-ukom23';
                    </script>";
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-soal-ukom23';
                    </script>";
        }
    }

    public function HapusSoal($id_soal)
    {
        $this->soalModel->delete([
            'id_soal' => $id_soal
        ]);
        echo "<script>
                    alert('Berhasil Dihapus');
                    window.location.href='/kelola-soal-ukom23';
                    </script>";
    }

    public function MulaiRandomSoal()
    {
        $akses = $this->session->akses;
        $periode = $this->session->periode_berjalan;
        if ($akses == 'Admin') {
            // UNTUK SEKARANG KITA AMBIL DATA SELURUH PESERTA
            $data_peserta = $this->pesertaPeriodeModel->get_peserta_periode_per_periode($periode['id_periode']);
            $periode = $this->session->periode_berjalan;
            foreach ($data_peserta as $peserta) :
                // INI GUE MASIH AMBIL SOAL PAS AJA DAN GA SPESIFIK, SEHARUSNYA SPESIFIK. NANTI KALAU UDAH ADA TABEL PESERTA PERIODE, AMBIL DARI SANA DIA UKOM PAS/IMI/ATAU APA
                $soal = $this->soalModel->get_soal_perjenis('pas');
                $urutan_soal = $this->UniqueRandomNumbersWithinRange(0, (count($soal) - 1), 5);
                for ($i = 0; $i < count($urutan_soal); $i++) {
                    $this->pembagiansoalModel->insert([
                        'id_peserta' => $peserta['id_peserta'],
                        'id_soal' => $soal[$urutan_soal[$i]]['id_soal'],
                        'id_periode' => $periode['id_periode']
                    ]);
                }
            endforeach;
            echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/kelola-soal-ukom23';
                    </script>";
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function ResetRandomSoal()
    {
        $akses = $this->session->akses;
        $periode = $this->session->periode_berjalan;
        if ($akses == 'Admin') {
            $data_randomisasi_soal = $this->pembagiansoalModel->get_pembagian_soal_per_periode($periode['id_periode']);
            foreach ($data_randomisasi_soal as $d) :
                $this->pembagiansoalModel->delete([
                    'id_pembagian' => $d['id_pembagian']
                ]);
            endforeach;
            echo "<script>
                    alert('Berhasil Direset');
                    window.location.href='/kelola-soal-ukom23';
                    </script>";
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Kontak 085710101467');
            window.location.href='/kelola-soal-ukom23';
            </script>";
        }
    }

    public function UniqueRandomNumbersWithinRange($min, $max, $quantity)
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}
