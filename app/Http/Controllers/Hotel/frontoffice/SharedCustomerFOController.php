<?php

namespace App\Http\Controllers\hotel\frontoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\SharedCustomer;



class SharedCustomerFOController extends Controller
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

        // Handle sorting
        $query->when($request->sort, function ($query) use ($request) {
            $direction = $request->direction === 'asc' ? 'asc' : 'desc';
            switch ($request->sort) {
                case 'no':
                    $query->orderBy('id', $direction);
                    break;
                case 'name':
                    $query->orderBy('name', $direction);
                    break;
                case 'email':
                    $query->orderBy('email', $direction);
                    break;
                case 'phone':
                    $query->orderBy('phone', $direction);
                    break;
                case 'gender':
                    $query->orderBy('gender', $direction);
                    break;
                default:
                    $query->orderBy($request->sort, $direction);
            }
        }, function ($query) {
            $query->orderBy('name', 'asc');
        });

        $customers = $query->paginate(10)->appends($request->all());

        return view('hotel.frontoffice.shared_customers.index', compact('customers'));
    }


    public function createHotel()
    {
        return view('hotel.frontoffice.shared_customers.create');
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
        $redirectUrl = $request->input('redirect_back') ?? route('hotel.frontoffice.shared_customers.index_hotel');

        return redirect($redirectUrl)->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function editHotel($id)
    {
        $customer = SharedCustomer::findOrFail($id);
        return view('hotel.frontoffice.shared_customers.edit', compact('customer'));
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

        return redirect()->route('hotel.frontoffice.shared_customers.index_hotel')->with('success', 'Pelanggan berhasil diperbarui.');
    }
}
