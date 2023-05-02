<?php

namespace App\Models\UKOM23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UKOM23_PesertaModel extends Model
{
    protected $table      = 'ukom23_ms_peserta';
    protected $primaryKey = 'id_peserta';

    protected $allowedFields = ['id_peserta', 'nama_peserta', 'nama_jabatan', 'jenis_peserta', 'id_satker'];

    public function get_peserta()
    {
        return $this->db->table('ukom23_ms_peserta')
            ->join('ukom23_ms_satker', 'ukom23_ms_peserta.id_satker=ukom23_ms_satker.id_satker', 'LEFT')
            ->get()->getResultArray();
    }

    public function get_detail_peserta($id_peserta)
    {
        return $this->db->table('ukom23_ms_peserta')
            ->where('id_peserta', $id_peserta)
            ->join('ukom23_ms_satker', 'ukom23_ms_peserta.id_satker=ukom23_ms_satker.id_satker', 'LEFT')
            ->get()->getRowArray();
    }
}
