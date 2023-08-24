<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Art Fashion Inventory Apps</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.css" rel="stylesheet">
    
    {{-- Loading CSS --}}
    <link href="/css/loading.css" rel="stylesheet">
    {{-- ENd Loading CSS --}}

    {{-- Mix JS and CSS --}}
    <script src="{!! mix('js/app.js') !!}"></script>
    <link rel="stylesheet" href="{!! mix('css/app.css') !!}">
    <!-- CSS Libraries -->
    {{-- block plugins_css %}{% endblock --}}
    @yield('topscripts')

    <script src="https://unpkg.com/js-big-decimal@1.3.1/dist/web/js-big-decimal.min.js"></script>
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('../assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/css/custom.css') }}">
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> --}}
</head>

<body onload="hide_loading()">
    <div class="loading overlay">
        <div class="lds-roller">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
    </div>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ asset('../assets/img/avatar/avatar-1.png') }}"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ session('name') }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="/mwarna">ArtFashion Inventory</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="/mwarna">AI</a>
                    </div>
                    @include('layouts.sidebar')
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Swifect Copyright &copy; 2022 <div class="bullet"></div>
                    <span>Designed By Namex (Anak Me...)</span>
                </div>                
                <div class="footer-right">
                    v 01.0.0 BETA
                </div>
            </footer>
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    
    {{-- <script src="../assets/js/stisla.js"></script> --}}
    <script src="{{ asset('../assets/js/stisla.js') }}"></script>
    <script src="{{ asset('../assets/js/moneyformat.js') }}"></script>

    <!-- JS Libraies -->
    @yield('pluginjs')
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.min.js"></script>

    {{-- Bottom Javascript --}}
    @yield('botscripts')
    <script type="text/javascript">
        let fadeTarget = document.querySelector(".loading")
        function show_loading(){
            fadeTarget.style.display = "block";
            fadeTarget.style.opacity = 1;
        }
        function hide_loading(){
            // fadeTarget.style.display = "none";
            var fadeEffect = setInterval(() => {
                if (!fadeTarget.style.opacity){
                    fadeTarget.style.opacity = 1;
                }
                if (fadeTarget.style.opacity > 0){
                    fadeTarget.style.opacity -= 1;
                } else {
                    clearInterval(fadeEffect);
                    fadeTarget.style.display = "none";
                }
            }, 300);
        }
    </script>
    <!-- Page Specific JS File -->
    {{-- {% block page_js %}{% endblock %} --}}
</body>

</html>