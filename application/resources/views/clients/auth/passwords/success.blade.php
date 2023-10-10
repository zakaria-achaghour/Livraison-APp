@extends('clients.layouts.auth')

@section('title', __('Félicitations'))

@section('content')
 <div class="text-center mb-11">
    <img src="{{ asset('assets/global/logo.png') }}" />
</div>

<div class="text-center mb-5 mt-10">
	<i class="ki-outline ki-verify fs-5x text-success"></i>
</div>

<div class="text-center mb-10">

    <h1 class="text-dark fw-bolder mb-3">
        {{ __('Félicitations') }}
    </h1>

    <div class="text-gray-500 fw-semibold fs-6">
        {{ __('Vous pouvez maintenant vous connecter à votre compte avec votre nouveau mot de passe.') }}
    </div>
</div>

<div class="d-grid mb-10">
    <a href="{{ route('clients.login') }}" class="btn btn-success">
        <span class="indicator-label">
            {{ __('Retour à la page de connexion') }}
        </span>
    </a>
</div>
@endsection