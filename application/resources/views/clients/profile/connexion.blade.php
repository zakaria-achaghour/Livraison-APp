@extends('clients.profile.layouts')

@section('title', __("Méthode de connexion"))

@php
	$user = auth()->user();
@endphp

@section('breadcrumb')
<li class="breadcrumb-item">
    <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> 
</li>

<li class="breadcrumb-item text-gray-700 fw-bold lh-1">
    {{ __("Méthode de connexion") }} 
</li>
@endsection

@section('block')
<div class="card mb-5">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ __("Méthode de connexion") }} </h3>
        </div>
    </div>

    <div id="kt_account_settings_signin_method" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="d-flex flex-wrap align-items-center">
                <div id="kt_signin_email">
                    <div class="fs-6 fw-bold mb-1">{{ __('Adresse électronique') }}</div>
                    <div class="fw-semibold text-gray-600">{{ $user->email }}</div>
                </div>
                <!--end::Label-->
                <!--begin::Edit-->
                <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                    <form id="kt_signin_change_email" action="{{ route('clients.email.change') }}" method="POST" class="form" novalidate="novalidate">
                    	@csrf
                        <div class="row mb-6">
                            <div class="col-lg-12 mb-4 mb-lg-0">
                                <div class="fv-row mb-0">
                                    <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">
	                                    {{ __('Entrez une nouvelle adresse e-mail') }}
	                                </label>
                                    <input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="{{ __('Adresse électronique') }}" name="email" value="{{ $user->email }}" required />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button id="kt_signin_submit" type="button" class="btn btn-primary  me-2 px-6">
                            	<span class="indicator-label">{{ __("Mettre à jour") }}</span>
                                <span class="indicator-progress">
                                    {{ __("Veuillez patienter ...") }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">{{ __("Annuler") }}</button>
                        </div>
                    </form>
                </div>

                <div id="kt_signin_email_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">{{ __("Changer E-mail") }}</button>
                </div>
            </div>

            <div class="separator separator-dashed my-6"></div>

            <div class="d-flex flex-wrap align-items-center mb-10">
                <div id="kt_signin_password">
                    <div class="fs-6 fw-bold mb-1">{{__("Mot de passe")}}</div>
                    <div class="fw-semibold text-gray-600">************</div>
                </div>

                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                    <form id="kt_signin_change_password" action="{{ route('clients.profile.password') }}" method="POST" class="form" novalidate="novalidate">
                    	@csrf
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">
                                    	{{ __('Ancien mot de passe') }}
                                    </label>
                                    <input type="password" class="form-control form-control-lg form-control-solid " name="old_password" id="currentpassword" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="newpassword" class="form-label fs-6 fw-bold mb-3">
                                    	{{ __('Nouveau mot de passe') }}
                                    </label>
                                    <input type="password" class="form-control form-control-lg form-control-solid " name="password" id="newpassword" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">
                                    	{{ __('Confirmation mot de passe') }}
                                    </label>
                                    <input type="password" class="form-control form-control-lg form-control-solid " name="password_confirmation" id="confirmpassword" />
                                </div>
                            </div>
                        </div>
                        <div class="form-text mb-5">
                        	{{ __("Utilisez 8 caractères ou plus avec une combinaison de lettres, de chiffres et de symboles. (Exemple: Abcd@123") }}
                        </div>
                        <div class="d-flex">
                            <button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">
                            	<span class="indicator-label">{{ __("Mettre à jour") }}</span>
                                <span class="indicator-progress">
                                    {{ __("Veuillez patienter ...") }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">{{ __('Annuler') }}</button>
                        </div>
                    </form>
                </div>

                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">{{ __("Modifier Mot de passe") }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('after_js')
<script type="text/javascript">
var KTAccountSettingsSigninMethods = function() {
    var t, e, n, o, i, s, r, a, l, d = function() {
            e.classList.toggle("d-none"), s.classList.toggle("d-none"), n.classList.toggle("d-none")
        },
        c = function() {
            o.classList.toggle("d-none"), a.classList.toggle("d-none"), i.classList.toggle("d-none")
        };
    return {
        init: function() {
            var m;
            t = document.getElementById("kt_signin_change_email"), e = document.getElementById("kt_signin_email"), n = document.getElementById("kt_signin_email_edit"), o = document.getElementById("kt_signin_password"), i = document.getElementById("kt_signin_password_edit"), s = document.getElementById("kt_signin_email_button"), r = document.getElementById("kt_signin_cancel"), a = document.getElementById("kt_signin_password_button"), l = document.getElementById("kt_password_cancel"), e && (s.querySelector("button").addEventListener("click", (function() {
                    d()
                })), r.addEventListener("click", (function() {
                    d()
                })), a.querySelector("button").addEventListener("click", (function() {
                    c()
                })), l.addEventListener("click", (function() {
                    c()
                }))), t.querySelector("#kt_signin_submit").addEventListener("click", function(e) {
                    e.preventDefault();

                    t.querySelector("#kt_signin_submit").setAttribute("data-kt-indicator", "on");
                    t.querySelector("#kt_signin_submit").disabled = !0;

                	const formData = new FormData(t);

		            fetch(t.action, {method: 'POST',body: formData})
		            .then(response => response.json())
		            .then(data => {
		            	t.querySelector("#kt_signin_submit").setAttribute("data-kt-indicator", "off");
	                    t.querySelector("#kt_signin_submit").disabled = !1;

	                    swal.fire({
                            text: data.message,
                            icon: data.success ? "success" : "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
            			});

                        if(data.success) {
                            setTimeout(function() {
                                location.reload();
                            },1200)
                        }
        			});
	            }),
                function(t) {
                    var e, n = document.getElementById("kt_signin_change_password");
                    
                    n.querySelector("#kt_password_submit").addEventListener("click", function(t) {
                        t.preventDefault();
                        
                        n.querySelector("#kt_password_submit").setAttribute("data-kt-indicator", "on");
	                    n.querySelector("#kt_password_submit").disabled = !0;

	                	const formData = new FormData(n);

			            fetch(n.action, {method: 'POST',body: formData})
			            .then(response => response.json())
			            .then(data => {
			            	n.querySelector("#kt_password_submit").setAttribute("data-kt-indicator", "off");
		                    n.querySelector("#kt_password_submit").disabled = !1;

		                    swal.fire({
	                            html: data.message,
	                            icon: data.success ? "success" : "error",
	                            buttonsStyling: !1,
	                            confirmButtonText: "Ok",
	                            customClass: {
	                                confirmButton: "btn font-weight-bold btn-light-primary"
	                            }
	            			});
	        			});
                    });
                }()
        }
    }
}();
KTUtil.onDOMContentLoaded((function() {
    KTAccountSettingsSigninMethods.init()
}));
</script>
@endsection