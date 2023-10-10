@extends('clients.layouts.app')

@section('title', __('Liste des produits'))

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
                        <span>{{ __("Liste des produits") }}</span>
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
                        {{ __('Stock') }} 
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("Liste des produits") }} </li>
                </ul>
            </div>

            <div class="d-flex align-self-center flex-center flex-shrink-0">
                <a href="{{ route('clients.inventory.add') }}" class="btn btn-sm btn-success d-flex flex-center ms-3 px-4 py-3">
                    <i class="ki-outline ki-plus-square fs-2"></i>
                    <span>{{ __("Nouveau Produit") }}</span>
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
                                    {{-- <label class="form-label fs-6 fw-semibold">{{ __('Ville') }}</label> --}}
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
                <table class="table table-respo has-checkbox align-middle table-row-bordered table-striped table-row-gray-300 fs-6 gy-5 datatable-browse" id="list_colis">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#list_colis .form-check-input" value="1" />
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
						            ['data' => 'product_name', 'name' => "product_name", 'title' =>  __("Produit")],
                                    ['data' => 'product_qty', 'name' => "product_qty", 'title' =>  __("Stock")],
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
                    <tbody class="text-gray-600 fw-semibold" id="list_colis_body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="export_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-400px">
        <div class="modal-content">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i> 
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-5 my-5">
                <form id="kt_subscriptions_export_form" class="form" action="#">
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-semibold form-label mb-5">
                            {{ __("Sélectionner le format d'exportation : ")}}
                        </label>

                        <select data-control="select2" data-placeholder="{{ __("Sélectionner le format d'exportation : ")}}" data-hide-search="true" class="form-select form-select-solid format-export">
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary btn-export">
                            <span class="indicator-label">
                                {{ __('Exporter') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <div class="toast-container position-fixed bottom-0 end-0 p-5 z-index-3" style="z-index: 11">
    <div class="toast align-items-center text-white bg-success fs-4" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body p-5">
                Hello, world! This is a toast message.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div> --}}
@endsection

@section('after_js')
<script src="{{ asset("assets/clients/plugins/custom/datatables/datatables.bundle.js") }}"></script>
<script src="{{ asset("assets/clients/plugins/custom/datatables/datatable-btns.js") }}"></script>

<script type="text/javascript">
	$(document).ready(function() {
        /*const toastElement = document.getElementById('toast');
        const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
        toast.show();*/

		table = $('.datatable-browse').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ route('clients.inventory.load') }}",
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

        // SEARCH
        $(".search-input").on('keyup', function (e) {
            if (e.keyCode === 13) {
            	$('.placeholder-loader').addClass('holder-active');
                table.search($(this).val()).draw();
            }
        });

        // FILTER
        $('.btn-filter-apply').on('click', function(e) {
            e.preventDefault();
            $('.placeholder-loader').addClass('holder-active');
            table.draw();
        });

        $('.btn-filter-reset').on('click', function(e) {
            e.preventDefault();
            $('.filter-form input, .filter-form select').val(" ").trigger('change');
            //$('.form-select').val("").trigger('change');
            $('.placeholder-loader').addClass('holder-active');
            table.draw();
        });

        // RERESH
        $('.btn-refresh').on('click', function(e) {
            e.preventDefault();
            $('.placeholder-loader').addClass('holder-active');
            table.ajax.reload( null, false );
        });

        table.on('page.dt', function () {
		    $('.placeholder-loader').addClass('holder-active');
	  	});

	  	table.on('length.dt', function () {
		    $('.placeholder-loader').addClass('holder-active');
	  	});

	  	$('.btn-export').on('click', function(e) {
	  		e.preventDefault();
	  		var format = $('.format-export').val();
	    	table.button('.buttons-'+format).trigger();
	    	$('#export_modal').modal('hide');
	  	});

        $(document).on('click', '.remove', function() {
            var current_remove = $(this).data('id');
            var current_btn = $(this);
            var url = '{{ route('clients.inventory.delete', ['id' => 0]) }}';
            var remove_url = url.slice(0, -1)+current_remove;

            Swal.fire({
                title: '{{ __("Êtes-vous sûr?") }}',
                text: '{{ __("Vous ne pourrez pas revenir en arrière") }}',
                icon: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: '{{ __("Oui, supprimez-le !") }}',
                cancelButtonText: '{{ __("Annuler") }}',
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-secondary"
                }
            }).then(function(a) {
                if(a.value) {
                    current_btn.prop('disabled', true);
                    current_btn.data("data-kt-indicator", "on");

                    $.ajax({
                        url: remove_url,
                        type: 'DELETE',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            current_btn.prop('disabled', false);
                            current_btn.data("data-kt-indicator", "off");

                            if(data.success) {
                                $('.btn-refresh').trigger('click');
                            }
                            
                            Swal.fire({
                                html: data.message,
                                icon: data.success ? "success" : "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            current_btn.prop('disabled', false);
                            current_btn.data("data-kt-indicator", "off");

                            Swal.fire({
                                html: '{{ __("Une erreur est survenue. Veuillez réessayer à nouveau.") }}',
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            });
                        }
                    });
                }
            });
        })


        // Add class to rows in mobile view
        function addClassToRows() {
            var screenWidth = $(window).width();
            var isMobileView = screenWidth < 768; // Adjust the breakpoint as needed
            
            table.rows().every(function () {
                var rowNode = this.node();
                if (isMobileView) {
                    $(rowNode).addClass('placeholder-loader'); // Add your desired class name
                } else {
                    $(rowNode).removeClass('placeholder-loader');
                }
            });
        }

        // Call the function on initial load and window resize
        addClassToRows();
        $(window).on('resize', addClassToRows);
	});


</script>
@endsection
