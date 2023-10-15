@extends('clients.layouts.app')

@section('title', __('Claims'))

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
                        <span>{{ __("List of Claims") }}</span>
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
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("List of Claims") }} </li>
                </ul>
            </div>

            <div class="d-flex align-self-center flex-center flex-shrink-0">
                <a href="{{ route('clients.inventory.add') }}" class="btn btn-sm btn-success d-flex flex-center ms-3 px-4 py-3">
                    <i class="ki-outline ki-plus-square fs-2"></i>
                    <span>{{ __("Add Claim") }}</span>
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
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <table class="table table-respo has-checkbox align-middle table-row-bordered table-striped table-row-gray-300 fs-6 gy-5 datatable-browse" id="list_claims">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#list_claims .form-check-input" value="1" />
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
						            ['data' => 'claims_object', 'name' => "claims_object", 'title' =>  __("Object")],
                                    ['data' => 'parcel_code', 'name' => "parcel_code", 'title' =>  __("Parcel Code")],
                                    ['data' => 'claims_statut', 'name' => "claims_statut", 'title' =>  __("Action Status")],
                                    ['data' => 'claims_time', 'name' => "claims_time", 'title' =>  __("Creation Date")],
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
                    <tbody class="text-gray-600 fw-semibold" id="list_claims_body"></tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@section('after_js')
    <script src="{{ asset("assets/clients/plugins/custom/datatables/datatables.bundle.js") }}"></script>
    <script src="{{ asset("assets/clients/plugins/custom/datatables/datatable-btns.js") }}"></script>

    <script type="text/javascript">

    </script>
@endsection
