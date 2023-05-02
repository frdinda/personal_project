<?php

namespace App\Models\ECK22;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class SoalModel extends Model
{
    protected $table      = 'eck22_ms_soal';
    protected $primaryKey = 'id_soal';

    protected $allowedFields = ['id_soal', 'soal', 'jawaban', 'kategori'];

    public function get_soal()
    {
        return $this->db->table('eck22_ms_soal')->get()->getResultArray();
    }

    public function get_detail_soal($id_soal)
    {
        return $this->db->table('eck22_ms_soal')
            ->where('id_soal', $id_soal)
            ->get()->getRowArray();
    }

    public function get_soal_perjenis($kategori)
    {
        return $this->db->table('eck22_ms_soal')
            ->where('kategori', $kategori)
            ->get()->getResultArray();
    }
}
