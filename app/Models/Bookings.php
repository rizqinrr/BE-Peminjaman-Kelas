<?php

namespace App\Models;

use CodeIgniter\Model;

class Bookings extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id_booking';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_user', 'id_room', 'booking_date', 'start_date', 'end_date', 'start_time', 'end_time', 'description', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBookingsByUser($id_user)
    {
        return $this->select('bookings.*, rooms.room_name, users.name')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->join('users', 'users.id_user = bookings.id_user')
            ->where('bookings.id_user', $id_user)
            ->findAll();
    }

    public function tampil()
    {
        return $this->select('bookings.*, rooms.room_name, users.name')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->join('users', 'users.id_user = bookings.id_user');
    }

    public function getBookings($id_room)
    {
        return $this->select('rooms.room_name, bookings.start_date, bookings.end_date, bookings.description, bookings.status')
            ->join('rooms', 'rooms.id_room = bookings.id_room')
            ->where('bookings.id_room', $id_room)
            ->orderBy('bookings.start_date', 'ASC')
            ->findAll();
    }
}
