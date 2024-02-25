@extends('layouts.papp')

@section('content')
        <!-- Single Page Header start -->
            <div class="container-fluid page-header py-5">
                    <h1 class="text-center text-white display-6">Checkout</h1>
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="/homepel">Home</a></li>
                        <li class="breadcrumb-item"><a href="/keranjang">Keranjang</a></li>
                        <li class="breadcrumb-item active text-white">Checkout</li>
                    </ol>
            </div>
        <!-- Single Page Header End -->

        <!-- Checkout Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">Billing details</h1>
                <form id="checkoutForm" action="{{ route('place.order') }}" method="POST">
                    @csrf
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-7">
                            <div class="form-item w-100">
                                <label class="form-label my-3">Nama<sup>*</sup></label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Alamat <sup>*</sup></label>
                                <input type="text" class="form-control" placeholder="House Number Street Name" value="{{ auth()->user()->alamat }}">
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Nomor Telepon<sup>*</sup></label>
                                <input type="tel" class="form-control" value="{{ auth()->user()->telp }}">
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Email Address<sup>*</sup></label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="form-item d-flex justify-content-center mt-3">
                                <textarea id="keteranganTextarea" class="form-control border-0 border-bottom rounded col-12" placeholder="Tambah Keterangan (Pakai pita, Dll)"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Products</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transaksiDetails as $transaksiDetail)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('img/' . $transaksiDetail->barang->image) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">{{ $transaksiDetail->barang->nama_barang }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">Rp. {{ number_format($transaksiDetail->barang->harga, 0, ',', '.') }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">{{ $transaksiDetail->qty }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">Rp. {{ number_format($transaksiDetail->qty * $transaksiDetail->barang->harga, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th scope="row">
                                            </th>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                            </td>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark">Pajak (PPN 10%): Rp. {{ number_format($ppn, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark">Rp. {{ number_format($total, 0, ',', '.') }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="Transfer" name="metode" value="TRANSFER">
                                        <label class="form-check-label" for="Transfer">Transfer</label>
                                    </div>
                                    <div id="bankFields" style="display: none;">
                                        <select class="form-select form-select-sm mb-3" id="bankSelect">
                                            <option selected>Select Bank</option>
                                            <option value="Bank A">Bank A</option>
                                            <option value="Bank B">Bank B</option>
                                            <option value="Bank C">Bank C</option>
                                        </select>
                                        <input type="text" class="form-control mb-3" id="nomorRekening" placeholder="Nomor Rekening">
                                    </div>
                                    <p class="text-start text-dark">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="Delivery" name="metode" value="TUNAI">
                                        <label class="form-check-label" for="Delivery">Cash On Delivery</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="EDC-1" name="metode" value="EDC">
                                        <label class="form-check-label" for="EDC-1">EDC</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                            </div>

                                                                                   
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Page End -->

                                    
        <script>
            document.querySelectorAll('input[name="metode"]').forEach((elem) => {
                elem.addEventListener('change', (event) => {
                    if (event.target.value === 'TRANSFER') {
                        document.getElementById('bankFields').style.display = 'block';
                    } else {
                        document.getElementById('bankFields').style.display = 'none';
                    }
                });
            });

            
            document.getElementById('keteranganTextarea').addEventListener('input', function() {
                var keterangan = this.value;

                // Send an AJAX request to update the keterangan
                updateKeterangan(keterangan);
            });

            function updateKeterangan(keterangan) {
                // Send an AJAX request to update the keterangan
                fetch('/update-keterangan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Assuming you're using CSRF protection
                    },
                    body: JSON.stringify({ keterangan: keterangan })
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Keterangan updated successfully.');
                    } else {
                        console.error('Failed to update keterangan.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        </script>       
@endsection

@push('scripts')
<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // You can add validation here if needed

        // Submit the form data via AJAX
        fetch(this.action, {
            method: this.method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                // Add form data to be sent to the server
            })
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Failed to place order.');
            }
        })
        .then(data => {
            // Handle the response data
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
@endpush