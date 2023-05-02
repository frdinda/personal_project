<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class EntryPenggunaLayananModel extends Model
{
    protected $table      = 'tr_entry_pengguna_layanan';
    protected $primaryKey = 'id_entry';

    protected $allowedFields = ['id_entry', 'no_telp_pengguna', 'tanggal_entry', 'user_id', 'perihal_konsultasi', 'jenis_layanan', 'jenis_konsultasi'];

    public function get_entry_pengguna_layanan()
    {
        return $this->db->table('tr_entry_pengguna_layanan')
            ->join('ms_pengguna_layanan', 'ms_pengguna_layanan.no_telp_pengguna=tr_entry_pengguna_layanan.no_telp_pengguna', 'LEFT')
            ->join('ms_user', 'tr_entry_pengguna_layanan.user_id=ms_user.user_id', 'LEFT')
            ->orderBy('tr_entry_pengguna_layanan.tanggal_entry', 'DESC')
            ->get()->getResultArray();
    }

    public function get_detail_entry_pengguna_layanan($id_entry)
    {
        return $this->db->table('tr_entry_pengguna_layanan')
            ->where('id_entry', $id_entry)
            ->orderBy('tr_entry_pengguna_layanan.tanggal_entry', 'DESC')
            ->get()->getRowArray();
    }

    public function get_detail_entry_pengguna_layanan_by_tanggal_dan_no_telp($tanggal_entry, $no_telp_pengguna)
    {
        return $this->db->table('tr_entry_pengguna_layanan')
            ->where('tr_entry_pengguna_layanan.tanggal_entry', $tanggal_entry)
            ->where('tr_entry_pengguna_layanan.no_telp_pengguna', $no_telp_pengguna)
            ->get()->getRowArray();
    }

    public function get_detail_entry_per_pengguna($no_telp_pengguna)
    {
        return $this->db->table('tr_entry_pengguna_layanan')
            ->where('tr_entry_pengguna_layanan.no_telp_pengguna', $no_telp_pengguna)
            ->join('ms_user', 'tr_entry_pengguna_layanan.user_id=ms_user.user_id', 'LEFT')
            ->orderBy('tr_entry_pengguna_layanan.tanggal_entry', 'DESC')
            ->get()->getResultArray();
    }

    public function get_detail_pengguna_per_jenis_layanan($tujuan_broadcast)
    {
        return $this->db->table('tr_entry_pengguna_layanan')
            ->where('tr_entry_pengguna_layanan.jenis_layanan', $tujuan_broadcast)
            ->groupBy('tr_entry_pengguna_layanan.no_telp_pengguna')
            ->get()->getResultArray();
    }

    public function get_detail_pengguna_per_jenis_layanan_no_telp($tujuan_broadcast)
    {
        return $this->db->table('tr_entry_pengguna_layanan')
            ->where('tr_entry_pengguna_layanan.jenis_layanan', $tujuan_broadcast)
            ->join('ms_pengguna_layanan', 'ms_pengguna_layanan.no_telp_pengguna=tr_entry_pengguna_layanan.no_telp_pengguna', 'LEFT')
            ->groupBy('ms_pengguna_layanan.no_telp_pengguna')
            ->get()->getResultArray();
    }
}
