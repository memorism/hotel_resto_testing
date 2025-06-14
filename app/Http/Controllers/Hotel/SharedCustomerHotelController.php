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
        // dd($request->all());

        $query = SharedCustomer::query();

        // Filter: hanya yang pernah punya transaksi dengan hotel yang sedang login
        $query->whereHas('hotelOrders', function ($q) {
            $q->where('hotel_id', auth()->user()->hotel_id);
        });

        // Apply search filter
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Apply gender filter
        if ($request->has('gender') && $request->gender !== '') {
            $query->where('gender', $request->gender);
        }

        // Apply sorting
        if ($request->has('sort') && $request->sort !== '') {
            $sort = $request->sort;
            $direction = $request->direction === 'asc' ? 'asc' : 'desc';
            switch ($sort) {
                case 'name':
                case 'phone':
                case 'email':
                case 'gender':
                case 'created_at':
                    $query->orderBy($sort, $direction);
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Default sort
        }

        $customers = $query->paginate(10)->appends($request->all());

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

        return redirect()->route('hotel.shared_customers.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }
}
