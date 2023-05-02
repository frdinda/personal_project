<?php

namespace App\Models\UKOM23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UKOM23_PembagianSoalModel extends Model
{
    protected $table      = 'ukom23_ms_pembagian_soal';
    protected $primaryKey = 'id_pembagian';

    protected $allowedFields = ['id_pembagian', 'id_peserta', 'id_soal', 'id_periode'];

    public function get_pembagian_soal_per_periode($id_periode)
    {
        return $this->db->table('ukom23_ms_pembagian_soal')
            ->where('id_periode', $id_periode)
            ->get()->getResultArray();
    }
}
