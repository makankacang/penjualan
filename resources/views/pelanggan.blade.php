@extends('layouts.app')

@section('content')
<div class="content">
  <!-- Sale & Revenue Start -->
  <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Pelanggan Table</h6>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addPelangganModal">Add Pelanggan</button>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Telepon</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelanggan as $data)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <form action="/editpelanggan/{{ $data->pelanggan_id }}" method="POST">
                                  @csrf
                                  <td>
                                      <span class="table-data">{{ $data->nama }}</span>
                                      <input type="text" name="nama" class="form-control edit-input" value="{{ $data->nama }}" style="display: none;">
                                  </td>
                                  <td>
                                    <span class="table-data badge {{ $data->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-light' }}">{{ $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    <div class="edit-input" style="display: none;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="L" {{ $data->jenis_kelamin == 'L' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jk_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="P" {{ $data->jenis_kelamin == 'P' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jk_p">Perempuan</label>
                                        </div>
                                    </div>
                                  </td>                                                            
                                  <td>
                                      <span class="table-data">{{ $data->telp }}</span>
                                      <input type="text" name="telp" class="form-control edit-input" value="{{ $data->telp }}" style="display: none;">
                                  </td>
                                  <td>
                                      <span class="table-data">{{ $data->alamat }}</span>
                                      <input type="text" name="alamat" class="form-control edit-input" value="{{ $data->alamat }}" style="display: none;">
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
                                          <a href="/deletebuku/{{ $data->pelanggan_id }}" class="btn text-success confirm-delete-btn">
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


<!-- Sale & Revenue End -->

<!-- Add Pelanggan Modal -->
<div class="modal fade" id="addPelangganModal" tabindex="-1" aria-labelledby="addPelangganModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-secondary text-light">
          <div class="modal-header border-0">
              <h5 class="modal-title" id="addPelangganModalLabel">Add New Pelanggan</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Add your form for adding a new entry to the "pelanggan" table here -->
              <form action="/addpelanggan" method="POST">
                @csrf
                  <div class="mb-3">
                      <label for="nama" class="form-label">Nama</label>
                      <input type="text" class="form-control bg-dark text-light" id="nama" name="nama">
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Jenis Kelamin</label><br>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="L">
                        <label class="form-check-label" for="jk_l">Laki-laki</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="P">
                        <label class="form-check-label" for="jk_p">Perempuan</label>
                      </div>
                  </div>
                  <div class="mb-3">
                      <label for="telp" class="form-label">Telepon</label>
                      <input type="text" class="form-control bg-dark text-light" id="telp" name="telp" placeholder="Format: 123-456-7890" maxlength="12">
                      <small class="text-muted">Format: 123-456-7890</small>
                  </div>
                  <div class="mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <input type="text" class="form-control bg-dark text-light" id="alamat" name="alamat">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
  </div>
</div>
<!-- End Add Pelanggan Modal -->

<script>
    // JavaScript to validate the telephone input field
    document.getElementById('telp').addEventListener('input', function(evt) {
        // Regex pattern to allow only digits and dashes
        var newValue = this.value.replace(/[^\d-]/g, '');
        // Update the input value with the cleaned value
        this.value = newValue;
        // Limit the input length
        if (newValue.length > 12) {
            this.value = newValue.slice(0, 12);
        }
    });
</script>



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

    // JavaScript to validate the telephone input field
    document.getElementById('telp').addEventListener('input', function(evt) {
        // Regex pattern to allow only digits and dashes
        var newValue = this.value.replace(/[^\d-]/g, '');
        // Update the input value with the cleaned value
        this.value = newValue;
        // Limit the input length
        if (newValue.length > 12) {
            this.value = newValue.slice(0, 12);
        }
    });

</script>

</div>
@endsection
