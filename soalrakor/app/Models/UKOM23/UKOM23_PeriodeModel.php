<?php

namespace App\Models\UKOM23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UKOM23_PeriodeModel extends Model
{
    protected $table      = 'ukom23_ms_periode';
    protected $primaryKey = 'id_periode';

    protected $allowedFields = ['id_periode', 'nama_periode'];

    public function get_periode()
    {
        return $this->db->table('ukom23_ms_periode')
            ->get()->getResultArray();
    }

    public function get_detail_periode($id_periode)
    {
        return $this->db->table('ukom23_ms_periode')
            ->where('id_periode', $id_periode)
            ->get()->getRowArray();
    }
}
