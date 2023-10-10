@extends('clients.layouts.app')

@section('title', __('Bons de livraison'))

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
                        <span>{{ __("Liste Bons de livraison") }}</span>
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
                        {{ __("Bons de livraison") }} </li>
                </ul>
            </div>

            <div class="d-flex align-self-center flex-center flex-shrink-0">
                <a href="{{ route('clients.delivery-note.add') }}" class="btn btn-sm btn-success d-flex flex-center ms-3 px-4 py-3">
                    <i class="ki-outline ki-plus-square fs-2"></i>
                    <span>{{ __("Nouveau Bon de livraison") }}</span>
                </a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
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

                         <div id="filter-dropdown" class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">

                            <form class="px-7 py-5 filter-form">
                                <div class="mb-6">
                                    <label class="form-label fs-6 fw-semibold">{{ __('Status') }}</label>
                                    <select name="status" class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="{{ __('Status (tous)') }}" data-allow-clear="true">
                                        <option></option>
                                        <option value="0">{{ __('Nouveau') }}</option>
                                        <option value="1">{{ __('Reçu') }}</option>
                                    </select>
                                </div>


                                <div class="mb-6">
                                    <label class="form-label fs-6 fw-semibold">{{ __('Date de création') }}</label>
                                    <input name="date" placeholder="{{ __('Date de création') }}" class="form-select form-select-solid" />
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

                        <button type="button" class="btn btn-sm  btn-light-success me-3" data-bs-toggle="modal" data-bs-target="#export_modal">
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
                        ['data' => 'delivery_note_ref', 'name' => "delivery_note_ref", 'title' =>  __("Référence")],
                        ['data' => 'delivery_note_time', 'name' => "delivery_note_time", 'title' =>  __("Date de création")],
                        ['data' => 'delivery_note_delivered', 'name' => "delivery_note_delivered", 'title' =>  __("Status")],
                        ['data' => 'delivery_parcels', 'name' => "delivery_parcels", 'title' =>  __("Colis")],
                        ['data' => 'action', 'name' => 'action', 'title' => 'Actions', 'orderable' => false, 'searchable' => false],
                    ];
                @endphp

                @include('clients.layouts.components.datatable', ['columns' => $columns])
            </div>
        </div>        
    </div>
</div>

@include('clients.layouts.components.export_modal')
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
                url : "{{ route('clients.delivery-note.load') }}",
		      	complete: function() {
			       $('.placeholder-loader').removeClass('holder-active');
			       $('[data-bs-toggle="tooltip"]').tooltip();
                   addClassToRows();
                   KTMenu.createInstances();
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

        

        var datapicker = $('input[name="date"]').daterangepicker({
            autoUpdateInput: false,
            /*maxDate: 'today',*/
            autoApply:true,
            @if(app()->getLocale() == "fr")
            locale: {
                format: 'YYYY/MM/DD',
                separator: ' - ',
                applyLabel: 'Appliquer',
                cancelLabel: 'Annuler',
                fromLabel: 'De',
                toLabel: 'À',
                customRangeLabel: 'Plage personnalisée',
                daysOfWeek: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                firstDay: 1
            }
            @else
            locale: {
                format: 'DD/MM/YYYY',
                separator: ' - ',
                applyLabel: 'تطبيق',
                cancelLabel: 'إلغاء',
                fromLabel: 'من',
                toLabel: 'إلى',
                customRangeLabel: 'نطاق مخصص',
                daysOfWeek: ['أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت'],
                monthNames: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                firstDay: 6
            }
            @endif
        });

        var menuEL = document.querySelector("#filter-dropdown");
        var menu = KTMenu.getInstance(menuEL);

        menu.on("kt.menu.dropdown.hide", function(item) {
            if ($('.daterangepicker').css('display') == "block") {
                return false;
            }
        });

        datapicker.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        });

	});
</script>

@yield('datatable_options')
@endsection
