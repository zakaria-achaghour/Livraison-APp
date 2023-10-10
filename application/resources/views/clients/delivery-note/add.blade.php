@extends('clients.layouts.app')

@section('title', __('Nouveau Bon de Livraison'))

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
        <div class="d-flex flex-stack flex-row-fluid">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="page-title d-flex align-items-center me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Nouveau Bon de Livraison") }}</span>
                    </h1>
                </div>

                <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-3 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="{{ route('clients.home') }}" class="text-white text-hover-primary">
                            <i class="ki-outline ki-home text-gray-700 fs-6"></i> </a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> 
                    </li>

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        {{ __('Colis') }} 
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("Bon de Livraison") }} </li>
                </ul>
            </div>
        </div>
    </div>

    @php
    $count_new_parcels = request()->user()->newParcels()->count();
    @endphp

    <div id="kt_app_content" class="app-content pt-2 flex-column-fluid ">
        @if($count_new_parcels == 0)
        <div class="card card-flush pt-3 mb-5">
            <div class="card-body pb-2">
                <div class="d-flex align-items-center justify-content-center" style="flex: 1;min-height: 50vh;">
                    <div style="text-align: center;">
                        <i class="ki-duotone ki-information-4 text-warning fs-7x mb-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                            <i class="path3"></i>
                        </i>
                        <h5 class="fs-3 text-center">{{ __("Aucun nouveau colis trouvé") }}</h5>
                        <p class="fs-5">
                            {{ __('Veuillez ajouter au moins un colis pour créer un nouveau bon de livraison.') }}
                        </p>
                        <a class="btn btn-success" href="{{ route('clients.parcels.add') }}">{{ __('Nouveau colis') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <form action="{{ route('clients.delivery-note.save') }}" method="POST" id="parcel_form">
            <div class="card card-flush pt-3 mb-5">
                <div class="card-body pb-2">
                    

                </div>

                <div class="card-footer py-6">
                    <button type="submit" class="btn btn-primary w-sm-auto w-100" @click="this.save" :disabled="is_adding">
                        <span class="indicator-label" v-if="!is_adding">{{ __("Enregister") }}</span>
                        <span class="indicator-progress d-block" v-if="is_adding">
                            {{ __("Veuillez patienter ...") }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@section('after_js')
<script src="{{ asset('assets/global/js/vue.js') }}"></script>
<script type="module">
    const { createApp } = Vue;
    console.warn = () => {};

    createApp({
        data() {
            return {
                is_adding : false
            }
        },
        mounted() {
            
        },
        methods: {

        }
    }).mount('#parcel_form');
</script>
@endsection