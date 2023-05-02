<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class PenilaianAtasanLangsungModel extends Model
{
    protected $table      = 'tr_nilai_atasan_langsung';
    protected $primaryKey = 'id_penilaian_atasan_langsung';

    protected $allowedFields = ['id_penilaian_atasan_langsung', 'nip_pegawai', 'nip_atasan_langsung', 'id_pertanyaan', 'periode_penilaian', 'nilai'];

    public function get_nilai_all()
    {
        return $this->db->table('tr_nilai_atasan_langsung')->get()->getResultArray();
    }

    public function get_nilai_per_atasan_langsung($nip_atasan_langsung)
    {
        return $this->db->table('tr_nilai_atasan_langsung')
            ->where('nip_atasan_langsung', $nip_atasan_langsung)
            ->get()->getResultArray();
    }

    public function get_nilai_per_pegawai($nip_pegawai)
    {
        return $this->db->table('tr_nilai_atasan_langsung')
            ->where('nip_pegawai', $nip_pegawai)
            ->get()->getResultArray();
    }

    public function get_nilai_per_pegawai_per_periode($nip_pegawai, $periode_penilaian)
    {
        return $this->db->table('tr_nilai_atasan_langsung')
            ->where('nip_pegawai', $nip_pegawai)
            ->where('periode_penilaian', $periode_penilaian)
            ->join('ms_pertanyaan', 'tr_nilai_atasan_langsung.id_pertanyaan=ms_pertanyaan.id_pertanyaan', 'LEFT')
            ->get()->getResultArray();
    }
}
