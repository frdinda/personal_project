<?php

namespace App\Controllers\Beranda;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PegawaiTeladanModel;

class Beranda extends BaseController
{
    protected $pegawaiModel;
    protected $pegawaiTeladanModel;
    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->pegawaiTeladanModel = new PegawaiTeladanModel();
    }

    public function index()
    {
        // atau ambil aja pegawai teladan semuanya, terus order by bulan ditetapkan. terus tampilin yang array 0 di atas, sisanya array 1 dst
        if (isset($this->session->jenis_user)) {
            $pegawai_teladan = $this->pegawaiTeladanModel->get_pegawai_teladan_urut_turun();
            $data_pegawai = $this->pegawaiModel->get_pegawai();
            $data = [
                'nama_page' => 'Beranda',
                'nama_pegawai' => $this->session->nama_pegawai,
                'jenis_user' => $this->session->jenis_user,
                'nama_jabatan' => $this->session->nama_jabatan,
                'nip_pegawai' => $this->session->nip_pegawai,
                'pegawai_teladan' => $pegawai_teladan,
                'data_pegawai' => $data_pegawai
            ];
            return view('beranda/beranda', $data);
        } else {
            return redirect()->to('/login');
        }
    }
}
