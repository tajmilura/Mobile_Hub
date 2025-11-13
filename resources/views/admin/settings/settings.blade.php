@extends('admin.index')
@section('title', 'Website Settings')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-2 font-weight-bold" style="color: rgba(3,152,139,0.7);">Website Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Tabs -->
                <div class="col-md-3">
                    <div class="list-group shadow-sm" id="settingsTabs">
                        <a href="#" class="list-group-item list-group-item-action active" data-tab="general">General
                            Info</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="contact">Contact Info</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="seo">SEO Settings</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="social">Social Links</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="pages">Content Pages</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="footer">Footer</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="payment">Payment</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="smtp">Mail / SMTP</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="analytics">Analytics</a>
                        <a href="#" class="list-group-item list-group-item-action" data-tab="misc">Miscellaneous</a>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="col-md-9">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h4 class="mb-0">Update Settings</h4>
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
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- GENERAL --}}
                                <div class="settings-tab active" id="general">
                                    <h5 class="font-weight-bold text-info mb-3">General Information</h5>
                                    <div class="form-group">
                                        <label>Site Name</label>
                                        <input type="text" class="form-control" name="site_name"
                                            value="{{ old('site_name', $setting->site_name ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Site Title</label>
                                        <input type="text" class="form-control" name="site_title"
                                            value="{{ old('site_title', $setting->site_title ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Tagline</label>
                                        <input type="text" class="form-control" name="tagline"
                                            value="{{ old('tagline', $setting->tagline ?? '') }}">
                                    </div>
                                    <div class="form-row">
                                        {{-- Logo Upload with Preview --}}
                                        <div class="mb-3">
                                            <label>Site Logo</label><br>
                                            @if (!empty($setting->site_logo))
                                                <img id="logo-preview" src="{{ asset('storage/' . $setting->site_logo) }}"
                                                    alt="Logo" width="100" class="rounded mb-2 border">
                                            @else
                                                <img id="logo-preview" src="" width="100"
                                                    class="rounded mb-2 d-none border">
                                            @endif
                                            <input type="file" name="site_logo" class="form-control" accept="image/*"
                                                onchange="previewImage(this, 'logo-preview')">
                                        </div>

                                        {{-- Favicon Upload with Preview --}}
                                        <div class="mb-3">
                                            <label>Favicon</label><br>
                                            @if (!empty($setting->favicon))
                                                <img id="favicon-preview" src="{{ asset('storage/' . $setting->favicon) }}"
                                                    alt="Favicon" width="40" class="rounded mb-2 border">
                                            @else
                                                <img id="favicon-preview" src="" width="40"
                                                    class="rounded mb-2 d-none border">
                                            @endif
                                            <input type="file" name="favicon" class="form-control" accept="image/*"
                                                onchange="previewImage(this, 'favicon-preview')">
                                        </div>
                                    </div>
                                </div>

                                {{-- CONTACT --}}
                                <div class="settings-tab" id="contact">
                                    <h5 class="font-weight-bold text-info mb-3">Contact Information</h5>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', $setting->email ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ old('phone', $setting->phone ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Alternate Phone</label>
                                        <input type="text" class="form-control" name="phone_alt"
                                            value="{{ old('phone_alt', $setting->phone_alt ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" name="address">{{ old('address', $setting->address ?? '') }}</textarea>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6"><input type="text" name="city" placeholder="City"
                                                class="form-control mb-2"
                                                value="{{ old('city', $setting->city ?? '') }}"></div>
                                        <div class="col-md-6"><input type="text" name="state" placeholder="State"
                                                class="form-control mb-2"
                                                value="{{ old('state', $setting->state ?? '') }}"></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6"><input type="text" name="country" placeholder="Country"
                                                class="form-control mb-2"
                                                value="{{ old('country', $setting->country ?? '') }}"></div>
                                        <div class="col-md-6"><input type="text" name="zipcode" placeholder="Zipcode"
                                                class="form-control mb-2"
                                                value="{{ old('zipcode', $setting->zipcode ?? '') }}"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Google Map Embed Code</label>
                                        <textarea class="form-control" name="google_map_embed">{{ old('google_map_embed', $setting->google_map_embed ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- SEO --}}
                                <div class="settings-tab" id="seo">
                                    <h5 class="font-weight-bold text-info mb-3">SEO Settings</h5>
                                    <div class="form-group">
                                        <label>Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title"
                                            value="{{ old('meta_title', $setting->meta_title ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea class="form-control" name="meta_description">{{ old('meta_description', $setting->meta_description ?? '') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords"
                                            value="{{ old('meta_keywords', $setting->meta_keywords ?? '') }}">
                                    </div>
                                </div>

                                {{-- SOCIAL --}}
                                <div class="settings-tab" id="social">
                                    <h5 class="font-weight-bold text-info mb-3">Social Media Links</h5>
                                    @foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok'] as $social)
                                        <div class="form-group">
                                            <label>{{ ucfirst($social) }}</label>
                                            <input type="url" class="form-control" name="{{ $social }}"
                                                value="{{ old($social, $setting->$social ?? '') }}">
                                        </div>
                                    @endforeach
                                </div>

                                {{-- PAGES --}}
                                <div class="settings-tab" id="pages">
                                    <h5 class="font-weight-bold text-info mb-3">Website Pages</h5>
                                    @foreach (['about_us' => 'About Us', 'terms_conditions' => 'Terms & Conditions', 'privacy_policy' => 'Privacy Policy', 'refund_policy' => 'Refund Policy', 'shipping_policy' => 'Shipping Policy', 'faq' => 'FAQ'] as $key => $label)
                                        <div class="form-group">
                                            <label>{{ $label }}</label>
                                            <textarea class="form-control editor summernote" name="{{ $key }}">{{ old($key, $setting->$key ?? '') }}</textarea>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- FOOTER --}}
                                <div class="settings-tab" id="footer">
                                    <h5 class="font-weight-bold text-info mb-3">Footer</h5>
                                    <div class="form-group">
                                        <label>Footer Text</label>
                                        <textarea class="form-control" id="summernote" name="footer_text">{{ old('footer_text', $setting->footer_text ?? '') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Copyright Text</label>
                                        <input type="text" class="form-control" name="copyright_text"
                                            value="{{ old('copyright_text', $setting->copyright_text ?? '') }}">
                                    </div>
                                </div>

                                {{-- PAYMENT --}}
                                <div class="settings-tab" id="payment">
                                    <h5 class="font-weight-bold text-info mb-3">Payment Settings</h5>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>Currency</label>
                                            <input type="text" class="form-control" name="currency"
                                                value="{{ old('currency', $setting->currency ?? 'BDT') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Currency Symbol</label>
                                            <input type="text" class="form-control" name="currency_symbol"
                                                value="{{ old('currency_symbol', $setting->currency_symbol ?? '৳') }}">
                                        </div>
                                    </div>
                                    <div class="form-check mt-3">
                                        <input type="checkbox" class="form-check-input" name="cod_enabled"
                                            value="1" {{ !empty($setting->cod_enabled) ? 'checked' : '' }}>
                                        <label>Cash On Delivery Enabled</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="sslcommerz_enabled"
                                            value="1" {{ !empty($setting->sslcommerz_enabled) ? 'checked' : '' }}>
                                        <label>SSLCommerz Enabled</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="stripe_enabled"
                                            value="1" {{ !empty($setting->stripe_enabled) ? 'checked' : '' }}>
                                        <label>Stripe Enabled</label>
                                    </div>
                                </div>

                                {{-- SMTP --}}
                                <div class="settings-tab" id="smtp">
                                    <h5 class="font-weight-bold text-info mb-3">Mail / SMTP</h5>
                                    @foreach (['smtp_host' => 'SMTP Host', 'smtp_port' => 'SMTP Port', 'smtp_user' => 'SMTP User', 'smtp_password' => 'SMTP Password', 'smtp_encryption' => 'Encryption Type'] as $key => $label)
                                        <div class="form-group">
                                            <label>{{ $label }}</label>
                                            <input type="text" class="form-control" name="{{ $key }}"
                                                value="{{ old($key, $setting->$key ?? '') }}">
                                        </div>
                                    @endforeach
                                </div>

                                {{-- ANALYTICS --}}
                                <div class="settings-tab" id="analytics">
                                    <h5 class="font-weight-bold text-info mb-3">Analytics</h5>
                                    <div class="form-group">
                                        <label>Google Analytics ID</label>
                                        <input type="text" class="form-control" name="google_analytics_id"
                                            value="{{ old('google_analytics_id', $setting->google_analytics_id ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Facebook Pixel ID</label>
                                        <input type="text" class="form-control" name="facebook_pixel_id"
                                            value="{{ old('facebook_pixel_id', $setting->facebook_pixel_id ?? '') }}">
                                    </div>
                                </div>

                                {{-- MISC --}}
                                <div class="settings-tab" id="misc">
                                    <h5 class="font-weight-bold text-info mb-3">Miscellaneous</h5>
                                    <div class="form-group">
                                        <label>Timezone</label>
                                        <input type="text" class="form-control" name="timezone"
                                            value="{{ old('timezone', $setting->timezone ?? 'Asia/Dhaka') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Language</label>
                                        <input type="text" class="form-control" name="language"
                                            value="{{ old('language', $setting->language ?? 'en') }}">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="maintenance_mode"
                                            value="1" {{ !empty($setting->maintenance_mode) ? 'checked' : '' }}>
                                        <label>Enable Maintenance Mode</label>
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .list-group-item.active {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }

        .settings-tab {
            display: none;
        }

        .settings-tab.active {
            display: block;
            animation: fadeIn .3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('#settingsTabs a').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('#settingsTabs a').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.settings-tab').forEach(sec => sec.classList.remove('active'));
                this.classList.add('active');
                document.getElementById(this.dataset.tab).classList.add('active');
            });
        });
    </script>
    {{-- JS Preview Script --}}
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script>
        $(function() {
            // Summernote
            $('.summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
@endpush
