<?php

namespace App\Controllers\UKOM23\Kelola;

use App\Controllers\BaseController;
use App\Models\UKOM23\UKOM23_UserModel;
use App\Models\UKOM23\UKOM23_SatkerModel;

class KelolaSatker extends BaseController
{
    protected $userModel;
    protected $satkerModel;
    public function __construct()
    {
        $this->userModel = new UKOM23_UserModel;
        $this->satkerModel = new UKOM23_SatkerModel;
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
                    'nama_page' => 'Kelola Satuan Kerja',
                    'nama_subpage' => 'Kelola Satuan Kerja',
                    'akses' => $akses,
                    'data_satker' => $this->satkerModel->get_satker(),
                    'nama_user' => $this->session->nama_user
                ];
                return view('ukom23/kelola/kelola_satker/kelola_satker', $data);
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

    public function TambahSatker()
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Satuan Kerja',
                    'nama_subpage' => 'Tambah Satuan Kerja',
                    'akses' => $akses,
                    'nama_user' => $this->session->nama_user
                ];
                return view('ukom23/kelola/kelola_satker/tambah_satker', $data);
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

    public function SubTambahSatker()
    {
        $id_satker = $this->request->getVar('id_satker');
        $nama_satker = $this->request->getVar('nama_satker');
        $jenis_satker = $this->request->getVar('jenis_satker');

        if (isset($id_satker)) {
            $detail_satker = $this->satkerModel->get_detail_satker($id_satker);
            if ($detail_satker == null) {
                $this->satkerModel->insert([
                    'id_satker' => $id_satker,
                    'nama_satker' => $nama_satker,
                    'jenis_satker' => $jenis_satker
                ]);
                echo "<script>
                alert('Berhasil Disimpan');
                window.location.href='/kelola-satker-ukom23';
                </script>";
            } else {
                $this->satkerModel->save([
                    'id_satker' => $id_satker,
                    'nama_satker' => $nama_satker,
                    'jenis_satker' => $jenis_satker
                ]);
                echo "<script>
                alert('Berhasil Disimpan Sebagai Update');
                window.location.href='/kelola-satker-ukom23';
                </script>";
            }
        } else {
            echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-satker-ukom23';
            </script>";
        }
    }

    public function EditSatker($id_satker)
    {
        $akses = $this->session->akses;
        $jenis_assessment = $this->session->jenis_assessment;

        if (isset($akses)) {
            if ($jenis_assessment == 'UKOM23') {
                $data = [
                    'nama_page' => 'Kelola Satuan Kerja',
                    'nama_subpage' => 'Edit Satuan Kerja',
                    'akses' => $akses,
                    'nama_user' => $this->session->nama_user,
                    'detail_satker' => $this->satkerModel->get_detail_satker($id_satker)
                ];
                return view('ukom23/kelola/kelola_satker/edit_satker', $data);
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

    public function SubEditSatker()
    {
        $id_satker = $this->request->getVar('id_satker');
        $nama_satker = $this->request->getVar('nama_satker');
        $jenis_satker = $this->request->getVar('jenis_satker');

        if (isset($nama_satker)) {
            $this->satkerModel->save([
                'id_satker' => $id_satker,
                'nama_satker' => $nama_satker,
                'jenis_satker' => $jenis_satker
            ]);
            echo "<script>
                alert('Berhasil Disimpan Sebagai Update');
                window.location.href='/kelola-satker-ukom23';
                </script>";
        } else {
            echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/edit-satker-ukom23';
            </script>";
        }
    }

    public function HapusSatker($id_satker)
    {
        $this->satkerModel->delete([
            'id_satker' => $id_satker
        ]);

        echo "<script>
            alert('Berhasil Dihapus');
            window.location.href='/kelola-satker-ukom23';
            </script>";
    }
}
