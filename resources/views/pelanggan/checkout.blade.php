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
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-7">
                            <form id="updateUserForm">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Nama<sup>*</sup></label>
                                    <input type="text" class="form-control" id="namaInput" value="{{ auth()->user()->name }}" readonly>
                                </div>
                                <div class="form-item">
                                    <label class="form-label my-3">Alamat <sup>*</sup></label>
                                    <input type="text" class="form-control" id="alamatInput" value="{{ auth()->user()->alamat }}">
                                    <div class="row g-1 text-center align-items-start justify-content-start pt-1">
                                        <button type="submit" class="btn border-secondary py-1 px-1 w-20 text-uppercase text-primary">Update Alamat</button>
                                    </div>
                                </div>
                                <div class="form-item">
                                    <label class="form-label my-3">Nomor Telepon<sup>*</sup></label>
                                    <input type="text" class="form-control" id="teleponInput" value="{{ auth()->user()->telp }}" readonly>
                                </div>
                                <div class="form-item">
                                    <label class="form-label my-3">Email Address<sup>*</sup></label>
                                    <input type="email" class="form-control" id="emailInput" value="{{ auth()->user()->email }}" readonly>
                                </div>

                            </form>
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
                                                    <img src="{{ asset('storage/img/' . $transaksiDetail->barang->image) }}" class="img-fluid me-5 rounded" style="width: 80px; height: 80px;" alt="">
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
                            <div class="form-item justify-content-center mt-1">
                                <h4>Keterangan</h4>
                                <textarea id="keteranganTextarea" class="form-control border-1 border-bottom rounded col-md-11" placeholder="Tambah Keterangan (Pakai pita, Dll)" value="{{ $transaksi->keterangan }}"></textarea>
                            </div>
                            
                            <form id="checkoutForm" action="{{ route('place.order') }}" method="POST">
                                @csrf


                            <div class="row g-4 text-left align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <h4 class="text-align-left">Metode pembayaran</h4>
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="Transfer" name="metode" value="TRANSFER" required>
                                        <label class="form-check-label" for="Transfer">Transfer</label>
                                    </div>
                                    <div id="bankFields" style="display: none;">
                                        <select class="form-select form-select-sm mb-3" id="bankSelect">
                                            <option selected>Select Bank</option>
                                            <option value="Bank A"><i class="fas fa-university"></i> Bank A</option>
                                            <option value="Bank B"><i class="fas fa-university"></i> Bank B</option>
                                            <option value="Bank C"><i class="fas fa-university"></i> Bank C</option>
                                        </select>
                                        <input type="text" class="form-control mb-3" name="no_rek" id="nomorRekening" placeholder="Nomor Rekening">
                                    </div>                                    
                                    <p class="text-start text-dark">Transfer dengan bank</p>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="TUNAI" name="metode" value="TUNAI" required>
                                        <label class="form-check-label" for="TUNAI">Cash On Delivery</label>
                                    </div>
                                    <p class="text-start text-dark">Bayar saat barang datang</p>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="EDC" name="metode" value="EDC" required>
                                        <label class="form-check-label" for="EDC">EDC</label>
                                    </div>
                                    <p class="text-start text-dark">Bayar dengan shoope, gopay Dll</p>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <input type="hidden" name="transaksi_id" value="{{ $transaksi->transaksi_id }}" >
                                <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                            </div>
                            </form>
                                                                                   
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

            
    document.getElementById('updateUserForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Collect updated user data from form fields
    var nama = document.getElementById('namaInput').value;
    var alamat = document.getElementById('alamatInput').value;
    var telepon = document.getElementById('teleponInput').value;
    var email = document.getElementById('emailInput').value;

    // Send AJAX request to update user data
    fetch('/update-user', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token if needed
        },
        body: JSON.stringify({
            nama: nama,
            alamat: alamat,
            telepon: telepon,
            email: email,
        })
    })
    .then(response => {
        if (response.ok) {
            console.log('User data updated successfully.');
            // Optionally, you can reload the page or show a success message here
        } else {
            console.error('Failed to update user data.');
            // Optionally, you can show an error message here
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
        </script>       
@endsection