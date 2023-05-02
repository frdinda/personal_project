<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class KonsultasiOnlineModel extends Model
{
    protected $table      = 'tr_konsultasi_online';
    protected $primaryKey = 'id_konsultasi_online';

    protected $allowedFields = ['id_konsultasi_online', 'no_telp_pengguna', 'user_id', 'NIP', 'tanggal_konsultasi_online', 'jam_konsultasi_online', 'id_entry', 'room_zoom', 'status_jalan_konsultasi', 'feedback_jalan_konsultasi'];

    public function get_data_konsultasi_online()
    {
        return $this->db->table('tr_konsultasi_online')
            ->get()->getResultArray();
    }

    public function get_data_konsultasi_online_join()
    {
        return $this->db->table('tr_konsultasi_online')
            ->join('ms_user', 'ms_user.user_id=tr_konsultasi_online.NIP')
            ->join('ms_pengguna_layanan', 'ms_pengguna_layanan.no_telp_pengguna=tr_konsultasi_online.no_telp_pengguna')
            ->orderBy('tr_konsultasi_online.tanggal_konsultasi_online', 'DESC')
            ->get()->getResultArray();
    }

    public function get_data_konsultasi_online_per_tanggal()
    {
        return $this->db->table('tr_konsultasi_online')
            ->where('tr_konsultasi_online.tanggal_konsultasi_online', date('Y-m-d'))
            ->get()->getResultArray();
    }

    public function get_detail_konsultasi_online($id_konsultasi_online)
    {
        return $this->db->table('tr_konsultasi_online')
            ->where('tr_konsultasi_online.id_konsultasi_online', $id_konsultasi_online)
            ->get()->getRowArray();
    }

    public function get_detail_konsultasi_online_join($id_konsultasi_online)
    {
        return $this->db->table('tr_konsultasi_online')
            ->join('ms_user', 'ms_user.user_id=tr_konsultasi_online.user_id')
            ->join('tr_entry_pengguna_layanan', 'tr_entry_pengguna_layanan.id_entry=tr_konsultasi_online.id_entry')
            ->join('ms_pengguna_layanan', 'ms_pengguna_layanan.no_telp_pengguna=tr_konsultasi_online.no_telp_pengguna')
            ->where('tr_konsultasi_online.id_konsultasi_online', $id_konsultasi_online)
            ->get()->getRowArray();
    }

    public function get_detail_konsultasi_online_by_entry($id_entry)
    {
        return $this->db->table('tr_konsultasi_online')
            ->where('tr_konsultasi_online.id_entry', $id_entry)
            ->get()->getRowArray();
    }

    public function get_detail_konsultasi_online_by_tanggal($jadwal_konsultasi_online)
    {
        return $this->db->table('tr_konsultasi_online')
            ->where('tr_konsultasi_online.id_konsultasi_online', $jadwal_konsultasi_online)
            ->get()->getRowArray();
    }

    public function get_data_konsultasi_online_user($user_id)
    {
        return $this->db->table('tr_konsultasi_online')
            ->where('tr_konsultasi_online.user_id', $user_id)
            ->get()->getResultArray();
    }

    public function get_data_konsultasi_online_user_per_tanggal($user_id, $tanggal_konsultasi)
    {
        return $this->db->table('tr_konsultasi_online')
            ->where('tr_konsultasi_online.user_id', $user_id)
            ->where('tr_konsultasi_online.tanggal_konsultasi_online', $tanggal_konsultasi)
            ->get()->getResultArray();
    }
}
