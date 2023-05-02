<?php

namespace App\Controllers\UKOM23\Kelola;

use App\Controllers\BaseController;
use App\Models\UKOM23\UKOM23_PeriodeModel;
use App\Models\UKOM23\UKOM23_PeriodeBerjalanModel;

class KelolaPeriode extends BaseController
{
    protected $periodeModel;
    protected $periodeBerjalanModel;
    public function __construct()
    {
        $this->periodeModel = new UKOM23_PeriodeModel;
        $this->periodeBerjalanModel = new UKOM23_PeriodeBerjalanModel;
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
                    'nama_page' => 'Kelola Periode',
                    'nama_subpage' => 'Kelola Periode',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'data_periode' => $this->periodeModel->get_periode(),
                    'periode_berjalan' => $this->session->periode_berjalan
                ];
                return view('ukom23/kelola/kelola_periode/kelola_periode', $data);
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

    public function TambahPeriode()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Periode',
                    'nama_subpage' => 'Tambah Periode',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses
                ];
                return view('ukom23/kelola/kelola_periode/tambah_periode', $data);
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

    public function SubTambahPeriode()
    {
        $nama_periode = $this->request->getVar('nama_periode');
        if (isset($nama_periode)) {
            $this->periodeModel->insert([
                'nama_periode' => $nama_periode
            ]);
            echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/kelola-periode-ukom23';
                    </script>";
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-periode-ukom23';
                    </script>";
        }
    }

    public function EditPeriode($id_periode)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Periode',
                    'nama_subpage' => 'Edit Periode',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'detail_periode' => $this->periodeModel->get_detail_periode($id_periode)
                ];

                return view('ukom23/kelola/kelola_periode/edit_periode', $data);
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

    public function SubEditPeriode()
    {
        $id_periode = $this->request->getVar('id_periode');
        $nama_periode = $this->request->getVar('nama_periode');
        if (isset($id_periode)) {
            $this->periodeModel->save([
                'id_periode' => $id_periode,
                'nama_periode' => $nama_periode
            ]);
            echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/kelola-periode-ukom23';
                    </script>";
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-periode-ukom23';
                    </script>";
        }
    }

    public function HapusPeriode($id_periode)
    {
        $this->periodeModel->delete([
            'id_periode' => $id_periode
        ]);
        echo "<script>
                    alert('Berhasil Dihapus');
                    window.location.href='/kelola-periode-ukom23';
                    </script>";
    }

    public function EditPeriodeBerjalan()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $periode_berjalan = $this->periodeBerjalanModel->get_periode_berjalan();
                $data_periode = $this->periodeModel->get_periode();
                $data = [
                    'nama_page' => 'Kelola Periode',
                    'nama_subpage' => 'Edit Periode',
                    'nama_user' => $this->session->nama_user,
                    'akses' => $akses,
                    'periode_berjalan' => $periode_berjalan,
                    'data_periode' => $data_periode
                ];

                return view('ukom23/kelola/kelola_periode/edit_periode_berjalan', $data);
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

    public function SubEditPeriodeBerjalan()
    {
        $id_periode_berjalan = $this->request->getVar('id_periode_berjalan');
        $id_periode = $this->request->getVar('id_periode');
        if (isset($id_periode)) {
            $this->periodeBerjalanModel->save([
                'id_periode_berjalan' => $id_periode_berjalan,
                'id_periode' => $id_periode
            ]);
            $periode_berjalan = $this->periodeBerjalanModel->get_periode_berjalan();
            $this->session->set('periode_berjalan', $periode_berjalan);
            $this->session->set('periode_berjalan_sementara', $periode_berjalan);
            echo "<script>
                    alert('Berhasil Disimpan');
                    window.location.href='/kelola-periode-ukom23';
                    </script>";
        } else {
            echo "<script>
                    alert('Data Kosong');
                    window.location.href='/kelola-periode-ukom23';
                    </script>";
        }
    }
}
