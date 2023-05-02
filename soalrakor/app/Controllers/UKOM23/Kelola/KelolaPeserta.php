<?php

namespace App\Controllers\UKOM23\Kelola;

use App\Controllers\BaseController;
use App\Models\UKOM23\UKOM23_PesertaModel;
use App\Models\UKOM23\UKOM23_SatkerModel;
use App\Models\UKOM23\UKOM23_PeriodeModel;
use App\Models\UKOM23\UKOM23_PesertaPeriodeModel;

class KelolaPeserta extends BaseController
{
    protected $pesertaModel;
    protected $satkerModel;
    protected $periodeModel;
    protected $pesertaPeriodeModel;
    public function __construct()
    {
        $this->pesertaModel = new UKOM23_PesertaModel;
        $this->satkerModel = new UKOM23_SatkerModel;
        $this->periodeModel = new UKOM23_PeriodeModel;
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
                    'nama_page' => 'Kelola Peserta',
                    'nama_subpage' => 'Kelola Peserta',
                    'akses' => $akses,
                    'data_peserta' => $this->pesertaModel->get_peserta(),
                    'nama_user' => $this->session->nama_user
                ];
                return view('ukom23/kelola/kelola_peserta/kelola_peserta', $data);
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

    public function TambahPeserta()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Peserta',
                    'nama_subpage' => 'Tambah Peserta',
                    'akses' => $akses,
                    'nama_user' => $this->session->nama_user,
                    'data_satker' => $this->satkerModel->get_satker()
                ];
                return view('ukom23/kelola/kelola_peserta/tambah_peserta', $data);
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

    public function SubTambahPeserta()
    {
        $id_peserta = $this->request->getVar('id_peserta');
        $nama_peserta = $this->request->getVar('nama_peserta');
        $nama_jabatan = $this->request->getVar('nama_jabatan');
        $id_satker = $this->request->getVar('id_satker');

        if (isset($id_peserta)) {
            $detail_peserta = $this->pesertaModel->get_detail_peserta($id_peserta);
            if ($detail_peserta == null) {
                $this->pesertaModel->insert([
                    'id_peserta' => $id_peserta,
                    'nama_peserta' => $nama_peserta,
                    'nama_jabatan' => $nama_jabatan,
                    'id_satker' => $id_satker
                ]);
                echo "<script>
                alert('Berhasil Disimpan');
                window.location.href='/kelola-peserta-ukom23';
                </script>";
            } else {
                $this->pesertaModel->save([
                    'id_peserta' => $id_peserta,
                    'nama_peserta' => $nama_peserta,
                    'nama_jabatan' => $nama_jabatan,
                    'id_satker' => $id_satker
                ]);
                echo "<script>
                alert('Berhasil Disimpan Sebagai Perubahan');
                window.location.href='/kelola-peserta-ukom23';
                </script>";
            }
        } else {
            echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-peserta-ukom23';
            </script>";
        }
    }

    public function EditPeserta($id_peserta)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Peserta',
                    'nama_subpage' => 'Edit Peserta',
                    'akses' => $akses,
                    'nama_user' => $this->session->nama_user,
                    'detail_peserta' => $this->pesertaModel->get_detail_peserta($id_peserta),
                    'data_satker' => $this->satkerModel->get_satker()
                ];
                return view('ukom23/kelola/kelola_peserta/edit_peserta', $data);
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

    public function SubEditPeserta()
    {
        $id_peserta = $this->request->getVar('id_peserta');
        $nama_peserta = $this->request->getVar('nama_peserta');
        $nama_jabatan = $this->request->getVar('nama_jabatan');
        $id_satker = $this->request->getVar('id_satker');

        if (isset($nama_peserta)) {
            $this->pesertaModel->save([
                'id_peserta' => $id_peserta,
                'nama_peserta' => $nama_peserta,
                'nama_jabatan' => $nama_jabatan,
                'id_satker' => $id_satker
            ]);
            echo "<script>
            alert('Berhasil Disimpan');
            window.location.href='/kelola-peserta-ukom23';
            </script>";
        } else {
            echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/edit-peserta-ukom23';
            </script>";
        }
    }

    public function HapusPeserta($id_peserta)
    {
        $this->pesertaModel->delete([
            'id_peserta' => $id_peserta
        ]);
        echo "<script>
        alert('Berhasil Dihapus');
        window.location.href='/kelola-peserta-ukom23';
        </script>";
    }

    public function PilihPeriodePeserta()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Peserta Periode',
                    'nama_subpage' => 'Pilih Periode Peserta',
                    'nama_user' => $this->session->nama_user,
                    'data_periode' => $this->periodeModel->get_periode()
                ];
                return view('ukom23/kelola/kelola_peserta/pilih_periode_peserta', $data);
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

    public function PilihPesertaPeriode()
    {
        $id_periode = $this->request->getVar('id_periode');
        $periode = $this->periodeModel->get_detail_periode($id_periode);
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;
        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Peserta Periode',
                    'nama_subpage' => 'Pilih Peserta Periode',
                    'nama_user' => $this->session->nama_user,
                    'data_peserta' => $this->pesertaModel->get_peserta(),
                    'id_periode' => $id_periode
                ];
                return view('ukom23/kelola/kelola_peserta/pilih_peserta_periode', $data);
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

    public function SubPilihPesertaPeriode()
    {
        $id_peserta = $this->request->getVar('id_peserta');
        $id_periode = $this->request->getVar('id_periode');
        if ($id_peserta != null) {
            $data_peserta_periode = $this->pesertaPeriodeModel->get_peserta_periode_per_periode($id_periode);
            foreach ($data_peserta_periode as $d) :
                $this->pesertaPeriodeModel->delete([
                    'id_peserta_periode' => $d['id_peserta_periode']
                ]);
            endforeach;

            foreach ($id_peserta as $p) :
                $this->pesertaPeriodeModel->insert([
                    'id_peserta' => $p,
                    'id_periode' => $id_periode
                ]);
            endforeach;
            echo "<script>
            alert('Berhasil Disimpan');
            window.location.href='/kelola-peserta-periode-ukom23';
            </script>";
        } else {
            echo "<script>
            alert('Tidak Ada Peserta Yang Dipilih');
            window.location.href='/kelola-peserta-periode-ukom23';
            </script>";
        }
    }
}
