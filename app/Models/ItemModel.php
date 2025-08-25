<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'it_id';

    protected $allowedFields = [
        'it_name',
        'it_price',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'it_created_at';
    protected $updatedField  = 'it_updated_at';
}
