@extends('admin.index')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-2 font-weight-bold" style="color: rgba(3, 152, 139, 0.622);">Add Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Product</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="container mt-5">
                    <div class="col-12">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h3 class="mb-0">Edit Product</h3>
                                <small class="text-muted">Fill in product details and media</small>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="POST" id="productForm" action="{{ route('product.update', $product->id) }}"
                                    enctype="multipart/form-data" class="formDropzone">
                                    @csrf
                                    @method('PUT')

                                    <!-- Progress Bar -->
                                    <div class="progress mb-4 mx-5" style="height: 25px;">
                                        <div class="progress-bar" role="progressbar" id="formProgress" style="width: 0%;">
                                        </div>
                                    </div>

                                    <!-- Step 1: Basic Info -->
                                    <div class="step active">
                                        <h4 class="text-center font-weight-bold my-3">Basic Info</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name', $product->name) }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Category</label>
                                                <select class="form-control" name="category_id">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Brand</label>
                                                <select class="form-control" name="brand_id">
                                                    <option value="">Select Brand</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                            {{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>Description</label>
                                            <textarea class="form-control" id="summernote" name="description">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 2: Specs -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Specifications</h4>
                                        <div class="row">
                                            <div class="col-md-6"><label>RAM</label><input type="text"
                                                    class="form-control" name="ram" value="{{ $product->ram }}"></div>
                                            <div class="col-md-6"><label>Storage</label><input type="text"
                                                    class="form-control" name="storage" value="{{ $product->storage }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><label>Processor</label><input type="text"
                                                    class="form-control" name="processor"
                                                    value="{{ $product->processor }}"></div>
                                            <div class="col-md-6"><label>OS</label><input type="text"
                                                    class="form-control" name="os" value="{{ $product->os }}"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><label>Battery</label><input type="text"
                                                    class="form-control" name="battery" value="{{ $product->battery }}">
                                            </div>
                                            <div class="col-md-6"><label>Charging</label><input type="text"
                                                    class="form-control" name="charging" value="{{ $product->charging }}">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 3: Display & Camera -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Display & Camera</h4>
                                        <div class="row">
                                            <div class="col-md-6"><label>Display</label><input type="text"
                                                    class="form-control" name="display" value="{{ $product->display }}">
                                            </div>
                                            <div class="col-md-6"><label>Resolution</label><input type="text"
                                                    class="form-control" name="resolution"
                                                    value="{{ $product->resolution }}"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><label>Camera</label><input type="text"
                                                    class="form-control" name="camera" value="{{ $product->camera }}">
                                            </div>
                                            <div class="col-md-6"><label>Front Camera</label><input type="text"
                                                    class="form-control" name="front_camera"
                                                    value="{{ $product->front_camera }}"></div>
                                        </div>
                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 4: Connectivity & Build -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Connectivity & Build</h4>
                                        <div class="row">
                                            <div class="col-md-6"><label>Network</label><input type="text"
                                                    class="form-control" name="network" value="{{ $product->network }}">
                                            </div>
                                            <div class="col-md-6"><label>SIM</label><input type="text"
                                                    class="form-control" name="sim" value="{{ $product->sim }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><label>Build</label><input type="text"
                                                    class="form-control" name="build" value="{{ $product->build }}">
                                            </div>
                                            <div class="col-md-6"><label>Weight</label><input type="text"
                                                    class="form-control" name="weight" value="{{ $product->weight }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><label>Dimensions</label><input type="text"
                                                    class="form-control" name="dimensions"
                                                    value="{{ $product->dimensions }}"></div>
                                            <div class="col-md-6"><label>Colors</label><input type="text"
                                                    class="form-control" name="colors"
                                                    value="{{ is_array($product->colors) ? implode(', ', $product->colors) : $product->colors }}">

                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 5: Extra Features -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Extra Features</h4>
                                        <div class="row">
                                            <div class="col-md-6"><label>Fingerprint</label><input type="text"
                                                    class="form-control" name="fingerprint"
                                                    value="{{ $product->fingerprint }}"></div>
                                            <div class="col-md-6"><label>Water Resistance</label><input type="text"
                                                    class="form-control" name="water_resistance"
                                                    value="{{ $product->water_resistance }}"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><label>Bluetooth</label><input type="text"
                                                    class="form-control" name="bluetooth"
                                                    value="{{ $product->bluetooth }}"></div>
                                            <div class="col-md-6"><label>WiFi</label><input type="text"
                                                    class="form-control" name="wifi" value="{{ $product->wifi }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><label>USB</label><input type="text"
                                                    class="form-control" name="usb" value="{{ $product->usb }}">
                                            </div>
                                            <div class="col-md-6"><label>Audio</label><input type="text"
                                                    class="form-control" name="audio" value="{{ $product->audio }}">
                                            </div>
                                        </div>
                                        <div class="form-group"><label>Sensors</label><input type="text"
                                                class="form-control" name="sensors" value="{{ $product->sensors }}">
                                        </div>
                                        <div class="form-group"><label>Release Date</label><input type="date"
                                                class="form-control" name="release_date"
                                                value="{{ $product->release_date }}"></div>

                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 6: Media -->
                                    <!-- Step 6: Media -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Media</h4>
                                        <div class="row">
                                            <!-- Main Image -->
                                            <div class="form-group mb-3">
                                                <label for="image">Main Image</label>
                                                <input type="file" name="image" id="image"
                                                    class="form-control">
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Main Image"
                                                        style="width: 150px; margin-top:10px;">
                                                @endif
                                                @error('image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Gallery Images --}}
                                            <div class="form-group mb-3">
                                                <label for="gallery">Gallery Images</label>
                                                <input type="file" name="gallery[]" id="gallery"
                                                    class="form-control" multiple>
                                                @if ($product->images->count())
                                                    <div class="mt-2">
                                                        @foreach ($product->images as $img)
                                                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                                                style="width:100px; margin-right:5px;"
                                                                alt="Gallery Image">
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @error('gallery.*')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Video Upload --}}
                                            <div class="form-group mb-3">
                                                <label for="video">Upload Video</label>
                                                <input type="file" name="video" id="video"
                                                    class="form-control">
                                                @if ($product->video)
                                                    @if ($product->video->video_path)
                                                        <video width="320" height="240" controls class="mt-2">
                                                            <source
                                                                src="{{ asset('storage/' . $product->video->video_path) }}"
                                                                type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @elseif($product->video->embed_link)
                                                        <iframe width="320" height="240"
                                                            src="{{ $product->video->embed_link }}" frameborder="0"
                                                            allowfullscreen class="mt-2"></iframe>
                                                    @endif
                                                @endif
                                                @error('video')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label>YouTube Video Link</label>
                                            <input type="text" class="form-control" name="video_link"
                                                value="{{ $product->video_link }}">
                                        </div>

                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>
                                    </div>


                                    <!-- Step 7: Price & Extra Info -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Price and Extra Info</h4>
                                        <div class="row">
                                            <div class="col-md-4"><label>Price</label><input type="number"
                                                    class="form-control" name="price" value="{{ $product->price }}">
                                            </div>
                                            <div class="col-md-4"><label>Discount Price</label><input type="number"
                                                    class="form-control" name="discount_price"
                                                    value="{{ $product->discount_price }}"></div>
                                            <div class="col-md-4"><label>Stock</label><input type="number"
                                                    class="form-control" name="stock" value="{{ $product->stock }}">
                                            </div>
                                        </div>

                                        <div class="row my-3">
                                            <div class="col-sm-4">
                                                <label>Featured</label>
                                                <input type="checkbox" name="is_featured" value="1"
                                                    {{ $product->is_featured ? 'checked' : '' }}>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>New Arrival</label>
                                                <input type="checkbox" name="is_new_arrival" value="1"
                                                    {{ $product->is_new_arrival ? 'checked' : '' }}>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Hot Deal</label>
                                                <input type="checkbox" name="is_hot_deal" value="1"
                                                    {{ $product->is_hot_deal ? 'checked' : '' }}>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Warranty</label>
                                            <input type="text" class="form-control" name="warranty"
                                                value="{{ $product->warranty }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Tags</label>
                                            <input type="text" class="form-control" name="tags"
                                                value="{{ is_array($product->tags) ? implode(', ', $product->tags) : $product->tags }}">
                                            <small class="form-text text-muted">Separate multiple tags with commas.</small>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6"><label>SKU</label><input type="text"
                                                    class="form-control" name="sku" value="{{ $product->sku }}">
                                            </div>
                                            <div class="col-md-6"><label>Barcode</label><input type="text"
                                                    class="form-control" name="barcode" value="{{ $product->barcode }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6"><label>Discount Start</label><input
                                                    type="datetime-local" class="form-control" name="discount_start"
                                                    value="{{ $product->discount_start }}"></div>
                                            <div class="col-md-6"><label>Discount End</label><input type="datetime-local"
                                                    class="form-control" name="discount_end"
                                                    value="{{ $product->discount_end }}"></div>
                                        </div>

                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
    </section>

    <!-- /.content -->


    <style>
        /* Steps layout */
        .step {
            display: none;
            background: #ffffff;
            padding: 1.25rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #f0f0f0;
        }

        /* hide all steps by default */
        .step h3,
        .step h4 {
            margin-bottom: 12px;
            color: #222;
        }

        .step.active {
            display: block;
            box-shadow: 0 6px 18px rgba(16, 24, 40, 0.06);
            border-color: rgba(3, 152, 139, 0.12);
        }

        /* Dropzone preview tweaks */
        .dropzone {
            min-height: 140px;
            border-radius: 8px;
            border: 2px dashed #e9ecef;
            background: #fafafa;
        }

        .dropzone .dz-preview img {
            max-width: 100%;
            max-height: 120px;
            display: block;
        }

        #galleryPreview img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            margin: 4px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        #videoPreviewContainer video {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* Buttons */
        .btn-primary.next {
            background: linear-gradient(90deg, #17a2b8, #20c997);
            border: none;
            box-shadow: 0 6px 12px rgba(32, 201, 151, 0.12);
        }

        .btn-secondary.prev {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #333;
        }

        /* Card header subtle styling */
        .card-header h3 {
            font-size: 1.05rem;
            color: #123;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentStep = 0;
            const steps = $(".step");

            function showStep(index) {
                steps.hide();
                steps.eq(index).show();
            }

            // basic validation per step
            function showError($input, msg) {
                $input.addClass('is-invalid');
                let $fb = $input.next('.invalid-feedback');
                if (!$fb.length) {
                    $fb = $('<div class="invalid-feedback"></div>');
                    $input.after($fb);
                }
                $fb.text(msg);
            }

            function clearError($input) {
                $input.removeClass('is-invalid');
                let $fb = $input.next('.invalid-feedback');
                if ($fb.length) $fb.remove();
            }

            function validateStep(index) {
                let valid = true;
                const $step = steps.eq(index);

                // clear previous errors in this step
                $step.find('input,textarea,select').each(function() {
                    clearError($(this));
                });

                if (index === 0) { // Basic Info
                    const $cat = $step.find('[name="category_id"]');
                    const $brand = $step.find('[name="brand_id"]');
                    const $name = $step.find('[name="name"]');
                    if (!$cat.val() || $cat.val().trim().length < 1) {
                        showError($cat, 'Category is required');
                        valid = false;
                    }
                    if (!$brand.val() || $brand.val().trim().length < 1) {
                        showError($brand, 'Brand is required');
                        valid = false;
                    }
                    if (!$name.val() || $name.val().trim().length < 2) {
                        showError($name, 'Enter a valid product name (min 2 chars)');
                        valid = false;
                    }
                }

                return valid;
            }

            showStep(currentStep); // to show first step

            $(".next").click(function(e) {
                // validate current step before moving forward
                if (!validateStep(currentStep)) {
                    e.preventDefault();
                    // scroll to first error
                    const $firstErr = $(".is-invalid").first();
                    if ($firstErr.length) {
                        $('html, body').animate({
                            scrollTop: $firstErr.offset().top - 100
                        }, 250);
                    }
                    return false;
                }
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            $(".prev").click(function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });
    </script>

    <script>
        // Additional page-specific JavaScript can go here
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    </script>
    <script>
        // Progress Bar Update
        $(document).ready(function() {
            var totalSteps = $(".step").length;
            var currentStep = 0;

            // Colors for each step
            var stepColors = ['#17a2b8', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#fd7e14'];

            function updateProgress() {
                var percent = ((currentStep + 1) / totalSteps) * 100;
                $("#formProgress").css({
                    "width": percent + "%",
                    "background-color": stepColors[Math.min(currentStep, stepColors.length - 1)]
                });
            }

            function showError($input, msg) {
                $input.addClass('is-invalid');
                let $fb = $input.next('.invalid-feedback');
                if (!$fb.length) {
                    $fb = $('<div class="invalid-feedback"></div>');
                    $input.after($fb);
                }
                $fb.text(msg);
            }

            function clearError($input) {
                $input.removeClass('is-invalid');
                let $fb = $input.next('.invalid-feedback');
                if ($fb.length) $fb.remove();
            }

            function validateStepAt(index) {
                var valid = true;
                var $step = $(".step").eq(index);
                $step.find('input,textarea,select').each(function() {
                    clearError($(this));
                });

                // Basic Info (index 0)
                if (index === 0) {
                    var $cat = $step.find('[name="category_id"]');
                    var $brand = $step.find('[name="brand_id"]');
                    var $name = $step.find('[name="name"]');
                    if (!$cat.val() || $cat.val().trim().length < 1) {
                        showError($cat, 'Category is required');
                        valid = false;
                    }
                    if (!$brand.val() || $brand.val().trim().length < 1) {
                        showError($brand, 'Brand is required');
                        valid = false;
                    }
                    if (!$name.val() || $name.val().trim().length < 2) {
                        showError($name, 'Enter a valid product name (min 2 chars)');
                        valid = false;
                    }
                }

                // Connectivity & Build (index 3) - colors validation
                if (index === 3) {
                    var $colors = $step.find('[name="colors"]');
                    var c = $colors.val();
                    if (c && c.trim().length) {
                        var ok = true;
                        if (/^\s*\[/.test(c)) {
                            try {
                                var parsed = JSON.parse(c);
                                if (!Array.isArray(parsed)) ok = false;
                            } catch (e) {
                                ok = false;
                            }
                        } else {
                            var parts = c.split(',').map(function(p) {
                                return p.trim();
                            }).filter(Boolean);
                            if (parts.length === 0) ok = false;
                        }
                        if (!ok) {
                            showError($colors, 'Enter colors as JSON array or comma-separated list');
                            valid = false;
                        }
                    }
                }

                // Media & Pricing (index 5) - optional checks for URL format
                // if (index === 5) {
                //     var $videoLink = $step.find('[name="video_link"]');
                //     var v = $videoLink.val();
                //     if (v && v.trim().length) {
                //         try {
                //             new URL(v);
                //         } catch (e) {
                //             showError($videoLink, 'Enter a valid URL'); valid = false;
                //         }
                //     }
                // }

                // Extra Info / Price & Stock (index 6)
                if (index === 6) {
                    var $price = $step.find('[name="price"]');
                    var $discount = $step.find('[name="discount_price"]');
                    var $stock = $step.find('[name="stock"]');
                    var $ds = $step.find('[name="discount_start"]');
                    var $de = $step.find('[name="discount_end"]');

                    var priceVal = parseFloat($price.val());
                    if (!$.isNumeric($price.val()) || priceVal < 0) {
                        showError($price, 'Enter a valid price');
                        valid = false;
                    }

                    if ($discount.val()) {
                        var discVal = parseFloat($discount.val());
                        if (!$.isNumeric($discount.val()) || discVal < 0) {
                            showError($discount, 'Enter a valid discount price');
                            valid = false;
                        } else if ($.isNumeric($price.val()) && discVal > priceVal) {
                            showError($discount, 'Discount must be <= price');
                            valid = false;
                        }
                    }

                    if ($stock.val() && (!Number.isInteger(Number($stock.val())) || Number($stock.val()) < 0)) {
                        showError($stock, 'Enter a valid stock number');
                        valid = false;
                    }

                    if ($ds.val() && $de.val()) {
                        var dsVal = Date.parse($ds.val());
                        var deVal = Date.parse($de.val());
                        if (isNaN(dsVal) || isNaN(deVal) || dsVal >= deVal) {
                            showError($de, 'Discount end must be after start');
                            valid = false;
                        }
                    }

                    // tags validation (index 6)
                    var $tags = $step.find('[name="tags"]');
                    var t = $tags.val();
                    if (t && t.trim().length) {
                        var ok2 = true;
                        if (/^\s*\[/.test(t)) {
                            try {
                                var p2 = JSON.parse(t);
                                if (!Array.isArray(p2)) ok2 = false;
                            } catch (e) {
                                ok2 = false;
                            }
                        } else {
                            var parts2 = t.split(',').map(function(p) {
                                return p.trim();
                            }).filter(Boolean);
                            if (parts2.length === 0) ok2 = false;
                        }
                        if (!ok2) {
                            showError($tags, 'Enter tags as JSON array or comma-separated list');
                            valid = false;
                        }
                    }
                }

                return valid;
            }

            $(".next").click(function() {
                if (currentStep < totalSteps - 1) {
                    // validate current step before moving
                    if (!validateStepAt(currentStep)) {
                        var $first = $('.is-invalid').first();
                        if ($first.length) $('html, body').animate({
                            scrollTop: $first.offset().top - 100
                        }, 250);
                        return;
                    }
                    $(".step").eq(currentStep).removeClass("active");
                    currentStep++;
                    $(".step").eq(currentStep).addClass("active");
                    updateProgress();
                }
            });

            $(".prev").click(function() {
                if (currentStep > 0) {
                    $(".step").eq(currentStep).removeClass("active");
                    currentStep--;
                    $(".step").eq(currentStep).addClass("active");
                    updateProgress();
                }
            });

            // final submit: validate all steps (important fields)
            var form = document.getElementById('productForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    var overallValid = true;
                    for (var i = 0; i < totalSteps; i++) {
                        if (!validateStepAt(i)) {
                            overallValid = false;
                        }
                    }
                    if (!overallValid) {
                        e.preventDefault();
                        var $first = $('.is-invalid').first();
                        if ($first.length) $('html, body').animate({
                            scrollTop: $first.offset().top - 100
                        }, 250);
                    }
                });
            }

            updateProgress(); // Initialize progress bar
        });
    </script>
    <!-- Dropzone JS -->
    <script>
        Dropzone.autoDiscover = false;

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('productForm');

            // 🔹 Gallery Dropzone
            const galleryInput = document.getElementById('galleryDropzone');
            let galleryFiles = [];

            galleryInput.addEventListener('change', function(e) {
                Array.from(e.target.files).forEach(file => {
                    galleryFiles.push(file);
                    const url = URL.createObjectURL(file);
                    const img = document.createElement('img');
                    img.src = url;
                    img.classList.add('img-thumbnail', 'm-1');
                    img.width = 100;
                    img.dataset.new = '1';
                    document.getElementById('galleryPreview').appendChild(img);

                    // click to remove
                    img.addEventListener('click', function() {
                        galleryFiles = galleryFiles.filter(f => f !== file);
                        img.remove();
                    });
                });
            });

            // 🔹 Old gallery remove handling
            document.querySelectorAll('#galleryPreview img[data-server-id]').forEach(img => {
                img.addEventListener('click', function() {
                    const serverId = img.dataset.serverId;
                    const removedInput = document.createElement('input');
                    removedInput.type = 'hidden';
                    removedInput.name = 'removed_old_gallery[]';
                    removedInput.value = serverId;
                    form.appendChild(removedInput);
                    img.remove();
                });
            });

            // 🔹 On form submit
            form.addEventListener('submit', function(e) {
                if (galleryFiles.length > 0) {
                    galleryFiles.forEach((file, i) => {
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        const input = document.createElement('input');
                        input.type = 'file';
                        input.name = 'gallery[]';
                        input.files = dt.files;
                        input.style.display = 'none';
                        form.appendChild(input);
                    });
                }
            });
        });
    </script>


    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
@endpush
