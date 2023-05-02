<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class PertanyaanModel extends Model
{
    protected $table      = 'ms_pertanyaan';
    protected $primaryKey = 'id_pertanyaan';

    protected $allowedFields = ['id_pertanyaan', 'jabaran_pertanyaan', 'kategori_pertanyaan'];

    public function get_pertanyaan()
    {
        return $this->db->table('ms_pertanyaan')->get()->getResultArray();
    }

    public function get_pertanyaan_join($nip_pegawai, $periode_penilaian)
    {
        return $this->db->table('ms_pertanyaan')
            ->where('nip_pegawai', $nip_pegawai)
            ->where('periode_penilaian', $periode_penilaian)
            ->join('tr_nilai_atasan_langsung', 'ms_pertanyaan.id_pertanyaan=tr_nilai_atasan_langsung.id_pertanyaan', 'LEFT')
            ->get()->getResultArray();
    }

    public function get_detail_pertanyaan($id_pertanyaan)
    {
        return $this->db->table('ms_pertanyaan')
            ->where('id_pertanyaan', $id_pertanyaan)
            ->get()->getRowArray();
    }
}
