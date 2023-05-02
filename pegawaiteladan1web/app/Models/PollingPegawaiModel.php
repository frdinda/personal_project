<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class PollingPegawaiModel extends Model
{
    protected $table      = 'tr_polling_pegawai';
    protected $primaryKey = 'id_polling';

    protected $allowedFields = ['id_polling', 'nip_pegawai', 'nip_pegawai_usulan', 'periode_polling', 'nilai_polling'];

    public function get_polling()
    {
        return $this->db->table('tr_polling_pegawai')->get()->getResultArray();
    }

    public function get_polling_per_pegawai_dan_periode($nip_pegawai, $periode_polling)
    {
        return $this->db->table('tr_polling_pegawai')
            ->where('nip_pegawai', $nip_pegawai)
            ->where('periode_polling', $periode_polling)
            ->get()->getRowArray();
    }

    public function get_polling_per_pegawai_yang_diusulkan_dan_periode($nip_pegawai_usulan, $periode_polling)
    {
        return $this->db->table('tr_polling_pegawai')
            ->where('nip_pegawai_usulan', $nip_pegawai_usulan)
            ->where('periode_polling', $periode_polling)
            ->get()->getResultArray();
    }
}
