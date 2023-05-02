<?php

namespace App\Models\ECK22;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class NilaiModel extends Model
{
    protected $table      = 'eck22_tr_penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $allowedFields = ['id_penilaian', 'id_user', 'id_satker', 'id_soal', 'nilai', 'simpulan'];

    public function get_nilai_dashboard()
    {
        return $this->db->table('eck22_tr_penilaian')
            ->join('eck22_ms_user', 'eck22_tr_penilaian.id_user=eck22_ms_user.id_user', 'LEFT')
            ->join('eck22_ms_satker', 'eck22_tr_penilaian.id_satker=eck22_ms_satker.id_satker', 'LEFT')
            ->join('eck22_ms_soal', 'eck22_tr_penilaian.id_soal=eck22_ms_soal.id_soal', 'LEFT')
            ->groupBy('eck22_tr_penilaian.id_penilaian')
            ->orderBy('eck22_tr_penilaian.id_satker', 'ASC')
            ->get()->getResultArray();
    }

    public function get_nilai_satker($id_satker)
    {
        return $this->db->table('eck22_tr_penilaian')
            ->where('eck22_tr_penilaian.id_satker', $id_satker)
            ->join('eck22_ms_user', 'eck22_tr_penilaian.id_user=eck22_ms_user.id_user', 'LEFT')
            ->join('eck22_ms_satker', 'eck22_tr_penilaian.id_satker=eck22_ms_satker.id_satker', 'LEFT')
            ->join('eck22_ms_soal', 'eck22_tr_penilaian.id_soal=eck22_ms_soal.id_soal', 'LEFT')
            ->groupBy('eck22_tr_penilaian.id_penilaian')
            ->orderBy('eck22_tr_penilaian.id_satker', 'ASC')
            ->get()->getResultArray();
    }

    public function get_pembagian_soal()
    {
        return $this->db->table('eck22_ms_pembagian_soal')
            ->groupBy('eck22_ms_pembagian_soal.id_pembagian')
            ->get()->getResultArray();
    }

    public function get_pembagian_soal_satker($id_satker)
    {
        return $this->db->table('eck22_ms_pembagian_soal')
            ->where('eck22_ms_pembagian_soal.id_satker', $id_satker)
            ->join('eck22_ms_soal', 'eck22_ms_pembagian_soal.id_soal=eck22_ms_soal.id_soal', 'LEFT')
            ->groupBy('eck22_ms_pembagian_soal.id_pembagian')
            ->get()->getResultArray();
    }

    public function get_soal_pertama($id_satker)
    {
        return $this->db->table('eck22_ms_pembagian_soal')
            ->where('eck22_ms_pembagian_soal.id_satker', $id_satker)
            ->limit(1)
            ->get()->getRowArray();
    }

    public function get_nilai_satker_persoal($id_soal, $id_satker, $id_user)
    {
        return $this->db->table('eck22_tr_penilaian')
            ->where('eck22_tr_penilaian.id_soal', $id_soal)
            ->where('eck22_tr_penilaian.id_satker', $id_satker)
            ->where('eck22_tr_penilaian.id_user', $id_user)
            ->get()->getRowArray();
    }
}
