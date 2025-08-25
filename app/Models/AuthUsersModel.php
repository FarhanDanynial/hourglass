<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthUsersModel extends Model
{
    protected $table = 'auth_users';
    protected $primaryKey = 'au_id';

    protected $allowedFields = [
        'au_id',
        'au_username',
        'au_password',
        'au_type'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'au_created_at';
    protected $updatedField  = 'au_updated_at';
}
