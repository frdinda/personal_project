<?php

namespace App\Controllers\ECK22\Kelola;

use App\Controllers\BaseController;
use App\Models\ECK22\SatkerModel;

class KelolaSatker extends BaseController
{
    protected $satkerModel;
    public function __construct()
    {
        $this->satkerModel = new SatkerModel;
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
                'nama_page' => 'kelola satker',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
                'data_satker' => $this->satkerModel->get_satker()
            ];
            return view('eck22/kelola/kelola_satker/kelola_satker', $data);
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
        if (isset($akses)) {
            $data = [
                'nama_page' => 'kelola satker',
                'nama_user' => $this->session->nama_user,
                'akses' => $akses,
            ];
            return view('eck22/kelola/kelola_satker/tambah_satker', $data);
        } else {
            echo "<script>
            alert('Anda Tidak Memiliki Akses, Silahkan Login');
            window.location.href='/';
            </script>";
        }
    }

    public function EditSatker($id_satker)
    {
        $akses = $this->session->akses;
        if (isset($akses)) {
            $data = [
                'nama_page' => 'kelola satker',
                'nama_user' => $this->session->nama_user,
                'akses' => $this->session->akses,
                'detail_satker' => $this->satkerModel->get_detail_satker($id_satker)
            ];
            return view('eck22/kelola/kelola_satker/edit_satker', $data);
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
        $nama_kasatker = $this->request->getVar('nama_kasatker');
        $jenis_satker = $this->request->getVar('jenis_satker');

        if (isset($id_satker)) {
            $this->satkerModel->insert([
                'id_satker' => $id_satker,
                'nama_satker' => $nama_satker,
                'nama_kasatker' => $nama_kasatker,
                'jenis_satker' => $jenis_satker
            ]);
            echo "<script>
            alert('Berhasil Disimpan');
            window.location.href='/kelola-satker';
            </script>";
        } else {
            echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-satker';
            </script>";
        }
    }

    public function SubEditSatker()
    {
        $id_satker = $this->request->getVar('id_satker');
        $nama_satker = $this->request->getVar('nama_satker');
        $nama_kasatker = $this->request->getVar('nama_kasatker');
        $jenis_satker = $this->request->getVar('jenis_satker');

        if (isset($nama_satker)) {
            $this->satkerModel->save([
                'id_satker' => $id_satker,
                'nama_satker' => $nama_satker,
                'nama_kasatker' => $nama_kasatker,
                'jenis_satker' => $jenis_satker
            ]);
            echo "<script>
            alert('Berhasil Disimpan');
            window.location.href='/kelola-satker';
            </script>";
        } else {
            echo "<script>
            alert('Data Tidak Lengkap');
            window.location.href='/tambah-satker';
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
                    window.location.href='/kelola-satker';
                    </script>";
    }
}
