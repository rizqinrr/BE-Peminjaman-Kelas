<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name', 'status', 'email', 'password', 'role'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function totalUser()
    {
        return $this->countAll();
    }
}
