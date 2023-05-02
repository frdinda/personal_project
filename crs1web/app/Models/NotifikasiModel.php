<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class NotifikasiModel extends Model
{
    protected $table      = 'tr_notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $allowedFields = ['id_notifikasi', 'id_broadcast', 'user_id', 'text_notifikasi', 'tanggal_kirim_notifikasi', 'status_kirim_notifikasi', 'jenis_notifikasi'];

    public function get_data_notifikasi()
    {
        return $this->db->table('tr_notifikasi')
            ->get()->getResultArray();
    }

    public function get_detail_notifikasi($id_notifikasi)
    {
        return $this->db->table('tr_notifikasi')
            ->where('tr_notifikasi.id_notifikasi', $id_notifikasi)
            ->get()->getRowArray();
    }

    public function get_detail_notifikasi_by_broadcast($id_broadcast)
    {
        return $this->db->table('tr_notifikasi')
            ->where('tr_notifikasi.id_broadcast', $id_broadcast)
            ->get()->getRowArray();
    }

    public function get_data_notifikasi_belum()
    {
        return $this->db->table('tr_notifikasi')
            ->where('tr_notifikasi.status_kirim_notifikasi', 'Belum')
            ->get()->getResultArray();
    }

    public function get_detail_notifikasi_pengingat($id_konsultasi_online)
    {
        return $this->db->table('tr_notifikasi')
            ->where('tr_notifikasi.id_broadcast', $id_konsultasi_online)
            ->where('tr_notifikasi.jenis_notifikasi', 'Pengingat')
            ->get()->getRowArray();
    }
}
