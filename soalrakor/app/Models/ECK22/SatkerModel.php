<?php

namespace App\Models\ECK22;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class SatkerModel extends Model
{
    protected $table      = 'eck22_ms_satker';
    protected $primaryKey = 'id_satker';

    protected $allowedFields = ['id_satker', 'nama_satker', 'nama_kasatker', 'jenis_satker'];

    public function get_satker()
    {
        return $this->db->table('eck22_ms_satker')
            ->get()->getResultArray();
    }

    public function get_detail_satker($id_satker)
    {
        return $this->db->table('eck22_ms_satker')
            ->where('id_satker', $id_satker)
            ->get()->getRowArray();
    }
}
