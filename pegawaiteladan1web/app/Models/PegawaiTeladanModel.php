<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class PegawaiTeladanModel extends Model
{
    protected $table      = 'tr_pegawai_teladan';
    protected $primaryKey = 'id_pegawai_teladan';

    protected $allowedFields = ['id_pegawai_teladan', 'nip_pegawai', 'bulan_ditetapkan', 'periode_pegawai_teladan'];

    public function get_pegawai_teladan()
    {
        return $this->db->table('tr_pegawai_teladan')->get()->getResultArray();
    }

    public function get_pegawai_teladan_urut_turun()
    {
        return $this->db->table('tr_pegawai_teladan')
            ->join('ms_pegawai', 'tr_pegawai_teladan.nip_pegawai=ms_pegawai.nip', 'LEFT')
            ->orderBy('tr_pegawai_teladan.bulan_ditetapkan', 'DESC')
            ->get()->getResultArray();
    }

    public function get_detail_pegawai_teladan($id_pegawai_teladan)
    {
        return $this->db->table('tr_pegawai_teladan')
            ->where('id_pegawai_teladan', $id_pegawai_teladan)
            ->get()->getRowArray();
    }

    public function get_pegawai_teladan_per_periode($periode_pegawai_teladan)
    {
        return $this->db->table('tr_pegawai_teladan')
            ->where('periode_pegawai_teladan', $periode_pegawai_teladan)
            ->get()->getResultArray();
    }
}
