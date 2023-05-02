<?php

namespace App\Models\TZI23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class TZI23_AsesiModel extends Model
{
    protected $table      = 'tzi23_ms_asesi';
    protected $primaryKey = 'id_asesi';

    protected $allowedFields = ['id_asesi', 'nama_asesi', 'jenis_jabatan', 'nama_jabatan'];

    public function get_asesi()
    {
        return $this->db->table('tzi23_ms_asesi')
            ->get()->getResultArray();
    }

    public function get_detail_asesi($id_asesi)
    {
        return $this->db->table('tzi23_ms_asesi')
            ->where('id_asesi', $id_asesi)
            ->get()->getRowArray();
    }
}
