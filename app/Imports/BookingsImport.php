<?php

namespace App\Imports;

use App\Models\HotelBooking;
use App\Models\HotelRoom;
use App\Models\SharedCustomer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class BookingsImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    protected int $uploadOrderId;
    protected int $hotelId;
    protected int $userId;

    public function sheets(): array
    {
        return [
            'DATA' => $this,
        ];
    }

    public function __construct(?int $uploadOrderId, ?int $hotelId, ?int $userId)
    {
        $this->uploadOrderId = $uploadOrderId;
        $this->hotelId = $hotelId;
        $this->userId = $userId;
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            if (empty($row['booking_id']) || empty($row['customer_name']) || empty($row['room_type_reserved'])) {
                continue;
            }

            // Cek duplikasi booking_id untuk hotel yang sama
            $exists = HotelBooking::where('booking_id', $row['booking_id'])
                ->where('hotel_id', $this->hotelId)
                ->exists();

            if ($exists) {
                continue;
            }

            // Ambil atau buat customer
            $customer = SharedCustomer::firstOrCreate(
                ['name' => $row['customer_name']],
                ['created_by' => $this->userId]
            );

            // Ambil atau buat kamar berdasarkan room_type dan hotel_id
            $roomType = trim($row['room_type_reserved']);
            $room = HotelRoom::firstOrCreate(
                [
                    'hotel_id' => $this->hotelId,
                    'room_type' => $roomType,
                ],
                [
                    'user_id' => $this->userId,
                    'description' => 'Auto-imported from Excel',
                    'total_rooms' => 0,
                    'price_per_room' => 0.00,
                ]
            );

            // Simpan booking
            HotelBooking::create([
                'hotel_id' => $this->hotelId,
                'user_id' => $this->userId,
                'hotel_upload_log_id' => $this->uploadOrderId,
                'customer_id' => $customer->id,
                'booking_id' => $row['booking_id'],
                'no_of_adults' => (int) ($row['no_of_adults'] ?? 0),
                'no_of_children' => (int) ($row['no_of_children'] ?? 0),
                'no_of_weekend_nights' => (int) ($row['no_of_weekend_nights'] ?? 0),
                'no_of_week_nights' => (int) ($row['no_of_week_nights'] ?? 0),
                'type_of_meal_plan' => $row['type_of_meal_plan'] ?? '-',
                'required_car_parking_space' => (int) ($row['required_car_parking_space'] ?? 0),
                'room_id' => $room->id,
                'lead_time' => (int) ($row['lead_time'] ?? 0),
                'arrival_year' => (int) ($row['arrival_year'] ?? date('Y')),
                'arrival_month' => (int) ($row['arrival_month'] ?? date('n')),
                'arrival_date' => (int) ($row['arrival_date'] ?? date('j')),
                'market_segment_type' => $row['market_segment_type'] ?? '-',
                'avg_price_per_room' => (float) ($row['avg_price_per_room'] ?? 0),
                'no_of_special_requests' => (int) ($row['no_of_special_requests'] ?? 0),
                'booking_status' => $row['booking_status'] ?? 'pending',
            ]);
        }
    }
}
