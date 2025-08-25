<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'u_id';

    protected $allowedFields = [
        'u_au_id',
        'u_name',
        'u_email',
        'u_phone',
        'u_membership_id',
        'u_points',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'u_created_at';
    protected $updatedField  = 'u_updated_at';
}
