@extends('admin.index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category/Edit Category/All Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Form Column -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title" id="formTitle">Add New Category</h3>
                            <button type="button" class="btn btn-success btn-sm d-none" id="addNewBtn">
                                <i class="fas fa-plus"></i> Add Category
                            </button>
                        </div>

                        <!-- form start -->
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" name="name" class="form-control" id="category_name"
                                        placeholder="Enter category name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category_icon">Category Icon</label>
                                    <input type="file" name="category_icon" class="form-control-file" id="category_icon"
                                        accept="image/*" onchange="previewImage(event, 'icon_preview')">
                                    @error('category_icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="icon_preview" src="#" alt="Icon Preview"
                                            style="display:none; max-width: 100px; max-height: 100px;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category_image">Category Image</label>
                                    <input type="file" name="category_image" class="form-control-file" id="category_image"
                                        accept="image/*" onchange="previewImage(event, 'image_preview')">
                                    @error('category_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="image_preview" src="#" alt="Image Preview"
                                            style="display:none; max-width: 200px; max-height: 200px;" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create Category</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table Column -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #ea238d; color: white;">
                            <h3 class="card-title">All Categories</h3>
                        </div>

                        <!-- Loader -->
                        <div id="loader" style="display:none; text-align:center; padding:20px;">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                        </div>

                        <div class="card-body" id="category-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Category Name</th>
                                        <th>Logo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $index => $category)
                                        <tr>
                                            <td>{{ $categories->firstItem() + $index }}.</td>
                                            <td>{{ $category->category_name }}</td>
                                            <td>
                                                @if ($category->category_icon)
                                                    <img src="{{ asset($category->category_icon) }}" alt="{{ $category->category_name }}"
                                                        width="50" height="50" class="rounded shadow-sm">
                                                @else
                                                    <span class="text-muted">No logo</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="#" data-id="{{ $category->id }}"
                                                    data-name="{{ $category->category_name }}"
                                                    data-icon="{{ asset($category->category_icon) }}"
                                                    data-image="{{ asset($category->category_image) }}"
                                                    class="text-primary pr-3 editCategoryBtn">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="#" class="text-danger delete-btn"
                                                    data-url="{{ route('category.destroy', $category->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-exclamation-circle"></i> No categories available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $categories->links('pagination::bootstrap-5') }}
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Scripts -->
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

    <!-- jQuery -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Pagination AJAX -->
    <script>
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            $('#loader').show();
            var url = $(this).attr('href');

            fetch(url)
                .then(res => res.text())
                .then(html => {
                    $('#category-table').html($(html).find('#category-table').html());
                    $('#loader').hide();
                });
        });
    </script>

    <!-- Delete AJAX -->
    <script>
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            var url = $(this).data('url');
            var row = $(this).closest('tr');

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
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                                toastr.success('Category deleted successfully.');
                            }
                        },
                        error: function() {
                            toastr.error('Something went wrong.');
                        }
                    });
                }
            });
        });
    </script>

    <!-- Edit Category -->
    <script>
        $(document).on('click', '.editCategoryBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let name = $(this).data('name');
            let icon = $(this).data('icon');
            let image = $(this).data('image');

            // Reset form
            $('form')[0].reset();
            $('#icon_preview, #image_preview').hide();
            $('input[name="_method"]').remove();

            // Fill form data
            $('#category_name').val(name);
            $('#icon_preview').attr('src', icon).show();
            $('#image_preview').attr('src', image).show();

            // Update route & method
            $('form').attr('action', '/category/update/' + id);
            $('form').append('<input type="hidden" name="_method" value="PUT">');

            // Button & header changes
            $('button[type="submit"]').text('Update Category')
                .removeClass('btn-primary')
                .addClass('btn-warning');
            $('#formTitle').text('Edit Category');
            $('#addNewBtn').removeClass('d-none');

            toastr.info('Edit mode enabled for "' + name + '"');
        });

        // Add Category Button to reset form
        $('#addNewBtn').on('click', function() {
            $('form')[0].reset();
            $('#icon_preview, #image_preview').attr('src', '#').hide();
            $('input[name="_method"]').remove();
            $('form').attr
                        // Change form action back to store route
            $('form').attr('action', '{{ route('category.store') }}');

            // Reset button text and style
            $('button[type="submit"]').text('Create Category')
                .removeClass('btn-warning')
                .addClass('btn-primary');

            // Reset header title
            $('#formTitle').text('Add New Category');

            // Hide the "Add Category" button
            $(this).addClass('d-none');

            // Clear category_name input
            $('#category_name').val('');

            toastr.success('Back to Add mode');
        });
    </script>
@endsection

