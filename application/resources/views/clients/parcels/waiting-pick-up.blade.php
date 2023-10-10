@extends('clients.layouts.app')

@section('title', __('Colis pour ramassage'))

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
                        <span>{{ __("Colis pour ramassage") }}</span>
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
                        {{ __("Colis pour ramassage") }} </li>
                </ul>
            </div>

            <div class="d-flex align-self-center flex-center flex-shrink-0">
                <a href="{{ route('clients.parcels.add') }}" class="btn btn-sm btn-success d-flex flex-center ms-3 px-4 py-3">
                    <i class="ki-outline ki-plus-square fs-2"></i>
                    <span>{{ __("Nouveau Colis") }}</span>
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
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end toolbar-actions-datatable" data-kt-subscription-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-sm btn-light-success me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-filter fs-2"></i> {{ __("Filter") }}
                        </button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        	@php
                        		$status = \App\Models\ParcelStatut::all()->groupBy('parcel_statut_type');
                        	@endphp


                            <form class="px-7 py-5 filter-form">
                                <div class="mb-6">
                                	{{-- <label class="form-label fs-6 fw-semibold">{{ __('Status') }}</label> --}}
                                    <select name="parcel_status" class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="{{ __('Status (tous)') }}" data-allow-clear="true" data-kt-subscription-table-filter="month" data-hide-search="true">
                                        <option></option>
                                        @foreach(['WAITING_PICKUP', 'NEW_PARCEL'] as $statut)
                                        	<option value="{{ $statut }}">
                                        		{{ \App\Models\Parcel::getStatus($statut)['text'] }}
                                        	</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-6">
                                	{{-- <label class="form-label fs-6 fw-semibold">{{ __('Ville') }}</label> --}}
                                    <select name="parcel_city" class="form-select form-select-solid fw-bold cities-select2">
                                        <option></option>
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
                        ['data' => 'parcel_code', 'name' => "parcel_code", 'title' =>  __("Code d'envoi")],
                        ['data' => 'parcel_receiver', 'name' => 'parcel_receiver', 'title' => __("Destinataire")],
                        ['data' => 'parcel_status', 'name' => 'parcel_status', 'title' => __("Status")],
                        ['data' => 'parcel_price', 'name' => 'parcel_price', 'title' => __("Prix")],
                        /*['data' => 'parcel_time', 'name' => 'parcel_time', 'title' => __("Dates")],*/
                        ['data' => 'delivery_note', 'name' => 'delivery_note', 'title' => __("Bon de livraison")],
                        ['data' => 'action', 'name' => 'action', 'title' => 'Actions', 'orderable' => false, 'searchable' => false],
                    ];
                @endphp
                @include('clients.layouts.components.datatable', ['columns' => $columns])
            </div>
        </div>
    </div>
</div>

@include('clients.layouts.components.export_modal')
@include('clients.parcels.components.informations_modal')
@endsection

@section('after_js')
<script src="{{ asset("assets/clients/plugins/custom/datatables/datatables.bundle.js") }}"></script>
<script src="{{ asset("assets/clients/plugins/custom/datatables/datatable-btns.js") }}"></script>
<script src="{{ asset('assets/global/js/moment.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {		
		table = $('.datatable-browse').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ route('clients.parcels.waiting-pick-up.load') }}",
		      	complete: function() {
			       $('.placeholder-loader').removeClass('holder-active');
			       $('[data-bs-toggle="tooltip"]').tooltip();
                   addClassToRows();
	        	},
                data: function (d) {
                    d.filters = $('.filter-form').serializeArray().reduce((acc, {name, value}) => ({...acc, [name]: value}),{});
                }
            },
            columns: {!! json_encode($columns) !!},
            language: {url: "{{ asset("assets/clients/plugins/custom/datatables/".app()->getLocale().".json") }}"},
            /*responsive: true,*/
            orderMulti: true,
            order: [],
            buttons: ["copy", "excel", "csv", "pdf", "print"],
            columnDefs: [
                {
                    targets: "_all", 
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).attr('data-label', this.api().column(col).header().textContent);
                    }
                }
            ]
        });

	  	$.ajax({
            url: "{{ route('clients.parcels.load.cities') }}",
            dataType: 'json',
            success: function (data) {
                $('.cities-select2').select2({
                    data: data,
                    placeholder: '{{ __("Ville (tous)") }}',
                    language: 'fr',
                    allowClear: true,
                });
            }
        });
	});
</script>

@include('clients.layouts.components.global_remove', ['url' => route('clients.parcels.delete', ['id' => 0])])

@yield('datatable_options')
@yield('informations_modal')
@endsection
