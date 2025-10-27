@extends('admin.index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Brand</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create Brand</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Brand</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="brand_name">Brand Name</label>
                                    <input type="text" name="name" class="form-control" id="brand_name"
                                        placeholder="Enter brand name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="brand_icon">Brand Icon</label>
                                    <input type="file" name="brand_icon" class="form-control-file" id="brand_icon"
                                        accept="image/*" onchange="previewImage(event, 'icon_preview')">
                                    @error('brand_icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="icon_preview" src="#" alt="Icon Preview"
                                            style="display:none; max-width: 100px; max-height: 100px;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brand_image">Brand Image</label>
                                    <input type="file" name="brand_image" class="form-control-file" id="brand_image"
                                        accept="image/*" onchange="previewImage(event, 'image_preview')">
                                    @error('brand_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="image_preview" src="#" alt="Image Preview"
                                            style="display:none; max-width: 200px; max-height: 200px;" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create Brand</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Brands</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- Loader -->
                        <div id="loader" style="display:none; text-align:center; padding:20px;">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                        </div>
                        <div class="card-body" id="brand-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Brand Name</th>
                                        <th>Logo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($brands as $index => $brand)
                                        <tr>
                                            <td>{{ $brands->firstItem() + $index }}.</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>
                                                @if ($brand->brand_icon)
                                                    <img src="{{ asset($brand->brand_icon) }}" alt="{{ $brand->name }}"
                                                        width="50" height="50" class="rounded shadow-sm">
                                                @else
                                                    <span class="text-muted">No logo</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('brand.edit', $brand->id) }}"
                                                    data-id="{{ $brand->id }}" class="text-primary pr-3">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="text-danger delete-btn"
                                                    data-url="{{ route('brand.destroy', $brand->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-exclamation-circle"></i> No brands available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $brands->links('pagination::bootstrap-5') }}
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

            </div>
        </div>
    </section>
    <!-- /.content -->

    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Pagination link click event
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // শুধু #brand-table content replace করবে
                        $('#brand-table').html($(html).find('#brand-table').html());
                    })
                    .catch(error => console.log(error));
            });
        });
    </script>


    <script>
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            $('#loader').show();
            var url = $(this).attr('href');

            fetch(url)
                .then(res => res.text())
                .then(html => {
                    $('#brand-table').html($(html).find('#brand-table').html());
                    $('#loader').hide();
                });
        });
    </script>

    <!-- jQuery must come first -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).on('click', '.delete-btn', function(e){
    e.preventDefault();

    var url = $(this).data('url');          // delete route
    var row = $(this).closest('tr');        // delete row

    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response){
                    if(response.success){
                        row.remove(); // টেবিল থেকে রো সরানো
                        toastr.success('Brand deleted successfully.');
                    }
                },
                error: function(){
                    toastr.error('Something went wrong.');
                }
            });
        }
    });
});
</script>

@endsection
