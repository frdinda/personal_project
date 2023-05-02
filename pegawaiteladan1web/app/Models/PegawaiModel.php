<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class PegawaiModel extends Model
{
    protected $table      = 'ms_pegawai';
    protected $primaryKey = 'nip';

    protected $allowedFields = ['nip', 'nama_pegawai', 'nama_jabatan', 'jenis_user', 'struktural', 'nip_atasan_langsung', 'foto_profil', 'password'];

    public function get_pegawai()
    {
        return $this->db->table('ms_pegawai')->get()->getResultArray();
    }

    public function get_detail_pegawai($nip)
    {
        return $this->db->table('ms_pegawai')
            ->where('nip', $nip)
            ->get()->getRowArray();
    }

    public function get_pegawai_per_atasan_langsung($nip_atasan_langsung)
    {
        return $this->db->table('ms_pegawai')
            ->where('nip_atasan_langsung', $nip_atasan_langsung)
            ->get()->getResultArray();
    }

    public function get_atasan_langsung()
    {
        return $this->db->table('ms_pegawai')
            ->where('struktural', 'Y')
            ->get()->getResultArray();
    }
}
