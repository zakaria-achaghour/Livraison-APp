@extends('clients.layouts.auth')

@section('title', __('S\'identifier'))

@section('content')
    <form action="{{ route('clients.login') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST">
        @csrf

        <div class="text-center mb-11">
            <img src="{{ asset('assets/global/logo.png') }}" />
        </div>

        <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mb-3">
                {{ __("S'identifier") }}
            </h1>
            <div class="text-gray-500 fw-semibold fs-5">
                {{ __("Accédez au panneau QuickLivraison.") }}
            </div>
        </div>


        <div class="row g-3 mb-9">
            <div class="col-md-12">
                <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                    <img class="h-15px me-3" src="{{ asset('assets/clients/media/svg/brand-logos/google-icon.svg') }}"/>
                    {{ __("Se connecter avec Google") }}
                </a>
            </div>
        </div>

        <div class="separator separator-content my-14">
            <span class="text-gray-500 fw-semibold fs-7" style="width: 100%;">{{ __("Ou avec votre email") }}</span>
        </div>

        @if($errors->any())
            <div id="alert-zone" class="alert alert-danger fs-5">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br/>
                @endforeach
            </div>
        @else
        <div id="alert-zone" class="d-none alert alert-danger fs-5"></div>
        @endif

        

        <div class="fv-row mb-8">
            <input type="email" placeholder="{{ __("Adresse E-mail") }}" name="email" class="form-control bg-transparent" />
        </div>

        <div class="fv-row mb-3">
            <input type="password" placeholder="{{ __("Mot de passe") }}" name="password" class="form-control bg-transparent" />
        </div>

        <div class="d-flex flex-stack flex-wrap gap-3 fs-6 fw-semibold mb-8">
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="remember" value="1">
                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                    {{ __('Mémoriser la session') }}
                </span>
            </label>

            <a href="{{ route('clients.password.request') }}" class="link-primary">
                {{ __("Mot de passe oublié?") }}
            </a>
        </div>

        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-success">
                <!--begin::Indicator label-->
                <span class="indicator-label">{{ __("S'identifier") }}</span>
                <span class="indicator-progress">
                    {{ __("Veuillez patienter ...") }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>

        <div class="text-gray-500 text-center fw-semibold fs-4">
            {{ __("Vous n'êtes pas utilisateur ? ") }}
            <a href="{{ route('clients.register') }}" class="link-primary">
                {{ __("S'inscrire") }}
            </a>
        </div>
    </form>
@endsection

@section('js')
<script src="{{ asset('assets/clients/js/locale/validation_'.app()->getLocale().'.js') }}"></script>
<script src="{{ asset('assets/clients/js/custom/authentication/sign-in/general.js') }}"></script>
@endsection