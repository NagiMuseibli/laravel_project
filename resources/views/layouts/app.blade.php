<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ url('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ url('assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">


    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.png') }}" />
    <!-- Link Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="{{ url('assets/vendors/flag-icon-css/css/staff.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>

<body>

    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="{{ route('orders') }}">Anbarhouse</a>
                <a class="sidebar-brand brand-logo-mini" href="{{ route('orders') }}">A</a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle " src="{{ URL::to('uploads\brands', $user->foto) }}"
                                    alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">{{ $user->name }} {{ $user->surname }}</h5>
                                @if ($user_id == 1)
                                    <span>ADMIN</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Anbar</span>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="/">
                        <span class="menu-icon">
                            <i class="mdi mdi-apple"></i>
                        </span>
                        <span class="menu-title">Brendlər</span>
                    </a>
                </li>


                <li class="nav-item menu-items">
                    <a class="nav-link" href="/products">
                        <span class="menu-icon">
                            <i class="mdi mdi-cellphone-android"></i>
                        </span>
                        <span class="menu-title">Məhsullar</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="/clients">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-multiple-plus"></i>
                        </span>
                        <span class="menu-title">Müştərilər</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="/xerc">
                        <span class="menu-icon">
                            <i class="mdi mdi-currency-usd"></i>
                        </span>
                        <span class="menu-title">Xərclər</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="/orders">
                        <span class="menu-icon">
                            <i class="mdi mdi-basket-fill"></i>
                        </span>
                        <span class="menu-title">Sifarişlər</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ route('credit') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-credit-card"></i>
                        </span>
                        <span class="menu-title">Kredit</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                        aria-controls="ui-basic">
                        <span class="menu-icon">
                            <i class="mdi mdi-laptop"></i>
                        </span>
                        <span class="menu-title">Tapşırıq meneceri</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('komendant') }}">Komendant</a>
                            </li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('layihe') }}">Layihələr</a></li>
                        </ul>
                    </div>
                </li>

                @if ($user_id == 1)
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="{{ route('messages') }}">
                            <span class="menu-icon">
                                <i class="mdi mdi-comment-processing-outline"></i>
                            </span>
                            <span class="menu-title">Mesajlar</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ route('staff') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-comment-processing-outline"></i>
                        </span>
                        <span class="menu-title">Staff</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img
                            src="{{ url('assets/images/logo-mini.svg') }}" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">

                            @yield('axtar')

                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">

                        @if ($user_id == 1)
                            <li class="nav-item dropdown border-left">
                                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown"
                                    href="#" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-email"></i>
                                    @if ($messages_alert->count() > 0)
                                        <span class="count bg-success"></span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                    aria-labelledby="messageDropdown">
                                    <h6 class="p-3 mb-0">Messages</h6>

                                    @foreach ($messages_alert as $message_alert)
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item preview-item"
                                            href="{{ route('message', $message_alert->id) }}">
                                            <div class="preview-thumbnail">
                                                <img src="{{ url('uploads/brands/nopic.png') }}" alt="image"
                                                    class="rounded-circle profile-pic">
                                            </div>
                                            <div class="preview-item-content">
                                                <p class="preview-subject ellipsis mb-1">{{ $message_alert->email }}
                                                </p>
                                                <p class="text-muted mb-0"> {{ $message_alert->created_at }} </p>
                                            </div>
                                        </a>
                                    @endforeach

                                    <div class="dropdown-divider"></div>
                                    @if ($messages_alert->count() > 0)
                                        <p class="p-3 mb-0 text-center">{{ $messages_alert->count() ?? 0 }} New
                                            Messages</p>
                                    @else
                                        <p class="p-3 mb-0 text-center">Doesn't have any messages</p>
                                    @endif
                                </div>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle"
                                        src="{{ URL::to('uploads\brands', $user->foto) }}" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ $user->name }}
                                        {{ $user->surname }}</p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Profile</h6>


                                <a class="dropdown-item preview-item" href="{{ route('profile.index') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-account"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Profile</p>
                                    </div>
                                </a>


                                @if ($user_id == 1)
                                    <a class="dropdown-item preview-item" href="{{ route('admin.index') }}">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-dark rounded-circle">
                                                <i class="mdi mdi-account"></i>
                                            </div>
                                        </div>
                                        <div class="preview-item-content">
                                            <p class="preview-subject mb-1">Admin</p>
                                        </div>
                                    </a>
                                @endif
                                <a class="dropdown-item preview-item" href="{{ route('staff') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-account"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Staff</p>
                                    </div>
                                </a>



                                <a class="dropdown-item preview-item" href="{{ route('cixis') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Log out</p>
                                    </div>
                                </a>

                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">Advanced settings</p>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card corona-gradient-card">
                                <div class="card-body py-0 px-0 px-sm-3">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-sm-3 col-xl-2">
                                            <img src="{{ url('assets/images/dashboard/Group126@2x.png') }}"
                                                class="gradient-corona-img img-fluid" alt="">
                                        </div>
                                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                                            <h4 class="mb-1 mb-sm-0">Want even more features?</h4>
                                            <p class="mb-0 font-weight-normal d-none d-sm-block">Check out our Pro
                                                version with 5 unique layouts!</p>
                                        </div>
                                        <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
                                            <span>
                                                <a href="https://www.bootstrapdash.com/product/corona-admin-template/"
                                                    target="_blank"
                                                    class="btn btn-outline-light btn-rounded get-started-btn">Upgrade
                                                    to PRO</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0">Brendlər</h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                {{ $bsay }}
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Ümumi say</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0">Məhsullar</h3>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                {{ $psay }}
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Ümumi say</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0">Müştərilər</h3>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                {{ $csay }}
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Ümumi say</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0">Sifarişlər</h3>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                {{ $osay + $ksay }}
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">
                                        Nağd: {{ $osay }}<br>
                                        Kredit: {{ $ksay }}
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0">Aktiv</h3>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                {{ $aktiv_mehsul }}
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Məhsullar</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0">Bitmiş</h3>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-danger ">
                                                {{ $bitmis_mehsul }}
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Məhsullar</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0">Ümumi</h3>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            @php
                                                $cemmehsul = 0;
                                                $cemalis = 0;
                                                $cemsatis = 0;
                                                $qazanc = 0;
                                                
                                                foreach ($mehsul as $info) {
                                                    $cemmehsul = $info->miqdar + $cemmehsul;
                                                    $cemalis = $info->miqdar * $info->alis + $cemalis;
                                                    $cemsatis = $info->miqdar * $info->satis + $cemsatis;
                                                    $qazanc = ($info->satis - $info->alis) * $info->miqdar + $qazanc;
                                                }
                                                
                                                $a = 0;
                                                $faiz = 0;
                                                $faizqazanc = 0;
                                                
                                                foreach ($umimicredit as $info) {
                                                    $a = ($info->satis - $info->alis) * $info->sifarissayi;
                                                
                                                    $faiz = $info->faiz;
                                                    $faizqazanc = $a + +($a * $faiz) / 100;
                                                }
                                                
                                                $cqazanc = 0;
                                                foreach ($carimehsul as $info) {
                                                    $cqazanc = $info->cqazanc + $cqazanc;
                                                }
                                                
                                                $cemxerc = 0;
                                                foreach ($xerc as $info) {
                                                    $cemxerc = $info->mebleg + $cemxerc;
                                                }
                                                
                                            @endphp
                                            @if ($qazanc + $faizqazanc + $cqazanc - $cemxerc >= $faizqazanc + $cqazanc - $cemxerc)
                                                <div class="icon icon-box-success ">
                                                    {{ number_format($qazanc + $faizqazanc + $cqazanc - $cemxerc, 2, '.', '') }}
                                                </div>
                                            @else
                                                <div class="icon icon-box-danger ">
                                                    {{ number_format($qazanc + $faizqazanc + $cqazanc - $cemxerc, 2, '.', '') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Qazanc</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0">Cari</h3>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            @php
                                                $cqazanc = 0;
                                                foreach ($carimehsul as $info) {
                                                    $cqazanc = $info->cqazanc + $cqazanc;
                                                }
                                                
                                                $mebleg = 0;
                                                
                                                $faizqazanc = 0;
                                                
                                                foreach ($caricredit as $info) {
                                                    $mebleg = $info->mebleg;
                                                    $faizqazanc = $mebleg + $faizqazanc;
                                                }
                                                
                                                $cemxerc = 0;
                                                foreach ($xerc as $info) {
                                                    $cemxerc = $info->mebleg + $cemxerc;
                                                }
                                                
                                            @endphp

                                            @if ($cqazanc + $faizqazanc > 0)
                                                <div class="icon icon-box-success ">
                                                    {{ number_format($cqazanc + $faizqazanc - $cemxerc, 2, '.', '') }}
                                                </div>
                                            @else
                                                <div class="icon icon-box-danger ">

                                                    {{ number_format($cqazanc + $faizqazanc - $cemxerc, 2, '.', '') }}
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Qazanc</h6>
                                </div>
                            </div>
                        </div>
                    </div>





                    @yield('brands')
                    @yield('profile')
                    @yield('admin')
                    @yield('staff')
                    @yield('komendant')
                    @yield('layihe')
                    @yield('message')
                    @yield('messages')
                    @yield('document')
                    @yield('products')
                    @yield('clients')
                    @yield('xerc')
                    @yield('orders')
                    @yield('credit')
                    @yield('login')


                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                                Anbarhouse {{ date('Y') }}</span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="{{ url('assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{ url('assets/vendors/chart.js/Chart.min.js') }}"></script>
        <script src="{{ url('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
        <script src="{{ url('assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
        <script src="{{ url('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ url('assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{ url('assets/js/off-canvas.js') }}"></script>
        <script src="{{ url('assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ url('assets/js/misc.js') }}"></script>
        <script src="{{ url('assets/js/settings.js') }}"></script>
        <script src="{{ url('assets/js/todolist.js') }}"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src="{{ url('assets/js/dashboard.js') }}"></script>
        <!-- End custom js for this page -->
</body>

</html>
