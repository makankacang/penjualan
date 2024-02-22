@extends('layouts.app')

@section('content')
<div class="content">
  <!-- Barang Table Start -->
  <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Barang Table</h6>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addBarangModal">Add Barang</button>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Supplier ID</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $data)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <form action="/editbarang/{{ $data->id }}" method="POST">
                                  @csrf
                                  <td>
                                      <span class="table-data">{{ $data->nama_barang }}</span>
                                      <input type="text" name="nama_barang" class="form-control edit-input" value="{{ $data->nama_barang }}" style="display: none;">
                                  </td>
                                  <td>
                                    <span class="table-data">Rp {{ number_format($data->harga, 0, ',', '.') }}</span>
                                    <input type="text" name="harga" class="form-control edit-input" value="{{ $data->harga }}" style="display: none;">
                                    </td>                                
                                  <td>
                                      <span class="table-data">{{ $data->stok }}</span>
                                      <input type="number" name="stok" class="form-control edit-input" value="{{ $data->stok }}" style="display: none;">
                                  </td>
                                  <td>
                                      <span class="table-data">{{ $data->supplier_id }}</span>
                                      <input type="number" name="supplier_id" class="form-control edit-input" value="{{ $data->supplier_id }}" style="display: none;">
                                  </td>
                                  <td>
                                      <button type="submit" class="btn text-success save-btn" style="display: none;">
                                    </form>
                                          <i class="bi bi-check"></i>
                                      </button>
                                      <button class="btn text-danger cancel-btn" style="display: none;">
                                          <i class="bi bi-x"></i>
                                      </button>
                                      <button class="btn text-white edit-btn">
                                          <i class="bi bi-pencil"></i>
                                      </button>
                                      <button class="btn text-danger delete-btn">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                      <div class="btn-group" style="display: none;">
                                          <p class="text-white mb-0">Are you sure?</p>
                                          <a href="/deletebarang/{{ $data->id }}" class="btn text-success confirm-delete-btn">
                                              <i class="bi bi-check"></i>
                                          </a>
                                          <button class="btn text-danger cancel-delete-btn"><i class="bi bi-x"></i></button>
                                      </div>
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
  <!-- Barang Table End -->

<!-- Add Barang Modal -->
<div class="modal fade" id="addBarangModal" tabindex="-1" aria-labelledby="addBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-secondary text-light">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="addBarangModalLabel">Add New Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/addbarang" method="POST">
                    @csrf
                    <!-- Hidden input for kode_barang -->
                    <input type="hidden" id="kode_barang" name="kode_barang">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control bg-dark text-light" id="nama_barang" name="nama_barang">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" class="form-control bg-dark text-light" id="harga" name="harga" placeholder="Format: Rp 100,000">
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control bg-dark text-light" id="stok" name="stok">
                    </div>
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-dark text-light" id="supplier_id" name="supplier_id" readonly>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#selectSupplierModal">Select Supplier</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Barang Modal -->


<!-- Select Supplier Modal -->
    <div class="modal fade" id="selectSupplierModal" tabindex="-1" aria-labelledby="selectSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-secondary text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="selectSupplierModalLabel">Select Supplier</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">Supplier ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Telepon</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Action</th> <!-- Add Action column for selecting supplier -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->supplier_id }}</td>
                        <td>{{ $supplier->nama }}</td>
                        <td>{{ $supplier->telp }}</td>
                        <td>{{ $supplier->alamat }}</td>
                        <td>
                            <button type="button" class="btn btn-primary select-supplier-btn" onclick="selectSupplier('{{ $supplier->supplier_id }}')">Select</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
      </div>
    </div>
  </div>
  <!-- End Select Supplier Modal -->
  
  

