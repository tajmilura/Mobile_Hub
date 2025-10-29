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
                    <form method="POST" id="productForm" enctype="multipart/form-data" class="formDropzone">
                        @csrf
                        <!-- Progress Bar -->
                        <div class="progress mb-4 mx-5" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" id="formProgress" style="width: 0%;"></div>
                        </div>
                        <!-- Step 1: Category & Brand -->
                        <div class="step active">
                            <h4 class="text-center font-weight-bold my-3">Basic Info</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" class="form-control" placeholder="Category"
                                            name="category_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <input type="text" class="form-control" placeholder="Brand" name="brand_id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Product Name"
                                            name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" placeholder="Description" name="description"></textarea>
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
                                        <input type="text" class="form-control" name="colors">
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
                            <h4 class="text-center font-weight-bold my-3">Media & Pricing</h4>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header font-weight-bold">Main Image</div>
                                        <div class="card-body">
                                            <div id="mainImageDropzone" class="dropzone"></div>
                                            <small class="text-muted d-block mt-2">Recommended: 800x800px (1 file)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-header font-weight-bold">Gallery Images</div>
                                        <div class="card-body">
                                            <div id="galleryDropzone" class="dropzone"></div>
                                            <div id="galleryPreview" class="d-flex flex-wrap mt-2"></div>
                                            <small class="text-muted d-block mt-2">You can upload multiple images</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header font-weight-bold">Video</div>
                                        <div class="card-body">
                                            <div id="videoDropzone" class="dropzone"></div>
                                            <div id="videoPreviewContainer" class="mt-2"></div>
                                            <small class="text-muted d-block mt-2">Supported: mp4, webm (1 file)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>YouTube Video Link</label>
                                <input type="text" class="form-control" name="video_link">
                            </div>

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
                                        <label>Stock</label>
                                        <input type="number" class="form-control" name="stock">
                                    </div>
                                </div>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" name="is_featured" id="is_featured"
                                    checked data-bootstrap-switch data-on-color="success" data-off-color="danger">
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" name="is_new_arrival"
                                    id="is_new_arrival" checked data-bootstrap-switch data-on-color="success"
                                    data-off-color="danger">
                                <label class="form-check-label" for="is_new_arrival">New Arrival</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" name="is_hot_deal" id="is_hot_deal"
                                    checked data-bootstrap-switch data-on-color="success" data-off-color="danger">
                                <label class="form-check-label" for="is_hot_deal">Hot Deal</label>
                            </div>

                            <div class="d-flex justify-content-end my-3">
                                <button type="button" class="btn btn-secondary mr-2 prev">Previous</button>
                                <button type="button" class="btn btn-primary next">Next</button>
                            </div>

                        </div>
                        <!-- Step 7: Extra Info -->
                        <div class="step">
                            <h4 class="text-center font-weight-bold my-3">Extra Info</h4>

                            <div class="form-group">
                                <label>Warranty</label>
                                <input type="text" class="form-control" name="warranty" placeholder="e.g., 1 year">
                            </div>

                            <div class="form-group">
                                <label>Tags</label>
                                <input type="text" class="form-control" name="tags"
                                    placeholder='e.g., ["gaming", "android", "5G"]'>
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
        .step {
            display: none;
        }

        /* hide all steps by default */
        .step h3 {
            margin-bottom: 15px;
        }

        .step.active {
            display: block;
        }
        /* Dropzone preview tweaks */
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

            showStep(currentStep); // প্রথম step দেখাবে

            $(".next").click(function() {
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
                    "background-color": stepColors[currentStep]
                });
            }

            $(".next").click(function() {
                if (currentStep < totalSteps - 1) {
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
                          if (file._galleryPreviewEl.parentNode) file._galleryPreviewEl.parentNode.removeChild(file._galleryPreviewEl);
                          if (file._galleryPreviewEl.dataset && file._galleryPreviewEl.dataset._previewUrl) URL.revokeObjectURL(file._galleryPreviewEl.dataset._previewUrl);
                      } catch (e) { /* ignore */ }
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
                      try { URL.revokeObjectURL(file._videoPreviewUrl); } catch (e) { /* ignore */ }
                  }
              });
          }
      });

      // On form submit, append files from Dropzones as hidden file inputs so the server receives them
      const form = document.getElementById('productForm');
      if (form) {
          form.addEventListener('submit', function(e) {
              // For each dropzone, add files as inputs
              [[mainDz, 'main_image'], [galleryDz, 'gallery[]'], [videoDz, 'video']].forEach(([dz, fieldName]) => {
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
@endpush
