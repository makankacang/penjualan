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
                                    <th scope="col">Order Code</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->kode_order }}</td>
                                    <td>{{ $order->pembayaran->metode }}</td>
                                    <td>{{ $order->transaksi_id }}</td>
                                    <td>{{ $order->pembayaran->total }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                        <form action="{{ route('confirm.order', ['orderId' => $order->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Confirm Order</button>
                                        </form>
                                        @elseif($order->status == 'confirmed')
                                        <form action="{{ route('complete.order', ['orderId' => $order->id]) }}" method="POST">
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
