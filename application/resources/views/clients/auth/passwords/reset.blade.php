@extends('clients.layouts.auth')

@section('title', __('Réinitialiser le mot de passe'))

@section('content')
<form class="form w-100" method="POST" action="{{ route('clients.password.update') }}" id="kt_new_password_form">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <div class="text-center mb-11">
        <img src="{{ asset('assets/global/logo.png') }}" />
    </div>

    <div class="text-center mb-10">
        <h1 class="text-dark fw-bolder mb-3">
            {{ __("Configurer un nouveau mot de passe") }}
        </h1>

        <div class="text-gray-500 fw-semibold fs-6">
            {{ __("Avez-vous déjà réinitialisé le mot de passe ?") }}
            <a href="{{ route('clients.login') }}" class="link-primary fw-bold">
                {{ __("Se connecter") }}
            </a>
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

    <div class="fv-row mb-8" data-kt-password-meter="true">
        <div class="mb-1">
            <div class="position-relative mb-3">
                <input class="form-control bg-transparent" type="password" placeholder="{{ __('Nouveau mot de passe') }}" name="password" autocomplete="off" required/>
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                    <i class="ki-outline ki-eye-slash fs-2"></i> 
                    <i class="ki-outline ki-eye fs-2 d-none"></i> 
                </span>
            </div>

            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
            </div>
        </div>
    </div>

    <div class="fv-row mb-8">
        <input type="password" placeholder="{{ __('Confirmez le mot de passe') }}" name="password_confirmation" autocomplete="off" class="form-control bg-transparent" required />
    </div>

    <div class="d-grid mb-10">
        <button type="submit" class="btn btn-success" id="kt_new_password_submit">
            <span class="indicator-label">
                {{ __('Réinitialiser le mot de passe') }}
            </span>
        </button>
    </div>
    <!--end::Action-->
</form>
@endsection

@section('js')
<script src="{{ asset('assets/clients/js/locale/validation_'.app()->getLocale().'.js') }}"></script>
<script type="text/javascript">
    KTUtil.onDOMContentLoaded((function() {
        var form = document.querySelector("#kt_new_password_form");
        var o = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));
        var button = document.querySelector("#kt_new_password_submit")


        // Validation
        var validation = FormValidation.formValidation(form, {
            localization: current_locale == 'ar' ? ar_MA : fr_FR,
            fields: {
                "password": {
                    validators: {
                        notEmpty: {},
                        callback: {
                            callback: function(t) {
                                if (t.value.length > 0) return o.getScore() == 100
                            },
                            message : '{{ __("Utilisez 8 caractères ou plus avec une combinaison de lettres, de chiffres et de symboles. (Exemple: Abcd@123") }}'
                        }
                    }
                },
                "password_confirmation": {
                    validators: {
                        notEmpty: {},
                        identical: {
                            compare: function() {
                                return form.querySelector('[name="password"]').value
                            },
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger({
                    event: {
                        password: !1
                    }
                }),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: ""
                })
            }
        });

        form.querySelector('input[name="password"]').addEventListener("input", (function() {
            this.value.length > 0 && validation.updateFieldStatus("password", "NotValidated")
        }));


        button.addEventListener("click", function(e) {
            e.preventDefault();
            validation.revalidateField("password");
            validation.validate().then(function(r) {
                if(r == "Valid") {
                    form.submit();
                }
            });
        });
    }));
</script>
@endsection
