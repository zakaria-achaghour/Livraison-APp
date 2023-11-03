@extends('clients.layouts.app')

@section('title', __('Users'))

@section('after_css')
    <link href="{{ asset("assets/clients/plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content') 

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
        <div class="d-flex flex-stack flex-row-fluid">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="page-title d-flex align-items-center me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("List of Users") }}</span>
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
                        {{ __('Users') }} 
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("List of Users") }} </li>
                </ul>
            </div>

        </div>
    </div>

    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i> <input type="text"
                            data-kt-subscription-table-filter="search"
                            class="form-control form-control-sm form-control-solid w-230px ps-12 search-input"
                            placeholder="{{ __('Tapez pour rechercher') }}" />
                    </div>
                    <button class="btn btn-icon btn-sm btn-primary ms-1 btn-refresh">
                        <i class="ki-solid ki-arrows-circle fs-4 text-white">
                        </i>
                    </button>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end toolbar-actions-datatable"
                        data-kt-subscription-table-toolbar="base">
                        <button type="button" class="btn btn-sm btn-light-success me-3" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-filter fs-2"></i> {{ __('Filter') }}
                        </button>
                        <div id="filter-dropdown" class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                            data-kt-menu="true">
                            <form class="px-7 py-5 filter-form">
                                <div class="mb-6">
                                    <select name="status" class="form-select form-select-solid fw-bold"
                                        data-kt-select2="true" data-placeholder="{{ __('Statut (Tout)') }}"
                                        data-allow-clear="true">
                                        <option></option>
                                        <option value="NEW">{{ __('Nouveau') }}</option>
                                        <option value="RECEIVED">{{ __('Received') }}</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button
                                        class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6 btn-filter-reset"
                                        data-kt-menu-dismiss="true">
                                        {{ __('Réinitialiser') }}
                                    </button>
                                    <button class="btn btn-primary fw-semibold px-6 btn-filter-apply"
                                        data-kt-menu-dismiss="true">
                                        {{ __('Appliquer') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <button type="button" class="btn btn-sm  btn-light-success me-3 excel-export"
                            data-bs-toggle="modal" data-bs-target="#export_modal">
                            <i class="ki-outline ki-exit-up fs-2"></i> {{ __('Exporter') }}
                        </button>
                        <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add">
                            <i class="ki-outline ki-plus fs-2"></i> {{ __('Add User') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">

                @php
                    $default_column = [
                        'visible' => true,
                        'orderable' => true,
                        'searchable' => true,
                    ];
                    $columns = [
                        ['data' => 'checkbox', 'orderable' => false, 'searchable' => false],
                        ['data' => 'action', 'name' => 'action', 'title' => 'Actions', 'orderable' => false, 'searchable' => false]
                    ];
                @endphp
                @include('clients.layouts.components.datatable', ['columns' => $columns])
            </div>
        </div>

        
    </div>
      {{-- Modals Add  --}}
      <div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_header">
                    <h2 class="fw-bold">{{ __('Add User') }}</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form id="pickup_request_form" class="form"
                        action="{{ route('clients.requests.pickups.store') }}">
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_header"
                            data-kt-scroll-wrappers="#kt_modal_add_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-md- 12">
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
                        </div>
                        <div class="row">
                            <div class="col-md- 12">
                                <div class="flex-row-fluid mb-8">
                                    <label class="required form-label">{{ __("Username") }}</label>
                                    <div class="position-relative">
                                        <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                            <i class="ki-outline ki-user fs-3"></i>
                                        </div>
                                        <input class="form-control form-control-solid form-control-md ps-12"
                                               type="text" placeholder="{{ __("Username") }}" name="userName" 
                                               autocomplete="off" data-kt-translate="sign-up-input-first-name"
                                               value="{{ old('userName') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row"> --}}
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
                        {{-- </div> --}}
                            {{-- <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="form-label required">{{ __('Note') }}</label>
                                        <div class="position-relative">
                                            <textarea name="note" class="form-control form-control-solid form-control-sm" placeholder="{{ __('Note') }}"
                                                data-kt-autosize="true" rows="4">{{ old('note') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="required form-label">{{ __('Phone Number') }}</label>
                                        <input class="form-control form-control-solid form-control-sm"
                                            id="phone_inputmask" name="phone"
                                            placeholder="{{ __('Phone Number') }}" value="{{ old('phone') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="required form-label">{{ __('City') }}</label>
                                        <select class="form-select form-control form-control-sm form-control-solid"
                                            data-control="select2" aria-label="Select example" name="city">
                                            <option>{{ __('City') }}</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="form-label required">{{ __('Address') }}</label>
                                        <div class="position-relative">
                                            <textarea name="address" class="form-control form-control-sm form-control-solid form-control-sm"
                                                placeholder="{{ __('Address') }}" data-kt-autosize="true" rows="4">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <!--end::Scroll-->
                        </div>
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="submit" class="btn btn-primary" id="pickup_request_submit">
                                <span class="indicator-label">
                                    {{ __('Enregister') }}
                                </span>
                                <span class="indicator-progress">
                                    {{ __('Please wait') }}... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
</div>

@include('clients.layouts.components.export_modal')

@endsection

@section('after_js')
    <script src="{{ asset("assets/clients/plugins/custom/datatables/datatables.bundle.js") }}"></script>
    <script src="{{ asset("assets/clients/plugins/custom/datatables/datatable-btns.js") }}"></script>

    <script type="text/javascript">

    </script>
    @yield('datatable_options')
@endsection
