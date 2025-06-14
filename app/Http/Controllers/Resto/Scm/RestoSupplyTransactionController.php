<?php

namespace App\Http\Controllers\Resto\Scm;

use App\Http\Controllers\Controller;
use App\Models\RestoSupplyTransaction;
use App\Models\RestoSupply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestoSupplyTransactionController extends Controller
{
    public function index()
    {
        $transactions = RestoSupplyTransaction::with('supply')
            ->where('resto_id', Auth::user()->resto_id)
            ->latest()
            ->paginate(10);

        return view('resto.scm.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $supplies = RestoSupply::where('resto_id', Auth::user()->resto_id)->get();
        return view('resto.scm.transactions.create', compact('supplies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resto_supply_id'  => 'required|exists:resto_supplies,id',
            'tanggal'          => 'required|date',
            'jenis_transaksi'  => 'required|in:masuk,keluar',
            'jumlah'           => 'required|integer|min:1',
            'keterangan'       => 'nullable|string',
        ]);

        $validated['resto_id'] = Auth::user()->resto_id;
        $validated['created_by'] = Auth::id();

        RestoSupplyTransaction::create($validated);

        // update stok otomatis
        $supply = RestoSupply::find($validated['resto_supply_id']);
        if ($validated['jenis_transaksi'] === 'masuk') {
            $supply->stok += $validated['jumlah'];
        } else {
            $supply->stok -= $validated['jumlah'];
        }
        $supply->save();

        return redirect()->route('scmresto.transactions.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    public function destroy(RestoSupplyTransaction $transaction)
    {
        // rollback stok saat menghapus transaksi
        $supply = $transaction->supply;
        if ($transaction->jenis_transaksi === 'masuk') {
            $supply->stok -= $transaction->jumlah;
        } else {
            $supply->stok += $transaction->jumlah;
        }
        $supply->save();

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
