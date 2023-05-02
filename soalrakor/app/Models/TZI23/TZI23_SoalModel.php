<?php

namespace App\Models\TZI23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class TZI23_SoalModel extends Model
{
    protected $table      = 'tzi23_ms_soal';
    protected $primaryKey = 'id_soal';

    protected $allowedFields = ['id_soal', 'soal', 'jawaban', 'jawaban_1', 'jawaban_2', 'jawaban_3', 'jawaban_4', 'kategori'];

    public function get_soal()
    {
        return $this->db->table('tzi23_ms_soal')->get()->getResultArray();
    }

    public function get_detail_soal($id_soal)
    {
        return $this->db->table('tzi23_ms_soal')
            ->where('id_soal', $id_soal)
            ->get()->getRowArray();
    }

    public function get_soal_perjenis($kategori)
    {
        return $this->db->table('tzi23_ms_soal')
            ->where('kategori', $kategori)
            ->get()->getResultArray();
    }
}
