<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\supplier;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class Penjualan extends Controller
{
    public function pelanggan()
    {
        $pelanggan = Pelanggan::all();
        return view('/pelanggan', compact('pelanggan'));
    }

    public function addpelanggan(Request $request)
    {
        Pelanggan::create($request->all());
        return redirect()->route('pelanggan')->with('success', 'Data berhasil ditambahkan');
    }

    public function editpelanggan(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return redirect()->route('pelanggan')->with('success', 'Data berhasil diperbarui');
    }

    public function deletepelanggan($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan')->with('success', 'Data berhasil dihapus');
    }



    public function barang()
    {
        $barang = Barang::with('supplier')->get();
        $suppliers = Supplier::all();
        return view('/barang', compact('barang', 'suppliers'));
    }

    public function addbarang(Request $request)
    {
        barang::create($request->all());
        return redirect()->route('barang')->with('success', 'Data barang berhasil ditambahkan');
    }

    public function editbarang(Request $request, $id)
    {
        $barang = barang::findOrFail($id);
        $barang->update($request->all());
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
        $suppliers = supplier::all();
        return view('/supplier', compact('suppliers'));
    }

    public function addsupplier(Request $request)
    {
        supplier::create($request->all());
        return redirect()->route('supplier')->with('success', 'Data Supplier berhasil ditambahkan');
    }

    public function editsupplier(Request $request, $id)
    {
        $supplier = supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->route('supplier')->with('success', 'Supplier Edited successfully');
    }

    public function deletesupplier($id)
    {
        $supplier = supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('supplier')->with('success', 'Supplier deleted successfully');
    }
}

