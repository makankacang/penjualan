<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\barang;
use App\Models\supplier;
use App\Models\Pelanggan;
use App\Models\transaksi;
use App\Models\Order;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\transaksidetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

function generateUniqueCode()
{
    // Get the latest order code from the database
    $latestOrder = Order::latest()->first();

    // If there are no orders yet, start with "O001"
    if (!$latestOrder) {
        return 'O001';
    }

    // Extract the numeric part of the latest order code
    $latestOrderNumber = intval(substr($latestOrder->kode_order, 1));

    // Generate the next order number
    $nextOrderNumber = $latestOrderNumber + 1;

    // Pad the order number with leading zeros if necessary
    $nextOrderCode = 'O' . str_pad($nextOrderNumber, 3, '0', STR_PAD_LEFT);

    return $nextOrderCode;
}

class Penjualan extends Controller
{
    public function shop()
    {
        // Retrieve all barang data from the database
        $barang = Barang::all();

        // Pass the $barang data to the view
        return view('pelanggan.shop', ['barang' => $barang]);
    }

    public function sukses()
    {

        // Pass the $barang data to the view
        return view('pelanggan.sukses');
    }

    public function detail($id)
    {
        // Fetch the barang (item) from the database based on the ID
        $barang = Barang::findOrFail($id);

        // Pass the retrieved barang to the view for display
        return view('pelanggan.detail', compact('barang'));
    }

    public function showCart()
    {
        // Get the transaksi for the authenticated user with status 'keranjang'
        $transaksi = Transaksi::where('pelanggan_id', auth()->id())->where('status', 'keranjang')->first();
    
        // Initialize other variables
        $transaksiDetails = [];
        $totalHarga = 0; // Initialize total harga
        $ppn = 0; // Initialize PPN
        $total = 0; // Initialize total
    
        if ($transaksi) {
            // Get the transaksi_detail for the transaksi
            $transaksiDetails = $transaksi->details;
    
            // Calculate total harga
            foreach ($transaksiDetails as $detail) {
                $totalHarga += $detail->harga * $detail->qty;
            }
    
            // Calculate PPN (10% of total harga)
            $ppn = $totalHarga * 0.1;
    
            // Calculate total (total harga + PPN)
            $total = $totalHarga + $ppn;
        }
    
        return view('pelanggan.keranjang', [
            'transaksi' => $transaksi,
            'transaksiDetails' => $transaksiDetails,
            'totalHarga' => $totalHarga,
            'ppn' => $ppn,
            'total' => $total,
        ]);
    }
    
