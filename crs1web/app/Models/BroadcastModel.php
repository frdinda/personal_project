<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class BroadcastModel extends Model
{
    protected $table      = 'tr_broadcast';
    protected $primaryKey = 'id_broadcast';

    protected $allowedFields = ['id_broadcast', 'platform_broadcast', 'tanggal_broadcast', 'user_id', 'judul_broadcast', 'text_broadcast', 'tujuan_broadcast', 'thumbnail_broadcast', 'status_terkirim', 'tujuan_broadcast'];

    public function get_data_broadcast()
    {
        return $this->db->table('tr_broadcast')
            ->join('ms_user', 'tr_broadcast.user_id=ms_user.user_id', 'LEFT')
            ->orderBy('tr_broadcast.tanggal_broadcast', 'DESC')
            ->get()->getResultArray();
    }

    public function get_data_broadcast_unit_kerja($user_id)
    {
        return $this->db->table('tr_broadcast')
            ->where('tr_broadcast.user_id', $user_id)
            ->join('ms_user', 'tr_broadcast.user_id=ms_user.user_id', 'LEFT')
            ->orderBy('tr_broadcast.tanggal_broadcast', 'DESC')
            ->get()->getResultArray();
    }

    public function get_detail_broadcast($id_broadcast)
    {
        return $this->db->table('tr_broadcast')
            ->where('tr_broadcast.id_broadcast', $id_broadcast)
            ->join('ms_user', 'tr_broadcast.user_id=ms_user.user_id', 'LEFT')
            ->get()->getRowArray();
    }

    public function get_detail_broadcast_belum_kirim()
    {
        return $this->db->table('tr_broadcast')
            ->where('tr_broadcast.status_terkirim', 'Belum')
            ->where('tr_broadcast.tanggal_broadcast <=', date('Y-m-d H:i:s'))
            ->join('ms_user', 'tr_broadcast.user_id=ms_user.user_id', 'LEFT')
            ->get()->getResultArray();
    }

    public function get_detail_broadcast_belum_kirim_total()
    {
        return $this->db->table('tr_broadcast')
            ->where('tr_broadcast.status_terkirim', 'Belum')
            ->join('ms_user', 'tr_broadcast.user_id=ms_user.user_id', 'LEFT')
            ->get()->getResultArray();
    }

    public function get_detail_broadcast_sudah_kirim_total()
    {
        return $this->db->table('tr_broadcast')
            ->where('tr_broadcast.status_terkirim', 'Sudah')
            ->join('ms_user', 'tr_broadcast.user_id=ms_user.user_id', 'LEFT')
            ->get()->getResultArray();
    }

    public function get_detail_broadcast_sudah_kirim_total_unit_kerja($user_id)
    {
        return $this->db->table('tr_broadcast')
            ->where('tr_broadcast.user_id', $user_id)
            ->where('tr_broadcast.status_terkirim', 'Sudah')
            ->join('ms_user', 'tr_broadcast.user_id=ms_user.user_id', 'LEFT')
            ->get()->getResultArray();
    }

    public function get_detail_broadcast_belum_kirim_total_unit_kerja($user_id)
    {
        return $this->db->table('tr_broadcast')
            ->where('tr_broadcast.user_id', $user_id)
            ->where('tr_broadcast.status_terkirim', 'Belum')
            ->join('ms_user', 'tr_broadcast.user_id=ms_user.user_id', 'LEFT')
            ->get()->getResultArray();
    }
}
