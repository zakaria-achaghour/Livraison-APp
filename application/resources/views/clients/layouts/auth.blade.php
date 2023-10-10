<!DOCTYPE html>
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

    <link rel="stylesheet" href="{{ asset('assets/clients/plugins/global/plugins.bundle.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/clients/css/style.bundle.css') }}" type="text/css" />

    @if(app()->getLocale() == "ar")
    <link rel="stylesheet" href="{{ asset('assets/clients/css/style.rtl.bundle.css') }}" type="text/css" />
    @endif
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">

    <div class="d-flex flex-column flex-root" id="kt_app_root">

        <style>
            body {
                background-image: url("{{ asset('assets/clients/media/auth/bg10.jpg') }}");
            }
        </style>

        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <!--begin::Content-->
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-450px">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

                            @yield('content')

                        </div>

                        <div class="d-flex justify-content-center">
                            @php
                                $locales =  [
                                    'fr' => 'Français',
                                    'ar' => 'العربية'
                                ]
                            @endphp
                            <div class="me-10">
                                <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                    <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ asset('assets/global/flags/'. app()->getLocale() .'.svg') }}" alt="">
                                    <span data-kt-element="current-lang-name" class="me-1">{{ $locales[app()->getLocale()]}}</span>
                                    <i class="ki-outline ki-down fs-5 text-muted rotate-180 m-0"></i> 
                                </button>

                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                                    @foreach($locales as $locale => $name)
                                        @if($locale != app()->getLocale())
                                        <div class="menu-item px-3">
                                            <a href="{{ route('clients.language.switch', ['locale' => $locale]) }}" class="menu-link d-flex px-5" data-kt-lang="ar">
                                                <span class="symbol symbol-20px me-4">
                                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/global/flags/'.$locale.'.svg') }}" alt="">
                                                </span>
                                                <span data-kt-element="lang-name">{{ $name }}</span>
                                            </a>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="d-none d-lg-flex flex-lg-row-fluid">
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">

                    <img class="theme-light-show mx-auto mw-100 mb-10 mb-lg-20" src="{{ asset('assets/clients/media/auth/promo-a.png') }}" alt="" />

                    <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
                        {{ __("Quicklivraison Panel") }}
                    </h1>

                    <div class="text-gray-600 fs-5 text-center fw-semibold" style="max-width: 400px;">
                        {{ __("Vous pouvez commencer à créer facilement vos colis grâce à sa conception conviviale et à sa mise en page réactive la plus complète.") }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Javascript -->
    <script type="text/javascript">
        current_locale = '{{ app()->getLocale() }}';
    </script>
    <script src="{{ asset('assets/clients/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/clients/js/scripts.bundle.js') }}"></script>

    @yield('js')
</body>

</html>