<?php

namespace App\Models\UKOM23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UKOM23_PeriodeBerjalanModel extends Model
{
    protected $table      = 'ukom23_ms_periode_berjalan';
    protected $primaryKey = 'id_periode_berjalan';

    protected $allowedFields = ['id_periode_berjalan', 'id_periode'];

    public function get_periode_berjalan()
    {
        return $this->db->table('ukom23_ms_periode_berjalan')
            ->join('ukom23_ms_periode', 'ukom23_ms_periode_berjalan.id_periode=ukom23_ms_periode.id_periode', 'LEFT')
            ->get()->getRowArray();
    }
}
