<?php

namespace App\Models\UKOM23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UKOM23_SatkerModel extends Model
{
    protected $table      = 'ukom23_ms_satker';
    protected $primaryKey = 'id_satker';

    protected $allowedFields = ['id_satker', 'nama_satker', 'jenis_satker'];

    public function get_satker()
    {
        return $this->db->table('ukom23_ms_satker')
            ->get()->getResultArray();
    }

    public function get_detail_satker($id_satker)
    {
        return $this->db->table('ukom23_ms_satker')
            ->where('id_satker', $id_satker)
            ->get()->getRowArray();
    }
}
