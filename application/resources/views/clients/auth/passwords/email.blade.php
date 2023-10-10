@extends('clients.layouts.auth')

@section('title', __('Réinitialiser le mot de passe'))

@section('content')
<form class="form w-100" method="POST" action="{{ route('clients.password.email') }}">
    @csrf

    <div class="text-center mb-11">
        <img src="{{ asset('assets/global/logo.png') }}" />
    </div>

    <div class="text-center mb-10">
        <h1 class="text-dark fw-bolder mb-3">
            {{ __('Réinitialiser le mot de passe') }}
        </h1>

        <div class="text-gray-500 fw-semibold fs-6">
            {{ __('Si vous avez oublié votre mot de passe, nous vous enverrons par e-mail des instructions pour réinitialiser votre mot de passe.')}}
        </div>

    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach
        </div>
    @endif

    <div class="fv-row mb-8">
        <input type="text" placeholder="{{ __('Adresse E-mail') }}" name="email" autocomplete="off" class="form-control bg-transparent" />
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success">
            <span class="indicator-label">
                {{ __('Envoyer le lien de réinitialisation') }}
            </span>
        </button>
    </div>

    <div class="separator separator-content my-8">
        <span class="text-gray-500 fw-semibold fs-7" style="width: 100%;">{{ __("Ou") }}</span>
    </div>

    <div class="d-flex justify-content-center">
        <a href="{{ route('clients.login') }}" class="btn btn-light">
            {{ __('Retour à la page de connexion') }}
        </a>
    </div>
</form>
@endsection