@extends('clients.layouts.app')

@section('title', __('Claims'))

@section('after_css')
    <link href="{{ asset('assets/clients/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

@section('content')

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
            <div class="d-flex flex-stack flex-row-fluid">
                <div class="d-flex flex-column flex-row-fluid">
                    <div class="page-title d-flex align-items-center me-3">
                        <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                            <span>{{ __('List of Claims') }}</span>
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
                            {{ __('Claims') }}
                        </li>

                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>

                        <li class="breadcrumb-item text-gray-700">
                            {{ __('List of Claims') }} </li>
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
                                            <option value="1">{{ __('Team Response Pending') }}</option>
                                            <option value="2">{{ __('Waiting For Customer Response') }}</option>
                                            <option value="3">{{ __('Claim Processed') }}</option>
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
                                <i class="ki-outline ki-plus fs-2"></i> {{ __('Add Claim') }}
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
                        $columns = [['data' => 'checkbox', 'orderable' => false, 'searchable' => false], ['data' => 'claims_object', 'name' => 'claims_object', 'title' => __('Obejct')], ['data' => 'parcel_code', 'name' => 'parcel_code', 'title' => __('Parcel Code')], ['data' => 'claims_statut', 'name' => 'claims_statut', 'title' => __('Status')], ['data' => 'claims_time', 'name' => 'claims_time', 'title' => __('Creation Date')], ['data' => 'action', 'name' => 'action', 'title' => 'Actions', 'orderable' => false, 'searchable' => false]];
                    @endphp
                    @include('clients.layouts.components.datatable', ['columns' => $columns])
                </div>
            </div>


            

        </div>
       
        {{-- </div> --}}
        {{-- Modals Add  --}}
        <div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header" id="kt_modal_add_header">
                        <h2 class="fw-bold">{{ __('Add Claim') }}</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body px-5 my-7">
                        <!--begin::Form-->
                        <form id="claim_form" class="form" action="{{ route('clients.requests.claims.store') }}">
                            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_scroll"
                                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                                data-kt-scroll-dependencies="#kt_modal_add_header"
                                data-kt-scroll-wrappers="#kt_modal_add_scroll" data-kt-scroll-offset="300px">

                                <div class="fv-row mb-3">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="flex-row-fluid mb-8">
                                            <label class="required form-label">{{ __('Claims type') }}</label>
                                            <select class="form-select form-control form-control-solid form-select-sm"
                                                name="type" data-control="select2" aria-label="Select example">
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->value }}">{{ __($type->value) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="flex-row-fluid mb-8">
                                            <label class="form-label required">{{ __('Parcel Code') }}</label>
                                            <div class="position-relative">
                                                <input type="text" name="parcelCode"
                                                    class="form-control form-control-solid form-control-sm"
                                                    placeholder="{{ __('Parcel Code') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="flex-row-fluid mb-8">
                                            <label class="form-label required">{{ __('Message') }}</label>
                                            <div class="position-relative">
                                                <textarea name="message" class="form-control form-control-solid form-control-sm" placeholder="{{ __('Message') }}"
                                                    data-kt-autosize="true" rows="4">{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Actions-->
                            <div class="text-center pt-10">
                                <button type="submit" class="btn btn-primary" id="submit">
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
    <script src="{{ asset('assets/clients/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/clients/plugins/custom/datatables/datatable-btns.js') }}"></script>
    <script src="{{ asset('assets/global/js/vue.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#claim_form')[0].reset();
            // load data	
            table = $('.datatable-browse').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('clients.requests.claims.load') }}",
                    complete: function() {
                        $('.placeholder-loader').removeClass('holder-active');
                        $('[data-bs-toggle="tooltip"]').tooltip();
                        addClassToRows();
                        KTMenu.createInstances();
                    },
                    data: function(d) {
                        d.filters = $('.filter-form').serializeArray().reduce((acc, {
                            name,
                            value
                        }) => ({
                            ...acc,
                            [name]: value
                        }), {});
                    }
                },
                columns: {!! json_encode($columns) !!},
                language: {
                    url: "{{ asset('assets/clients/plugins/custom/datatables/' . app()->getLocale() . '.json') }}"
                },
                // responsive: true,
                orderMulti: true,
                order: [],
                buttons: ["copy", "excel", "csv", "pdf", "print"],
                columnDefs: [{
                    targets: "_all",
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).attr('data-label', this.api().column(col).header().textContent);
                    }
                }]
            });
            // Send Save
            $('#submit').on('click', function(e) {
                e.preventDefault();
                var current_btn = $(this);
                current_btn.prop('disabled', true);
                current_btn.data("data-kt-indicator", "on");
                var formData = new FormData($('#claim_form')[0]);

                $.ajax({
                    url: '{{ route('clients.requests.claims.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        current_btn.prop('disabled', false);
                        current_btn.data("data-kt-indicator", "off");

                        Swal.fire({
                            html: data.message,
                            icon: data.success ? "success" : "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });

                        if (data.success) {
                            $('#claim_form')[0].reset();
                            table.ajax.reload();
                            $('#kt_modal_add').modal('toggle');
                        }
                    },
                    error: function(data) {
                        current_btn.prop('disabled', false);
                        current_btn.data("data-kt-indicator", "off");
                        Swal.fire({
                            html: data.responseJSON.message,
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }
                });
            });

        });
    </script>
    @yield('datatable_options')
@endsection
