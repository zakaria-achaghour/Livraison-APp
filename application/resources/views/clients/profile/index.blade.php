@extends('clients.profile.layouts')

@section('title', __('Profile'))

@php
	$user = auth()->user();
@endphp

@section('breadcrumb')
<li class="breadcrumb-item">
    <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> 
</li>

<li class="breadcrumb-item text-gray-700 fw-bold lh-1">
    {{ __("Détails du profil") }} 
</li>
@endsection

@section('block')
<div id="kt_app_content" class="flex-column-fluid ">
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="me-lg-7 mb-4 text-center">
                            <div class="symbol symbol-80px symbol-lg-160px symbol-fixed position-relative">
                                <div class="symbol-label fs-1 fw-semibold bg-primary text-inverse-primary">
                                    {{ $user->getAvatarLetters() }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column">
                            <div class="d-flex flex-column align-items-center align-items-lg-start">
                                <div class="mb-2">
                                    <a href="javascript:;" class="text-gray-900 text-hover-primary text-capitalize fs-2 fw-bold me-1">{{ $user->name }}</a>
                                </div>

                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <a href="javascript:;" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-outline ki-profile-circle fs-4 me-1"></i> 
                                        {{ $user->type == "CUSTOMER" ? __("Client") : __("Staff") }}
                                    </a>
                                    <a href="javascript:;" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-outline ki-geolocation fs-4 me-1"></i> 
                                        {{ $user->store }}
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center justify-content-lg-start">
                                <div :class="['border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mx-2 mb-3 placeholder-loader', {'holder-active' : is_loading_parcels}]">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-outline ki-truck fs-3 text-success me-2"></i>
                                        <div class="fs-2 fw-bold">
                                            @{{ num_parcels }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400">{{ __('Colis') }}</div> 
                                </div>

                                <div :class="['border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mx-2 mb-3 placeholder-loader', {'holder-active' : is_loading_invoices}]">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-outline ki-dollar fs-3 text-success me-2"></i>
                                        <div class="fs-2 fw-bold">
                                             @{{ num_invoices }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400">{{ __("Factures") }}</div>
                                </div>
                            </div>
                        </div>        
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ __("Détails du profil") }} </h3>
        </div>
    </div>

    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __('Nom') }}</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800 text-capitalize">{{ $user->name }}</span>
            </div>
        </div>

        @if($user->store)
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __('Store') }}</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800 text-uppercase">{{ $user->store }}</span>
            </div>
        </div>
        @endif

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __('Numéro de téléphone') }}</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $user->phone }}</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __('Ville') }}</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6 text-uppercase">{{ $user->city }}</span>
            </div>
        </div>

        @if($user->address)
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __('Adresse') }}</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6 text-uppercase">{{ $user->address }}</span>
            </div>
        </div>
        @endif

        @if($user->website)
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __('Site web') }}</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $user->website }}</span>
            </div>
        </div>
        @endif

        @if($user->brand)
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __('Mon business') }}</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6 text-uppercase">{{ $user->brand }}</span>
            </div>
        </div>
        @endif

        @if($companyType = $user->companyType()->first())
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">{{ __("Type d'entereprise") }}</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $companyType->name }}</span>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('after_js')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script type="module">
        const { createApp } = Vue;
        console.warn = () => {};

        createApp({
            data() {
                return {
                    is_loading_invoices: true,
                    is_loading_parcels : true,
                    num_invoices : null,
                    num_parcels : null
                }
            },
            mounted() {
                this.load();
            },
            methods: {
                load : function() {
                    this.is_loading_invoices = true;
                    this.is_loading_parcels = true;

                    fetch('{{ route('clients.profile.num-invoices') }}', {method: 'GET'})
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                this.is_loading_invoices = false;
                                this.num_invoices = data.numInvoices;    
                            }
                            
                        });

                    fetch('{{ route('clients.profile.num-parcels') }}', {method: 'GET'})
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                this.is_loading_parcels = false;
                                this.num_parcels = data.numParcels;    
                            }
                            
                        });
                }
            }
        }).mount('#kt_app_body');
    </script>
@endsection