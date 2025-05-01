<?php

namespace App\Http\Controllers\Hotel\SCM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HotelSupplyTransaction;
use App\Models\HotelSupply;

class HotelSupplyTransactionController extends Controller
{
    public function index()
    {
        $hotelId = Auth::user()->hotel_id;

        $transactions = HotelSupplyTransaction::with('supply')
            ->where('hotel_id', $hotelId)
            ->latest()
            ->paginate(10);

        return view('hotel.scm.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $supplies = HotelSupply::where('hotel_id', Auth::user()->hotel_id)->get();
        return view('hotel.scm.transactions.create', compact('supplies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supply_id' => 'required|exists:hotel_supplies,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction = HotelSupplyTransaction::create([
            'supply_id' => $request->supply_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'note' => $request->note,
            'transaction_date' => $request->transaction_date,
            'user_id' => Auth::id(),
            'hotel_id' => Auth::user()->hotel_id,
        ]);

        // Update stok barang
        $supply = HotelSupply::find($request->supply_id);
        if ($request->type === 'in') {
            $supply->quantity += $request->quantity;
        } else {
            $supply->quantity -= $request->quantity;
            if ($supply->quantity < 0)
                $supply->quantity = 0; // mencegah negatif
        }
        $supply->save();

        return redirect()->route('scm.transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }


    public function destroy($id)
    {
        $transaction = HotelSupplyTransaction::findOrFail($id);

        if ($transaction->supply->hotel_id !== Auth::user()->hotel_id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Rollback stok
        $supply = $transaction->supply;
        if ($transaction->type === 'in') {
            $supply->quantity -= $transaction->quantity;
            if ($supply->quantity < 0)
                $supply->quantity = 0;
        } else {
            $supply->quantity += $transaction->quantity;
        }
        $supply->save();

        $transaction->delete();

        return redirect()->route('scm.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

}
