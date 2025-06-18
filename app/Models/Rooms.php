<?php

namespace App\Models;

use CodeIgniter\Model;

class Rooms extends Model
{
    protected $table            = 'rooms';
    protected $primaryKey       = 'id_room';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['room_name', 'location', 'capacity', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function totalRuang()
    {
        return $this->countAll();
    }

}
