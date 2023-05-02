<?php

namespace App\Controllers\TZI23\KelolaSoal;

use App\Controllers\BaseController;
use App\Models\TZI23\TZI23_SoalModel;
use App\Models\TZI23\TZI23_AsesiModel;
use App\Models\TZI23\TZI23_PembagianSoalModel;

class KelolaSoal extends BaseController
{
    protected $soalModel;
    protected $asesiModel;
    protected $pembagiansoalModel;
    public function __construct()
    {
        $this->soalModel = new TZI23_SoalModel;
        $this->asesiModel = new TZI23_AsesiModel;
        $this->pembagiansoalModel = new TZI23_PembagianSoalModel;
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
            $data = [
                'nama_page' => 'Kelola Soal',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'soal' => $this->soalModel->get_soal()
            ];
            return view('tzi23/soal_dan_penilaian/kelola_soal/kelola_soal', $data);
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
        if (isset($akses) && $jenis_assessment == 'TZI23') {
            $data = [
                'nama_page' => 'Kelola Soal',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses
            ];
            return view('tzi23/soal_dan_penilaian/kelola_soal/tambah_soal', $data);
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
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses) && $jenis_assessment == 'TZI23') {
            $data = [
                'nama_page' => 'Kelola Soal',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'detail_soal' => $this->soalModel->get_detail_soal($id_soal)
            ];
            return view('tzi23/soal_dan_penilaian/kelola_soal/edit_soal', $data);
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
        $kategori = $this->request->getVar('kategori');
        if (isset($soal)) {
            if ($kategori == 'pilgan') {
                $this->soalModel->insert([
                    'soal' => $soal,
                    'jawaban_1' => $this->request->getVar('jawaban_1'),
                    'jawaban_2' => $this->request->getVar('jawaban_2'),
                    'jawaban_3' => $this->request->getVar('jawaban_3'),
                    'jawaban_4' => $this->request->getVar('jawaban_4'),
                    'kategori' => $kategori,
                    'jawaban' => $this->request->getVar('jawaban')
                ]);
                echo "<script>
                        alert('Berhasil Disimpan');
                        window.location.href='/kelola-soal-tzi23';
                        </script>";
            } else {
                $this->soalModel->insert([
                    'soal' => $soal,
                    'jawaban' => $this->request->getVar('jawaban'),
                    'kategori' => $kategori
                ]);
                echo "<script>
                        alert('Berhasil Disimpan');
                        window.location.href='/kelola-soal-tzi23';
                        </script>";
            }
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-soal-tzi23';
                    </script>";
        }
    }

    public function SubEditSoal()
    {
        $id_soal = $this->request->getVar('id_soal');
        $soal = $this->request->getVar('soal');
        $kategori = $this->request->getVar('kategori');
        if (isset($id_soal)) {
            if ($kategori == 'pilgan') {
                $this->soalModel->save([
                    'id_soal' => $id_soal,
                    'soal' => $soal,
                    'jawaban_1' => $this->request->getVar('jawaban_1'),
                    'jawaban_2' => $this->request->getVar('jawaban_2'),
                    'jawaban_3' => $this->request->getVar('jawaban_3'),
                    'jawaban_4' => $this->request->getVar('jawaban_4'),
                    'jawaban' => $this->request->getVar('jawaban')
                ]);
                echo "<script>
                        alert('Berhasil Disimpan');
                        window.location.href='/kelola-soal-tzi23';
                        </script>";
            } else {
                $this->soalModel->save([
                    'id_soal' => $id_soal,
                    'soal' => $soal,
                    'jawaban' => $this->request->getVar('jawaban'),
                    'kategori' => $kategori
                ]);
                echo "<script>
                        alert('Berhasil Disimpan');
                        window.location.href='/kelola-soal-tzi23';
                        </script>";
            }
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-soal-tzi23';
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
                    window.location.href='/kelola-soal-tzi23';
                    </script>";
    }

    public function MulaiRandomSoal()
    {
        $id_user = $this->session->id_user;
        if ($id_user == '199901112020122001') {
            $data_asesi = $this->asesiModel->get_asesi();
            foreach ($data_asesi as $asesi) :
                if ($asesi['jenis_jabatan'] == 'pegawai') {
                    $soal_pilgan = $this->soalModel->get_soal_perjenis('pilgan');
                    $soal_wajib = $this->soalModel->get_soal_perjenis('wajib');
                    $soal_wajib_2 = $this->soalModel->get_soal_perjenis('wajib2');
                    $urutan_pilgan = $this->UniqueRandomNumbersWithinRange(0, (count($soal_pilgan) - 1), 25);
                    for ($i = 0; $i < count($urutan_pilgan); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_pilgan[$urutan_pilgan[$i]]['id_soal'],
                            'id_asesi' => $asesi['id_asesi']
                        ]);
                    }
                    for ($i = 0; $i < count($soal_wajib); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_wajib[$i]['id_soal'],
                            'id_asesi' => $asesi['id_asesi']
                        ]);
                    }
                    for ($i = 0; $i < count($soal_wajib_2); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_wajib_2[$i]['id_soal'],
                            'id_asesi' => $asesi['id_asesi']
                        ]);
                    }
                } else {
                    $soal_acak = $this->soalModel->get_soal_perjenis('acak');
                    $soal_wajib = $this->soalModel->get_soal_perjenis('wajib');
                    $soal_wajib_2 = $this->soalModel->get_soal_perjenis('wajib2');
                    $urutan_acak = $this->UniqueRandomNumbersWithinRange(0, (count($soal_acak) - 1), 3);
                    for ($i = 0; $i < count($urutan_acak); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_acak[$urutan_acak[$i]]['id_soal'],
                            'id_asesi' => $asesi['id_asesi']
                        ]);
                    }
                    for ($i = 0; $i < count($soal_wajib); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_wajib[$i]['id_soal'],
                            'id_asesi' => $asesi['id_asesi']
                        ]);
                    }
                    for ($i = 0; $i < count($soal_wajib_2); $i++) {
                        $this->pembagiansoalModel->insert([
                            'id_soal' => $soal_wajib_2[$i]['id_soal'],
                            'id_asesi' => $asesi['id_asesi']
                        ]);
                    }
                }
            endforeach;
            echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/kelola-soal-tzi23';
                    </script>";
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Kontak 085710101467');
            window.location.href='/kelola-soal-tzi23';
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
            $this->pembagiansoalModel->emptyTable('tzi23_ms_pembagian_soal');
            echo "<script>
                    alert('Berhasil Direset');
                    window.location.href='/kelola-soal-tzi23';
                    </script>";
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Kontak 085710101467');
            window.location.href='/kelola-soal-tzi23';
            </script>";
        }
    }
}
