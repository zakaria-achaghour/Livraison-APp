@extends('clients.layouts.app')

@section('title', __('Collection'))

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
                        <span>{{ __("List of Collection") }}</span>
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
                        {{ __('Collection') }} 
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("List of Collection") }} </li>
                </ul>
            </div>

            <div class="d-flex align-self-center flex-center flex-shrink-0">
                <a href="{{ route('clients.requests.pickups.create') }}" class="btn btn-sm btn-success d-flex flex-center ms-3 px-4 py-3">
                    <i class="ki-outline ki-plus-square fs-2"></i>
                    <span>{{ __("Add Collection") }}</span>
                </a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i> <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-sm form-control-solid w-230px ps-12 search-input" placeholder="{{ __('Tapez pour rechercher') }}"/>
                    </div>
                    <button class="btn btn-icon btn-sm btn-primary ms-1 btn-refresh">
                    	<i class="ki-solid ki-arrows-circle fs-4 text-white">
						</i>
                    </button>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end toolbar-actions-datatable" data-kt-subscription-table-toolbar="base">
                        <button type="button" class="btn btn-sm btn-light-success me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-filter fs-2"></i> {{ __("Filter") }}
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <form class="px-7 py-5 filter-form">
                                <div class="mb-6">
                                    <select name="product_status" class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="{{ __('Statut (Tout)') }}" data-allow-clear="true">
                                        <option></option>
                                        <option value="-1">{{ __('Non Reçu') }}</option>
                                        <option value="1">{{ __('Reçu') }}</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6 btn-filter-reset" data-kt-menu-dismiss="true">
                                    	{{ __('Réinitialiser') }}
                                    </button>
                                    <button class="btn btn-primary fw-semibold px-6 btn-filter-apply" data-kt-menu-dismiss="true">
                                    	{{ __('Appliquer') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <button type="button" class="btn btn-sm  btn-light-success me-3 excel-export" data-bs-toggle="modal" data-bs-target="#export_modal">
                            <i class="ki-outline ki-exit-up fs-2"></i> {{ __("Exporter") }}
                        </button>
                        <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_pickup">
                                <i class="ki-outline ki-plus fs-2"></i> {{ __("Add Collection") }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">

                @php
                $default_column = [
                    'visible' => true,
                    'orderable' => true,
                    'searchable' => true
                ];
                $columns = [
                    ['data' => 'checkbox', 'orderable' => false, 'searchable' => false],
                    ['data' => 'pickup_request_type', 'name' => "pickup_request_type", 'title' =>  __("Type")],
                    ['data' => 'pickup_request_statut', 'name' => "pickup_request_statut", 'title' =>  __("Status")],
                    ['data' => 'pickup_request_time', 'name' => "pickup_request_time", 'title' =>  __("Creation Date")],
                    ['data' => 'pickup_request_phone', 'name' => "pickup_request_phone", 'title' =>  __("Phone")],
                    ['data' => 'pickup_request_address', 'name' => "pickup_request_address", 'title' =>  __("Adress")],
                    ['data' => 'pickup_request_note', 'name' => "pickup_request_note", 'title' =>  __("Remarque")],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Actions', 'orderable' => false, 'searchable' => false],
                ];
            @endphp
                @include('clients.layouts.components.datatable', ['columns' => $columns])

                {{-- <table class="table table-respo has-checkbox align-middle table-row-bordered table-striped table-row-gray-300 fs-6 gy-5 datatable-browse" id="list_pickups">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#list_pickups .form-check-input" value="1" />
                                </div>
                            </th>
                            @php
                                $default_column = [
                                    'visible' => true,
                                    'orderable' => true,
                                    'searchable' => true
                                ];
                                $columns = [
						            ['data' => 'checkbox', 'orderable' => false, 'searchable' => false],
						            ['data' => 'pickup_request_type', 'name' => "pickup_request_type", 'title' =>  __("Type")],
                                    ['data' => 'pickup_request_statut', 'name' => "pickup_request_statut", 'title' =>  __("Status")],
                                    ['data' => 'pickup_request_time', 'name' => "pickup_request_time", 'title' =>  __("Creation Date")],
                                    ['data' => 'pickup_request_phone', 'name' => "pickup_request_phone", 'title' =>  __("Phone")],
                                    ['data' => 'pickup_request_address', 'name' => "pickup_request_address", 'title' =>  __("Adress")],
                                    ['data' => 'pickup_request_note', 'name' => "pickup_request_note", 'title' =>  __("Remarque")],
						            ['data' => 'action', 'name' => 'action', 'title' => 'Actions', 'orderable' => false, 'searchable' => false],
						        ];
                            @endphp
                            @foreach($columns as $column)
                                @php
                                	$column = $default_column + $column;
                                @endphp

                                @if($column['data'] == "checkbox")
                                    @continue
                                @endif

                                @if($column['data'] == "action")
                                	<th class="text-end min-w-70px">{{ $column['title'] }}</th>
                                @elseif($column['visible'])
                                	<th class="min-w-125px">{{ $column['title'] }}</th>
                                @endif
                            @endforeach
                            
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold" id="list_pickups_body"></tbody>
                </table> --}}
            </div>
        </div>
    </div>
       {{-- Modals Add Pickup --}}
       <div class="modal fade" id="kt_modal_add_pickup" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_pickup_header">
                    <h2 class="fw-bold">{{ __("Add Collection") }}</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                         data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form id="pickup_request_form" class="form" action="{{ route('clients.requests.pickups.store') }}">
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10"
                            id="kt_modal_add_pickup_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="true"
                            data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_pickup_header"
                            data-kt-scroll-wrappers="#kt_modal_add_pickup_scroll"
                            data-kt-scroll-offset="300px">

                            <div class="fv-row mb-3">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="required form-label">{{ __("Pickups type") }}</label>
                                            <select class="form-select form-control form-control-solid form-select-sm" name="typeOfPickup" data-control="select2" aria-label="Select example">
                                                @foreach ($types as $key => $type)
                                                    <option value="{{$key}}" >{{__($type)}}</option>                                        
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="form-label required">{{ __("Note") }}</label>
                                        <div class="position-relative">
                                            <textarea name="note" class="form-control form-control-solid form-control-sm" placeholder="{{ __("Note") }}" data-kt-autosize="true" rows="4">{{ old('note') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="required form-label">{{ __("Phone Number") }}</label>
                                            <input class="form-control form-control-solid form-control-sm" name="phone"
                                            placeholder="{{ __("Phone Number") }}" value="{{ old('phone') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="required form-label">{{ __("City") }}</label>
                                            <select class="form-select form-control form-control-sm form-control-solid" 
                                                    data-control="select2" aria-label="Select example" name="city">
                                                <option>{{ __("City") }}</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{$city->id}}"
                                                        {{ old('city') == $city->id ? 'selected' : '' }}
                                                        >{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="form-label required">{{ __("Address") }}</label>
                                        <div class="position-relative">
                                            <textarea name="address" class="form-control form-control-sm form-control-solid form-control-sm" placeholder="{{ __("Address") }}" data-kt-autosize="true" rows="4">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!--end::Scroll-->
                    </div>
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="submit" class="btn btn-primary" id="pickup_request_submit">
                                <span class="indicator-label">
                                    {{__("Enregister")}}
                                </span>
                                <span class="indicator-progress">
                                    {{__("Please wait")}}... <span
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


@endsection

@section('after_js')
    <script src="{{ asset("assets/clients/plugins/custom/datatables/datatables.bundle.js") }}"></script>
    <script src="{{ asset("assets/clients/plugins/custom/datatables/datatable-btns.js") }}"></script>
    <script src="{{ asset('assets/global/js/vue.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {		
            // table = $('.datatable-browse').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: {
            //         url : "{{ route('clients.parcels.from-inventory.load') }}",
            //           complete: function() {
            //            $('.placeholder-loader').removeClass('holder-active');
            //            $('[data-bs-toggle="tooltip"]').tooltip();
            //            addClassToRows();
            //         },
            //         data: function (d) {
            //             d.filters = $('.filter-form').serializeArray().reduce((acc, {name, value}) => ({...acc, [name]: value}),{});
            //         }
            //     },
            //     columns: {!! json_encode($columns) !!},
            //     language: {url: "{{ asset("assets/clients/plugins/custom/datatables/".app()->getLocale().".json") }}"},
            //     orderMulti: true,
            //     order: [],
            //     buttons: ["copy", "excel", "csv", "pdf", "print"],
            //     columnDefs: [
            //         {
            //             targets: "_all", 
            //             createdCell: function(td, cellData, rowData, row, col) {
            //                 $(td).attr('data-label', this.api().column(col).header().textContent);
            //             }
            //         }
            //     ]
            // });
    
             // Send Save
        $('#pickup_request_submit').on('click', function(e) {
            e.preventDefault();
            var current_btn = $(this);
            current_btn.prop('disabled', true);
            current_btn.data("data-kt-indicator", "on");

            var formData =  new FormData($('#pickup_request_form')[0]);

            console.log(formData);
            $.ajax({
                url: '{{ route('clients.requests.pickups.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
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

                    // if(data.success) {
                    //     setTimeout(function() {
                    //         location.href = data.redirect
                    //     }, 1100);
                        
                    // }
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
            //   $.ajax({
            //     url: "{{ route('clients.parcels.load.cities') }}",
            //     dataType: 'json',
            //     success: function (data) {
            //         $('.cities-select2').select2({
            //             data: data,
            //             placeholder: '{{ __("Ville (tous)") }}',
            //             language: 'fr',
            //             allowClear: true,
            //         });
            //     }
            // });
        });
    </script>
@endsection
