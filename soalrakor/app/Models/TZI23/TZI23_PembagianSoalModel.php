<?php

namespace App\Models\TZI23;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class TZI23_PembagianSoalModel extends Model
{
    protected $table      = 'tzi23_ms_pembagian_soal';
    protected $primaryKey = 'id_pembagian';

    protected $allowedFields = ['id_pembagian', 'id_asesi', 'id_soal'];
}
