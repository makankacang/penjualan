@extends('layouts.papp')

@section('content')
<!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Shop</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active text-white">Shop</li>
            </ol>
    </div>
<!-- Single Page Header End -->
<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Fresh fruits shop</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-xl-3">
                        <div class="input-group w-100 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-6"></div>
                    <div class="col-xl-3">
                        <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                            <label for="fruits">Default Sorting:</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" form="fruitform">
                                <option value="volvo">Nothing</option>
                                <option value="saab">Popularity</option>
                                <option value="opel">Organic</option>
                                <option value="audi">Fantastic</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Apples</a>
                                                <span>(3)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Oranges</a>
                                                <span>(5)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Strawbery</a>
                                                <span>(2)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Banana</a>
                                                <span>(8)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="#"><i class="fas fa-apple-alt me-2"></i>Pumpkin</a>
                                                <span>(5)</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-2">Price</h4>
                                    <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                    <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Additional</h4>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-1" name="Categories-1" value="Beverages">
                                        <label for="Categories-1"> Organic</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-2" name="Categories-1" value="Beverages">
                                        <label for="Categories-2"> Fresh</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Beverages">
                                        <label for="Categories-3"> Sales</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-4" name="Categories-1" value="Beverages">
                                        <label for="Categories-4"> Discount</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-5" name="Categories-1" value="Beverages">
                                        <label for="Categories-5"> Expired</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <h4 class="mb-3">Featured products</h4>
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="img/featur-1.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Big Banana</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="img/featur-2.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Big Banana</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="img/featur-3.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Big Banana</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center my-4">
                                    <a href="#" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Vew More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center">
                            @foreach($barang as $data)
                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <a href="/detailbarang/{{ $data->id }}">
                                    <div class="rounded position-relative fruite-item">
                                        <div class="fruite-img">
                                            <img src="{{ asset('storage/img/' . $data->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $data->nama_barang }}" width="100" height="100">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $data->kategori }}</div>
                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                            <h4>{{ $data->nama_barang }}</h4>
                                            <p>{{ $data->deskripsi }}</p>
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($data->harga, 0, ',', '.') }}</p>
                                        </a>
                                        <div class="d-flex align-items-center justify-content-center mt-4">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border me-2" onclick="decreaseQty(this)" data-item-id="{{ $data->id }}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="text" name="qty" value="1" class="form-control form-control-sm text-center border-0 mx-2" style="width: 50px; padding: 0;">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border me-2" onclick="increaseQty(this)" data-item-id="{{ $data->id }}">
                                                <i class="fa fa-plus"></i>
                                            </button>                                            
                                            <form id="addToCartForm" action="{{ route('add-to-cart', $data->id) }}" method="POST" class="ml-2">
                                                @csrf
                                                <input type="hidden" name="qty" id="qty_input_{{ $data->id }}" value="1">
                                                <button type="button" class="btn border border-secondary rounded-pill px-4 text-primary addToCartBtn">
                                                    <i class="fa fa-cart-plus me-2 text-primary"></i>
                                                </button>
                                            </form>                                                                                                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-12">
                                <div class="pagination d-flex justify-content-center mt-5">
                                    <a href="#" class="rounded">&laquo;</a>
                                    <a href="#" class="active rounded">1</a>
                                    <a href="#" class="rounded">2</a>
                                    <a href="#" class="rounded">3</a>
                                    <a href="#" class="rounded">4</a>
                                    <a href="#" class="rounded">5</a>
                                    <a href="#" class="rounded">6</a>
                                    <a href="#" class="rounded">&raquo;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                           
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fruits Shop End-->

                    
<script>
    function increaseQty(button) {
        var input = button.parentElement.querySelector('input[name="qty"]');
        var value = parseInt(input.value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        input.value = value;
        document.getElementById('qty_input_' + button.dataset.itemId).value = value; // Update hidden input value
        return false; // Prevent default button behavior
    }

    function decreaseQty(button) {
        var input = button.parentElement.querySelector('input[name="qty"]');
        var value = parseInt(input.value, 10);
        value = isNaN(value) ? 0 : value;
        value--;
        if(value < 1) value = 1;
        input.value = value;
        document.getElementById('qty_input_' + button.dataset.itemId).value = value; // Update hidden input value
        return false; // Prevent default button behavior
    }

    function validateQty(form) {
        var qty = parseInt(form.querySelector('input[name="qty"]').value, 10);
        if (isNaN(qty) || qty < 1) {
            alert("Please enter a valid quantity.");
            return false;
        }
        return true;
    }

// Function to show a Bootstrap toast notification with animation
function showToast(message) {
    const toastContainer = document.querySelector('.container-fluid'); // Select the container element where you want to append the toast
    const toast = document.createElement('div');
    toast.classList.add('toast');
    toast.classList.add('show');
    toast.classList.add('position-fixed');
    toast.classList.add('top-1');
    toast.classList.add('end-0');
    toast.classList.add('m-4');
    toast.style.opacity = '0'; // Start with opacity 0
    toast.style.transform = 'scale(0.8)'; // Start with a smaller scale
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    const toastBody = document.createElement('div');
    toastBody.classList.add('toast-body');
    toastBody.innerText = message;

    toast.appendChild(toastBody);
    toastContainer.appendChild(toast);

    // Animate the toast
    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out'; // Add transition for opacity and transform
        toast.style.opacity = '1'; // Fade in
        toast.style.transform = 'scale(1)'; // Scale up
        setTimeout(() => {
            toast.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out'; // Add transition for opacity and transform
            toast.style.opacity = '0'; // Fade out
            toast.style.transform = 'scale(0.8)'; // Scale down
            setTimeout(() => {
                toast.remove();
            }, 300); // Remove the toast after animation completes
        }, 3000); // Display the toast for 3 seconds
    }, 100); // Delay the animation to ensure it starts properly
}





    // Update the cart count badge
    function updateCartCount() {
        fetch('/getCartCount')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch cart count');
                }
                return response.json();
            })
            .then(data => {
                // Update the cart count badge with the fetched count
                document.getElementById('cartCountBadge').innerText = data.count;
            })
            .catch(error => {
                console.error('Error fetching cart count:', error.message);
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Listen for click events on the addToCart button
        const addToCartButtons = document.querySelectorAll('.addToCartBtn');
        addToCartButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const form = button.closest('form'); // Find the parent form
                const formData = new FormData(form); // Create FormData object
                const url = form.getAttribute('action'); // Get the form action URL

                // Send an AJAX request to the server
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Item added successfully, show a success message
                        showToast(data.message);
                        updateCartCount(); // Update the cart count badge
                    } else {
                        // Handle error or show error message
                        alert('Failed to add item to cart. Please try again.');
                    }
                })
                .catch(error => {
                    // Handle errors or show error message
                    console.error('Error:', error);
                    alert('An error occurred while processing your request. Please try again later.');
                });
            });
        });
    });
</script>






@endsection