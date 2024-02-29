@extends('layouts.papp')

@section('content')
        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Keranjang</h1>
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
                                <th scope="col">
                                    <input type="checkbox" id="selectAllCheckbox" class="form-check-input">
                                </th>
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
                                <td>
                                    <input type="checkbox" name="selectedItems[]" class="form-check-input" value="{{ $transaksiDetail->transaksi_detail_id }}">
                                </td>
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
                                    <button class="btn btn-md rounded-circle bg-light border mt-4 deleteCartItemBtn" data-transaksi-detail-id="{{ $transaksiDetail->transaksi_detail_id }}">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>                                                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>  
                    <div class="mb-1 d-flex align-items-end" style="position : absolute;">
                        <button id="deleteSelectedBtn" class="btn btn-danger m-1" style="display: none;"><i class="bi bi-trash"></i> Delete</button>
                        <button id="resetSelectionBtn" class="btn btn-secondary m-1" style="display: none;"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                    </div>                     
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
                            <a href="/checkout" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">Proceed Checkout</a>
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

        // Fetch the updated total harga immediately after updating quantity
        fetchUpdatedTotalHarga();
    }).catch(error => {
        console.error('Error updating quantity:', error.message);
        // Revert the input value if there was an error
        qtyInput.value = currentQty;
    });
}

// Function to fetch the updated total harga after updating quantity
function fetchUpdatedTotalHarga() {
    fetch('/getUpdatedTotalHarga')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch updated total harga');
            }
            return response.json();
        })
        .then(data => {
            // Update the displayed total harga, ppn, and total with the fetched values
            document.getElementById('totalHarga').innerText = 'Rp. ' + data.totalHarga;
            document.getElementById('ppn').innerText = 'Rp. ' + data.ppn;
            document.getElementById('total').innerText = 'Rp. ' + data.total;
        })
        .catch(error => {
            console.error('Error fetching updated total harga:', error.message);
        });
}

    // Function to handle the deletion of a cart item
    function deleteCartItem(transaksiDetailId) {
        // Send an AJAX request to delete the cart item
        fetch('/deletecart/' + transaksiDetailId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete cart item');
            }
            // Cart item deleted successfully
            console.log('Cart item deleted successfully');
            // Update the page content after successful deletion
            updatePageContent();
        }).catch(error => {
            console.error('Error deleting cart item:', error.message);
        });
    }

    // Function to update the page content after deleting a cart item
    function updatePageContent() {
        // Reload the page or update specific content as needed
        // For example, you can remove the deleted item from the DOM
        // or update the cart summary dynamically
        // For simplicity, let's reload the page after deletion
        location.reload();
    }

    // Function to handle the "Select All" checkbox
    document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('selectAllCheckbox').checked;
        });
    });

        // Function to handle the "Select All" checkbox
        document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('selectAllCheckbox').checked;
        });

        toggleDeleteButtonsVisibility();
    });

    // Function to handle individual checkbox changes
    var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            toggleDeleteButtonsVisibility();
        });
    });

    // Function to toggle visibility of delete buttons based on checkbox selection
    function toggleDeleteButtonsVisibility() {
        var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]');
        var deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        var resetSelectionBtn = document.getElementById('resetSelectionBtn');
        var checkedCount = 0;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checkedCount++;
            }
        });

        if (checkedCount > 0) {
            deleteSelectedBtn.style.display = 'block';
            resetSelectionBtn.style.display = 'block';
        } else {
            deleteSelectedBtn.style.display = 'none';
            resetSelectionBtn.style.display = 'none';
        }
    }

    // Function to handle delete selected items
    document.getElementById('deleteSelectedBtn').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]:checked');
        var selectedIds = [];
        checkboxes.forEach(function(checkbox) {
            selectedIds.push(checkbox.value);
        });

        // Send AJAX request to delete selected items
        fetch('/deleteSelectedItems', {
            method: 'POST',
            body: JSON.stringify({ selectedIds: selectedIds }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                // Handle success
                console.log('Selected items deleted successfully.');
                // Optionally, you can reload the page or update the cart view
                window.location.reload(); // Example: Reload the page
            } else {
                // Handle failure
                console.error('Failed to delete selected items.');
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    });

    // Function to reset selection
    document.getElementById('resetSelectionBtn').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        toggleDeleteButtonsVisibility();
    });
        </script>
        
        
        
          
@endsection
