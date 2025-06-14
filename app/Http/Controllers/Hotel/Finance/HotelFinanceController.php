<?php

namespace App\Http\Controllers\Hotel\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelFinance;
use Illuminate\Support\Str;

class HotelFinanceController extends Controller
{
    public function index(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;

        $query = HotelFinance::where('hotel_id', $hotelId)
            ->when($request->type, fn($q) => $q->where('transaction_type', $request->type))
            ->when($request->month, fn($q) => $q->whereMonth('transaction_date', $request->month))
            ->when($request->year, fn($q) => $q->whereYear('transaction_date', $request->year))
            ->when($request->status, fn($q) => $q->where('approval_status', $request->status))
            ->when($request->start_date, fn($q) => $q->whereDate('transaction_date', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('transaction_date', '<=', $request->end_date));

        // Handle sorting
        $query->when($request->sort, function ($query) use ($request) {
            $direction = $request->direction === 'asc' ? 'asc' : 'desc';
            switch ($request->sort) {
                case 'no':
                    $query->orderBy('id', $direction);
                    break;
                case 'approval_status':
                    $query->orderBy('approval_status', $direction);
                    break;
                case 'transaction_date':
                    $query->orderBy('transaction_date', $direction);
                    break;
                case 'transaction_type':
                    $query->orderBy('transaction_type', $direction);
                    break;
                case 'category':
                    $query->orderBy('category', $direction);
                    break;
                case 'amount':
                    $query->orderBy('amount', $direction);
                    break;
                case 'payment_method':
                    $query->orderBy('payment_method', $direction);
                    break;
                default:
                    $query->orderBy($request->sort, $direction);
            }
        }, function ($query) {
            $query->orderBy('transaction_date', 'desc');
        });

        $finance = $query->paginate(10)->appends($request->all());

        return view('hotel.finance.index', compact('finance'));
    }

    public function create()
    {
        return view('hotel.finance.create', ['finance' => null]);
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
            'approval_status' => 'pending', // ✅ default pending
        ]);

        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil ditambahkan & menunggu persetujuan.');
    }

    public function edit(HotelFinance $finance)
    {
        $this->authorizeTransaction($finance);
        return view('hotel.finance.edit', compact('finance'));
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
                // ✅ Reset approval jika diedit
                'approval_status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'rejection_note' => null,
            ]
        ));

        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil diperbarui & menunggu persetujuan ulang.');
    }

    public function destroy(HotelFinance $finance)
    {
        $this->authorizeTransaction($finance);
        $finance->delete();

        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil dihapus.');
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


}
