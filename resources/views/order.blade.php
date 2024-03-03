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
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#CompleteOrderModal">Completed Order</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode Order</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Metode Pembayaran</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Total Pembayaran</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <!-- Nested loop for transaksi_detail -->
                                @if($order->transaksi->status == 'pending' || $order->transaksi->status == 'ordered')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->kode_order }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->user->alamat }}</td>
                                    <td>{{ $order->pembayaran->metode }}</td>
                                    <td>{{ $order->transaksi->keterangan }}</td>
                                    <td>{{ $order->transaksi->status }}</td>
                                    <td>{{ $order->pembayaran->total }}</td>
                                    <td>
                                        @if($order->transaksi->status == 'pending')
                                        <form action="/confirmorder" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->transaksi->transaksi_id }}">
                                            <button type="submit" class="btn btn-sm btn-warning">Confirm Order</button>
                                        </form>
                                        @elseif($order->transaksi->status == 'ordered')
                                        <form action="/unconfirmorder" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->transaksi->transaksi_id }}">
                                            <button type="submit" class="btn btn-sm btn-danger m-1">Unconfirmed Order</button>
                                        </form>
                                        <form action="/completeorder" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->transaksi->transaksi_id }}">
                                            <button type="submit" class="btn btn-sm btn-success m-1">Complete Order</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="11">
                                        <div class="row row-cols-auto justify-content-start">
                                            <!-- Display transaksi_detail information as small inline cards -->
                                            @foreach($order->transaksi->details as $transaksiDetail)
                                            <div class="col">
                                                <div class="card custom-bg-color mb-2 shadow-md" style="max-width: 300px;">
                                                    <div class="row g-1">
                                                        <div class="col-md-4">
                                                            <img src="{{ asset('storage/img/' . $transaksiDetail->barang->image) }}" class="img-fluid rounded-start" alt="{{ $transaksiDetail->barang->nama_barang }}">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="card-body" style="max-height: 200px; overflow: hidden;">
                                                                <h5 class="card-title">{{ $transaksiDetail->barang->nama_barang }}</h5>
                                                                <p class="card-text" style="font-size: 12px;"><strong>Rp. {{ number_format($transaksiDetail->barang->harga, 0, ',', '.') }}</strong></p>
                                                                <p class="card-text" style="font-size: 12px;"><strong>Kategori:</strong> {{ $transaksiDetail->barang->kategori }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <!-- End of nested loop -->
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

<!-- Add this modal to your blade file -->
<div class="modal fade" id="CompleteOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Completed Orders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach($orders as $order)
                <div class="card mb-3 bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title">{{ $order->kode_order }}</h5>
                        <table class="table">
                            <!-- Table header -->
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Metode Pembayaran</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Total Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->user->alamat }}</td>
                                    <td>{{ $order->pembayaran->metode }}</td>
                                    <td>{{ $order->transaksi->keterangan }}</td>
                                    <td>{{ $order->transaksi->status }}</td>
                                    <td>Rp. {{ number_format($order->pembayaran->total, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Display barang related to each order -->
                        <div class="card mt-3 bg-dark">
                            <div class="card-body">
                                <h5 class="card-title">Barang</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->transaksi->details as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->barang->nama_barang }}</td>
                                            <td>Rp. {{ number_format($detail->barang->harga, 0, ',', '.') }}</td>
                                            <td>{{ $detail->barang->kategori }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End of barang display -->
                    </div>
                </div>
                @endforeach
                             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@endsection
