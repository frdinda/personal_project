<?php

namespace App\Models\UKOM23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UKOM23_UserModel extends Model
{
    protected $table      = 'ukom23_ms_user';
    protected $primaryKey = 'id_user';

    protected $allowedFields = ['id_user', 'nama_user', 'jenis_akses', 'jabatan', 'password'];

    public function get_user()
    {
        return $this->db->table('ukom23_ms_user')->get()->getResultArray();
    }

    public function get_detail_user($id_user)
    {
        return $this->db->table('ukom23_ms_user')
            ->where('id_user', $id_user)
            ->get()->getRowArray();
    }
}
