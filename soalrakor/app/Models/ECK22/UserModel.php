<?php

namespace App\Models\ECK22;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UserModel extends Model
{
    protected $table      = 'eck22_ms_user';
    protected $primaryKey = 'id_user';

    protected $allowedFields = ['id_user', 'nama_user', 'jenis_akses', 'jabatan', 'password'];

    public function get_user()
    {
        return $this->db->table('eck22_ms_user')->get()->getResultArray();
    }

    public function get_detail_user($id_user)
    {
        return $this->db->table('eck22_ms_user')
            ->where('id_user', $id_user)
            ->get()->getRowArray();
    }
}
