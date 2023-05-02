<?php

namespace App\Models\TZI23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class TZI23_NilaiModel extends Model
{
    protected $table      = 'tzi23_tr_penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $allowedFields = ['id_penilaian', 'id_user', 'id_asesi', 'id_soal', 'nilai', 'pokja', 'jawaban_dipilih', 'jawaban_program'];

    public function get_nilai_dashboard()
    {
        return $this->db->table('tzi23_tr_penilaian')
            ->join('tzi23_ms_user', 'tzi23_tr_penilaian.id_user=tzi23_ms_user.id_user', 'LEFT')
            ->join('tzi23_ms_asesi', 'tzi23_tr_penilaian.id_asesi=tzi23_ms_asesi.id_asesi', 'LEFT')
            ->join('tzi23_ms_soal', 'tzi23_tr_penilaian.id_soal=tzi23_ms_soal.id_soal', 'LEFT')
            ->groupBy('tzi23_tr_penilaian.id_penilaian')
            ->orderBy('tzi23_tr_penilaian.id_asesi', 'ASC')
            ->get()->getResultArray();
    }

    public function get_nilai_asesi($id_asesi)
    {
        return $this->db->table('tzi23_tr_penilaian')
            ->where('tzi23_tr_penilaian.id_asesi', $id_asesi)
            ->join('tzi23_ms_user', 'tzi23_tr_penilaian.id_user=tzi23_ms_user.id_user', 'LEFT')
            ->join('tzi23_ms_asesi', 'tzi23_tr_penilaian.id_asesi=tzi23_ms_asesi.id_asesi', 'LEFT')
            ->join('tzi23_ms_soal', 'tzi23_tr_penilaian.id_soal=tzi23_ms_soal.id_soal', 'LEFT')
            ->groupBy('tzi23_tr_penilaian.id_penilaian')
            ->orderBy('tzi23_tr_penilaian.id_asesi', 'ASC')
            ->get()->getResultArray();
    }

    public function get_pembagian_soal()
    {
        return $this->db->table('tzi23_ms_pembagian_soal')
            ->groupBy('tzi23_ms_pembagian_soal.id_pembagian')
            ->get()->getResultArray();
    }

    public function get_pembagian_soal_asesi($id_asesi)
    {
        return $this->db->table('tzi23_ms_pembagian_soal')
            ->where('tzi23_ms_pembagian_soal.id_asesi', $id_asesi)
            ->join('tzi23_ms_soal', 'tzi23_ms_pembagian_soal.id_soal=tzi23_ms_soal.id_soal', 'LEFT')
            ->groupBy('tzi23_ms_pembagian_soal.id_pembagian')
            ->get()->getResultArray();
    }

    public function get_soal_pertama($id_asesi)
    {
        return $this->db->table('tzi23_ms_pembagian_soal')
            ->where('tzi23_ms_pembagian_soal.id_asesi', $id_asesi)
            ->limit(1)
            ->get()->getRowArray();
    }

    public function get_nilai_asesi_persoal($id_soal, $id_asesi, $id_user)
    {
        return $this->db->table('tzi23_tr_penilaian')
            ->where('tzi23_tr_penilaian.id_soal', $id_soal)
            ->where('tzi23_tr_penilaian.id_asesi', $id_asesi)
            ->where('tzi23_tr_penilaian.id_user', $id_user)
            ->get()->getRowArray();
    }
}
