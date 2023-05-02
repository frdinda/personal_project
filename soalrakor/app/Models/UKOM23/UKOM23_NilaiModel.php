<?php

namespace App\Models\UKOM23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UKOM23_NilaiModel extends Model
{
    protected $table      = 'ukom23_tr_penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $allowedFields = ['id_penilaian', 'id_user', 'id_peserta', 'id_soal', 'nilai', 'id_periode'];

    public function get_nilai_dashboard($id_periode)
    {
        return $this->db->table('ukom23_tr_penilaian')
            ->where('ukom23_tr_penilaian.id_periode', $id_periode)
            ->join('ukom23_ms_user', 'ukom23_tr_penilaian.id_user=ukom23_ms_user.id_user', 'LEFT')
            ->join('ukom23_ms_peserta', 'ukom23_tr_penilaian.id_peserta=ukom23_ms_peserta.id_peserta', 'LEFT')
            ->join('ukom23_ms_soal', 'ukom23_tr_penilaian.id_soal=ukom23_ms_soal.id_soal', 'LEFT')
            ->groupBy('ukom23_tr_penilaian.id_penilaian')
            ->orderBy('ukom23_tr_penilaian.id_peserta', 'ASC')
            ->get()->getResultArray();
    }

    public function get_nilai_peserta($id_peserta, $id_periode)
    {
        return $this->db->table('ukom23_tr_penilaian')
            ->where('ukom23_tr_penilaian.id_peserta', $id_peserta)
            ->where('ukom23_tr_penilaian.id_periode', $id_periode)
            ->join('ukom23_ms_user', 'ukom23_tr_penilaian.id_user=ukom23_ms_user.id_user', 'LEFT')
            ->join('ukom23_ms_peserta', 'ukom23_tr_penilaian.id_peserta=ukom23_ms_peserta.id_peserta', 'LEFT')
            ->join('ukom23_ms_soal', 'ukom23_tr_penilaian.id_soal=ukom23_ms_soal.id_soal', 'LEFT')
            ->groupBy('ukom23_tr_penilaian.id_penilaian')
            ->orderBy('ukom23_tr_penilaian.id_peserta', 'ASC')
            ->get()->getResultArray();
    }

    public function get_pembagian_soal($id_periode)
    {
        return $this->db->table('ukom23_ms_pembagian_soal')
            ->where('ukom23_ms_pembagian_soal.id_periode', $id_periode)
            ->groupBy('ukom23_ms_pembagian_soal.id_pembagian')
            ->get()->getResultArray();
    }

    public function get_pembagian_soal_peserta($id_peserta, $id_periode)
    {
        return $this->db->table('ukom23_ms_pembagian_soal')
            ->where('ukom23_ms_pembagian_soal.id_peserta', $id_peserta)
            ->where('ukom23_ms_pembagian_soal.id_periode', $id_periode)
            ->join('ukom23_ms_soal', 'ukom23_ms_pembagian_soal.id_soal=ukom23_ms_soal.id_soal', 'LEFT')
            ->groupBy('ukom23_ms_pembagian_soal.id_pembagian')
            ->get()->getResultArray();
    }

    public function get_soal_pertama($id_peserta, $id_periode)
    {
        return $this->db->table('ukom23_ms_pembagian_soal')
            ->where('ukom23_ms_pembagian_soal.id_peserta', $id_peserta)
            ->where('ukom23_ms_pembagian_soal.id_periode', $id_periode)
            ->limit(1)
            ->get()->getRowArray();
    }

    public function get_nilai_peserta_persoal($id_soal, $id_peserta, $id_user, $id_periode)
    {
        return $this->db->table('ukom23_tr_penilaian')
            ->where('ukom23_tr_penilaian.id_soal', $id_soal)
            ->where('ukom23_tr_penilaian.id_peserta', $id_peserta)
            ->where('ukom23_tr_penilaian.id_user', $id_user)
            ->where('ukom23_tr_penilaian.id_periode', $id_periode)
            ->get()->getRowArray();
    }
}
