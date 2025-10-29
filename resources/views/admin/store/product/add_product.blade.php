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
                                <h3 class="mb-0">Add Product</h3>
                                <small class="text-muted">Fill in product details and media</small>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="productForm" action="{{ route('product.store') }}"
                                    enctype="multipart/form-data" class="formDropzone">
                                    @csrf
                                    <!-- Progress Bar -->
                                    <div class="progress mb-4 mx-5" style="height: 25px;">
                                        <div class="progress-bar" role="progressbar" id="formProgress" style="width: 0%;">
                                        </div>
                                    </div>
                                    <!-- Step 1: Category & Brand -->
                                    <div class="step active">
                                        <h4 class="text-center font-weight-bold my-3">Basic Info</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" placeholder="Product Name"
                                                        name="name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Category</label>
                                                    <select class="form-control" name="category_id">
                                                        <option value="">Select Category</option>
                                                        <option value="1">Mobile</option>
                                                        <option value="2">Laptop</option>
                                                        <option value="3">Tablet</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Brand</label>
                                                    <select class="form-control" name="brand_id">
                                                        <option value="">Select Brand</option>
                                                        <option value="1">Apple</option>
                                                        <option value="2">Samsung</option>
                                                        <option value="3">Xiaomi</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control" id="summernote" placeholder="Description" name="description">
                                                           Place <em>some</em> <u>text</u> <strong>here</strong>
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>

                                    </div>


                                    <!-- Step 2: Specs -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Specifications</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>RAM</label>
                                                    <input type="text" class="form-control" name="ram">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Storage</label>
                                                    <input type="text" class="form-control" name="storage">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Processor</label>
                                                    <input type="text" class="form-control" name="processor">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>OS</label>
                                                    <input type="text" class="form-control" name="os">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Battery</label>
                                                    <input type="text" class="form-control" name="battery">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Charging</label>
                                                    <input type="text" class="form-control" name="charging">
                                                </div>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Display</label>
                                                    <input type="text" class="form-control" name="display">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Resolution</label>
                                                    <input type="text" class="form-control" name="resolution">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Camera</label>
                                                    <input type="text" class="form-control" name="camera">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Front Camera</label>
                                                    <input type="text" class="form-control" name="front_camera">
                                                </div>
                                            </div>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Network</label>
                                                    <input type="text" class="form-control" name="network">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>SIM</label>
                                                    <input type="text" class="form-control" name="sim">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Build</label>
                                                    <input type="text" class="form-control" name="build">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Weight</label>
                                                    <input type="text" class="form-control" name="weight">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Dimensions</label>
                                                    <input type="text" class="form-control" name="dimensions">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Colors</label>
                                                    <input type="text" class="form-control" name="colors"
                                                        placeholder='e.g., ["red", "blue", "green"]'>
                                                    <small class="text-muted">Enter colors in JSON array format</small>
                                                </div>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Fingerprint</label>
                                                    <input type="text" class="form-control" name="fingerprint">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Water Resistance</label>
                                                    <input type="text" class="form-control" name="water_resistance">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Bluetooth</label>
                                                    <input type="text" class="form-control" name="bluetooth">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>WiFi</label>
                                                    <input type="text" class="form-control" name="wifi">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>USB</label>
                                                    <input type="text" class="form-control" name="usb">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Audio</label>
                                                    <input type="text" class="form-control" name="audio">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Sensors</label>
                                            <input type="text" class="form-control" name="sensors">
                                        </div>
                                        <div class="form-group">
                                            <label>Release Date</label>
                                            <input type="date" class="form-control" name="release_date">
                                        </div>

                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>

                                    </div>

                                    <!-- Step 6: Media & Pricing -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Media</h4>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-header font-weight-bold">Main Image</div>
                                                    <div class="card-body">
                                                        <div id="mainImageDropzone" class="dropzone"></div>
                                                        <small class="text-muted d-block mt-2">Recommended: 800x800px (1
                                                            file)</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="card">
                                                    <div class="card-header font-weight-bold">Gallery Images</div>
                                                    <div class="card-body">
                                                        <div id="galleryDropzone" class="dropzone"></div>
                                                        <div id="galleryPreview" class="d-flex flex-wrap mt-2"></div>
                                                        <small class="text-muted d-block mt-2">You can upload multiple
                                                            images</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header font-weight-bold">Video</div>
                                                    <div class="card-body">
                                                        <div id="videoDropzone" class="dropzone"></div>
                                                        <div id="videoPreviewContainer" class="mt-2"></div>
                                                        <small class="text-muted d-block mt-2">Supported: mp4, webm (1
                                                            file)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>YouTube Video Link</label>
                                            <input type="text" class="form-control" name="video_link">
                                        </div>

                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="button" class="btn btn-primary next">Next</button>
                                        </div>

                                    </div>
                                    <!-- Step 7: Price and Extra Info -->
                                    <div class="step">
                                        <h4 class="text-center font-weight-bold my-3">Price and Extra Info</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Price</label>
                                                    <input type="number" class="form-control" name="price">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Discount Price</label>
                                                    <input type="number" class="form-control" name="discount_price">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-dark">Stock</label>
                                                    <input type="number" class="form-control" name="stock">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row my-3">
                                            <div class="col-sm-4">
                                                <label class="font-weight-bold text-dark d-block mb-2">Featured: </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="is_featured" id="is_featured" data-bootstrap-switch
                                                        data-on-color="success" data-off-color="danger">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="font-weight-bold text-dark d-block mb-2">New Arrival:
                                                </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="is_new_arrival" id="is_new_arrival" data-bootstrap-switch
                                                        data-on-color="success" data-off-color="danger">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="font-weight-bold text-dark d-block mb-2">Hot Deal: </label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="is_hot_deal" id="is_hot_deal" data-bootstrap-switch
                                                        data-on-color="success" data-off-color="danger">
                                                    <label class="form-check-label ml-2 mb-0" for="is_hot_deal">Hot
                                                        Deal</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Warranty</label>
                                            <input type="text" class="form-control" name="warranty"
                                                placeholder="e.g., 1 year">
                                        </div>

                                        <div class="form-group">
                                            <label>Tags</label>
                                            <input type="text" class="form-control" name="tags"
                                                placeholder='Enter tags like: gaming, android, 5G'>
                                            <small class="form-text text-muted">Separate multiple tags with commas.</small>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>SKU</label>
                                                <input type="text" class="form-control" name="sku">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Barcode</label>
                                                <input type="text" class="form-control" name="barcode">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Discount Start</label>
                                                <input type="datetime-local" class="form-control" name="discount_start">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Discount End</label>
                                                <input type="datetime-local" class="form-control" name="discount_end">
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end my-3">
                                            <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                            <button type="button" class="btn btn-primary next">Next</button>
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
                $step.find('input,textarea,select').each(function() { clearError($(this)); });

                if (index === 0) { // Basic Info
                    const $cat = $step.find('[name="category_id"]');
                    const $brand = $step.find('[name="brand_id"]');
                    const $name = $step.find('[name="name"]');
                    if (!$cat.val() || $cat.val().trim().length < 1) { showError($cat, 'Category is required'); valid = false; }
                    if (!$brand.val() || $brand.val().trim().length < 1) { showError($brand, 'Brand is required'); valid = false; }
                    if (!$name.val() || $name.val().trim().length < 2) { showError($name, 'Enter a valid product name (min 2 chars)'); valid = false; }
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
                        $('html, body').animate({ scrollTop: $firstErr.offset().top - 100 }, 250);
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
                $step.find('input,textarea,select').each(function() { clearError($(this)); });

                // Basic Info (index 0)
                if (index === 0) {
                    var $cat = $step.find('[name="category_id"]');
                    var $brand = $step.find('[name="brand_id"]');
                    var $name = $step.find('[name="name"]');
                    if (!$cat.val() || $cat.val().trim().length < 1) { showError($cat, 'Category is required'); valid = false; }
                    if (!$brand.val() || $brand.val().trim().length < 1) { showError($brand, 'Brand is required'); valid = false; }
                    if (!$name.val() || $name.val().trim().length < 2) { showError($name, 'Enter a valid product name (min 2 chars)'); valid = false; }
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
                            } catch (e) { ok = false; }
                        } else {
                            var parts = c.split(',').map(function(p){return p.trim();}).filter(Boolean);
                            if (parts.length === 0) ok = false;
                        }
                        if (!ok) { showError($colors, 'Enter colors as JSON array or comma-separated list'); valid = false; }
                    }
                }

                // Media & Pricing (index 5) - optional checks for URL format
                if (index === 5) {
                    var $videoLink = $step.find('[name="video_link"]');
                    var v = $videoLink.val();
                    if (v && v.trim().length) {
                        try {
                            new URL(v);
                        } catch (e) {
                            showError($videoLink, 'Enter a valid URL'); valid = false;
                        }
                    }
                }

                // Extra Info / Price & Stock (index 6)
                if (index === 6) {
                    var $price = $step.find('[name="price"]');
                    var $discount = $step.find('[name="discount_price"]');
                    var $stock = $step.find('[name="stock"]');
                    var $ds = $step.find('[name="discount_start"]');
                    var $de = $step.find('[name="discount_end"]');

                    var priceVal = parseFloat($price.val());
                    if (!$.isNumeric($price.val()) || priceVal < 0) { showError($price, 'Enter a valid price'); valid = false; }

                    if ($discount.val()) {
                        var discVal = parseFloat($discount.val());
                        if (!$.isNumeric($discount.val()) || discVal < 0) { showError($discount, 'Enter a valid discount price'); valid = false; }
                        else if ($.isNumeric($price.val()) && discVal > priceVal) { showError($discount, 'Discount must be <= price'); valid = false; }
                    }

                    if ($stock.val() && (!Number.isInteger(Number($stock.val())) || Number($stock.val()) < 0)) { showError($stock, 'Enter a valid stock number'); valid = false; }

                    if ($ds.val() && $de.val()) {
                        var dsVal = Date.parse($ds.val());
                        var deVal = Date.parse($de.val());
                        if (isNaN(dsVal) || isNaN(deVal) || dsVal >= deVal) { showError($de, 'Discount end must be after start'); valid = false; }
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
                            } catch (e) { ok2 = false; }
                        } else {
                            var parts2 = t.split(',').map(function(p){return p.trim();}).filter(Boolean);
                            if (parts2.length === 0) ok2 = false;
                        }
                        if (!ok2) { showError($tags, 'Enter tags as JSON array or comma-separated list'); valid = false; }
                    }
                }

                return valid;
            }

            $(".next").click(function() {
                if (currentStep < totalSteps - 1) {
                    // validate current step before moving
                    if (!validateStepAt(currentStep)) {
                        var $first = $('.is-invalid').first();
                        if ($first.length) $('html, body').animate({ scrollTop: $first.offset().top - 100 }, 250);
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
                        if (!validateStepAt(i)) { overallValid = false; }
                    }
                    if (!overallValid) {
                        e.preventDefault();
                        var $first = $('.is-invalid').first();
                        if ($first.length) $('html, body').animate({ scrollTop: $first.offset().top - 100 }, 250);
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
            // Initialize Dropzones but don't auto-upload; we'll append files to the form on submit
            const mainDz = new Dropzone("#mainImageDropzone", {
                url: "#",
                autoProcessQueue: false,
                maxFiles: 1,
                addRemoveLinks: true,
                acceptedFiles: "image/*",
                init: function() {
                    this.on('addedfile', function(file) {
                        // If a new file is added when one already exists, remove the previous one
                        if (this.files && this.files.length > 1) {
                            // remove the first (old) file so only the newest remains
                            this.removeFile(this.files[0]);
                        }
                    });

                    this.on('maxfilesexceeded', function(file) {
                        // fallback: ensure only the most recent file is kept
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                }
            });

            const galleryDz = new Dropzone("#galleryDropzone", {
                url: "#",
                autoProcessQueue: false,
                maxFiles: 20,
                addRemoveLinks: true,
                acceptedFiles: "image/*",
                init: function() {
                    this.on('addedfile', function(file) {
                        try {
                            const url = URL.createObjectURL(file);
                            const img = document.createElement('img');
                            img.src = url;
                            img.dataset._previewUrl = url;
                            img.dataset._fileName = file.name;
                            img.alt = file.name;
                            document.getElementById('galleryPreview').appendChild(img);
                            // store reference for cleanup
                            file._galleryPreviewEl = img;
                        } catch (err) {
                            console.warn('Gallery preview error:', err);
                        }
                    });

                    this.on('removedfile', function(file) {
                        if (file && file._galleryPreviewEl) {
                            try {
                                if (file._galleryPreviewEl.parentNode) file._galleryPreviewEl
                                    .parentNode.removeChild(file._galleryPreviewEl);
                                if (file._galleryPreviewEl.dataset && file._galleryPreviewEl
                                    .dataset._previewUrl) URL.revokeObjectURL(file
                                    ._galleryPreviewEl.dataset._previewUrl);
                            } catch (e) {
                                /* ignore */
                            }
                        }
                    });
                }
            });

            const videoDz = new Dropzone("#videoDropzone", {
                url: "#",
                autoProcessQueue: false,
                maxFiles: 1,
                addRemoveLinks: true,
                acceptedFiles: "video/*",
                init: function() {
                    this.on('addedfile', function(file) {
                        if (this.files && this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }

                        // Create a video preview using an object URL
                        try {
                            const previewEl = file.previewElement;
                            if (previewEl) {
                                const video = document.createElement('video');
                                video.controls = true;
                                video.width = 200;
                                video.style.display = 'block';
                                video.style.marginTop = '8px';
                                const url = URL.createObjectURL(file);
                                video.src = url;
                                // store url so we can revoke it later
                                file._videoPreviewUrl = url;
                                previewEl.appendChild(video);
                            }
                        } catch (err) {
                            console.warn('Could not create video preview:', err);
                        }
                    });

                    this.on('removedfile', function(file) {
                        if (file && file._videoPreviewUrl) {
                            try {
                                URL.revokeObjectURL(file._videoPreviewUrl);
                            } catch (e) {
                                /* ignore */
                            }
                        }
                    });
                }
            });

            // On form submit, append files from Dropzones as hidden file inputs so the server receives them
            const form = document.getElementById('productForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // For each dropzone, add files as inputs
                    [
                        [mainDz, 'image'],
                        [galleryDz, 'gallery[]'],
                        [videoDz, 'video']
                    ].forEach(([dz, fieldName]) => {
                        dz.files.forEach((file) => {
                            const dt = new DataTransfer();
                            dt.items.add(file);
                            const input = document.createElement('input');
                            input.type = 'file';
                            input.name = fieldName;
                            input.files = dt.files;
                            input.style.display = 'none';
                            form.appendChild(input);
                        });
                    });
                });
            } else {
                console.warn('Product form not found; Dropzone will not append files on submit.');
            }
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
