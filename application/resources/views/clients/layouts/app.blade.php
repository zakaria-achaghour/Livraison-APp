<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Author -->
    <meta name="author" content="{{ config('settings.author.name') }}">

    <!-- Title -->
    <title>@yield('title') - {{ setting('config_ws_app_name') }}</title>

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('assets/global/favicon.ico') }}">

    <!-- Styles -->
    <link href="{{ asset("assets/clients/plugins/global/plugins.bundle.css") }}" rel="stylesheet"  />
    <link href="{{ asset("assets/clients/css/style.bundle.css") }}" rel="stylesheet" />
    
    <script type="application/javascript">
        full_url = '{{ url('') }}';
        current_locale = '{{ app()->getLocale() }}';
    </script>
    
    @yield('after_css')

    <!-- Javascript -->
    <script src="{{ asset("assets/clients/plugins/global/plugins.bundle.js") }}"></script>
    <script src="{{ asset("assets/clients/js/scripts.bundle.js") }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var currentUrl = window.location.href;
        $(document).ready(function() {
            @yield('currentUrl')
            
            var menuItems = document.querySelectorAll('.app-sidebar .menu-item a');

            for (var i = 0; i < menuItems.length; i++) {
                if (menuItems[i].href == currentUrl) {
                    menuItems[i].classList.add('active');

                    // Check if the parent menu item has the "has-submenu" class
                    var parentMenuItem = menuItems[i].closest('.menu-sub');
                    if (parentMenuItem) {
                        parentMenuItem.classList.add('show');
                    }
                }
            }

            setTimeout(function(){ 
                $('.preloader').fadeOut(300, function() {
                    $('body').removeClass('preloader-body');
                }); 
            }, 800);
        });
    </script>   
</head>
<body id="kt_app_body" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="preloader">
            <span class="loader2"></span>
        </div>

        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">

            @include('clients.layouts.inc.topbar')

            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">
                <div class="app-container container-xxxl d-flex flex-row-fluid ">

                    @include('clients.layouts.inc.sidebar')

                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

                        @yield('content')

                        @include('clients.layouts.inc.footer')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @yield('start_js')
    @yield('after_js')
    @yield('end_js')
</body>

</html>