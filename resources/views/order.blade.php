@extends('layouts.app')

@section('content')

<div class="content">
    <!-- Orders Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0">Order Details</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode Order</th>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Metode Pembayaran</th>
                                    <th scope="col">Transaksi detail id</th>
                                    <th scope="col">Total Pembayaran</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->kode_order }}</td>
                                    <td>{{ $order->created_at }}</td> <!-- Assuming 'waktu' is the order creation time -->
                                    <td>{{ $order->user->name }}</td> <!-- Assuming the relationship is named 'user' -->
                                    <td>{{ $order->user->alamat }}</td> <!-- Assuming the relationship is named 'user' -->
                                    <td>{{ $order->pembayaran->metode }}</td>
                                    <td> <!-- Loop through each transaksidetail -->
                                        @foreach($order->transaksidetail as $transaksiDetail)
                                            {{ $transaksiDetail->transaksi_detail_id }}, <!-- Debugging line -->
                                        @endforeach
                                    </td>
                                    <td>{{ $order->pembayaran->total }}</td>
                                    <td>{{ $order->transaksi->keterangan }}</td>
                                    <td>{{ $order->transaksi->status }}</td>
                                    
                                    <td>
                                        @if($order->transaksi->status == 'pending')
                                        <form action="" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Confirm Order</button>
                                        </form>
                                        @elseif($order->transaksi->status == 'confirmed')
                                        <form action="" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Complete Order</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Orders End -->
</div>

@endsection
