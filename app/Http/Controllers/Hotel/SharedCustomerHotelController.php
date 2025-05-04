<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\SharedCustomer;



class SharedCustomerHotelController extends Controller
{

    public function indexHotel(Request $request)
    {
        $query = SharedCustomer::query();

        // Filter: hanya yang pernah punya transaksi dengan hotel yang sedang login
        $query->whereHas('hotelOrders', function ($q) {
            $q->where('hotel_id', auth()->user()->hotel_id);
        });

        // Optional: filter by search
        if ($request->has('search') && $request->search !== '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $customers = $query->paginate(10);

        return view('hotel.shared_customers.index', compact('customers'));
    }

    public function createHotel()
    {
        return view('hotel.shared_customers.create');
    }

    public function storeHotel(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:shared_customers,email',
            'phone' => 'nullable|string',
            'gender' => 'nullable|in:L,P',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        SharedCustomer::create($validated);
        // Redirect dinamis
        $redirectUrl = $request->input('redirect_back') ?? route('hotel.shared_customers.index_hotel');

        return redirect($redirectUrl)->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function editHotel($id)
    {
        $customer = SharedCustomer::findOrFail($id);
        return view('hotel.shared_customers.edit', compact('customer'));
    }

    public function updateHotel(Request $request, $id)
    {
        $customer = SharedCustomer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:shared_customers,email,' . $customer->id,
            'phone' => 'nullable|string',
            'gender' => 'nullable|in:L,P',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->route('hotel.shared_customers.index_hotel')->with('success', 'Pelanggan berhasil diperbarui.');
    }
}
