<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\HotelFinance;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;

        $finance = HotelFinance::where('hotel_id', $hotelId)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%' . $request->search . '%')
                        ->orWhere('category', 'like', '%' . $request->search . '%')
                        ->orWhere('payment_method', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->type, fn($q) =>
                $q->where('transaction_type', $request->type))
            ->when($request->status, fn($q) =>
                $q->where('approval_status', $request->status))
            ->when($request->start_date, fn($q) =>
                $q->whereDate('transaction_date', '>=', $request->start_date))
            ->when($request->end_date, fn($q) =>
                $q->whereDate('transaction_date', '<=', $request->end_date))
            ->when($request->sort, function ($query) use ($request) {
                $direction = $request->direction === 'asc' ? 'asc' : 'desc';
                switch ($request->sort) {
                    case 'date':
                        $query->orderBy('transaction_date', $direction);
                        break;
                    case 'type':
                        $query->orderBy('transaction_type', $direction);
                        break;
                    case 'amount':
                        $query->orderBy('amount', $direction);
                        break;
                    case 'status':
                        $query->orderBy('approval_status', $direction);
                        break;
                    case 'category':
                        $query->orderBy('category', $direction);
                        break;
                    case 'subcategory':
                        $query->orderBy('subcategory', $direction);
                        break;
                    default:
                        $query->orderBy('transaction_date', 'desc');
                }
            }, function ($query) {
                $query->orderBy('transaction_date', 'desc');
            })
            ->paginate(10)
            ->appends($request->all());

        return view('hotel.hotelfinance.index', compact('finance'));
    }

    public function create()
    {
        return view('hotel.hotelfinance.create', ['finance' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'category' => 'required|string',
        ]);

        HotelFinance::create([
            'hotel_id' => auth()->user()->hotel_id,
            'user_id' => auth()->id(),
            'transaction_code' => 'TRX' . now()->format('YmdHis') . strtoupper(Str::random(3)),
            'transaction_date' => $request->transaction_date,
            'transaction_time' => $request->transaction_time ?? now()->format('H:i:s'),
            'transaction_type' => $request->transaction_type,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'source_or_target' => $request->source_or_target,
            'reference_number' => $request->reference_number,
            'description' => $request->description,
            'approval_status' => 'pending',
        ]);


        return redirect()->route('hotel.finance.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(HotelFinance $finance)
    {
        $this->authorizeTransaction($finance);
        return view('hotel.hotelfinance.edit', compact('finance'));
    }

    public function update(Request $request, HotelFinance $finance)
    {
        $this->authorizeTransaction($finance);

        $request->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'category' => 'required|string',
        ]);

        $finance->update(array_merge(
            $request->only([
                'transaction_date',
                'transaction_time',
                'transaction_type',
                'amount',
                'payment_method',
                'category',
                'subcategory',
                'source_or_target',
                'reference_number',
                'description',
            ]),
            [
                'approval_status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'rejection_note' => null,
            ]
        ));

        return redirect()->route('hotel.finance.index')->with('success', 'Transaksi berhasil diperbarui dan menunggu persetujuan ulang.');
    }

    public function destroy(HotelFinance $finance)
    {
        $this->authorizeTransaction($finance);
        $finance->delete();

        return redirect()->route('hotel.finance.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    protected function authorizeTransaction($finance)
    {
        if ($finance->hotel_id !== auth()->user()->hotel_id) {
            abort(403, 'Tidak punya akses ke transaksi ini.');
        }
    }

    public function show(HotelFinance $finance)
    {
        abort(404);
    }

    public function approve($id)
    {
        $finance = HotelFinance::where('id', $id)->where('hotel_id', auth()->user()->hotel_id)->firstOrFail();

        $finance->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_note' => null,
        ]);

        return redirect()->back()->with('success', 'Transaksi disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_note' => 'required|string|max:1000',
        ]);

        $finance = HotelFinance::where('id', $id)->where('hotel_id', auth()->user()->hotel_id)->firstOrFail();

        $finance->update([
            'approval_status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return redirect()->back()->with('success', 'Transaksi ditolak.');
    }
    public function bulkAction(Request $request)
    {
        $request->validate([
            'selected_transactions' => 'required|array',
            'selected_transactions.*' => 'exists:hotel_finances,id',
            'action' => 'required|in:approve,reject'
        ]);

        $finance = HotelFinance::whereIn('id', $request->selected_transactions)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('approval_status', 'pending')
            ->get();

        if ($request->action === 'approve') {
            $finance->each(function ($item) {
                $item->update([
                    'approval_status' => 'approved',
                    // 'approved_by' => auth()->id(),
                    'approved_at' => now(),
                    'rejection_note' => null,
                ]);
            });

            return redirect()->back()->with('success', 'Transaksi terpilih berhasil disetujui.');
        }

        return redirect()->back();
    }

    public function bulkReject(Request $request)
    {
        $request->validate([
            'selected_transactions' => 'required|array',
            'selected_transactions.*' => 'exists:hotel_finances,id',
            'rejection_note' => 'required|string|max:1000'
        ]);

        $finance = HotelFinance::whereIn('id', $request->selected_transactions)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('approval_status', 'pending')
            ->get();

        $finance->each(function ($item) use ($request) {
            $item->update([
                'approval_status' => 'rejected',
                // 'approved_by' => auth()->id(),
                'approved_at' => now(),
                'rejection_note' => $request->rejection_note,
            ]);
        });

        return redirect()->back()->with('success', 'Transaksi terpilih berhasil ditolak.');
    }
}
