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
    
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="bg-body rounded-4 p-10">
                <div class="d-flex flex-column flex-column-fluid ">
                <div class="text-center mb-11">
                    <img src="{{ asset('assets/global/logo.png') }}" />
                </div>
                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">
                        {{ __("S'inscrire") }}
                    </h1>
                </div>
    
                <div class="row g-3 mb-9">
                    <div class="col-md-12">
                        <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                            <img class="h-15px me-3" src="{{ asset('assets/clients/media/svg/brand-logos/google-icon.svg') }}" />
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
    
                <!-- Registration Form -->
                <form action="{{ route('clients.register') }}" 
                class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST">
                    @csrf
                    <!-- Your form fields here -->
                    <div class="row g-2 mb-9">
                        <!-- First Name Field -->
                        <div class="col-md-8">
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("FullName") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-user fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-solid form-control-md ps-12"
                                           type="text" placeholder="{{ __("FullName") }}" name="fullName" 
                                           autocomplete="off" data-kt-translate="sign-up-input-first-name"
                                           value="{{ old('fullName') }}" />
                                </div>
                            </div>
                        </div>
        
                        <!-- Last Name Field -->
                        <div class="col-md-4">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label">{{ __("CINE") }}</label>
                                <div class="position-relative">
                                    <input class="form-control form-control-md form-control-solid ps-12"
                                           type="text" placeholder="CINE" name="cine" autocomplete="off"
                                           value="{{ old('cine') }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  mb-9">
                        <div class="col-md">      
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("Adresse E-mail") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-send fs-3"></i>
                                    </div>
                                    <input type="email" placeholder="{{ __("Adresse E-mail") }}" name="email" 
                                           class="form-control form-control-solid form-control-md ps-12"
                                           value="{{ old('email') }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  mb-9">
                          <!--begin::Input group-->
                          <div class="fv-row mb-10" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">    
                                    <input class="form-control form-control-md form-control-solid" type="password" placeholder="{{ __("Password") }}" name="password" autocomplete="off" data-kt-translate="sign-up-input-password"/>
                    
                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                        <i class="ki-outline ki-eye-slash fs-2"></i>                    <i class="ki-outline ki-eye fs-2 d-none"></i>                </span>
                                </div>
                                <!--end::Input wrapper-->
                    
                                <!--begin::Meter-->
                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                </div>
                                <!--end::Meter-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Hint-->
                            <div class="text-muted" data-kt-translate="sign-up-hint">
                                {{ __("Use 8 or more characters with a mix of letters, numbers & symbols.") }}
                            </div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group--->
                    
                        <!--begin::Input group-->
                        <div class="fv-row mb-10"> 
                            <input class="form-control form-control-md form-control-solid" type="password" placeholder="{{__("Confirm Password")}}" name="password_confirmation" autocomplete="off" data-kt-translate="sign-up-input-confirm-password" />
                        </div>
                    </div>

                    <div class="separator separator-content my-14">
                        <span class="text-gray-500 fw-semibold fs-7" style="width: 100%;">{{ __("Additional information") }}</span>
                    </div>
                    <div class="row g-2 mb-9">
                        <div class="col-md-6 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("Store Name") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-shop fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-solid ps-12" name="storeName"
                                           placeholder="{{ __("Store Name") }}" value="{{ old('storeName') }}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("Company type") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-route fs-3"></i>
                                    </div>
                                    <select class="form-select form-control form-control-solid" name="companyType" data-control="select2" aria-label="Select example">
                                        <option>{{ __("Company type") }}</option>
                                         @foreach ($companyTypes as $companyType)
                                            <option value="{{$companyType->id}}" 
                                                {{ old('companyType') == $companyType->id ? 'selected' : '' }}
                                                >{{$companyType->name}}</option>
                                         @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label">{{ __("Site web") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-click fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-solid ps-12" name="siteWeb"
                                           placeholder="{{ __("Site web") }}"
                                           value="{{ old('siteWeb') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("Phone Number") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-whatsapp fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-solid ps-12" name="phone"
                                    placeholder="{{ __("Phone Number") }}" value="{{ old('phone') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("City") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-route fs-3"></i>
                                    </div>
                                    <select class="form-select form-control form-control-solid" 
                                            data-control="select2" aria-label="Select example" name="city">
                                        <option>{{ __("City") }}</option>
                                         @foreach ($cities as $city)
                                            <option value="{{$city->name}}"
                                                {{ old('city') == $city->name ? 'selected' : '' }}
                                                >{{$city->name}}</option>
                                         @endforeach
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label required">{{ __("Address") }}</label>
                                <div class="position-relative">
                                    <textarea name="address" class="form-control form-control-solid" placeholder="{{ __("Address") }}" data-kt-autosize="true" rows="4">
                                        {{ old('address') }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-success">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">{{ __("S'inscrire") }}</span>
                            <span class="indicator-progress">
                                {{ __("Veuillez patienter ...") }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    
                    <div class="text-gray-500 text-center fw-semibold fs-4">
                        {{ __("Vous avez déjà un compte ?") }}
                        <a href="{{ route('clients.login') }}" class="link-primary">
                            {{ __("S'identifier") }}
                        </a>
                    </div>
                </form>
    
                <!-- Add more forms or content here -->
            </div>

            <div class="d-flex ">
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
    
    

    <!-- Javascript -->
    <script type="text/javascript">
        current_locale = '{{ app()->getLocale() }}';
    </script>
    <script src="{{ asset('assets/clients/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/clients/js/scripts.bundle.js') }}"></script>
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
</body>

</html>