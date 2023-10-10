@extends('clients.layouts.auth')

@section('content')
<div class="card card-bordered">
    <div class="card-inner card-inner-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title">{{ __('Re-connexion') }}</h4>
            </div>
        </div>

        <form action="{{ route('password.confirm') }}" method="POST">
            @csrf

            <div class="form-group">
                <div class="form-label-group">
                    <label class="form-label" for="password">{{ __('Mot de passe') }}</label>
                    @if (Route::has('password.request'))
                        <a class="link link-primary link-sm" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié?') }}
                        </a>
                    @endif
                </div>
                <div class="form-control-wrap">
                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" placeholder="{{ __('Mot de passe') }}" name="password" required autocomplete="current-password">
                </div>

                @error('password')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary btn-block">
                    {{ __('Connexion') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
