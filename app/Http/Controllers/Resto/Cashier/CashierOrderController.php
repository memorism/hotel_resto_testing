<?php

namespace App\Http\Controllers\Resto\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RestoOrder;
use App\Models\RestoUploadLog;
use App\Models\SharedCustomer;

class CashierOrderController extends Controller
{
    public function index(Request $request)
    {
        $restoId = Auth::user()->resto_id;
        $perPage = $request->get('perPage', 10);
        $sortField = $request->get('sort', 'order_date');
        $sortDirection = $request->get('direction', 'desc');

        $query = RestoOrder::with(['uploadLog', 'customer'])
            ->where('resto_id', $restoId)
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('item_name', 'like', "%$search%")
                        ->orWhere('item_type', 'like', "%$search%")
                        ->orWhere('transaction_type', 'like', "%$search%")
                        ->orWhere('type_of_order', 'like', "%$search%")
                        ->orWhere('order_date', 'like', "%$search%")
                        ->orWhere('time_order', 'like', "%$search%")
                        ->orWhere('received_by', 'like', "%$search%");
                })->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->when($request->status, fn($q) => $q->where('approval_status', $request->status))
            ->when($request->start_date, fn($q) => $q->whereDate('order_date', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('order_date', '<=', $request->end_date))
            ->orderBy($sortField, $sortDirection);

        if ($perPage === 'all') {
            $orders = $query->get();
        } else {
            $orders = $query->paginate((int) $perPage)->appends($request->all());
        }

        return view('resto.cashier.orders.index', compact('orders', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        $restoId = Auth::user()->resto_id;

        $uploads = RestoUploadLog::where('resto_id', $restoId)->get();
        $customers = SharedCustomer::whereHas('restoOrders', function ($q) use ($restoId) {
            $q->where('resto_id', $restoId);
        })->orWhereDoesntHave('restoOrders')->orderBy('name')->get();

        return view('resto.cashier.orders.create', compact('uploads', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:shared_customers,id',
            'excel_upload_id' => 'nullable|exists:resto_upload_logs,id',
            'order_date' => 'required|date',
            'time_order' => 'required|date_format:H:i',
            'item_name' => 'required|string',
            'item_type' => 'required|string',
            'item_price' => 'required|integer',
            'quantity' => 'required|integer',
            'transaction_amount' => 'required|integer',
            'transaction_type' => 'required|string',
            'type_of_order' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['resto_id'] = Auth::user()->resto_id;
        $validated['approval_status'] = 'pending';

        if ($request->filled('customer_id')) {
            $customer = SharedCustomer::find($request->customer_id);
            $validated['received_by'] = $customer->gender ?? 'Unknown';
        } else {
            $validated['received_by'] = 'Unknown';
        }

        RestoOrder::create($validated);

        return redirect()->route('cashierresto.orders.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function edit(RestoOrder $order)
    {
        if ($order->resto_id !== Auth::user()->resto_id) {
            abort(403, 'Akses ditolak.');
        }

        $uploads = RestoUploadLog::where('resto_id', Auth::user()->resto_id)->get();
        $customers = SharedCustomer::whereHas('restoOrders', function ($q) {
            $q->where('resto_id', Auth::user()->resto_id);
        })->orWhereDoesntHave('restoOrders')->orderBy('name')->get();

        return view('resto.cashier.orders.edit', compact('order', 'uploads', 'customers'));
    }

    public function update(Request $request, RestoOrder $order)
    {
        if ($order->resto_id !== Auth::user()->resto_id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'customer_id' => 'nullable|exists:shared_customers,id',
            'order_date' => 'required|date',
            'time_order' => 'required|date_format:H:i',
            'item_name' => 'required|string',
            'item_type' => 'required|string',
            'item_price' => 'required|integer',
            'quantity' => 'required|integer',
            'transaction_amount' => 'required|integer',
            'transaction_type' => 'required|string',
            'type_of_order' => 'required|string',
        ]);

        if ($request->filled('customer_id')) {
            $customer = SharedCustomer::find($request->customer_id);
            $validated['received_by'] = $customer->gender ?? 'Unknown';
        } else {
            $validated['received_by'] = 'Unknown';
        }

        $order->update(array_merge($validated, [
            'approval_status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
            'rejection_note' => null,
        ]));

        return redirect()->route('cashierresto.orders.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $order = RestoOrder::where('id', $id)
            ->where('resto_id', Auth::user()->resto_id)
            ->firstOrFail();

        $order->delete();

        return redirect()->route('cashierresto.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
