<?php

namespace App\Http\Controllers;

use App\Models\SharedCustomer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class SharedCustomerController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = SharedCustomer::query();

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

        // Apply date range filter for created_at
        if ($request->has('start_date') && $request->start_date !== '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date !== '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // User-specific filtering
        if ($user->usertype === 'admin') {
            // Admin can see all customers
        } elseif ($user->usertype === 'hotel') {
            $query->whereHas('hotelBookings', function ($q) use ($user) {
                $q->where('hotel_id', $user->hotel_id);
            });
        } elseif ($user->usertype === 'resto') {
            $query->whereHas('restoOrders', function ($q) use ($user) {
                $q->where('resto_id', $user->resto_id);
            });
        } else {
            abort(403);
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

        return view('shared_customers.index', compact('customers'));
    }

    public function show(SharedCustomer $sharedCustomer)
    {
        $this->authorize('view', $sharedCustomer);

        return view('shared_customers.show', compact('sharedCustomer'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'nullable|in:L,P',
        ]);

        $validated['created_by'] = auth()->id(); // opsional jika kamu punya field ini

        $customer = SharedCustomer::create($validated);

        return response()->json([
            'success' => true,
            'customer' => $customer,
        ]);
    }

    public function edit(SharedCustomer $sharedCustomer)
    {
        $this->authorize('view', $sharedCustomer); // Agar hanya FO/resto yg berkaitan bisa edit

        return view('shared_customers.edit', compact('sharedCustomer'));
    }

    public function update(Request $request, SharedCustomer $sharedCustomer)
    {
        $this->authorize('view', $sharedCustomer); // Proteksi akses

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:shared_customers,email,' . $sharedCustomer->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:L,P',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
        ]);

        $sharedCustomer->update($validated);

        return redirect()->route('shared_customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(SharedCustomer $sharedCustomer)
    {
        $this->authorize('view', $sharedCustomer);

        if ($sharedCustomer->hotelBookings()->exists() || $sharedCustomer->restoOrders()->exists()) {
            return back()->with('error', 'Tidak bisa hapus pelanggan yang sudah punya histori booking atau order.');
        }

        $sharedCustomer->delete();

        return redirect()->route('shared_customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    }

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