    public function getUpdatedTotalHarga()
    {
        // Retrieve the updated total harga after quantity update
        $transaksi = Transaksi::where('pelanggan_id', auth()->id())->where('status', 'keranjang')->first();
        $totalHarga = 0;
    
        if ($transaksi) {
            foreach ($transaksi->details as $detail) {
                $totalHarga += $detail->harga * $detail->qty;
            }
        }
    
        $ppn = $totalHarga * 0.1;
        $total = $totalHarga + $ppn;
    
        // Return the updated total harga, ppn, and total as JSON response
        return response()->json([
            'totalHarga' => number_format($totalHarga, 0, ',', '.'),
            'ppn' => number_format($ppn, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.'),
        ]);
    }
    
    
    public function addToCart(Request $request, Barang $barang)
    {
        // Get the authenticated user
        $user = Auth::user();
    
        // Get the transaction for the user with status 'keranjang' or create a new one if it doesn't exist
        $transaksi = Transaksi::firstOrCreate([
            'pelanggan_id' => $user->id,
            'status' => 'keranjang'
        ]);
    
        // Check if the barang already exists in the transaction details
        $existingDetail = $transaksi->details()->where('barang_id', $barang->id)->first();
    
        // Get the quantity from the request
        $qty = $request->input('qty', 1); // Default to 1 if no quantity is provided
    
        if ($existingDetail) {
            // If the barang already exists, increase the quantity
            $existingDetail->qty += $qty;
            $existingDetail->save();
        } else {
            // If the barang does not exist, create a new transaction detail
            $transaksiBarang = new TransaksiDetail();
            $transaksiBarang->barang_id = $barang->id;
            $transaksiBarang->qty = $qty;
            $transaksiBarang->harga = $barang->harga;
            $transaksi->details()->save($transaksiBarang);
        }
    
        // Return a JSON response with a success message
        return response()->json([
            'success' => true,
            'message' => 'Sukses memasukkan kedalam keranjang!'
        ]);
    }
    
    


public function updateQuantity($transaksiDetailId, $newQty) {
    // Find the transaction detail by its ID
    $transaksiDetail = TransaksiDetail::findOrFail($transaksiDetailId);

    // Update the quantity
    $transaksiDetail->qty = $newQty;
    $transaksiDetail->save();

    // Return a response
    return response()->json(['message' => 'Quantity updated successfully'], 200);
}

public function deletecart($id)
{
    // Find the transaksi detail by ID
    $transaksiDetail = TransaksiDetail::findOrFail($id);

    // Delete the transaksi detail
    $transaksiDetail->delete();

    // Return a response indicating success (optional)
    return response()->json(['success' => true, 'message' => 'Cart item deleted successfully']);
}

public function deleteSelectedItems(Request $request)
{
    $selectedIds = $request->input('selectedIds');
    TransaksiDetail::whereIn('transaksi_detail_id', $selectedIds)->delete();
    return response()->json(['message' => 'Selected items deleted successfully']);
}

public function getCartCount()
{
    // Retrieve the total count of records from the database
    $cartCount = TransaksiDetail::whereHas('transaksi', function ($query) {
                    $query->where('status', 'keranjang')
                          ->where('pelanggan_id', auth()->id());
                })->count();

    // Return the count as JSON response
    return response()->json(['count' => $cartCount]);
}


public function updateKeterangan(Request $request)
    {
        $keterangan = $request->input('keterangan');

        // Assuming you have authentication and can get the authenticated user
        $user = auth()->user();

        // Find the transaksi for the authenticated user
        $transaksi = Transaksi::where('pelanggan_id', $user->id)->first();

        if ($transaksi) {
            // Update the keterangan column
            $transaksi->keterangan = $keterangan;
            $transaksi->save();

            return response()->json(['message' => 'Keterangan updated successfully.']);
        } else {
            return response()->json(['error' => 'Transaksi not found.'], 404);
        }
    }

    public function update(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Update user information based on the request data
        $user->update([
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'telepon' => $request->input('telepon'),
            'email' => $request->input('email'),
            // Add more fields if needed
        ]);

        // Optionally, you can update additional fields or handle other logic here
        
        // Return a response
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function showCheckoutPage()
    {
        // Get the transaksi for the authenticated user with status "keranjang"
        $transaksi = Transaksi::where('pelanggan_id', auth()->id())
                        ->where('status', 'keranjang')
                        ->first();
    
        // If a transaction with status "keranjang" is found
        if ($transaksi) {
            // Get the transaksi_details for the transaksi
            $transaksiDetails = TransaksiDetail::where('transaksi_id', $transaksi->transaksi_id)->get();
            
            // Calculate total harga
            $totalHarga = $transaksiDetails->sum(function ($detail) {
                return $detail->harga * $detail->qty;
            });
    
            // Calculate PPN (10% of total harga)
            $ppn = $totalHarga * 0.1;
    
            // Calculate total (total harga + PPN)
            $total = $totalHarga + $ppn;
    
            return view('pelanggan.checkout', [
                'transaksi' => $transaksi,
                'transaksiDetails' => $transaksiDetails,
                'totalHarga' => $totalHarga,
                'ppn' => $ppn,
                'total' => $total,
            ]);
        } else {
            // Handle the case where no transaction with status "keranjang" is found
            return redirect()->back()->with('error', 'No items in the cart to checkout.');
        }
    }

    public function placeOrder(Request $request)
{
    // Validate the request data
    $request->validate([
        'transaksi_id' => 'required',
        'metode' => 'required',
        'nomorRekening' => 'required_if:metode,TRANSFER', // Only required if the method is TRANSFER
    ]);

    // Find the transaction record with status 'keranjang' and belonging to the authenticated user
    $transaction = Transaksi::where('transaksi_id', $request->input('transaksi_id'))
                             ->where('status', 'keranjang')
                             ->where('pelanggan_id', auth()->id())
                             ->first();

    // Check if the transaction was found
    if (!$transaction) {
        return redirect()->back()->with('error', 'Invalid transaction or status.');
    }

    // Calculate total based on the transaction's details including PPN
    $transaksiDetails = $transaction->details;
    $totalHarga = $transaksiDetails->sum(function ($detail) {
        return $detail->harga * $detail->qty;
    });
    $ppn = $totalHarga * 0.1;
    $total = $totalHarga + $ppn;

    // Create a new payment record
    $payment = new Pembayaran();
    $payment->waktu_bayar = now();
    $payment->total = $total; // Use the calculated total
    $payment->metode = $request->input('metode');
    $payment->transaksi_id = $request->input('transaksi_id');
    $payment->no_rek = $request->input('nomorRekening');
    $payment->save();

    // Create a new order and use the same pembayaran_id as the created payment
    $order = new Order();
    $order->kode_order = generateUniqueCode(); // You need to implement this function to generate a unique code
    $order->pembayaran_id = $payment->getKey(); // Get the ID of the created payment
    $order->transaksi_id = $request->input('transaksi_id');
    $order->pelanggan_id = auth()->user()->id; // Use the authenticated user's ID
    $order->save();

    // Update transaction status to pending
    $transaction->status = 'pending';
    $transaction->save();

    // Redirect to pelanggan.sukses route after successful order placement
    return redirect()->route('sukses')->with('success', 'Order placed successfully!');
}

    
    

    
    
    
    
    









    public function pelanggan()
    {
    $users = User::where('level', 'user')->get();
    return view('pelanggan', compact('users'));
    }

    public function editpelanggan(Request $request, $id)
    {
    // Find the user by ID
    $user = User::findOrFail($id);
    
    // Update the user with the provided data
    $user->update($request->all());
    
    return redirect()->route('pelanggan')->with('success', 'Data berhasil diperbarui');
    }

    public function deletepelanggan($id)
    {
    // Find the user by ID
    $user = User::findOrFail($id);
    
    // Delete the user
    $user->delete();
    
    return redirect()->route('pelanggan')->with('success', 'Data berhasil dihapus');
    }



    public function barang()
    {
        // Assuming the 'supplier' role is assigned to users who act as suppliers
        $suppliers = User::where('level', 'supplier')->get();
        
        // Now fetch barang data and eager load the supplier information
        $barang = Barang::with('supplier')->get();
    
        return view('barang', compact('barang', 'suppliers'));
    }
    

    public function addbarang(Request $request)
    {
    // Validate the form data
    $request->validate([
        'nama_barang' => 'required',
        'harga' => 'required',
        'stok' => 'required',
        'supplier_id' => 'required',
        'deskripsi' => 'required',
        'kategori' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,jfif|max:2048', // Assuming only image files are allowed
    ]);

    try {
        // Handle image upload
        if ($request->hasFile('image')) {
            // Get the file name with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('image')->storeAs('public/img', $fileNameToStore);
        } else {
            $fileNameToStore = null; // If no image is uploaded
        }

        // Create a new Barang instance with form data
        $barang = new Barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->harga = $request->harga;
        $barang->stok = $request->stok;
        $barang->supplier_id = $request->supplier_id;
        $barang->deskripsi = $request->deskripsi;
        $barang->kategori = $request->kategori;
        $barang->image = $fileNameToStore; // Save the filename to the database

        // Save the Barang instance
        $barang->save();

        // Redirect or do something else
        return redirect()->route('barang')->with('success', 'Data barang berhasil ditambahkan');
    } catch (\Exception $e) {
        // Handle any errors that occur during the process
        return redirect()->back()->with('error', 'Failed to add barang: '.$e->getMessage());
    }
    }



    public function editbarang(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'supplier_id' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming only image files are allowed
        ]);
    
        // Find the barang by ID
        $barang = barang::findOrFail($id);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Get the file name with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('image')->storeAs('public/img', $fileNameToStore);
            // Delete previous image if exists
            if ($barang->image) {
                Storage::delete('public/img/'.$barang->image);
            }
            // Update image column
            $barang->image = $fileNameToStore;
        }
    
