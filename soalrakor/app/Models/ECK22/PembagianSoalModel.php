<?php

namespace App\Models\ECK22;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;

class PembagianSoalModel extends Model
{
    protected $table      = 'eck22_ms_pembagian_soal';
    protected $primaryKey = 'id_pembagian';

    protected $allowedFields = ['id_pembagian', 'id_satker', 'id_soal'];
}
