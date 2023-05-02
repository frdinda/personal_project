<?php

namespace App\Models\UKOM23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UKOM23_PesertaPeriodeModel extends Model
{
    protected $table      = 'ukom23_ms_peserta_periode';
    protected $primaryKey = 'id_peserta_periode';

    protected $allowedFields = ['id_peserta_periode', 'id_peserta', 'id_periode'];

    public function get_peserta_periode()
    {
        return $this->db->table('ukom23_ms_peserta_periode')
            ->join('ukom23_ms_peserta', 'ukom23_ms_peserta_periode.id_peserta=ukom23_ms_peserta.id_peserta', 'LEFT')
            ->join('ukom23_ms_satker', 'ukom23_ms_peserta.id_satker=ukom23_ms_satker.id_satker', 'LEFT')
            ->get()->getResultArray();
    }

    public function get_peserta_periode_per_periode($id_periode)
    {
        return $this->db->table('ukom23_ms_peserta_periode')
            ->where('ukom23_ms_peserta_periode.id_periode', $id_periode)
            ->join('ukom23_ms_peserta', 'ukom23_ms_peserta_periode.id_peserta=ukom23_ms_peserta.id_peserta', 'LEFT')
            ->join('ukom23_ms_satker', 'ukom23_ms_peserta.id_satker=ukom23_ms_satker.id_satker', 'LEFT')
            ->get()->getResultArray();
    }
}
