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
    <title>{{ __("Maintenance en cours") }} - {{ setting('config_ws_app_name') }}</title>

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('assets/global/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('assets/clients/plugins/global/plugins.bundle.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/clients/css/style.bundle.css') }}" type="text/css" />

</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat" style="background-image: url('{{ asset("assets/clients/media/auth/bg6.jpg") }}');">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <div class="d-flex flex-column flex-center text-center p-10">
                <div class="card card-flush w-lg-650px py-5">
                    <div class="card-body py-15 py-lg-20">
                        <div class="text-center mb-13">
                            <img src="{{ asset('assets/global/logo.png') }}" />
                        </div>

                        <h1 class="fw-bolder text-gray-900 mb-7">
                            {{ __("Maintenance en cours") }}
                        </h1>
                        <div class="fw-semibold fs-6 text-gray-500 mb-7">
                            {{ __("Nous sommes actuellement en train de procéder à une maintenance de routine pour améliorer les performances et ajouter de nouvelles fonctionnalités à notre application. Nous nous excusons pour tout inconvénient que cela pourrait causer et nous vous remercions de votre patience. Nous serons de retour en ligne dès que possible.") }}
                        </div>
                        <div class="fw-bold fs-4 text-gray-500 mt-4 mb-4">
                            {{ __("Merci de votre compréhension.") }}
                        </div>

                        <div class="mb-n5">
                            <img src="{{ asset('assets/clients/media/auth/chart-graph.png') }}" class="mw-100 mh-300px theme-light-show" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