        // Update other fields
        $barang->nama_barang = $request->nama_barang;
        $barang->harga = $request->harga;
        $barang->stok = $request->stok;
        $barang->supplier_id = $request->supplier_id;
        $barang->kategori = $request->kategori;
        $barang->deskripsi = $request->deskripsi;
    
        // Save the Barang instance
        $barang->save();
    
        // Redirect or do something else
        return redirect()->route('barang')->with('success', 'Data barang berhasil diperbarui');
    }
    

    public function deletebarang($id)
    {
        $barang = barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang')->with('success', 'Data barang berhasil dihapus');
    }

    public function order()
    {
        // Fetch all orders with their associated user and transaction details
        $orders = Order::with(['user','pembayaran', 'transaksi', 'transaksidetail'])->get();

        // Pass the orders data to the view
        return view('order', compact('orders'));
    }




    public function supplier()
    {
    $suppliers = User::where('level', 'supplier')->get();
    return view('supplier', compact('suppliers'));
    }

    public function editsupplier(Request $request, $id)
    {
    $user = User::findOrFail($id);
    $user->fill($request->all());
    $user->save();
    return redirect()->route('supplier')->with('success', 'Supplier updated successfully');
    }

    public function deletesupplier($id)
    {
    $user = User::findOrFail($id);
    $user->delete();
    return redirect()->route('supplier')->with('success', 'Supplier deleted successfully');
    }
}

