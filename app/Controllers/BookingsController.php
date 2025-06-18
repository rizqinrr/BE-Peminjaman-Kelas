<?php

namespace App\Controllers;

use App\Models\Bookings;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class BookingsController extends ResourceController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Bookings(); // Inisialisasi model Bookings
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $bookings = $this->model->tampil()->orderBy('bookings.id_booking', 'DESC')->findAll();

        // Olah hasil supaya JSON hanya menampilkan nama user & nama ruangan
        $result = array_map(function ($item) {
            return [
                'id_booking'   => $item['id_booking'],
                'booking_date' => $item['booking_date'],
                'start_date'   => $item['start_date'],
                'end_date'     => $item['end_date'],
                'start_time'   => $item['start_time'],
                'end_time'     => $item['end_time'],
                'description'  => $item['description'],
                'status'       => $item['status'],
                'user_name'    => $item['user_name'],    // dari tabel users
                'room_name'    => $item['room_name'],    // dari tabel rooms
            ];
        }, $bookings);

        return $this->response->setJSON([
            'message' => 'success',
            'data_users' => $result
        ]);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = $this->validate([
            'id_user' => 'required',
            'id_room' => 'required',
            'booking_date' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->insert([
            'id_user' => esc($this->request->getVar('id_user')),
            'id_room' => esc($this->request->getVar('id_room')),
            'booking_date' => esc($this->request->getVar('booking_date')),
            'start_date' => esc($this->request->getVar('start_date')),
            'end_date' => esc($this->request->getVar('end_date')),
            'start_time' => esc($this->request->getVar('start_time')),
            'end_time' => esc($this->request->getVar('end_time')),
            'description' => esc($this->request->getVar('description')),
            'status' => esc($this->request->getVar('status')),
        ]);

        $response = [
            'messsage' => 'Formulir Peminjaman berhasil diajukan'
        ];

        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        // Validasi hanya field status
    $rules = $this->validate([
        'status' => 'required',
    ]);

    if (!$rules) {
        $response = [
            'message' => $this->validator->getErrors()
        ];
        return $this->failValidationErrors($response);
    }

    // Ambil data lama
    $oldData = $this->model->find($id);
    if (!$oldData) {
        return $this->failNotFound('Data booking tidak ditemukan');
    }

    // Data baru hanya status
    $newData = [
        'status' => esc($this->request->getVar('status')),
    ];

        // Update data booking
        $this->model->update($id, $newData);

        // Kirim notifikasi jika status berubah
        if ($oldData['status'] !== $newData['status']) {
            $userId = $oldData['id_user'];
            $status = $newData['status'];

            switch ($status) {
                case 'Accepted':
                    $messageToUser = "Peminjaman Anda telah <strong>diterima</strong>.";
                    break;
                case 'Declined':
                    $messageToUser = "Peminjaman Anda telah <strong>ditolak</strong>.";
                    break;
                default:
                    $messageToUser = "Status peminjaman Anda telah diperbarui.";
                    break;
            }
        }

        // Response ke frontend
        $response = [
            'message' => 'Data room berhasil diubah',
            'status_update' => $messageToUser ?? null
        ];

        return $this->respond($response, 200);
    }

    public function show($id_booking = null)
    {
        $dataBooking = $this->model->tampil()
        ->where('bookings.id_booking', $id_booking)
        ->first();

    if (!$dataBooking) {
        return $this->failNotFound('Data Peminjaman tidak ditemukan');
    }

    // Buat struktur JSON respons
    $data = [
        'message' => 'success',
        'bookings_byid' => [
            'id_booking'   => $dataBooking['id_booking'],
            'booking_date' => $dataBooking['booking_date'],
            'start_date'   => $dataBooking['start_date'],
            'end_date'     => $dataBooking['end_date'],
            'start_time'   => $dataBooking['start_time'],
            'end_time'     => $dataBooking['end_time'],
            'description'  => $dataBooking['description'],
            'status'       => $dataBooking['status'],
            'user_name'    => $dataBooking['user_name'],
            'room_name'    => $dataBooking['room_name'],
        ]
    ];

    return $this->respond($data, 200);
    }

    public function delete($id_booking = null)
    {
        $this->model->delete($id_booking);

        $response = [
            'messsage' => 'Data Booking berhasil dihapus'
        ];

        return $this->respondDeleted($response);
    }
}
