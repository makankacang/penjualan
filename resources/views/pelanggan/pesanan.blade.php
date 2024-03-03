@extends('layouts.papp')

@section('content')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Pesanan Saya</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active text-white">Pesanan Saya</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- My Order Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="d-flex justify-content-center mb-3">
            <!-- Button to filter pending and ordered orders -->
            <form action="{{ route('pesanan') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary mr-2 {{ (request('status') === 'pending' || !request('status')) ? 'active' : '' }}" {{ (request('status') === 'pending' || !request('status')) ? 'disabled' : '' }}><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                <input type="hidden" name="status" value="pending">
            </form>
            <!-- Text in the middle -->
            @if( request('status') === 'pending' || !request('status'))
            <h2 class="mx-3 text-primary">Pesanan</h2> 
            @elseif( request('status') === 'completed')
            <h2 class="mx-3 text-primary">Selesai</h2> 
            @endif
            <!-- Button to filter completed orders -->
            <form action="{{ route('pesanan') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary ml-2 {{ (request('status') === 'completed' && request('status')) ? 'active' : '' }}" {{ (request('status') === 'completed' && request('status')) ? 'disabled' : '' }}><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                <input type="hidden" name="status" value="completed">
            </form>
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
                        <th scope="col">Total Pembayaran</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->kode_order }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->user->alamat }}</td>
                        <td>{{ $order->pembayaran->metode }}</td>
                        <td>Rp. {{ number_format($order->pembayaran->total, 0, ',', '.') }}</td>
                        <td>{{ $order->transaksi->keterangan }}</td>
                        <td>
                            @if($order->transaksi->status == 'pending')
                            <span class="badge badge-primary"><i class="fa fa-clock" aria-hidden="true"></i> Menunggu Konfirmasi</span>
                            <!-- Button to trigger the deletion process -->
                            <button class="btn btn-sm btn-plus rounded-pill bg-light border text-danger mt-1" onclick="handleDelete({{ $order->id }})">
                                <i class="fa fa-times"></i> Batalkan pesanan
                            </button>
                            @elseif($order->transaksi->status == 'ordered')
                            <span class="badge badge-warning"><i class="fa fa-truck" aria-hidden="true"></i> Dalam perjalanan</span>
                            @elseif($order->transaksi->status == 'completed')
                            <span class="badge badge-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Pesanan Selesai</span>
                            @endif
                        </td>
                    </tr>
                    <!-- Nested loop for transaksi_detail -->
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
                    <!-- End of nested loop -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- My Order Page End -->

<!-- Bootstrap modal for confirmation -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Apakah Anda yakin ingin membatalkan pesanan ini?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript to handle deletion and show modal -->
<script>
    // Function to handle the delete confirmation
    function handleDelete(id) {
        // Set the ID of the order to delete
        var orderId = id;

        // Show the confirmation modal
        $('#confirmDeleteModal').modal('show');

        // When the confirm delete button is clicked
        $('#confirmDeleteBtn').click(function() {
            // Hide the modal
            $('#confirmDeleteModal').modal('hide');

            // Send an AJAX request to delete the order and related data
            $.ajax({
                url: '/cancelorder/' + orderId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Reload the page or perform any other actions after deletion
                    location.reload();
                },
                error: function(xhr) {
                    // Handle errors if any
                    console.error(xhr.responseText);
                }
            });
        });
    }
</script>

@endsection
