@extends('layouts.papp')

@section('content')
        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Pesanan Akan diantar</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Sukses</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- 404 Start -->
        <div class="container-fluid py-5">
            <div class="container py-5 text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <i class="bi bi-hand-thumbs-up display-1 text-secondary"></i>
                        <h4 class="display-1">Pesanan akan segera diantar!</h4>
                        <p class="mb-4">Silahkan siapkan uang bila sudah transfer langsung terima</p>
                        <a class="btn border-secondary rounded-pill py-3 px-5" href="/shop">Pesan barang lain</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- 404 End -->
@endsection