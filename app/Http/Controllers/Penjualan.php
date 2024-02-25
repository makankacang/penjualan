<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\barang;
use App\Models\supplier;
use App\Models\Pelanggan;
use App\Models\transaksi;
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

    public function detail($id)
    {
        // Fetch the barang (item) from the database based on the ID
        $barang = Barang::findOrFail($id);

        // Pass the retrieved barang to the view for display
        return view('pelanggan.detail', compact('barang'));
    }

    public function showCart()
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

    // Get the transaksi for the user
    $transaksi = Transaksi::firstOrCreate(['pelanggan_id' => Auth::id()]);

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

    public function placeOrder(Request $request)
    {
        // Validate the request if needed

        // Create a new transaksi entry
        $transaksi = Transaksi::create([
            // Add transaksi data here
        ]);

        // Create a new pembayaran entry
        $pembayaran = Pembayaran::create([
            // Add pembayaran data here
        ]);

        // Update the transaksi status to pending
        $transaksi->update(['status' => 'pending']);

        // Return a response if needed
        return response()->json(['message' => 'Order placed successfully']);
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
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming only image files are allowed
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

