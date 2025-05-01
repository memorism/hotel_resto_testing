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

        $finance = HotelFinance::where('hotel_id', $hotelId)
            ->when($request->type, fn($q) => $q->where('transaction_type', $request->type))
            ->when($request->month, fn($q) => $q->whereMonth('transaction_date', $request->month))
            ->when($request->year, fn($q) => $q->whereYear('transaction_date', $request->year))
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

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
            'transaction_code' => 'TRX' . now()->format('YmdHis') . Str::random(3),
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
        ]);

        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil ditambahkan.');
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

        $finance->update($request->only([
            'transaction_date',
            'transaction_time',
            'transaction_type',
            'amount',
            'payment_method',
            'category',
            'subcategory',
            'source_or_target',
            'reference_number',
            'description'
        ]));

        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(HotelFinance $finance)
    {
        $this->authorizeTransaction($finance);
        $finance->delete();
        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    protected function authorizeTransaction($finance)
    {
        $hotelId = auth()->user()->hotel_id;
        if ($finance->hotel_id !== $hotelId) {
            abort(403, 'Tidak punya akses ke transaksi ini.');
        }
    }


    public function show(HotelFinance $finance)
    {
        // Kosongkan jika memang tidak digunakan
        abort(404); // Atau redirect()->back();
    }

}
