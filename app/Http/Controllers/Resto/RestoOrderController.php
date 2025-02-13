<?php

namespace App\Http\Controllers\Resto;

use App\Models\RestoOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RestoOrderController extends Controller
{
    public function index(Request $request)
    {
        // Ambil per halaman dari parameter
        $perPage = $request->get('perPage', 10);
    
        // Menangani pencarian berdasarkan beberapa kolom
        $orders = RestoOrder::when($request->has('search'), function ($query) use ($request) {
            return $query->where('item_name', 'like', '%' . $request->search . '%')
                         ->orWhere('item_type', 'like', '%' . $request->search . '%')
                         ->orWhere('transaction_type', 'like', '%' . $request->search . '%')
                         ->orWhere('type_of_order', 'like', '%' . $request->search . '%')
                         ->orWhere('order_date', 'like', '%' . $request->search . '%')
                         ->orWhere('time_order', 'like', '%' . $request->search . '%')
                         ->orWhere('received_by', 'like', '%' . $request->search . '%');
        })
        ->paginate($perPage);
    
        return view('resto.orders.index', compact('orders'));
    }
    


    public function create()
    {
        return view('resto.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
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

        RestoOrder::create([
            'user_id' => Auth::id(),
            'order_date' => $request->order_date,
            'time_order' => $request->time_order,
            'item_name' => $request->item_name,
            'item_type' => $request->item_type,
            'item_price' => $request->item_price,
            'quantity' => $request->quantity,
            'transaction_amount' => $request->transaction_amount,
            'transaction_type' => $request->transaction_type,
            'received_by' => $request->received_by,
            'type_of_order' => $request->type_of_order,
        ]);

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $id = RestoOrder::find($id);
        return response()->json($id);
    }

    public function edit(RestoOrder $order)
    {
        return view('resto.orders.edit', compact('order'));
    }

    public function update(Request $request, RestoOrder $order)
    {
        $request->validate([
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

        $order->update($request->all());

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy(RestoOrder $order)
    {
        $order->delete();
        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
