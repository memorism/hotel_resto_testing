<?php

namespace App\Http\Controllers\resto;

use App\Http\Controllers\Controller;
use App\Models\SharedCustomer;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class SharedCustomerRestoController extends Controller
{
    public function createResto()
    {
        return view('resto.shared_customers.create_resto');
    }

    public function storeResto(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'nullable|in:L,P',
        ]);

        $validated['created_by'] = auth()->id();
        SharedCustomer::create($validated);

        $redirectTo = $request->input('redirect_back') ?? route('resto.orders.create');

        return redirect($redirectTo)->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function indexResto()
    {
        $customers = SharedCustomer::whereHas('restoOrders', function ($q) {
            $q->where('resto_id', auth()->user()->resto_id);
        })->paginate(10);


        return view('resto.shared_customers.index_resto', compact('customers'));
    }

    public function editResto($id)
    {
        $customer = SharedCustomer::findOrFail($id);
        return view('resto.shared_customers.edit_resto', compact('customer'));
    }

    public function updateResto(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'nullable|in:L,P',
        ]);

        $customer = SharedCustomer::findOrFail($id);
        $customer->update($validated);

        return redirect()->route('resto.shared_customers.index_resto')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroyResto($id)
    {
        $customer = SharedCustomer::findOrFail($id);

        if ($customer->created_by !== auth()->id()) {
            return redirect()->back()->with('error', 'Tidak diizinkan menghapus pelanggan ini.');
        }

        $customer->delete();

        return redirect()->route('resto.shared_customers.index_resto')->with('success', 'Pelanggan berhasil dihapus.');
    }

}
