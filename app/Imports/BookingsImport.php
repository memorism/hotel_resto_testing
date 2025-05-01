<?php

namespace App\Imports;

use App\Models\HotelBooking;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BookingsImport implements ToCollection, WithHeadingRow
{
    protected $uploadOrderId;
    protected $hotelId;
    protected $userId;

    public function __construct($uploadOrderId, $hotelId, $userId)
    {
        $this->uploadOrderId = $uploadOrderId;
        $this->hotelId = $hotelId;
        $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // 🔥 Skip kalau booking_id kosong
            if (empty($row['booking_id'])) {
                continue;
            }

            HotelBooking::create([
                'booking_id' => $row['booking_id'],
                'no_of_adults' => $row['no_of_adults'],
                'no_of_children' => $row['no_of_children'],
                'no_of_weekend_nights' => $row['no_of_weekend_nights'],
                'no_of_week_nights' => $row['no_of_week_nights'],
                'type_of_meal_plan' => $row['type_of_meal_plan'],
                'required_car_parking_space' => $row['required_car_parking_space'],
                'room_type_reserved' => $row['room_type_reserved'],
                'lead_time' => $row['lead_time'],
                'arrival_year' => $row['arrival_year'],
                'arrival_month' => $row['arrival_month'],
                'arrival_date' => $row['arrival_date'],
                'market_segment_type' => $row['market_segment_type'],
                'avg_price_per_room' => $row['avg_price_per_room'],
                'no_of_special_requests' => $row['no_of_special_requests'],
                'booking_status' => $row['booking_status'],
                'upload_order_id' => $this->uploadOrderId,
                'hotel_id' => $this->hotelId,
                'user_id' => $this->userId,
            ]);
        }
    }

}