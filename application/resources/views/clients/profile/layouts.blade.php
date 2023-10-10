@extends('clients.layouts.app')

@section('title')
	@yield('title')
@endsection

@section('after_js')
	@yield('after_js')
@endsection

@php
	$user = auth()->user();
@endphp

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
        <!--begin::Toolbar container-->
        <div class="d-flex flex-stack flex-row-fluid">
            <!--begin::Toolbar container-->
            <div class="d-flex flex-column flex-row-fluid">
                <!--begin::Toolbar wrapper-->
                <!--begin::Page title-->
                <div class="page-title d-flex align-items-center me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Paramètres du compte") }}</span>
                    </h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-3 fs-7">
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="{{ route('clients.home')}}" class="text-white text-hover-primary">
                            <i class="ki-outline ki-home text-gray-700 fs-6"></i> 
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> 
                    </li>

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        {{ __("Paramètres du compte") }} 
                    </li>

                    @yield('breadcrumb')
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div class="card mb-3 mb-xl-5">
            <div class="card-body px-lg-8 p-0">
                <ul class="nav nav-fill nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary m-0 p-6 {{ route('clients.profile.index') == url()->current() ? "active" : "" }} " href="{{ route('clients.profile.index') }}">
                            <span class="d-block d-lg-none fs-1">
                                <i class="ki-duotone ki-user-edit fs-32px">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                </i>   
                            </span>
                            
                            <span class="d-none d-lg-block">{{ __("Détails du profil") }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-active-primary m-0 p-6 {{ route('clients.profile.connexion') == url()->current() ? "active" : "" }} " href="{{ route('clients.profile.connexion') }}">
                            <span class="d-blokc d-lg-none">
                                <i class="ki-duotone ki-lock-2 fs-32px">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                </i>   
                            </span>
                            
                            <span class="d-none d-lg-block">{{ __("Méthode de connexion") }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-active-primary m-0 p-6 {{ route('clients.profile.paiement') == url()->current() ? "active" : "" }} " href="{{ route('clients.profile.paiement') }}">
                            <span class="d-blokc d-lg-none fs-1">
                                <i class="ki-duotone ki-two-credit-cart fs-32px">
                                 <i class="path1"></i>
                                 <i class="path2"></i>
                                 <i class="path3"></i>
                                 <i class="path4"></i>
                                 <i class="path5"></i>
                                </i>
                            </span>
                            
                            <span class="d-none d-lg-block">{{ __("Mode de paiement") }}</span>
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>

        @yield('block')
    </div>

</div>
@endsection