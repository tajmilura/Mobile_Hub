@extends('admin.index')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Slider / Banner</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Slider/Banner</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left Side: Form -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title" id="formTitle">Add New</h3>
                            <button type="button" class="btn btn-success btn-sm d-none" id="addNewBtn">
                                <i class="fas fa-plus"></i> Add New
                            </button>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('slider_banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <!--  Type -->
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="slider">Slider</option>
                                        <option value="banner">Banner</option>
                                        <option value="long_banner">Long Banner</option>
                                    </select>
                                </div>

                                <!--  Title -->
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Enter title" required>
                                </div>

                                <!--  Subtitle -->
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control"
                                        placeholder="Enter subtitle (optional)">
                                </div>
                                <!-- Link -->
                                <div class="form-group">
                                    <label for="title">Link</label>
                                    <input type="text" name="link" id="link" class="form-control"
                                        placeholder="Enter Link" required>
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image">Upload Image</label>
                                    <input type="file" name="image" id="image" class="form-control-file"
                                        accept="image/*" onchange="previewImage(event)">
                                    <div class="mt-2">
                                        <img id="image_preview" src="#" alt="Preview"
                                            style="display:none; max-width:400px; border:1px solid #ddd; border-radius:6px;">
                                    </div>
                                </div>

                                <!--  Order -->
                                <div class="form-group">
                                    <label for="order">Display Order</label>
                                    <input type="number" name="order" id="order" class="form-control"
                                        placeholder="e.g. 1">
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">-- Select Type --</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Side: Table -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #ea238d; color: white;">
                            <h3 class="card-title">All Banner/Slider/BG Items</h3>
                        </div>
                        <div class="card-body" id="media-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sliderbanner as $index => $item)
                                        <tr>
                                            <td>{{ $sliderbanner->firstItem() + $index }}</td>
                                            <td><span class="badge badge-info text-uppercase">{{ $item->type }}</span>
                                            </td>
                                            <td>{{ $item->title ?? 'N/A' }}</td>
                                            <td>
                                                @if ($item->image_path)
                                                    <img src="{{ asset('storage/' . $item->image_path) }}" width="70"
                                                        class="rounded shadow-sm">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="text-primary editBtn mr-4"
                                                    data-id="{{ $item->id }}" data-type="{{ $item->type }}"
                                                    data-title="{{ $item->title }}" data-subtitle="{{ $item->subtitle }}"
                                                    data-order="{{ $item->order }}" data-link ="{{ $item->link }}" data-status="{{ $item->status }}"
                                                    data-image="{{ asset('storage/' . $item->image_path) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="text-danger delete-btn"
                                                    data-url="{{ route('slider_banner.destroy', $item->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">No media items found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $sliderbanner->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('image_preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    {{-- sweet alart for delete --}}
    <script>
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            var url = $(this).data('url'); // delete route
            var row = $(this).closest('tr'); // delete row

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
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                                toastr.success('Element deleted successfully.');
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
    <script>
        $(document).on('click', '.editBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let type = $(this).data('type');
            let title = $(this).data('title');
            let subtitle = $(this).data('subtitle');
            let link = $(this).data('link');
            let order = $(this).data('order');
            let status = $(this).data('status');
            let image = $(this).data('image');

            // Reset form before filling
            $('form')[0].reset();
            $('#image_preview').hide();
            $('input[name="_method"]').remove();

            // Fill form data
            $('#type').val(type);
            $('#title').val(title);
            $('#subtitle').val(subtitle);
            $('#link').val(link);
            $('#order').val(order);
            $('#status').val(status);

            if (image) {
                $('#image_preview').attr('src', image).show();
            }

            // Change form to UPDATE mode
            $('form').attr('action', '/slider_banner/update/' + id);
            $('form').append('<input type="hidden" name="_method" value="PUT">');

            // Change button text and color
            $('button[type="submit"]').text('Update Item')
                .removeClass('btn-primary')
                .addClass('btn-warning');

            // Change form title
            $('#formTitle').text('Edit Slider/Banner');

            // Show "Add New" button
            $('#addNewBtn').removeClass('d-none');

            toastr.info('Edit mode enabled for "' + (title || 'Untitled') + '"');
        });


        //  Back to Add Mode
        $('#addNewBtn').on('click', function() {
            $('form')[0].reset();
            $('#image_preview').attr('src', '#').hide();
            $('input[name="_method"]').remove();

            // Change form back to store route
            $('form').attr('action', '{{ route('slider_banner.store') }}');

            // Change button style back
            $('button[type="submit"]').text('Save')
                .removeClass('btn-warning')
                .addClass('btn-primary');

            // Change header title
            $('#formTitle').text('Add New');

            // Hide Add New button again
            $(this).addClass('d-none');

            toastr.success('Back to Add Mode');
        });
    </script>
@endpush