<script>
    document.querySelectorAll('.edit-btn').forEach((button) => {
    button.addEventListener('click', () => {
        const row = button.closest('tr');
        const tableData = row.querySelectorAll('.table-data');
        const inputFields = row.querySelectorAll('.edit-input');
        const saveButton = row.querySelector('.save-btn');
        const cancelButton = row.querySelector('.cancel-btn');
        const deleteButton = row.querySelector('.delete-btn');
        const confirmDeleteButton = row.querySelector('.confirm-delete-btn');
        const cancelDeleteButton = row.querySelector('.cancel-delete-btn');

        tableData.forEach((data, index) => {
            data.style.display = 'none';
            inputFields[index].style.display = 'inline-block'; // This line should ensure input fields are displayed
        });

        saveButton.style.display = 'inline-block';
        cancelButton.style.display = 'inline-block';
        button.style.display = 'none';
        deleteButton.style.display = 'none';
        confirmDeleteButton.parentNode.style.display = 'none'; // Hide confirm delete button group
    });
});


    document.querySelectorAll('.cancel-btn').forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const tableData = row.querySelectorAll('.table-data');
            const inputFields = row.querySelectorAll('.edit-input');
            const editButton = row.querySelector('.edit-btn');
            const saveButton = row.querySelector('.save-btn');
            const deleteButton = row.querySelector('.delete-btn');
            const confirmDeleteButton = row.querySelector('.confirm-delete-btn');
            const cancelDeleteButton = row.querySelector('.cancel-delete-btn');

            tableData.forEach((data, index) => {
                data.style.display = 'inline-block';
                inputFields[index].style.display = 'none';
            });

            saveButton.style.display = 'none';
            button.style.display = 'none';
            editButton.style.display = 'inline-block';
            deleteButton.style.display = 'inline-block';
            confirmDeleteButton.parentNode.style.display = 'none'; // Hide confirm delete button group
        });
    });

    document.querySelectorAll('.delete-btn').forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const confirmDeleteButton = row.querySelector('.confirm-delete-btn');
            const deleteButton = row.querySelector('.delete-btn');
            const editButton = row.querySelector('.edit-btn'); // Get the edit button

            deleteButton.style.display = 'none'; // Hide delete button
            editButton.style.display = 'none'; // Hide edit button
            confirmDeleteButton.parentNode.style.display = 'inline-block'; // Show confirm delete button group
        });
    });

    document.querySelectorAll('.cancel-delete-btn').forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const deleteButton = row.querySelector('.delete-btn');
            const confirmDeleteButton = row.querySelector('.confirm-delete-btn');
            const editButton = row.querySelector('.edit-btn'); // Get the edit button

            confirmDeleteButton.parentNode.style.display = 'none'; // Hide confirm delete button group
            deleteButton.style.display = 'inline-block'; // Show delete button
            editButton.style.display = 'inline-block'; // Show edit button
        });
    });

    // Format input value with Rp prefix and dots as thousand separators
    document.getElementById('harga').addEventListener('input', function(evt) {
        // Remove non-digit characters
        var value = this.value.replace(/\D/g, '');
        // Add dots as thousand separators
        var formattedValue = Number(value).toLocaleString('id');
        // Add 'Rp' prefix and update the input value
        this.value = 'Rp ' + formattedValue;
    });

    // Function to handle selection of supplier
    function selectSupplier(id) {
        // Get the selected supplier ID
        const supplierId = id;
        // Set the selected supplier ID to the input field
        document.getElementById('supplier_id').value = supplierId;
        // Hide the modal
        $('#selectSupplierModal').modal('hide');
    }

    // Function to remove Rp prefix and thousand separators from harga input field
    function prepareHargaInput() {
        const hargaInput = document.getElementById('harga');
        // Remove Rp prefix
        hargaInput.value = hargaInput.value.replace('Rp ', '');
        // Remove thousand separators
        hargaInput.value = hargaInput.value.replace(/\./g, '');
    }

    // Event listener to call prepareHargaInput function when harga input field changes
    document.getElementById('harga').addEventListener('input', prepareHargaInput);

    // Function to generate kode_barang with format B001, B002, ...
    function generateKodeBarang() {
        // Get the number of existing rows (assuming B001, B002, ...)
        const rowCount = document.querySelectorAll('.table tbody tr').length;
        // Increment the number for the new row
        const newNumber = rowCount + 1;
        // Generate kode_barang with format Bxxx
        const kodeBarang = 'B' + newNumber.toString().padStart(3, '0');
        // Set the value to the hidden input
        document.getElementById('kode_barang').value = kodeBarang;
    }

    // Call the function when the modal is shown
    $('#addBarangModal').on('show.bs.modal', function (e) {
        // Generate kode_barang when the modal is shown
        generateKodeBarang();
    });
</script>

</div>
@endsection
