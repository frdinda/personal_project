<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class PenggunaLayananModel extends Model
{
    protected $table      = 'ms_pengguna_layanan';
    protected $primaryKey = 'no_telp_pengguna';

    protected $allowedFields = ['no_telp_pengguna', 'email_pengguna', 'nama_pengguna', 'instansi_asal_pengguna'];

    public function get_pengguna_layanan()
    {
        return $this->db->table('ms_pengguna_layanan')
            ->orderBy('ms_pengguna_layanan.no_telp_pengguna', 'ASC')
            ->get()->getResultArray();
    }

    public function get_pengguna_layanan_join()
    {
        return $this->db->table('ms_pengguna_layanan')
            ->join('tr_entry_pengguna_layanan', 'tr_entry_pengguna_layanan.no_telp_pengguna=ms_pengguna_layanan.no_telp_pengguna')
            ->groupBy('ms_pengguna_layanan.no_telp_pengguna')
            ->get()->getResultArray();
    }

    public function get_detail_pengguna_layanan($no_telp_pengguna)
    {
        return $this->db->table('ms_pengguna_layanan')
            ->where('ms_pengguna_layanan.no_telp_pengguna', $no_telp_pengguna)
            ->get()->getRowArray();
    }
}
