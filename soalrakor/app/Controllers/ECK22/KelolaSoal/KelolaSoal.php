<?php

namespace App\Controllers\ECK22\KelolaSoal;

use App\Controllers\BaseController;
use App\Models\ECK22\SoalModel;
use App\Models\ECK22\SatkerModel;
use App\Models\ECK22\PembagianSoalModel;

class KelolaSoal extends BaseController
{
    protected $soalModel;
    protected $satkerModel;
    protected $pembagiansoalModel;
    public function __construct()
    {
        $this->soalModel = new SoalModel;
        $this->satkerModel = new SatkerModel;
        $this->pembagiansoalModel = new PembagianSoalModel;
    }

    public function maintenance()
    {
        return view('login/maintenance');
    }

    public function index()
    {
        $akses = $this->session->akses;

        if (isset($akses)) {
            $data = [
                'nama_page' => 'kelola soal',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'soal' => $this->soalModel->get_soal()
            ];
            return view('eck22/soal_dan_penilaian/kelola_soal/kelola_soal', $data);
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
        if (isset($akses)) {
            $data = [
                'nama_page' => 'kelola soal',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses
            ];
            return view('eck22/soal_dan_penilaian/kelola_soal/tambah_soal', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function EditSoal($id_soal)
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $data = [
                'nama_page' => 'kelola soal',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'detail_soal' => $this->soalModel->get_detail_soal($id_soal)
            ];
            return view('eck22/soal_dan_penilaian/kelola_soal/edit_soal', $data);
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
                    window.location.href='/kelola-soal';
                    </script>";
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-soal';
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
                    window.location.href='/kelola-soal';
                    </script>";
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-soal';
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
                    window.location.href='/kelola-soal';
                    </script>";
    }

    public function MulaiRandomSoal()
    {
        // buat disini cuma bisa dilakuin sama yang id_usernya gue, kalau nggak bilang lo ga punya akses.
        // ambil data satker
        // foreach data satker, ambil data soal yang kategori-nya sesuai jenis satker
        // udah diambil, ambil .lengthnya atau count()nya terus buat for, di dalem for adan random itu dan save randomnya ke tabel pembagian soal. 

        $id_user = $this->session->id_user;
        if ($id_user == '199901112020122001') {
            $data_satker = $this->satkerModel->get_satker();
            // foreach ($data_satker as $satker) :
            //     if ($satker['jenis_satker'] == 'laper') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('laper');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_laper = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal lapas
            //         for ($i = 0; $i < count($urutan_laper); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_laper[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'ruper') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('ruper');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_ruper = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal lapas
            //         for ($i = 0; $i < count($urutan_ruper); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_ruper[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'lpka') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('lpka');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_lpka = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal lapas
            //         for ($i = 0; $i < count($urutan_lpka); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_lpka[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'lpn') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('lpn');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_lpn = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal lapas
            //         for ($i = 0; $i < count($urutan_lpn); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_lpn[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'lapas') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('lapas');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_lapas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal lapas
            //         for ($i = 0; $i < count($urutan_lapas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_lapas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'rutan') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('rutan');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_rutan = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal lapas
            //         for ($i = 0; $i < count($urutan_rutan); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_rutan[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'kanim') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('kanim');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('imi');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_kanim = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_imi = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal 
            //         for ($i = 0; $i < count($urutan_kanim); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_kanim[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal imi
            //         for ($i = 0; $i < count($urutan_imi); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_imi[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'rudenim') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('rudenim');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('imi');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_rudenim = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_imi = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal
            //         for ($i = 0; $i < count($urutan_rudenim); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_rudenim[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal imi
            //         for ($i = 0; $i < count($urutan_imi); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_imi[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'bhp') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('bhp');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_bhp = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 3);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal lapas
            //         for ($i = 0; $i < count($urutan_bhp); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_bhp[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'bapas') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('bapas');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_bapas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal bapas
            //         for ($i = 0; $i < count($urutan_bapas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_bapas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'lpp') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('lpp');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_lpp = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal lpp
            //         for ($i = 0; $i < count($urutan_lpp); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_lpp[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            //     if ($satker['jenis_satker'] == 'rupbasan') {
            //         $soal_1 = $this->soalModel->get_soal_perjenis('rupbasan');
            //         $soal_2 = $this->soalModel->get_soal_perjenis('pas');
            //         $soal_3 = $this->soalModel->get_soal_perjenis('min');
            //         // get random number
            //         $urutan_rupbasan = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
            //         $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 2);
            //         $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 2);
            //         // looping untuk soal rupbasan
            //         for ($i = 0; $i < count($urutan_rupbasan); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_1[$urutan_rupbasan[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal pas
            //         for ($i = 0; $i < count($urutan_pas); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //         // looping untuk soal min
            //         for ($i = 0; $i < count($urutan_min); $i++) {
            //             $this->pembagiansoalModel->insert([
            //                 'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
            //                 'id_satker' => $satker['id_satker']
            //             ]);
            //         }
            //     }
            // endforeach;
            foreach ($data_satker as $satker) :
                if ($satker['jenis_satker'] == 'laper' || $satker['jenis_satker'] == 'lpn' || $satker['jenis_satker'] == 'lapas' || $satker['jenis_satker'] == 'lpp') {
                    $soal_ppt = $this->soalModel->get_soal_perjenis('ppt');
                    $soal_video = $this->soalModel->get_soal_perjenis('video');
                    $soal_simpulan = $this->soalModel->get_soal_perjenis('simpulan');
                    // $soal_1 = $this->soalModel->get_soal_perjenis('lainlain');
                    $soal_1 = $this->soalModel->get_soal_perjenis('lapas');
                    // $soal_2 = $this->soalModel->get_soal_perjenis('pas');
                    $soal_3 = $this->soalModel->get_soal_perjenis('min');
                    // get random number
                    // $urutan_lain = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    $urutan_lapas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    // $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 1);
                    $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 1);
                    // looping untuk soal video
                    for ($i = 0; $i < count($soal_video); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_video[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal ppt
                    for ($i = 0; $i < count($soal_ppt); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_ppt[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal lapas
                    for ($i = 0; $i < count($urutan_lapas); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_1[$urutan_lapas[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal pas
                    // for ($i = 0; $i < count($urutan_pas); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal min
                    for ($i = 0; $i < count($urutan_min); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal lapas
                    // for ($i = 0; $i < count($urutan_lain); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_1[$urutan_lain[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal simpulan
                    for ($i = 0; $i < count($soal_simpulan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_simpulan[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                }
                if ($satker['jenis_satker'] == 'ruper' || $satker['jenis_satker'] == 'rutan') {
                    $soal_ppt = $this->soalModel->get_soal_perjenis('ppt');
                    $soal_video = $this->soalModel->get_soal_perjenis('video');
                    $soal_simpulan = $this->soalModel->get_soal_perjenis('simpulan');
                    // $soal_1 = $this->soalModel->get_soal_perjenis('lainlain');
                    $soal_1 = $this->soalModel->get_soal_perjenis('rutan');
                    // $soal_2 = $this->soalModel->get_soal_perjenis('pas');
                    $soal_3 = $this->soalModel->get_soal_perjenis('min');
                    // get random number
                    // $urutan_lain = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    $urutan_rutan = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    // $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 1);
                    $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 1);
                    // looping untuk soal video
                    for ($i = 0; $i < count($soal_video); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_video[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal ppt
                    for ($i = 0; $i < count($soal_ppt); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_ppt[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal rutan
                    for ($i = 0; $i < count($urutan_rutan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_1[$urutan_rutan[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal pas
                    // for ($i = 0; $i < count($urutan_pas); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal min
                    for ($i = 0; $i < count($urutan_min); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal lapas
                    // for ($i = 0; $i < count($urutan_lain); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_1[$urutan_lain[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal simpulan
                    for ($i = 0; $i < count($soal_simpulan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_simpulan[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                }
                if ($satker['jenis_satker'] == 'lpka') {
                    $soal_ppt = $this->soalModel->get_soal_perjenis('ppt');
                    $soal_video = $this->soalModel->get_soal_perjenis('video');
                    $soal_simpulan = $this->soalModel->get_soal_perjenis('simpulan');
                    // $soal_1 = $this->soalModel->get_soal_perjenis('lainlain');
                    $soal_1 = $this->soalModel->get_soal_perjenis('lpka');
                    // $soal_2 = $this->soalModel->get_soal_perjenis('pas');
                    $soal_3 = $this->soalModel->get_soal_perjenis('min');
                    // get random number
                    // $urutan_lain = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    $urutan_lpka = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    // $urutan_pas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 1);
                    $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 1);
                    // looping untuk soal video
                    for ($i = 0; $i < count($soal_video); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_video[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal ppt
                    for ($i = 0; $i < count($soal_ppt); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_ppt[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal lpka
                    for ($i = 0; $i < count($urutan_lpka); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_1[$urutan_lpka[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal pas
                    // for ($i = 0; $i < count($urutan_pas); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_2[$urutan_pas[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal min
                    for ($i = 0; $i < count($urutan_min); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal lapas
                    // for ($i = 0; $i < count($urutan_lain); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_1[$urutan_lain[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal simpulan
                    for ($i = 0; $i < count($soal_simpulan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_simpulan[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                }
                if ($satker['jenis_satker'] == 'bapas') {
                    $soal_ppt = $this->soalModel->get_soal_perjenis('ppt');
                    $soal_video = $this->soalModel->get_soal_perjenis('video');
                    $soal_simpulan = $this->soalModel->get_soal_perjenis('simpulan');
                    // $soal_1 = $this->soalModel->get_soal_perjenis('lainlain');
                    $soal_2 = $this->soalModel->get_soal_perjenis('bapas');
                    $soal_3 = $this->soalModel->get_soal_perjenis('min');
                    // get random number
                    // $urutan_lain = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    $urutan_bapas = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 1);
                    $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 1);
                    // looping untuk soal video
                    for ($i = 0; $i < count($soal_video); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_video[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal ppt
                    for ($i = 0; $i < count($soal_ppt); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_ppt[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal bapas
                    for ($i = 0; $i < count($urutan_bapas); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_2[$urutan_bapas[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal min
                    for ($i = 0; $i < count($urutan_min); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal lapas
                    // for ($i = 0; $i < count($urutan_lain); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_1[$urutan_lain[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal simpulan
                    for ($i = 0; $i < count($soal_simpulan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_simpulan[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                }
                if ($satker['jenis_satker'] == 'rupbasan') {
                    $soal_ppt = $this->soalModel->get_soal_perjenis('ppt');
                    $soal_video = $this->soalModel->get_soal_perjenis('video');
                    $soal_simpulan = $this->soalModel->get_soal_perjenis('simpulan');
                    // $soal_1 = $this->soalModel->get_soal_perjenis('lainlain');
                    $soal_2 = $this->soalModel->get_soal_perjenis('rupbasan');
                    $soal_3 = $this->soalModel->get_soal_perjenis('min');
                    // get random number
                    // $urutan_lain = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    $urutan_rupbasan = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 1);
                    $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 1);
                    // looping untuk soal video
                    for ($i = 0; $i < count($soal_video); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_video[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal ppt
                    for ($i = 0; $i < count($soal_ppt); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_ppt[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal rupbasan
                    for ($i = 0; $i < count($urutan_rupbasan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_2[$urutan_rupbasan[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal min
                    for ($i = 0; $i < count($urutan_min); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal lapas
                    // for ($i = 0; $i < count($urutan_lain); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_1[$urutan_lain[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal simpulan
                    for ($i = 0; $i < count($soal_simpulan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_simpulan[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                }
                if ($satker['jenis_satker'] == 'kanim') {
                    $soal_ppt = $this->soalModel->get_soal_perjenis('ppt');
                    $soal_video = $this->soalModel->get_soal_perjenis('video');
                    $soal_simpulan = $this->soalModel->get_soal_perjenis('simpulan');
                    // $soal_1 = $this->soalModel->get_soal_perjenis('lainlain');
                    $soal_2 = $this->soalModel->get_soal_perjenis('kanim');
                    $soal_3 = $this->soalModel->get_soal_perjenis('min');
                    // get random number
                    // $urutan_lain = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    $urutan_kanim = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 1);
                    $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 1);
                    // looping untuk soal video
                    for ($i = 0; $i < count($soal_video); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_video[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal ppt
                    for ($i = 0; $i < count($soal_ppt); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_ppt[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal kanim
                    for ($i = 0; $i < count($urutan_kanim); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_2[$urutan_kanim[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal min
                    for ($i = 0; $i < count($urutan_min); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal 
                    // for ($i = 0; $i < count($urutan_lain); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_1[$urutan_lain[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal simpulan
                    for ($i = 0; $i < count($soal_simpulan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_simpulan[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                }
                if ($satker['jenis_satker'] == 'rudenim') {
                    $soal_ppt = $this->soalModel->get_soal_perjenis('ppt');
                    $soal_video = $this->soalModel->get_soal_perjenis('video');
                    $soal_simpulan = $this->soalModel->get_soal_perjenis('simpulan');
                    // $soal_1 = $this->soalModel->get_soal_perjenis('lainlain');
                    $soal_2 = $this->soalModel->get_soal_perjenis('rudenim');
                    $soal_3 = $this->soalModel->get_soal_perjenis('min');
                    // get random number
                    // $urutan_lain = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    $urutan_rudenim = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 1);
                    $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 1);
                    // looping untuk soal video
                    for ($i = 0; $i < count($soal_video); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_video[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal ppt
                    for ($i = 0; $i < count($soal_ppt); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_ppt[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal rudenim
                    for ($i = 0; $i < count($urutan_rudenim); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_2[$urutan_rudenim[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal min
                    for ($i = 0; $i < count($urutan_min); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal 
                    // for ($i = 0; $i < count($urutan_lain); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_1[$urutan_lain[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal simpulan
                    for ($i = 0; $i < count($soal_simpulan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_simpulan[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                }
                if ($satker['jenis_satker'] == 'bhp') {
                    $soal_ppt = $this->soalModel->get_soal_perjenis('ppt');
                    $soal_video = $this->soalModel->get_soal_perjenis('video');
                    $soal_simpulan = $this->soalModel->get_soal_perjenis('simpulan');
                    // $soal_1 = $this->soalModel->get_soal_perjenis('lainlain');
                    $soal_2 = $this->soalModel->get_soal_perjenis('bhp');
                    $soal_3 = $this->soalModel->get_soal_perjenis('min');
                    // get random number
                    // $urutan_lain = $this->UniqueRandomNumbersWithinRange(0, (count($soal_1) - 1), 1);
                    $urutan_bhp = $this->UniqueRandomNumbersWithinRange(0, (count($soal_2) - 1), 1);
                    $urutan_min = $this->UniqueRandomNumbersWithinRange(0, (count($soal_3) - 1), 1);
                    // looping untuk soal video
                    for ($i = 0; $i < count($soal_video); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_video[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal ppt
                    for ($i = 0; $i < count($soal_ppt); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_ppt[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal lapas
                    for ($i = 0; $i < count($urutan_bhp); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_2[$urutan_bhp[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal min
                    for ($i = 0; $i < count($urutan_min); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_3[$urutan_min[$i]]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                    // looping untuk soal 
                    // for ($i = 0; $i < count($urutan_lain); $i++) {
                    //     $this->pembagiansoalModel->insert([
                    //         'id_soal' => $soal_1[$urutan_lain[$i]]['id_soal'],
                    //         'id_satker' => $satker['id_satker']
                    //     ]);
                    // }
                    // looping untuk soal simpulan
                    for ($i = 0; $i < count($soal_simpulan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_simpulan[$i]['id_soal'],
                            'id_satker' => $satker['id_satker']
                        ]);
                    }
                }
            endforeach;
            echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/kelola-soal';
                    </script>";
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Kontak 085710101467');
            window.location.href='/kelola-soal';
            </script>";
        }
    }

    public function UniqueRandomNumbersWithinRange($min, $max, $quantity)
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    public function ResetRandomSoal()
    {
        $id_user = $this->session->id_user;
        if ($id_user == '199901112020122001') {
            $this->pembagiansoalModel->emptyTable('ms_pembagian_soal');
            echo "<script>
                    alert('Berhasil Direset');
                    window.location.href='/kelola-soal';
                    </script>";
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Kontak 085710101467');
            window.location.href='/kelola-soal';
            </script>";
        }
    }
}
