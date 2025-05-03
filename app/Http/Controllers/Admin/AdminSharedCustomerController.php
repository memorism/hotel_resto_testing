<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SharedCustomer;
use PhpParser\Node\Stmt\ElseIf_;

class AdminSharedCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = SharedCustomer::query();
    
        // ✅ Tampilkan yang sudah dihapus (soft delete)
        if ($request->boolean('with_deleted')) {
            $query->withTrashed();
        }
    
        // 🔍 Search berdasarkan nama/email/phone
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }
    
        // 📁 Filter berdasarkan asal data
        if ($request->input('source') === 'hotel') {
            $query->whereHas('hotelOrders');
        } elseif ($request->input('source') === 'resto') {
            $query->whereHas('restoOrders');
        }
    
        $customers = $query->latest()->paginate(10);
    
        return view('admin.shared_customers.index', compact('customers'));
    }
    

    public function create()
    {
        return view('admin.shared_customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:shared_customers,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:L,P',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:500',
        ]);

        SharedCustomer::create($validated);
        return redirect()->route('admin.shared_customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $customer = SharedCustomer::withTrashed()->findOrFail($id);
        return view('admin.shared_customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = SharedCustomer::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:shared_customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:L,P',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:500',
        ]);

        $customer->update($validated);
        return redirect()->route('admin.shared_customers.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $customer = SharedCustomer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.shared_customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function restore($id)
    {
        $customer = SharedCustomer::withTrashed()->findOrFail($id);
        $customer->restore();

        return redirect()->route('admin.shared_customers.index')->with('success', 'Pelanggan berhasil dipulihkan.');
    }

}
