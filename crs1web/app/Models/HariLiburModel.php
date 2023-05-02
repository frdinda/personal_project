<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class HariLiburModel extends Model
{
    protected $table      = 'ms_hari_libur';
    protected $primaryKey = 'id_hari_libur';

    protected $allowedFields = ['id_hari_libur', 'tanggal_hari_libur'];

    public function get_hari_libur()
    {
        return $this->db->table('ms_hari_libur')
            ->get()->getResultArray();
    }
}
