  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('admin_dashboard') }}" class="brand-link">
          <img src="{{ asset('storage/' . getSetting('site_logo')) }}" alt="{{ getSetting('site_name') }}"
              class="brand-image img-circle elevation-3" style="opacity: 80">
          <span class="brand-text font-weight-light">Mobile Hub</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ Auth::user()->profile_photo_url ?? asset('default-avatar.png') }}" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info">
                  <a href="{{ route('admin.profile.edit') }}" class="d-block"> {{ Str::limit(Auth::user()->name, 12) }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item menu-open">
                      <a href="{{ route('admin_dashboard') }}" class="nav-link active">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                  </li>
                  <li class="nav-header">Products Management</li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-box-open"></i>
                          <p>
                              Product
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('product.create') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Product</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('product.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Products</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class=" nav-icon fas fa-solid fa-box-open"></i>
                          <p>
                              Brand
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('brand.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Brand</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p>
                              Category
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('category.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Category</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                 <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p>
                              Coupon
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('coupons.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Coupon</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p>
                              Slider & Banner
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('slider_banner.create') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Slider & Banner </p>
                              </a>
                          </li>
                           <li class="nav-item">
                              <a href="{{ route('category.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Slider & Banner </p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-header">Oder Management</li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-box-open"></i>
                          <p>
                             Order
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('order.all_order') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Orders</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('product.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Order Items</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-header">Payment Management</li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-box-open"></i>
                          <p>
                              Payment
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('admin.payment-methods.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add Payment Method</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-header">User Management</li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-box-open"></i>
                          <p>
                              Admin & Customer
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('admin.users.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Customer</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('product.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Admins</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                     <li class="nav-header">News Letters</li>
                  <li class="nav-item">
                      <a href="{{ route('newsletter.index') }}" class="nav-link">
                          <i class="nav-icon fas fa-ellipsis-h"></i>
                          <p>All News Letters</p>
                      </a>
                  </li>
                  <li class="nav-header">Website Management</li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-box-open"></i>
                          <p>
                              Settings
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('settings.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Settings</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('product.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Order Items</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-header">MISCELLANEOUS</li>
                  <li class="nav-item">
                      <a href="{{ route('admin_dashboard') }}" class="nav-link">
                          <i class="nav-icon fas fa-ellipsis-h"></i>
                          <p>{{ getSetting('site_name') }}</p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
