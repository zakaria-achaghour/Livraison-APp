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
        <div id="kt_app_content" class="app-content mt-5 flex-column-fluid ">
            
            <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                <!--begin::Messenger-->
                <div class="card shadow-md card-flush card-rounded" id="kt_chat_messenger">
                    <!--begin::Card header-->
                    <div class="card-header bg-warning" id="kt_chat_messenger_header">
                        <!--begin::Title-->
                        <div class="card-title">
                            <!--begin::User-->
                            <div class="d-flex justify-content-center flex-column me-3">
                                <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">Brian
                                    Cox</a>

                                <!--begin::Info-->
                                <div class="mb-0 lh-1">
                                    <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                    <span class="fs-7 fw-semibold text-muted">Active</span>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body " id="kt_chat_messenger_body">
                        <!--begin::Messages-->
                        <div class="scroll-y me-n5 pe-5 h-200px h-lg-200px" data-kt-element="messages" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                            data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body"
                            data-kt-scroll-offset="5px">



                            <!--begin::Message(in)-->
                            <div class="d-flex justify-content-start mb-10 ">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Avatar-->
                                        <div class="symbol  symbol-35px symbol-circle "><img alt="Pic"
                                                src="../../assets/media/avatars/300-25.jpg" />
                                        </div><!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-3">
                                            <a href="#"
                                                class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian
                                                Cox</a>
                                            <span class="text-muted fs-7 mb-1">2 mins</span>
                                        </div>
                                        <!--end::Details-->

                                    </div>
                                    <!--end::User-->

                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                                        data-kt-element="message-text">
                                        How likely are you to recommend our company to your
                                        friends and family ? </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(in)-->

                            <!--begin::Message(out)-->
                            <div class="d-flex justify-content-end mb-10 ">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-end">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Details-->
                                        <div class="me-3">
                                            <span class="text-muted fs-7 mb-1">5 mins</span>
                                            <a href="#"
                                                class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                        </div>
                                        <!--end::Details-->

                                        <!--begin::Avatar-->
                                        <div class="symbol  symbol-35px symbol-circle "><img alt="Pic"
                                                src="../../assets/media/avatars/300-1.jpg" />
                                        </div><!--end::Avatar-->
                                    </div>
                                    <!--end::User-->

                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
                                        data-kt-element="message-text">
                                        Hey there, we’re just writing to let you know that
                                        you’ve been subscribed to a repository on GitHub. </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(out)-->

                            <!--begin::Message(in)-->
                            <div class="d-flex justify-content-start mb-10 ">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Avatar-->
                                        <div class="symbol  symbol-35px symbol-circle "><img alt="Pic"
                                                src="../../assets/media/avatars/300-25.jpg" />
                                        </div><!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-3">
                                            <a href="#"
                                                class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian
                                                Cox</a>
                                            <span class="text-muted fs-7 mb-1">1 Hour</span>
                                        </div>
                                        <!--end::Details-->

                                    </div>
                                    <!--end::User-->

                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                                        data-kt-element="message-text">
                                        Ok, Understood! </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(in)-->

                            <!--begin::Message(out)-->
                            <div class="d-flex justify-content-end mb-10 ">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-end">
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Details-->
                                        <div class="me-3">
                                            <span class="text-muted fs-7 mb-1">2 Hours</span>
                                            <a href="#"
                                                class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                        </div>
                                        <!--end::Details-->

                                        <!--begin::Avatar-->
                                        <div class="symbol  symbol-35px symbol-circle "><img alt="Pic"
                                                src="../../assets/media/avatars/300-1.jpg" />
                                        </div><!--end::Avatar-->
                                    </div>
                                    <!--end::User-->

                                    <!--begin::Text-->
                                    <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
                                        data-kt-element="message-text">
                                        You’ll receive notifications for all issues, pull
                                        requests! </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Message(out)-->

                        </div>
                        <!--end::Messages-->
                    </div>
                    <!--end::Card body-->

                    <!--begin::Card footer-->
                    <div class="card-footer bg-active-light pt-4" id="kt_chat_messenger_footer">
                        <!--begin::Input-->
                        <textarea class="form-control form-control-solid  mb-3" rows="2" data-kt-element="input"
                            placeholder="Type a message"></textarea>
                        <!--end::Input-->

                        <!--begin:Toolbar-->
                        <div class="d-flex row">
                            <!--begin::Send-->
                            <button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
                            <!--end::Send-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Messenger-->
            </div>
        </div>
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

            // $(document).on('click', '.remove', function() {
            //     var current_remove = $(this).data('id');
            //     var current_btn = $(this);
            //     var url = '{{ route('clients.requests.pickups.delete', ['id' => 0]) }}';
            //     var remove_url = url.slice(0, -1) + current_remove;
            //     Swal.fire({
            //         title: '{{ __('Êtes-vous sûr?') }}',
            //         text: '{{ __('Vous ne pourrez pas revenir en arrière') }}',
            //         icon: "warning",
            //         buttonsStyling: false,
            //         showCancelButton: true,
            //         confirmButtonText: '{{ __('Yes, Cancel request !') }}',
            //         cancelButtonText: '{{ __('Annuler') }}',
            //         customClass: {
            //             confirmButton: "btn btn-danger",
            //             cancelButton: "btn btn-secondary"
            //         }
            //     }).then(function(a) {
            //         if (a.value) {
            //             current_btn.prop('disabled', true);
            //             current_btn.data("data-kt-indicator", "on");

            //             $.ajax({
            //                 url: remove_url,
            //                 type: 'DELETE',
            //                 processData: false,
            //                 contentType: false,
            //                 success: function(data) {
            //                     current_btn.prop('disabled', false);
            //                     current_btn.data("data-kt-indicator", "off");

            //                     if (data.success) {
            //                         $('.btn-refresh').trigger('click');
            //                     }

            //                     Swal.fire({
            //                         html: data.message,
            //                         icon: data.success ? "success" : "error",
            //                         buttonsStyling: !1,
            //                         confirmButtonText: "Ok",
            //                         customClass: {
            //                             confirmButton: "btn font-weight-bold btn-light-primary"
            //                         }
            //                     });
            //                 },
            //                 error: function(xhr, status, error) {
            //                     current_btn.prop('disabled', false);
            //                     current_btn.data("data-kt-indicator", "off");

            //                     Swal.fire({
            //                         html: '{{ __('Une erreur est survenue. Veuillez réessayer à nouveau.') }}',
            //                         icon: "error",
            //                         buttonsStyling: !1,
            //                         confirmButtonText: "Ok",
            //                         customClass: {
            //                             confirmButton: "btn font-weight-bold btn-light-primary"
            //                         }
            //                     });
            //                 }
            //             });
            //         }
            //     });
            // })
        });
    </script>
    @yield('datatable_options')
@endsection
