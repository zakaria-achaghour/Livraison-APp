@extends('clients.layouts.app')

@section('title', __('Edit Collection'))

@section('after_css')
<style>
    .image-input-placeholder {
        background-image: url('{{ asset('assets/clients/media/svg/files/blank-image.svg') }}');
    }

    [data-bs-theme="dark"] .image-input-placeholder {
        background-image: url('{{ asset('assets/clients/media/svg/files/blank-image-dark.svg') }}');
    }                
</style>
@endsection

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
        <div class="d-flex flex-stack flex-row-fluid">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="page-title d-flex align-items-center me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Edit Collection") }}</span>
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
                        <a href="{{ route('clients.requests.pickups.index') }}" class="text-gray-700 text-hover-primary">
                        {{ __('Collection') }} 
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("Edit Collection") }} </li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection

@section('after_js')
<script src="{{ asset('assets/clients/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script></script>
@endsection