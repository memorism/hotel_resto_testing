<?php

namespace App\Http\Controllers\Resto\Cashier;

use App\Http\Controllers\Controller;
use App\Models\SharedCustomer;
use Illuminate\Http\Request;

class CashierCustomerController extends Controller
{
    public function create()
    {
        return view('resto.cashier.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'nullable|in:L,P',
        ]);

        $validated['created_by'] = auth()->id();
        SharedCustomer::create($validated);

        $redirectTo = $request->input('redirect_back') ?? route('cashierresto.orders.create');

        return redirect($redirectTo)->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        $customers = SharedCustomer::whereHas('restoOrders', function ($q) {
            $q->where('resto_id', auth()->user()->resto_id);
        })
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends(['search' => $search, 'sort' => $sortField, 'direction' => $sortDirection]);

        return view('resto.cashier.customers.index', compact('customers'));
    }

    public function edit($id)
    {
        $customer = SharedCustomer::findOrFail($id);
        return view('resto.cashier.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'nullable|in:L,P',
        ]);

        $customer = SharedCustomer::findOrFail($id);
        $customer->update($validated);

        return redirect()->route('cashierresto.customers.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $customer = SharedCustomer::findOrFail($id);

        if ($customer->created_by !== auth()->id()) {
            return redirect()->back()->with('error', 'Tidak diizinkan menghapus pelanggan ini.');
        }

        $customer->delete();

        return redirect()->route('cashierresto.customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
