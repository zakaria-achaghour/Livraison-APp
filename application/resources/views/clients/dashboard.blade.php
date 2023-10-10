@extends('clients.layouts.app')

@section('title')
{{ __('Tableau de bord') }}
@endsection

@section('after_css')
	<link href="{{ asset("assets/clients/plugins/custom/fullcalendar/fullcalendar.bundle.css") }}" rel="stylesheet" />
	<link href="{{ asset("assets/clients/plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" />
@endsection

@section('content')
	<div class="d-flex flex-column flex-column-fluid">                       <!--begin::Toolbar-->
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
	                        <span><span class="fw-light">Welcome back</span>,&nbsp;Adam</span>
	                        <!--begin::Description-->
	                        <span class="page-desc text-gray-600 fs-base fw-semibold">
	                            You are logged in as a Cloud Owner </span>
	                        <!--end::Description-->
	                    </h1>
	                    <!--end::Title-->
	                </div>
	                <!--end::Page title-->
	            </div>
	            <!--end::Toolbar container-->
	            <!--begin::Actions-->
	            <div class="d-flex align-self-center flex-center flex-shrink-0">
	                <a href="#" class="btn btn-sm btn-success d-flex flex-center ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
	                    <i class="ki-outline ki-plus-square fs-2"></i>
	                    <span>Invite</span>
	                </a>
	                <a href="#" class="btn btn-sm btn-dark ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">
	                    Create <span class="d-none d-sm-inline">Target</span>
	                </a>
	            </div>
	            <!--end::Actions-->
	        </div>
	        <!--end::Toolbar container-->
	    </div>
	    <!--end::Toolbar-->
	    <!--begin::Content-->
	    <div id="kt_app_content" class="app-content  flex-column-fluid ">
	        <!--begin::Row-->
	        <div class="row g-5 g-xl-10 mb-5 mb-xl-0">
	            <!--begin::Col-->
	            <div class="col-md-4 mb-xl-10">
	                <!--begin::Card widget 28-->
	                <div class="card card-flush ">
	                    <!--begin::Header-->
	                    <div class="card-header pt-7">
	                        <!--begin::Card title-->
	                        <div class="card-title flex-stack flex-row-fluid">
	                            <!--begin::Symbol-->
	                            <div class="symbol symbol-45px me-5">
	                                <span class="symbol-label bg-light-info">
	                                    <i class="ki-outline ki-instagram fs-2x text-gray-800"></i> </span>
	                            </div>
	                            <!--end::Symbol-->
	                            <!--begin::Wrapper-->
	                            <div class="me-n2">
	                                <!--begin::Badge-->
	                                <span class="badge badge-light-success align-self-center fs-base">
	                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i> 2.2%
	                                </span>
	                                <!--end::Badge-->
	                            </div>
	                            <!--end::Wrapper-->
	                        </div>
	                        <!--end::Header-->
	                    </div>
	                    <!--end::Card title-->
	                    <!--begin::Card body-->
	                    <div class="card-body d-flex align-items-end">
	                        <!--begin::Wrapper-->
	                        <div class="d-flex flex-column">
	                            <span class="fw-bolder fs-2x text-dark">$65,209.00</span>
	                            <span class="fw-bold fs-7 text-gray-500">SAP UI Progress</span>
	                        </div>
	                        <!--end::Wrapper-->
	                    </div>
	                    <!--end::Card body-->
	                </div>
	                <!--end::Card widget 28-->
	            </div>
	            <!--end::Col-->
	            <!--begin::Col-->
	            <div class="col-md-4 mb-xl-10">
	                <!--begin::Card widget 28-->
	                <div class="card card-flush ">
	                    <!--begin::Header-->
	                    <div class="card-header pt-7">
	                        <!--begin::Card title-->
	                        <div class="card-title flex-stack flex-row-fluid">
	                            <!--begin::Symbol-->
	                            <div class="symbol symbol-45px me-5">
	                                <span class="symbol-label bg-light-info">
	                                    <i class="ki-outline ki-microsoft fs-2x text-gray-800"></i> </span>
	                            </div>
	                            <!--end::Symbol-->
	                            <!--begin::Wrapper-->
	                            <div class="me-n2">
	                                <!--begin::Badge-->
	                                <span class="badge badge-light-danger align-self-center fs-base">
	                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>
	                                    2.5% </span>
	                                <!--end::Badge-->
	                            </div>
	                            <!--end::Wrapper-->
	                        </div>
	                        <!--end::Header-->
	                    </div>
	                    <!--end::Card title-->
	                    <!--begin::Card body-->
	                    <div class="card-body d-flex align-items-end">
	                        <!--begin::Wrapper-->
	                        <div class="d-flex flex-column">
	                            <span class="fw-bolder fs-2x text-dark">$6,526.00</span>
	                            <span class="fw-bold fs-7 text-gray-500">SAP UI Progress</span>
	                        </div>
	                        <!--end::Wrapper-->
	                    </div>
	                    <!--end::Card body-->
	                </div>
	                <!--end::Card widget 28-->
	            </div>
	            <!--end::Col-->
	            <!--begin::Col-->
	            <div class="col-md-4 mb-xl-10">
	                <!--begin::Card widget 28-->
	                <div class="card card-flush ">
	                    <!--begin::Header-->
	                    <div class="card-header pt-7">
	                        <!--begin::Card title-->
	                        <div class="card-title flex-stack flex-row-fluid">
	                            <!--begin::Symbol-->
	                            <div class="symbol symbol-45px me-5">
	                                <span class="symbol-label bg-light-info">
	                                    <i class="ki-outline ki-apple fs-2x text-gray-800"></i> </span>
	                            </div>
	                            <!--end::Symbol-->
	                            <!--begin::Wrapper-->
	                            <div class="me-n2">
	                                <!--begin::Badge-->
	                                <span class="badge badge-light-success align-self-center fs-base">
	                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i> 2.7%
	                                </span>
	                                <!--end::Badge-->
	                            </div>
	                            <!--end::Wrapper-->
	                        </div>
	                        <!--end::Header-->
	                    </div>
	                    <!--end::Card title-->
	                    <!--begin::Card body-->
	                    <div class="card-body d-flex align-items-end">
	                        <!--begin::Wrapper-->
	                        <div class="d-flex flex-column">
	                            <span class="fw-bolder fs-2x text-dark">$45,142.00</span>
	                            <span class="fw-bold fs-7 text-gray-500">SAP UI Progress</span>
	                        </div>
	                        <!--end::Wrapper-->
	                    </div>
	                    <!--end::Card body-->
	                </div>
	                <!--end::Card widget 28-->
	            </div>
	            <!--end::Col-->
	        </div>
	        <!--end::Row-->
	        <!--begin::Row-->
	        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
	            <!--begin::Col-->
	            <div class="col-xl-6">
	                <!--begin::List widget 23-->
	                <div class="card card-flush h-xl-100">
	                    <!--begin::Header-->
	                    <div class="card-header pt-7">
	                        <!--begin::Title-->
	                        <h3 class="card-title align-items-start flex-column">
	                            <span class="card-label fw-bold text-gray-800">Lading Teams</span>
	                            <span class="text-gray-400 mt-1 fw-semibold fs-6">8k social visitors</span>
	                        </h3>
	                        <!--end::Title-->
	                        <!--begin::Toolbar-->
	                        <div class="card-toolbar">
	                        </div>
	                        <!--end::Toolbar-->
	                    </div>
	                    <!--end::Header-->
	                    <!--begin::Body-->
	                    <div class="card-body pt-5">
	                        <!--begin::Items-->
	                        <div class="">
	                            <!--begin::Item-->
	                            <div class="d-flex flex-stack">
	                                <!--begin::Section-->
	                                <div class="d-flex align-items-center me-5">
	                                    <!--begin::Flag-->
	                                    <img src="assets/media/svg/brand-logos/atica.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
	                                    <!--end::Flag-->
	                                    <!--begin::Content-->
	                                    <div class="me-5">
	                                        <!--begin::Title-->
	                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Abstergo Ltd.</a>
	                                        <!--end::Title-->
	                                        <!--begin::Desc-->
	                                        <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Community</span>
	                                        <!--end::Desc-->
	                                    </div>
	                                    <!--end::Content-->
	                                </div>
	                                <!--end::Section-->
	                                <!--begin::Wrapper-->
	                                <div class="d-flex align-items-center">
	                                    <!--begin::Number-->
	                                    <span class="text-gray-800 fw-bold fs-4 me-3">579</span>
	                                    <!--end::Number-->
	                                    <!--begin::Info-->
	                                    <div class="m-0">
	                                        <!--begin::Label-->
	                                        <span class="badge badge-light-success fs-base">
	                                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>
	                                            2.6%
	                                        </span>
	                                        <!--end::Label-->
	                                    </div>
	                                    <!--end::Info-->
	                                </div>
	                                <!--end::Wrapper-->
	                            </div>
	                            <!--end::Item-->
	                            <!--begin::Separator-->
	                            <div class="separator separator-dashed my-3"></div>
	                            <!--end::Separator-->
	                            <!--begin::Item-->
	                            <div class="d-flex flex-stack">
	                                <!--begin::Section-->
	                                <div class="d-flex align-items-center me-5">
	                                    <!--begin::Flag-->
	                                    <img src="assets/media/svg/brand-logos/telegram-2.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
	                                    <!--end::Flag-->
	                                    <!--begin::Content-->
	                                    <div class="me-5">
	                                        <!--begin::Title-->
	                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Binford Ltd.</a>
	                                        <!--end::Title-->
	                                        <!--begin::Desc-->
	                                        <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Social Media</span>
	                                        <!--end::Desc-->
	                                    </div>
	                                    <!--end::Content-->
	                                </div>
	                                <!--end::Section-->
	                                <!--begin::Wrapper-->
	                                <div class="d-flex align-items-center">
	                                    <!--begin::Number-->
	                                    <span class="text-gray-800 fw-bold fs-4 me-3">2,588</span>
	                                    <!--end::Number-->
	                                    <!--begin::Info-->
	                                    <div class="m-0">
	                                        <!--begin::Label-->
	                                        <span class="badge badge-light-danger fs-base">
	                                            <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>
	                                            0.4%
	                                        </span>
	                                        <!--end::Label-->
	                                    </div>
	                                    <!--end::Info-->
	                                </div>
	                                <!--end::Wrapper-->
	                            </div>
	                            <!--end::Item-->
	                            <!--begin::Separator-->
	                            <div class="separator separator-dashed my-3"></div>
	                            <!--end::Separator-->
	                            <!--begin::Item-->
	                            <div class="d-flex flex-stack">
	                                <!--begin::Section-->
	                                <div class="d-flex align-items-center me-5">
	                                    <!--begin::Flag-->
	                                    <img src="assets/media/svg/brand-logos/balloon.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
	                                    <!--end::Flag-->
	                                    <!--begin::Content-->
	                                    <div class="me-5">
	                                        <!--begin::Title-->
	                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Barone LLC.</a>
	                                        <!--end::Title-->
	                                        <!--begin::Desc-->
	                                        <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Messanger</span>
	                                        <!--end::Desc-->
	                                    </div>
	                                    <!--end::Content-->
	                                </div>
	                                <!--end::Section-->
	                                <!--begin::Wrapper-->
	                                <div class="d-flex align-items-center">
	                                    <!--begin::Number-->
	                                    <span class="text-gray-800 fw-bold fs-4 me-3">794</span>
	                                    <!--end::Number-->
	                                    <!--begin::Info-->
	                                    <div class="m-0">
	                                        <!--begin::Label-->
	                                        <span class="badge badge-light-success fs-base">
	                                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>
	                                            0.2%
	                                        </span>
	                                        <!--end::Label-->
	                                    </div>
	                                    <!--end::Info-->
	                                </div>
	                                <!--end::Wrapper-->
	                            </div>
	                            <!--end::Item-->
	                            <!--begin::Separator-->
	                            <div class="separator separator-dashed my-3"></div>
	                            <!--end::Separator-->
	                            <!--begin::Item-->
	                            <div class="d-flex flex-stack">
	                                <!--begin::Section-->
	                                <div class="d-flex align-items-center me-5">
	                                    <!--begin::Flag-->
	                                    <img src="assets/media/svg/brand-logos/kickstarter.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
	                                    <!--end::Flag-->
	                                    <!--begin::Content-->
	                                    <div class="me-5">
	                                        <!--begin::Title-->
	                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Abstergo Ltd.</a>
	                                        <!--end::Title-->
	                                        <!--begin::Desc-->
	                                        <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Video Channel</span>
	                                        <!--end::Desc-->
	                                    </div>
	                                    <!--end::Content-->
	                                </div>
	                                <!--end::Section-->
	                                <!--begin::Wrapper-->
	                                <div class="d-flex align-items-center">
	                                    <!--begin::Number-->
	                                    <span class="text-gray-800 fw-bold fs-4 me-3">1,578</span>
	                                    <!--end::Number-->
	                                    <!--begin::Info-->
	                                    <div class="m-0">
	                                        <!--begin::Label-->
	                                        <span class="badge badge-light-success fs-base">
	                                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>
	                                            4.1%
	                                        </span>
	                                        <!--end::Label-->
	                                    </div>
	                                    <!--end::Info-->
	                                </div>
	                                <!--end::Wrapper-->
	                            </div>
	                            <!--end::Item-->
	                            <!--begin::Separator-->
	                            <div class="separator separator-dashed my-3"></div>
	                            <!--end::Separator-->
	                            <!--begin::Item-->
	                            <div class="d-flex flex-stack">
	                                <!--begin::Section-->
	                                <div class="d-flex align-items-center me-5">
	                                    <!--begin::Flag-->
	                                    <img src="assets/media/svg/brand-logos/vimeo.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
	                                    <!--end::Flag-->
	                                    <!--begin::Content-->
	                                    <div class="me-5">
	                                        <!--begin::Title-->
	                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Biffco Enterprises</a>
	                                        <!--end::Title-->
	                                        <!--begin::Desc-->
	                                        <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
	                                        <!--end::Desc-->
	                                    </div>
	                                    <!--end::Content-->
	                                </div>
	                                <!--end::Section-->
	                                <!--begin::Wrapper-->
	                                <div class="d-flex align-items-center">
	                                    <!--begin::Number-->
	                                    <span class="text-gray-800 fw-bold fs-4 me-3">3,458</span>
	                                    <!--end::Number-->
	                                    <!--begin::Info-->
	                                    <div class="m-0">
	                                        <!--begin::Label-->
	                                        <span class="badge badge-light-success fs-base">
	                                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>
	                                            8.3%
	                                        </span>
	                                        <!--end::Label-->
	                                    </div>
	                                    <!--end::Info-->
	                                </div>
	                                <!--end::Wrapper-->
	                            </div>
	                            <!--end::Item-->
	                            <!--begin::Separator-->
	                            <div class="separator separator-dashed my-3"></div>
	                            <!--end::Separator-->
	                            <!--begin::Item-->
	                            <div class="d-flex flex-stack">
	                                <!--begin::Section-->
	                                <div class="d-flex align-items-center me-5">
	                                    <!--begin::Flag-->
	                                    <img src="assets/media/svg/brand-logos/plurk.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
	                                    <!--end::Flag-->
	                                    <!--begin::Content-->
	                                    <div class="me-5">
	                                        <!--begin::Title-->
	                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Big Kahuna Burger</a>
	                                        <!--end::Title-->
	                                        <!--begin::Desc-->
	                                        <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
	                                        <!--end::Desc-->
	                                    </div>
	                                    <!--end::Content-->
	                                </div>
	                                <!--end::Section-->
	                                <!--begin::Wrapper-->
	                                <div class="d-flex align-items-center">
	                                    <!--begin::Number-->
	                                    <span class="text-gray-800 fw-bold fs-4 me-3">2,047</span>
	                                    <!--end::Number-->
	                                    <!--begin::Info-->
	                                    <div class="m-0">
	                                        <!--begin::Label-->
	                                        <span class="badge badge-light-success fs-base">
	                                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>
	                                            1.9%
	                                        </span>
	                                        <!--end::Label-->
	                                    </div>
	                                    <!--end::Info-->
	                                </div>
	                                <!--end::Wrapper-->
	                            </div>
	                            <!--end::Item-->
	                        </div>
	                        <!--end::Items-->
	                    </div>
	                    <!--end: Card Body-->
	                </div>
	                <!--end::List widget 23-->
	            </div>
	            <!--end::Col-->
	            <!--begin::Col-->
	            <div class="col-xl-6">
	                <!--begin::Chart Widget 33-->
	                <div class="card card-flush h-xl-100">
	                    <!--begin::Header-->
	                    <div class="card-header pt-5 mb-6">
	                        <!--begin::Title-->
	                        <h3 class="card-title align-items-start flex-column">
	                            <!--begin::Statistics-->
	                            <div class="d-flex align-items-center mb-2">
	                                <!--begin::Currency-->
	                                <span class="fs-3 fw-semibold text-gray-400 align-self-start me-1">$</span>
	                                <!--end::Currency-->
	                                <!--begin::Value-->
	                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">3,274.94</span>
	                                <!--end::Value-->
	                                <!--begin::Label-->
	                                <span class="badge badge-light-success fs-base">
	                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>
	                                    9.2%
	                                </span>
	                                <!--end::Label-->
	                            </div>
	                            <!--end::Statistics-->
	                            <!--begin::Description-->
	                            <span class="fs-6 fw-semibold text-gray-400">Etherium rate</span>
	                            <!--end::Description-->
	                        </h3>
	                        <!--end::Title-->
	                        <!--begin::Toolbar-->
	                        <div class="card-toolbar">
	                            <!--begin::Menu-->
	                            <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
	                                <i class="ki-outline ki-dots-square fs-1 text-gray-400 me-n1"></i>
	                            </button>
	                            <!--begin::Menu 2-->
	                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
	                                <!--begin::Menu item-->
	                                <div class="menu-item px-3">
	                                    <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions</div>
	                                </div>
	                                <!--end::Menu item-->
	                                <!--begin::Menu separator-->
	                                <div class="separator mb-3 opacity-75"></div>
	                                <!--end::Menu separator-->
	                                <!--begin::Menu item-->
	                                <div class="menu-item px-3">
	                                    <a href="#" class="menu-link px-3">
	                                        New Ticket
	                                    </a>
	                                </div>
	                                <!--end::Menu item-->
	                                <!--begin::Menu item-->
	                                <div class="menu-item px-3">
	                                    <a href="#" class="menu-link px-3">
	                                        New Customer
	                                    </a>
	                                </div>
	                                <!--end::Menu item-->
	                                <!--begin::Menu item-->
	                                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
	                                    <!--begin::Menu item-->
	                                    <a href="#" class="menu-link px-3">
	                                        <span class="menu-title">New Group</span>
	                                        <span class="menu-arrow"></span>
	                                    </a>
	                                    <!--end::Menu item-->
	                                    <!--begin::Menu sub-->
	                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
	                                        <!--begin::Menu item-->
	                                        <div class="menu-item px-3">
	                                            <a href="#" class="menu-link px-3">
	                                                Admin Group
	                                            </a>
	                                        </div>
	                                        <!--end::Menu item-->
	                                        <!--begin::Menu item-->
	                                        <div class="menu-item px-3">
	                                            <a href="#" class="menu-link px-3">
	                                                Staff Group
	                                            </a>
	                                        </div>
	                                        <!--end::Menu item-->
	                                        <!--begin::Menu item-->
	                                        <div class="menu-item px-3">
	                                            <a href="#" class="menu-link px-3">
	                                                Member Group
	                                            </a>
	                                        </div>
	                                        <!--end::Menu item-->
	                                    </div>
	                                    <!--end::Menu sub-->
	                                </div>
	                                <!--end::Menu item-->
	                                <!--begin::Menu item-->
	                                <div class="menu-item px-3">
	                                    <a href="#" class="menu-link px-3">
	                                        New Contact
	                                    </a>
	                                </div>
	                                <!--end::Menu item-->
	                                <!--begin::Menu separator-->
	                                <div class="separator mt-3 opacity-75"></div>
	                                <!--end::Menu separator-->
	                                <!--begin::Menu item-->
	                                <div class="menu-item px-3">
	                                    <div class="menu-content px-3 py-3">
	                                        <a class="btn btn-primary  btn-sm px-4" href="#">
	                                            Generate Reports
	                                        </a>
	                                    </div>
	                                </div>
	                                <!--end::Menu item-->
	                            </div>
	                            <!--end::Menu 2-->
	                            <!--end::Menu-->
	                        </div>
	                        <!--end::Toolbar-->
	                    </div>
	                    <!--end::Header-->
	                    <!--begin::Body-->
	                    <div class="card-body py-0 px-0">
	                        <!--begin::Nav-->
	                        <ul class="nav d-flex justify-content-between mb-3 mx-9">
	                            <!--begin::Item-->
	                            <li class="nav-item mb-3">
	                                <!--begin::Link-->
	                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px active" data-bs-toggle="tab" id="kt_charts_widget_33_tab_1" href="#kt_charts_widget_33_tab_content_1">
	                                    1d
	                                </a>
	                                <!--end::Link-->
	                            </li>
	                            <!--end::Item-->
	                            <!--begin::Item-->
	                            <li class="nav-item mb-3">
	                                <!--begin::Link-->
	                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px " data-bs-toggle="tab" id="kt_charts_widget_33_tab_2" href="#kt_charts_widget_33_tab_content_2">
	                                    5d
	                                </a>
	                                <!--end::Link-->
	                            </li>
	                            <!--end::Item-->
	                            <!--begin::Item-->
	                            <li class="nav-item mb-3">
	                                <!--begin::Link-->
	                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px " data-bs-toggle="tab" id="kt_charts_widget_33_tab_3" href="#kt_charts_widget_33_tab_content_3">
	                                    1m
	                                </a>
	                                <!--end::Link-->
	                            </li>
	                            <!--end::Item-->
	                            <!--begin::Item-->
	                            <li class="nav-item mb-3">
	                                <!--begin::Link-->
	                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px " data-bs-toggle="tab" id="kt_charts_widget_33_tab_4" href="#kt_charts_widget_33_tab_content_4">
	                                    6m
	                                </a>
	                                <!--end::Link-->
	                            </li>
	                            <!--end::Item-->
	                            <!--begin::Item-->
	                            <li class="nav-item mb-3">
	                                <!--begin::Link-->
	                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px " data-bs-toggle="tab" id="kt_charts_widget_33_tab_5" href="#kt_charts_widget_33_tab_content_5">
	                                    1y
	                                </a>
	                                <!--end::Link-->
	                            </li>
	                            <!--end::Item-->
	                        </ul>
	                        <!--end::Nav-->
	                        <!--begin::Tab Content-->
	                        <div class="tab-content mt-n6">
	                            <!--begin::Tap pane-->
	                            <div class="tab-pane fade active show" id="kt_charts_widget_33_tab_content_1">
	                                <!--begin::Chart-->
	                                <div id="kt_charts_widget_33_chart_1" data-kt-chart-color="info" class="min-h-auto h-200px ps-3 pe-6"></div>
	                                <!--end::Chart-->
	                                <!--begin::Table container-->
	                                <div class="table-responsive mx-9 mt-n6">
	                                    <!--begin::Table-->
	                                    <table class="table align-middle gs-0 gy-4">
	                                        <!--begin::Table head-->
	                                        <thead>
	                                            <tr>
	                                                <th class="min-w-100px"></th>
	                                                <th class="min-w-100px text-end pe-0"></th>
	                                                <th class="text-end min-w-50px"></th>
	                                            </tr>
	                                        </thead>
	                                        <!--end::Table head-->
	                                        <!--begin::Table body-->
	                                        <tbody>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-danger">-139.34</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:10 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$3,207.03</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-success">+576.24</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:55 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$3,274.94</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-success">+124.03</span>
	                                                </td>
	                                            </tr>
	                                        </tbody>
	                                        <!--end::Table body-->
	                                    </table>
	                                    <!--end::Table-->
	                                </div>
	                                <!--end::Table container-->
	                            </div>
	                            <!--end::Tap pane-->
	                            <!--begin::Tap pane-->
	                            <div class="tab-pane fade " id="kt_charts_widget_33_tab_content_2">
	                                <!--begin::Chart-->
	                                <div id="kt_charts_widget_33_chart_2" data-kt-chart-color="info" class="min-h-auto h-200px ps-3 pe-6"></div>
	                                <!--end::Chart-->
	                                <!--begin::Table container-->
	                                <div class="table-responsive mx-9 mt-n6">
	                                    <!--begin::Table-->
	                                    <table class="table align-middle gs-0 gy-4">
	                                        <!--begin::Table head-->
	                                        <thead>
	                                            <tr>
	                                                <th class="min-w-100px"></th>
	                                                <th class="min-w-100px text-end pe-0"></th>
	                                                <th class="text-end min-w-50px"></th>
	                                            </tr>
	                                        </thead>
	                                        <!--end::Table head-->
	                                        <!--begin::Table body-->
	                                        <tbody>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-success">+231.01</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-primary">+233.07</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,145.55</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-danger">+134.06</span>
	                                                </td>
	                                            </tr>
	                                        </tbody>
	                                        <!--end::Table body-->
	                                    </table>
	                                    <!--end::Table-->
	                                </div>
	                                <!--end::Table container-->
	                            </div>
	                            <!--end::Tap pane-->
	                            <!--begin::Tap pane-->
	                            <div class="tab-pane fade " id="kt_charts_widget_33_tab_content_3">
	                                <!--begin::Chart-->
	                                <div id="kt_charts_widget_33_chart_3" data-kt-chart-color="info" class="min-h-auto h-200px ps-3 pe-6"></div>
	                                <!--end::Chart-->
	                                <!--begin::Table container-->
	                                <div class="table-responsive mx-9 mt-n6">
	                                    <!--begin::Table-->
	                                    <table class="table align-middle gs-0 gy-4">
	                                        <!--begin::Table head-->
	                                        <thead>
	                                            <tr>
	                                                <th class="min-w-100px"></th>
	                                                <th class="min-w-100px text-end pe-0"></th>
	                                                <th class="text-end min-w-50px"></th>
	                                            </tr>
	                                        </thead>
	                                        <!--end::Table head-->
	                                        <!--begin::Table body-->
	                                        <tbody>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">12:40 AM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,346.25</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-warning">+134.57</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">11:30 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$1,565.26</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-danger">+155.03</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">4:25 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-success">+124.03</span>
	                                                </td>
	                                            </tr>
	                                        </tbody>
	                                        <!--end::Table body-->
	                                    </table>
	                                    <!--end::Table-->
	                                </div>
	                                <!--end::Table container-->
	                            </div>
	                            <!--end::Tap pane-->
	                            <!--begin::Tap pane-->
	                            <div class="tab-pane fade " id="kt_charts_widget_33_tab_content_4">
	                                <!--begin::Chart-->
	                                <div id="kt_charts_widget_33_chart_4" data-kt-chart-color="info" class="min-h-auto h-200px ps-3 pe-6"></div>
	                                <!--end::Chart-->
	                                <!--begin::Table container-->
	                                <div class="table-responsive mx-9 mt-n6">
	                                    <!--begin::Table-->
	                                    <table class="table align-middle gs-0 gy-4">
	                                        <!--begin::Table head-->
	                                        <thead>
	                                            <tr>
	                                                <th class="min-w-100px"></th>
	                                                <th class="min-w-100px text-end pe-0"></th>
	                                                <th class="text-end min-w-50px"></th>
	                                            </tr>
	                                        </thead>
	                                        <!--end::Table head-->
	                                        <!--begin::Table body-->
	                                        <tbody>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:20 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$3,756.26</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-danger">+234.03</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">10:30 AM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$1,474.04</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-info">-134.03</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">1:30 AM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-primary">+124.03</span>
	                                                </td>
	                                            </tr>
	                                        </tbody>
	                                        <!--end::Table body-->
	                                    </table>
	                                    <!--end::Table-->
	                                </div>
	                                <!--end::Table container-->
	                            </div>
	                            <!--end::Tap pane-->
	                            <!--begin::Tap pane-->
	                            <div class="tab-pane fade " id="kt_charts_widget_33_tab_content_5">
	                                <!--begin::Chart-->
	                                <div id="kt_charts_widget_33_chart_5" data-kt-chart-color="info" class="min-h-auto h-200px ps-3 pe-6"></div>
	                                <!--end::Chart-->
	                                <!--begin::Table container-->
	                                <div class="table-responsive mx-9 mt-n6">
	                                    <!--begin::Table-->
	                                    <table class="table align-middle gs-0 gy-4">
	                                        <!--begin::Table head-->
	                                        <thead>
	                                            <tr>
	                                                <th class="min-w-100px"></th>
	                                                <th class="min-w-100px text-end pe-0"></th>
	                                                <th class="text-end min-w-50px"></th>
	                                            </tr>
	                                        </thead>
	                                        <!--end::Table head-->
	                                        <!--begin::Table body-->
	                                        <tbody>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">3:30 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$1,756.25</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-primary">+144.04</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">2:30 PM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,756.26</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-danger">+124.03</span>
	                                                </td>
	                                            </tr>
	                                            <tr>
	                                                <td>
	                                                    <a href="#" class="text-gray-600 fw-bold fs-6">12:30 AM</a>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="text-gray-800 fw-bold fs-6 me-1">$2,034.65</span>
	                                                </td>
	                                                <td class="pe-0 text-end">
	                                                    <span class="fw-bold fs-6 text-success">+184.05</span>
	                                                </td>
	                                            </tr>
	                                        </tbody>
	                                        <!--end::Table body-->
	                                    </table>
	                                    <!--end::Table-->
	                                </div>
	                                <!--end::Table container-->
	                            </div>
	                            <!--end::Tap pane-->
	                        </div>
	                        <!--end::Tab Content-->
	                    </div>
	                    <!--end::Body-->
	                </div>
	                <!--end::Chart Widget 33-->
	            </div>
	            <!--end::Col-->
	        </div>
	        <!--end::Row-->
	        <!--begin::Row-->
	        <div class="row g-lg-5 g-xl-10">
	            <!--begin::Col-->
	            <div class="col-md-6 col-xl-6 mb-5 mb-xl-10">
	                <!--begin::Card widget 12-->
	                <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
	                    <!--begin::Card body-->
	                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
	                        <!--begin::Statistics-->
	                        <div class="mb-4 px-9">
	                            <!--begin::Info-->
	                            <div class="d-flex align-items-center mb-2">
	                                <!--begin::Value-->
	                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">47,769,700</span>
	                                <!--end::Value-->
	                                <!--begin::Label-->
	                                <span class="d-flex align-items-end text-gray-400 fs-6 fw-semibold">
	                                    Tons </span>
	                                <!--end::Label-->
	                            </div>
	                            <!--end::Info-->
	                            <!--begin::Description-->
	                            <span class="fs-6 fw-semibold text-gray-400">Total Online Sales</span>
	                            <!--end::Description-->
	                        </div>
	                        <!--end::Statistics-->
	                        <!--begin::Chart-->
	                        <div id="kt_card_widget_12_chart" class="min-h-auto" style="height: 125px"></div>
	                        <!--end::Chart-->
	                    </div>
	                    <!--end::Card body-->
	                </div>
	                <!--end::Card widget 12-->
	                <!--begin::Card widget 10-->
	                <div class="card card-flush h-md-50 mb-lg-10">
	                    <!--begin::Header-->
	                    <div class="card-header pt-5">
	                        <!--begin::Title-->
	                        <div class="card-title d-flex flex-column">
	                            <!--begin::Amount-->
	                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">69,700</span>
	                            <!--end::Amount-->
	                            <!--begin::Subtitle-->
	                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Expected Earnings This Month</span>
	                            <!--end::Subtitle-->
	                        </div>
	                        <!--end::Title-->
	                    </div>
	                    <!--end::Header-->
	                    <!--begin::Card body-->
	                    <div class="card-body d-flex align-items-end pt-0">
	                        <!--begin::Wrapper-->
	                        <div class="d-flex align-items-center flex-wrap">
	                            <!--begin::Chart-->
	                            <div class="d-flex me-7 me-xxl-10">
	                                <div id="kt_card_widget_10_chart" class="min-h-auto" style="height: 78px; width: 78px" data-kt-size="78" data-kt-line="11">
	                                </div>
	                            </div>
	                            <!--end::Chart-->
	                            <!--begin::Labels-->
	                            <div class="d-flex flex-column content-justify-center flex-grow-1">
	                                <!--begin::Label-->
	                                <div class="d-flex fs-6 fw-semibold align-items-center">
	                                    <!--begin::Bullet-->
	                                    <div class="bullet w-8px h-6px rounded-2 bg-success me-3"></div>
	                                    <!--end::Bullet-->
	                                    <!--begin::Label-->
	                                    <div class="fs-6 fw-semibold text-gray-400 flex-shrink-0">Used Truck freight</div>
	                                    <!--end::Label-->
	                                    <!--begin::Separator-->
	                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2"></div>
	                                    <!--end::Separator-->
	                                    <!--begin::Stats-->
	                                    <div class="ms-auto fw-bolder text-gray-700 text-end">45%</div>
	                                    <!--end::Stats-->
	                                </div>
	                                <!--end::Label-->
	                                <!--begin::Label-->
	                                <div class="d-flex fs-6 fw-semibold align-items-center my-1">
	                                    <!--begin::Bullet-->
	                                    <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>
	                                    <!--end::Bullet-->
	                                    <!--begin::Label-->
	                                    <div class="fs-6 fw-semibold text-gray-400 flex-shrink-0">Used Ship freight</div>
	                                    <!--end::Label-->
	                                    <!--begin::Separator-->
	                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2"></div>
	                                    <!--end::Separator-->
	                                    <!--begin::Stats-->
	                                    <div class="ms-auto fw-bolder text-gray-700 text-end">21%</div>
	                                    <!--end::Stats-->
	                                </div>
	                                <!--end::Label-->
	                                <!--begin::Label-->
	                                <div class="d-flex fs-6 fw-semibold align-items-center">
	                                    <!--begin::Bullet-->
	                                    <div class="bullet w-8px h-6px rounded-2 me-3" style="background-color: #E4E6EF"></div>
	                                    <!--end::Bullet-->
	                                    <!--begin::Label-->
	                                    <div class="fs-6 fw-semibold text-gray-400 flex-shrink-0">Used Plane freight</div>
	                                    <!--end::Label-->
	                                    <!--begin::Separator-->
	                                    <div class="separator separator-dashed min-w-10px flex-grow-1 mx-2"></div>
	                                    <!--end::Separator-->
	                                    <!--begin::Stats-->
	                                    <div class="ms-auto fw-bolder text-gray-700 text-end">34%</div>
	                                    <!--end::Stats-->
	                                </div>
	                                <!--end::Label-->
	                            </div>
	                            <!--end::Labels-->
	                        </div>
	                        <!--end::Wrapper-->
	                    </div>
	                    <!--end::Card body-->
	                </div>
	                <!--end::Card widget 10-->
	            </div>
	            <!--end::Col-->
	            <!--begin::Col-->
	            <div class="col-md-6 col-xl-6 mb-md-5 mb-xl-10">
	                <!--begin::Card widget 13-->
	                <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
	                    <!--begin::Card body-->
	                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
	                        <!--begin::Statistics-->
	                        <div class="mb-4 px-9">
	                            <!--begin::Statistics-->
	                            <div class="d-flex align-items-center mb-2">
	                                <!--begin::Value-->
	                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">259,786</span>
	                                <!--end::Value-->
	                                <!--begin::Label-->
	                                <!--end::Label-->
	                            </div>
	                            <!--end::Statistics-->
	                            <!--begin::Description-->
	                            <span class="fs-6 fw-semibold text-gray-400">Total Shipments</span>
	                            <!--end::Description-->
	                        </div>
	                        <!--end::Statistics-->
	                        <!--begin::Chart-->
	                        <div id="kt_card_widget_13_chart" class="min-h-auto" style="height: 125px"></div>
	                        <!--end::Chart-->
	                    </div>
	                    <!--end::Card body-->
	                </div>
	                <!--end::Card widget 13-->
	                <!--begin::Card widget 7-->
	                <div class="card card-flush h-md-50 mb-lg-10">
	                    <!--begin::Header-->
	                    <div class="card-header pt-5">
	                        <!--begin::Title-->
	                        <div class="card-title d-flex flex-column">
	                            <!--begin::Amount-->
	                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">604</span>
	                            <!--end::Amount-->
	                            <!--begin::Subtitle-->
	                            <span class="text-gray-400 pt-1 fw-semibold fs-6">New Customers This Month</span>
	                            <!--end::Subtitle-->
	                        </div>
	                        <!--end::Title-->
	                    </div>
	                    <!--end::Header-->
	                    <!--begin::Card body-->
	                    <div class="card-body d-flex flex-column justify-content-end pe-0">
	                        <!--begin::Title-->
	                        <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Today’s Heroes</span>
	                        <!--end::Title-->
	                        <!--begin::Users group-->
	                        <div class="symbol-group symbol-hover flex-nowrap">
	                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
	                                <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
	                            </div>
	                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
	                                <img alt="Pic" src="assets/media/avatars/300-11.jpg" />
	                            </div>
	                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
	                                <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
	                            </div>
	                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
	                                <img alt="Pic" src="assets/media/avatars/300-2.jpg" />
	                            </div>
	                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
	                                <span class="symbol-label bg-danger text-inverse-danger fw-bold">P</span>
	                            </div>
	                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Barry Walter">
	                                <img alt="Pic" src="assets/media/avatars/300-12.jpg" />
	                            </div>
	                            <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
	                                <span class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+42</span>
	                            </a>
	                        </div>
	                        <!--end::Users group-->
	                    </div>
	                    <!--end::Card body-->
	                </div>
	                <!--end::Card widget 7-->
	            </div>
	            <!--end::Col-->
	        </div>
	        <!--end::Row-->
	    </div>
	    <!--end::Content-->
	</div>
@endsection

@section('after_js')
	<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>

	<script src="{{ asset("assets/clients/plugins/custom/fullcalendar/fullcalendar.bundle.js") }}"></script>
	<script src="{{ asset("assets/clients/plugins/custom/datatables/datatables.bundle.js") }}"></script>
	<script src="{{ asset("assets/clients/js/widgets.bundle.js") }}"></script>
	<script src="{{ asset("assets/clients/js/custom/widgets.js") }}"></script>
	<script src="{{ asset("assets/clients/js/custom/apps/chat/chat.js") }}"></script>
	<script src="{{ asset("assets/clients/js/custom/utilities/modals/upgrade-plan.js") }}"></script>
	<script src="{{ asset("assets/clients/js/custom/utilities/modals/new-target.js") }}"></script>
	<script src="{{ asset("assets/clients/js/custom/utilities/modals/users-search.js") }}"></script>
@endsection