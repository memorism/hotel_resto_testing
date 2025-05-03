<?php

namespace App\Http\Controllers\Resto;

use App\Models\RestoOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RestoUploadLog;
use Illuminate\Support\Facades\DB;
use App\Models\SharedCustomer;

class RestoOrderController extends Controller
{
    public function index(Request $request)
    {
        $restoId = auth()->user()->resto_id;
        $perPage = $request->get('perPage', 10);

        $orders = RestoOrder::with('uploadLog')
            ->where('resto_id', $restoId)
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                return $query->where(function ($q) use ($search) {
                    $q->where('item_name', 'like', "%$search%")
                        ->orWhere('item_type', 'like', "%$search%")
                        ->orWhere('transaction_type', 'like', "%$search%")
                        ->orWhere('type_of_order', 'like', "%$search%")
                        ->orWhere('order_date', 'like', "%$search%")
                        ->orWhere('time_order', 'like', "%$search%")
                        ->orWhere('received_by', 'like', "%$search%");
                });
            })
            ->paginate($perPage);

        return view('resto.orders.index', compact('orders'));
    }

    public function create()
    {
        $restoId = auth()->user()->resto_id;

        $uploads = RestoUploadLog::where('resto_id', $restoId)->get();

        $customers = SharedCustomer::whereHas('restoOrders', function ($q) use ($restoId) {
            $q->where('resto_id', $restoId);
        })->orWhereDoesntHave('restoOrders')
            ->orderBy('name')->get();

        return view('resto.orders.create', compact('uploads', 'customers'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:shared_customers,id',
            'excel_upload_id' => 'required|exists:resto_upload_logs,id',
            'order_date' => 'required|date',
            'time_order' => 'required|date_format:H:i',
            'item_name' => 'required|string',
            'item_type' => 'required|string',
            'item_price' => 'required|integer',
            'quantity' => 'required|integer',
            'transaction_amount' => 'required|integer',
            'transaction_type' => 'required|string',
            'received_by' => 'required|string',
            'type_of_order' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['resto_id'] = auth()->user()->resto_id;

        RestoOrder::create($validated);

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }


    public function show($id)
    {
        $order = RestoOrder::where('id', $id)
            ->where('resto_id', auth()->user()->resto_id)
            ->firstOrFail();

        return response()->json($order);
    }

    public function edit(RestoOrder $order)
    {
        if ($order->resto_id !== auth()->user()->resto_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit pesanan ini.');
        }

        $uploads = RestoUploadLog::where('resto_id', auth()->user()->resto_id)->get();

        return view('resto.orders.edit', compact('order', 'uploads'));
    }

    public function update(Request $request, RestoOrder $order)
    {
        if ($order->resto_id !== auth()->user()->resto_id) {
            return redirect()->route('resto.orders.index')->with('error', 'Unauthorized access');
        }

        $validated = $request->validate([
            'order_date' => 'required|date',
            'time_order' => 'required|date_format:H:i:s',
            'item_name' => 'required|string',
            'item_type' => 'required|string',
            'item_price' => 'required|integer',
            'quantity' => 'required|integer',
            'transaction_amount' => 'required|integer',
            'transaction_type' => 'required|string',
            'received_by' => 'required|string',
            'type_of_order' => 'required|string',
        ]);

        $order->update($validated);

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy($request)
    {
        $search = $request->input('search');

        $customers = SharedCustomer::whereHas('restoOrders', function ($q) {
                $q->where('resto_id', auth()->user()->resto_id);
            })
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(10)
            ->appends(['search' => $search]); // biar keyword tetap ada saat pindah halaman

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }


}
