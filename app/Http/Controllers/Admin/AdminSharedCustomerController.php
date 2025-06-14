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
        $search = $request->input('search');
        $source = $request->input('source');
        $withDeleted = $request->boolean('with_deleted');
        $perPage = $request->input('per_page', 10); // Default to 10 items per page
        $sort = $request->input('sort', 'created_at'); // Default sort by created_at
        $direction = $request->input('direction', 'desc'); // Default sort direction descending

        $query = SharedCustomer::query();

        if ($withDeleted) {
            $query->withTrashed();
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($source) {
            $query->where('source', $source);
        }

        // Validate sort column
        $allowedSortColumns = ['name', 'email', 'phone', 'gender', 'address', 'created_at'];
        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'created_at';
        }

        // Validate direction
        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        // Handle "semua" for per_page
        $perPage = ($perPage === 'semua') ? $query->count() : (int) $perPage;

        $customers = $query->orderBy($sort, $direction)->paginate($perPage)->appends($request->all());

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
