<!DOCTYPE html>
<html lang="fr">

    @include('layouts.header')

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Preloader -->
            {{-- <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
            </div> --}}

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    {{-- <li class="nav-item d-none d-sm-inline-block">
                        <a href="index3.html" class="nav-link">Accueil</a>
                    </li> --}}
                    {{-- <li class="nav-item d-none d-sm-inline-block text-center text-bold bg-success p-1">
                        <span class="text-center">{{ exercice(parametre()->exercice_id)->libelle }}</span> <br>
                        <span>({{ devise(parametre()->devise_id)->libelle }})</span>
                    </li> --}}
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li> --}}
                    {{-- <li class="nav-item text-center text-bold bg-danger px-3 mr-3">
                        <span class="text-center">{{ parametre()->exercice->libelle }}</span> <br>
                        <span>Devise {{ parametre()->devise->libelle }}</span>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('parametre')}}" role="button">
                        <i class="fas fa-cogs"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}" role="button">
                        <i class="fas fa-power-off text-danger"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->           

            {{-- @yield('sidebar') --}}
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">            

                @yield('content')

            </div>
            <!-- /.content-wrapper -->

            @include('layouts.footer')

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{compta_asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{compta_asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{compta_asset('plugins/toastr/toastr.min.js')}}"></script>
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>

        @yield('scripts')

        <!-- AdminLTE App -->
        <script src="{{compta_asset('dist/js/adminlte.js')}}"></script>

        @if (session('success') && !is_array(session('error')))  
            <script>
                toastr.success("{{session('success')}}");
            </script>
        @endif
        @if (session('info'))  
            <script>
                toastr.info("{{session('info')}}");
            </script>
        @endif
        @if (session('error') && !is_array(session('error')))  
            <script>
                toastr.error("{{session('error')}}");
            </script>
        @endif
        @if (session('warning'))  
            <script>
                toastr.warning("{{session('warning')}}");
            </script>
        @endif

    </body>
</html>
