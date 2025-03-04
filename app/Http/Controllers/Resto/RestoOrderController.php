<?php

namespace App\Http\Controllers\Resto;

use App\Models\RestoOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ExcelUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RestoOrderController extends Controller
{
    // Menampilkan daftar pesanan hanya untuk user yang login
    public function index(Request $request)
    {
        $userId = Auth::id(); // Mengambil ID user yang sedang login

        // Ambil per halaman dari parameter (default 10)
        $perPage = $request->get('perPage', 10);

        // Menangani pencarian hanya untuk data milik user yang sedang login
        $orders = RestoOrder::with('excelUpload')
            ->where('user_id', $userId)
            ->when($request->has('search'), function ($query) use ($request) {
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

    // Menampilkan form tambah pesanan
    public function create()
    {
        $uploads = ExcelUpload::where('user_id', auth()->id())->get(); // Ambil hanya file milik user yang login
        return view('resto.orders.create', compact('uploads'));
    }


    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'excel_upload_id' => 'required|exists:excel_uploads,id',
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
            'excel_upload_id' => $request->excel_upload_id, // Menyimpan file yang dipilih
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


    // Menampilkan detail pesanan hanya jika pesanan milik user yang login
    public function show($id)
    {
        $order = RestoOrder::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$order) {
            return response()->json(['message' => 'Pesanan tidak ditemukan atau tidak memiliki akses'], 403);
        }

        return response()->json($order);
    }

    // Menampilkan form edit hanya jika pesanan milik user yang login
    public function edit(RestoOrder $order)
    {
        // Pastikan hanya user yang memiliki pesanan bisa mengedit
        if ($order->user_id != Auth::id()) {
            return abort(403, 'Anda tidak memiliki akses untuk mengedit pesanan ini.');
        }

        // Ambil daftar file yang telah diupload oleh user untuk ditampilkan di dropdown
        $uploads = ExcelUpload::where('user_id', Auth::id())->get();

        return view('resto.orders.edit', compact('order', 'uploads'));
    }


    // Memperbarui data pesanan hanya jika pesanan milik user yang login
    public function update(Request $request, RestoOrder $order)
    {
        // Pastikan pesanan hanya bisa diubah oleh user yang memilikinya
        if ($order->user_id != auth()->id()) {
            return redirect()->route('resto.orders.index')->with('error', 'Unauthorized access');
        }

        // Validasi data (pastikan time_order bisa menerima format yang benar)
        $validated = $request->validate([
            'order_date' => 'required|date',
            'time_order' => 'required|date_format:H:i:s', // Pastikan format mencakup detik
            'item_name' => 'required|string',
            'item_type' => 'required|string',
            'item_price' => 'required|integer',
            'quantity' => 'required|integer',
            'transaction_amount' => 'required|integer',
            'transaction_type' => 'required|string',
            'received_by' => 'required|string',
            'type_of_order' => 'required|string',
        ]);


        // Pastikan file yang digunakan milik user yang sedang login
        if ($order->excel_upload_id) {
            $file = $order->excelUpload;
            if (!$file || $file->user_id != auth()->id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke file ini.');
            }
        }

        // Update data pesanan
        $order->update($request->only([
            'order_date',
            'time_order',
            'item_name',
            'item_type',
            'item_price',
            'quantity',
            'transaction_amount',
            'transaction_type',
            'received_by',
            'type_of_order'
        ]));

        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil diperbarui!');
    }




    // Menghapus pesanan hanya jika pesanan milik user yang login
    public function destroy($id)
    {
        $order = RestoOrder::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$order) {
            return abort(403, 'Anda tidak memiliki akses untuk menghapus pesanan ini.');
        }

        $order->delete();
        return redirect()->route('resto.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

}
