<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class JenisLayananModel extends Model
{
    protected $table      = 'ms_jenis_layanan';
    protected $primaryKey = 'jenis_layanan';

    protected $allowedFields = ['jenis_layanan', 'nama_jenis_layanan', 'warna_jenis_layanan'];

    public function get_jenis_layanan()
    {
        return $this->db->table('ms_jenis_layanan')->get()->getResultArray();
    }

    public function get_detail_jenis_layanan($user_id)
    {
        return $this->db->table('ms_jenis_layanan')
            ->where('jenis_layanan', $user_id)
            ->get()->getRowArray();
    }
}
