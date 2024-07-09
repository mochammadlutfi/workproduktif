<header id="page-header">
    <div class="border-bottom">
        <div class="content-header">
            <!-- Left Section -->
            <div class="d-flex align-items-center space-x-3">
                <!-- Logo -->
                <a href="{{ route('admin.beranda') }}">
                    <img src="/images/logo.png" width="140px">
                </a>
                <!-- END Logo -->
            </div>
            <!-- END Left Section -->
    
            <!-- Right Section -->
            <div class="space-x-1">
                <!-- Open Search Section -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                    data-action="header_search_on">
                    <i class="fa fa-fw fa-search opacity-50 me-1"></i>
                    <span>Search</span>
                </button>
                <!-- END Open Search Section -->
    
                <!-- Toggle Sidebar -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout"
                    data-action="sidebar_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <!-- END Toggle Sidebar -->
                <!-- User Dropdown -->
                <div class="dropdown d-inline-block">
                    <a type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user d-sm-none"></i>
                            <span class="d-none d-sm-inline-block fw-semibold">{{ Auth::guard('admin')->user()->nama }}</span>
                        <i class="fa fa-angle-down opacity-50 ms-1"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0"
                        aria-labelledby="page-header-user-dropdown">
                        <div class="px-2 py-3 bg-body-light rounded-top">
                            <h5 class="h6 text-center mb-0">
                                {{ Auth::guard('admin')->user()->nama }}
                            </h5>
                        </div>
                        <div class="p-2">
                            <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                                href="{{ route('admin.profile.edit') }}">
                                <span>Profil</span>
                                <i class="fa fa-fw fa-user opacity-25"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.password') }}">
                                <span>Ubah Password</span>
                                <i class="fa fa-fw fa-envelope-open opacity-25"></i>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                                    :href="route('admin.logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <span>Keluar</span>
                                    <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END User Dropdown -->
            </div>
            <!-- END Right Section -->
        </div>
    </div>
    <!-- Header Content -->
    <div class="bg-primary">
        <div class="menu-header">
            <!-- Left Section -->
            <div class="space-x-1">
                <x-menu class="nav-main nav-main-horizontal nav-main-hover d-none d-lg-block"/>
            </div>
            <!-- END Left Section -->
        </div>
    </div>
    <!-- END Header Content -->
</header>