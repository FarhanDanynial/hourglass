<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sl_id';

    protected $allowedFields = [
        'sl_it_id',
        'sl_quantity',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'sl_created_at';
    protected $updatedField  = 'sl_updated_at';
}
