@extends('admin.index')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Release Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td><a href="{{ route('product.show', $product->id) }}" class="text-dark font-weight-bold">
                                    {{ $product->name }}
                                </a></td>
                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                            <td>{{ $product->release_date ?? 'N/A' }}</td>
                            <td class="text-center align-middle">
                                <a href="{{ route('product.edit', $product->id) }}" data-id="{{ $product->id }}"
                                    data-name="" class="text-primary pr-3 editBrandBtn">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="#" class="text-danger delete-btn"
                                    data-url="{{ route('product.destroy', $product->id) }}">
                                    <i class="fas fa-trash"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@push('scripts')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

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
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                                toastr.success('Product deleted successfully.');
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
@endpush
