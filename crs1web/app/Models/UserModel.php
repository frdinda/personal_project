<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class UserModel extends Model
{
    protected $table      = 'ms_user';
    protected $primaryKey = 'user_id';

    protected $allowedFields = ['user_id', 'nama_unit_kerja', 'nama_kepala', 'nip_kepala', 'jenis_akses', 'password', 'no_telp_representatif'];

    public function get_user()
    {
        return $this->db->table('ms_user')->get()->getResultArray();
    }

    public function get_detail_user($user_id)
    {
        return $this->db->table('ms_user')
            ->where('user_id', $user_id)
            ->get()->getRowArray();
    }
}
