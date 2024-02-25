@extends('layouts.papp')

@section('content')
        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active text-white">Keranjang</li>
            </ol>
        </div>
        <!-- Single Page Header End -->

        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Products</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiDetails as $transaksiDetail)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('img/' . $transaksiDetail->barang->image) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $transaksiDetail->barang->nama_barang }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">Rp. {{ number_format($transaksiDetail->barang->harga, 0, ',', '.') }}</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 150px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border" onclick="updateQuantity({{ $transaksiDetail->transaksi_detail_id }}, -1)">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="qty_input_{{ $transaksiDetail->transaksi_detail_id }}" class="form-control form-control-sm text-center border-0" value="{{ $transaksiDetail->qty }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border" onclick="updateQuantity({{ $transaksiDetail->transaksi_detail_id }}, 1)">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>                                                                                                                      
                                <td>
                                    <p class="mb-0 mt-4">Rp. {{ number_format($transaksiDetail->qty * $transaksiDetail->barang->harga, 0, ',', '.') }}</p>
                                </td>
                                <td>
                                    <a href="/deletecart/{{ $transaksiDetail->transaksi_detail_id }}" class="btn btn-md rounded-circle bg-light border mt-4">
                                        <i class="fa fa-times text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>                                                     
                </div>                              
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Total Harga:</h5>
                                    <p class="mb-0">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Pajak (PPN 10%):</h5>
                                    <div class="">
                                        <p class="mb-0">Rp. {{ number_format($ppn, 0, ',', '.') }}</p>
                                    </div>
                                </div>                                
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total:</h5>
                                <p class="mb-0 pe-4">Rp. {{ number_format($total, 0, ',', '.') }}</p>
                            </div>
                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</button>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
        <!-- Cart Page End -->

        <script>
            function updateQuantity(transaksiDetailId, change) {
                var qtyInput = document.getElementById('qty_input_' + transaksiDetailId);
                var currentQty = parseInt(qtyInput.value);
                var newQty = currentQty + change;
        
                // Make sure the quantity doesn't go below 1
                if (newQty < 1) {
                    newQty = 1;
                }
        
                // Send AJAX request to update the quantity in the database
                fetch('/updateQuantity/' + transaksiDetailId + '/' + newQty, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to update quantity');
                    }
                    // Quantity updated successfully
                    console.log('Quantity updated successfully');
        
                    // Update the displayed quantity value
                    qtyInput.value = newQty;
                }).catch(error => {
                    console.error('Error updating quantity:', error.message);
                    // Revert the input value if there was an error
                    qtyInput.value = currentQty;
                });
            }


        </script>
        
        
        
          
@endsection
