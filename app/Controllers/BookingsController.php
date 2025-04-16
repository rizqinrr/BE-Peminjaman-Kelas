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
        $data = [
            'message' => 'success',
            'data_users' => $this->model->tampil()->orderBy('bookings.id_booking', 'DESC')->findAll()
        ];

        return $this->response->setJSON($data, 200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    // public function show ($id_user)
    // {
    //     $bookingModel = new Bookings();
    //     $data = $bookingModel->getBookingsByUser($id_user);

    //     return $this->response->setJSON($data);
    // }

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

        // Ambil data lama
        $oldData = $this->model->find($id);
        if (!$oldData) {
            return $this->failNotFound('Data booking tidak ditemukan');
        }

        // Ambil data baru dari request
        $newData = [
            'id_user' => esc($this->request->getVar('id_user')),
            'id_room' => esc($this->request->getVar('id_room')),
            'booking_date' => esc($this->request->getVar('booking_date')),
            'start_date' => esc($this->request->getVar('start_date')),
            'end_date' => esc($this->request->getVar('end_date')),
            'start_time' => esc($this->request->getVar('start_time')),
            'end_time' => esc($this->request->getVar('end_time')),
            'description' => esc($this->request->getVar('description')),
            'status' => esc($this->request->getVar('status')),
        ];

        // Update data booking
        $this->model->update($id, $newData);

        // Kirim notifikasi jika status berubah
        if ($oldData['status'] !== $newData['status']) {
            $userId = $newData['id_user'];
            $status = $newData['status'];

            switch ($status) {
                case 'Accepted':
                    $messageToUser = "Peminjaman Anda telah <strong>diterima</strong>.";
                    break;
                case 'Declined':
                    $messageToUser = "Peminjaman Anda telah <strong>ditolak</strong>.";
                    break;
                case 'Pending':
                    $messageToUser = "Peminjaman Anda sedang <strong>menunggu persetujuan</strong>.";
                    break;
                case 'Finished':
                    $messageToUser = "Peminjaman Anda telah <strong>selesai</strong>.";
                    break;
                default:
                    $messageToUser = "Status peminjaman Anda telah diperbarui.";
                    break;
            }

            // Simpan ke tabel notifikasi (opsional)
            // $this->notificationModel->insert([
            //     'id_user' => $userId,
            //     'message' => $messageToUser,
            //     'is_read' => 0
            // ]);
        }

        // Response ke frontend
        $response = [
            'message' => 'Data room berhasil diubah',
            'status_update' => $messageToUser ?? null
        ];

        return $this->respond($response, 200);
    }

    public function show($id_room = null)
    {
        $data = $this->model->getBookings($id_room);

        return $this->respond([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}
