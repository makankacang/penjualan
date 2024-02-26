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
    
    
    public function showCheckoutPage()
{
    // Get the transaksi for the authenticated user
    $transaksi = Transaksi::where('pelanggan_id', auth()->id())->first();

    // Get the transaksi_detail for the transaksi
    $transaksiDetails = [];
    $totalHarga = 0; // Initialize total harga

    if ($transaksi) {
        $transaksiDetails = TransaksiDetail::where('transaksi_id', $transaksi->transaksi_id)->get();
        
        // Calculate total harga
        foreach ($transaksiDetails as $detail) {
            $totalHarga += $detail->harga * $detail->qty;
        }
    }

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
}

    
public function addToCart(Request $request, Barang $barang) {
    // Assuming you have authentication and can get the authenticated user
    $user = Auth::user();

    // Get the transaksi for the user with status 'keranjang' or create a new one if it doesn't exist
    $transaksi = Transaksi::firstOrCreate(['pelanggan_id' => Auth::id(), 'status' => 'keranjang']);

    // Check if the barang already exists in the transaksi details
    $existingDetail = $transaksi->details()->where('barang_id', $barang->id)->first();

    // Get the quantity from the request
    $qty = $request->input('qty', 1); // Default to 1 if no quantity is provided

    if ($existingDetail) {
        // If the barang already exists, increase the quantity
        $existingDetail->qty += $qty;
        $existingDetail->save();
    } else {
        // If the barang does not exist, create a new transaksi detail
        $transaksiBarang = new TransaksiDetail();
        $transaksiBarang->barang_id = $barang->id;
        $transaksiBarang->qty = $qty;
        $transaksiBarang->harga = $barang->harga;
        $transaksi->details()->save($transaksiBarang);
    }

    return redirect()->back()->with('success', 'Item added to cart successfully!');
}


public function deletecart($id)
{
// Find the user by ID
$transaksidetail = transaksidetail::findOrFail($id);

// Delete the transaksi detail
$transaksidetail->delete();

return redirect()->back()->with('success', 'Item added to cart successfully!');
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

public function getCartCount()
{
    // Retrieve the total count of records from the database
    $cartCount = transaksidetail::count();

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

    public function placeOrder(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'metode' => 'required', // You can add more validation rules as needed
            'transaksi_id' => 'required'
        ]);
    
        // Create a new Pembayaran instance
        $pembayaran = Pembayaran::create([
            'waktu_bayar' => now(),
            'total' => 0, // You need to set the total value accordingly
            'metode' => $request->input('metode'),
            'transaksi_id' => $request->input('transaksi_id'),
            'no_rek' => $request->input('no_rek') // Make sure to adjust this according to your form
        ]);
    
        // Ensure Pembayaran is properly created
        if (!$pembayaran) {
            return back()->with('error', 'Failed to create payment record.');
        }
    
        // Create a new Order instance
        $order = Order::create([
            'kode_order' => uniqid(),
            'pembayaran_id' => $pembayaran->pembayaran_id,
            'transaksi_id' => $request->input('transaksi_id')
        ]);
    
        // Update the status in the Transaksi table
        $transaksi = Transaksi::findOrFail($request->input('transaksi_id'));
        $transaksi->status = 'pending';
        $transaksi->save();
    
        // Redirect to /sukses with a success message
        return redirect('/sukses')->with('success', 'Order placed successfully!');
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
        // Retrieve all orders with the pembayaran relationship loaded
        $orders = Order::with('pembayaran')->get();

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

