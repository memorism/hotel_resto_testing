<?php

namespace App\Http\Controllers\Resto;

use App\Models\RestoOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RestoUploadLog;
use App\Models\SharedCustomer;

class RestoOrderController extends Controller
{
    public function index(Request $request)
    {
        $restoId = auth()->user()->resto_id;

        $orders = RestoOrder::with(['uploadLog', 'customer'])
            ->where('resto_id', $restoId)
            ->when($request->status, fn($q) => $q->where('approval_status', $request->status))
            ->when($request->start_date, fn($q) => $q->whereDate('order_date', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('order_date', '<=', $request->end_date))
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('item_name', 'like', "%$search%")
                        ->orWhere('transaction_type', 'like', "%$search%")
                        ->orWhereHas('customer', fn($q) => $q->where('name', 'like', "%$search%"));
                });
            })
            ->when($request->sort, function ($query) use ($request) {
                $direction = $request->direction === 'asc' ? 'asc' : 'desc';

                switch ($request->sort) {
                    case 'customer_name':
                        $query->join('shared_customers', 'resto_orders.customer_id', '=', 'shared_customers.id')
                            ->orderBy('shared_customers.name', $direction);
                        break;
                    case 'no':
                        $query->orderBy('id', $direction);
                        break;
                    default:
                        $query->orderBy($request->sort, $direction);
                }
            }, function ($query) {
                $query->latest();
            })
            ->paginate(10)
            ->appends($request->all());

        return view('resto.orders.index', compact('orders'));
    }

    public function create()
    {
        $restoId = auth()->user()->resto_id;
        $uploads = RestoUploadLog::where('resto_id', $restoId)->get();
        $customers = SharedCustomer::orderBy('name')->get();

        return view('resto.orders.create', compact('uploads', 'customers'));
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

        $validated['user_id'] = auth()->id();
        $validated['resto_id'] = auth()->user()->resto_id;
        $validated['approval_status'] = 'pending';

        if ($request->filled('customer_id')) {
            $customer = SharedCustomer::find($request->customer_id);
            $validated['received_by'] = $customer->gender ?? 'Unknown';
        } else {
            $validated['received_by'] = 'Unknown';
        }

        RestoOrder::create($validated);

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function edit(RestoOrder $order)
    {
        $this->authorizeAccess($order);

        $uploads = RestoUploadLog::where('resto_id', auth()->user()->resto_id)->get();
        $customers = SharedCustomer::orderBy('name')->get();

        return view('resto.orders.edit', compact('order', 'uploads', 'customers'));
    }

    public function update(Request $request, RestoOrder $order)
    {
        $this->authorizeAccess($order);

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

        $validated['approval_status'] = 'pending';
        $validated['approved_by'] = null;
        $validated['approved_at'] = null;
        $validated['rejection_note'] = null;

        if ($request->filled('customer_id')) {
            $customer = SharedCustomer::find($request->customer_id);
            $validated['received_by'] = $customer->gender ?? 'Unknown';
        } else {
            $validated['received_by'] = 'Unknown';
        }

        $order->update($validated);

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $order = RestoOrder::where('id', $id)
            ->where('resto_id', auth()->user()->resto_id)
            ->firstOrFail();

        $order->delete();

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function approve($id)
    {
        $order = RestoOrder::where('id', $id)->where('resto_id', auth()->user()->resto_id)->firstOrFail();

        $order->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_note' => null,
        ]);

        return back()->with('success', 'Pesanan berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_note' => 'required|string|max:1000',
        ]);

        $order = RestoOrder::where('id', $id)->where('resto_id', auth()->user()->resto_id)->firstOrFail();

        $order->update([
            'approval_status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', 'Pesanan berhasil ditolak dengan catatan.');
    }

    private function authorizeAccess(RestoOrder $order)
    {
        if ($order->resto_id !== auth()->user()->resto_id) {
            abort(403, 'Akses tidak diizinkan.');
        }
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('selected_orders', []);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $updated = RestoOrder::whereIn('id', $ids)
            ->where('approval_status', 'pending')
            ->update([
                'approval_status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

        return back()->with('success', "$updated pesanan berhasil disetujui.");
    }

    public function bulkReject(Request $request)
    {
        $ids = $request->input('selected_orders', []);
        $note = $request->input('rejection_note');

        if (empty($ids) || empty($note)) {
            return back()->with('error', 'Pilih data dan isi alasan penolakan.');
        }

        $updated = RestoOrder::whereIn('id', $ids)
            ->where('approval_status', 'pending')
            ->update([
                'approval_status' => 'rejected',
                'rejection_note' => $note,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

        return back()->with('success', "$updated pesanan berhasil ditolak.");
    }

}
