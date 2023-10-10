@extends('clients.layouts.app')

@section('title', __('Nouveau Colis'))

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
        <div class="d-flex flex-stack flex-row-fluid">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="page-title d-flex align-items-center me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Nouveau Colis") }}</span>
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
                        {{ __("Nouveau Colis") }} </li>
                </ul>
            </div>

            {{-- <div class="d-flex align-self-center flex-center flex-shrink-0">
                <a href="{{ route('clients.parcels.add') }}" class="btn btn-sm btn-success d-flex flex-center ms-3 px-4 py-3">
                    <i class="ki-outline ki-plus-square fs-2"></i>
                    <span>{{ __("Nouveau Colis") }}</span>
                </a>
            </div> --}}
        </div>
    </div>

    <div id="kt_app_content" class="app-content pt-2 flex-column-fluid ">
        <form action="{{ route('clients.parcels.save') }}" method="POST" id="parcel_form">
            <div class="card card-flush pt-3 mb-5">
                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("Code suivi") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-cube-2 fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-solid ps-12" name="parcel_code" placeholder="{{ __("Code suivi") }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("Destinataire") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-user"></i>
                                    </div>
                                    <input class="form-control form-control-solid ps-12" name="parcel_receiver" placeholder="{{ __("Destinataire") }}" id="name_inputmask">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="flex-row-fluid mb-8">
                                <label class="required form-label">{{ __("Téléphone") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-whatsapp fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-solid ps-12" name="parcel_phone" placeholder="{{ __("Téléphone") }}" id="phone_inputmask">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label">{{ __("Marchandise") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-purchase fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-solid ps-12" name="parcel_prd_name" placeholder="{{ __("Marchandise") }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label">{{ __("Quantité") }}</label>
                                <div class="position-relative" data-kt-dialer="true" data-kt-dialer-min="1" data-kt-dialer-max="1000" data-kt-dialer-step="1" data-kt-dialer-decimals="0">
                                    <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
                                        <i class="ki-outline ki-minus-square fs-1"></i> </button>

                                    <input type="text" class="form-control form-control-solid border-0 text-center" data-kt-dialer-control="input" placeholder="{{ __("Quantité") }}" name="parcel_prd_qty" readonly />

                                    <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
                                        <i class="ki-outline ki-plus-square fs-1"></i> </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label required">{{ __("Prix") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-bill fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-solid ps-12" name="parcel_price" placeholder="{{ __("Prix") }}" id="price_inputmask">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label required">{{ __("Ville") }}</label>
                                <select class="form-control form-control-solid cities-select2" name="parcel_city">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label">{{ __("Tarifs") }}</label>
                                <div class="input-group">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="input-group mb-5 placeholder-loader">
                                                <span class="input-group-text">{{ __("Livraison")}}</span>
                                                <input type="text" class="form-control form-control-solid" value="0 {{ __('DH') }}" id="delivered-fees" disabled>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="input-group mb-5 placeholder-loader">
                                                <span class="input-group-text">{{ __("Retour")}}</span>
                                                <input type="text" class="form-control form-control-solid" value="0 {{ __('DH') }}" id="returned-fees" disabled>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="input-group mb-5 placeholder-loader">
                                                <span class="input-group-text">{{ __("Refus")}}</span>
                                                <input type="text" class="form-control form-control-solid" value="0 {{ __('DH') }}" id="refused-fees" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label required">{{ __("Adresse") }}</label>
                                <textarea name="parcel_address" class="form-control form-control-solid" placeholder="{{ __("Adresse") }}" data-kt-autosize="true" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <div class="flex-row-fluid mb-8">
                                <label class="form-label">
                                    {{ __("Commentaire") }} <small>({{ __("Autre téléphone, Date de livraison ...") }})</small>
                                </label>
                                <textarea name="parcel_note" class="form-control form-control-solid" placeholder="{{ __("Commentaire") }}" data-kt-autosize="true" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="flex-row-fluid">
                                <label class="form-label required">{{ __("Options") }}</label>
                                <div class="d-flex flex-column flex-md-row">
                                    <label class="form-check form-switch form-check-custom form-check-solid me-3 mb-3">
                                        <input class="form-check-input" name="parcel_open" type="checkbox"/>
                                        <span class="form-check-label fw-semibold text-muted">
                                            {{ __("Peut ouvrir le colis") }}
                                        </span>
                                    </label>

                                    <label class="form-check form-switch form-check-custom form-check-solid me-3 mb-3">
                                        <input class="form-check-input" name="parcel_replace" type="checkbox"/>
                                        <span class="form-check-label fw-semibold text-muted">
                                            {{ __("Colis à remplacer") }}
                                        </span>
                                    </label>

                                    @if(\Auth::user()->customers_stock == 1)
                                    <label class="form-check form-switch form-check-custom form-check-solid me-3 mb-3">
                                        <input class="form-check-input" name="parcel_stock_check" type="checkbox"/>
                                        <span class="form-check-label fw-semibold text-muted">
                                            {{ __("Colis de Stock") }}
                                        </span>
                                    </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer py-6">
                    <button type="submit" class="btn btn-primary w-sm-auto w-100" @click="this.save" :disabled="is_adding">
                        <span class="indicator-label" v-if="!is_adding">{{ __("Enregister") }}</span>
                        <span class="indicator-progress d-block" v-if="is_adding">
                            {{ __("Veuillez patienter ...") }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('after_js')
<script src="{{ asset('assets/global/js/vue.js') }}"></script>
<script type="module">
    const { createApp } = Vue;
    console.warn = () => {};

    createApp({
        data() {
            return {
                is_adding : false
            }
        },
        mounted() {
            Inputmask({
                mask: '06{1} 99 99 99 99',
                placeholder: '0_ __ __ __ __',
                definitions: {
                  '6': {
                    validator: "[5-8]",
                  }
                }
            }).mask("#phone_inputmask");

            Inputmask({
                mask: '*{1,50}',
                definitions: {
                    '*': {
                      validator: "[\u0600-\u06FFA-Za-z '\"]",
                      casing: "upper"
                    }
                }
            }).mask("#name_inputmask");

            Inputmask({
                alias: 'numeric',
                rightAlign: false,
                digits: 2,
                radixPoint: '.',
                groupSeparator: '',
                autoGroup: true,
                autoUnmask: true,
                allowMinus: false
            }).mask("#price_inputmask");

            this.load();
        },
        methods: {
            load : function() {
                var global_this = this;
                $.ajax({
                    url: "{{ route('clients.parcels.load.cities') }}",
                    dataType: 'json',
                    success: function (data) {
                        $('.cities-select2').select2({
                            data: data,
                            placeholder: '{{ __("Ville") }}',
                            language: 'fr',
                            allowClear: true,
                        });

                        $('.cities-select2').on('change', global_this.get_tarfis);
                    }
                });                
            },
            get_tarfis : function(event) {
                $('.placeholder-loader').addClass('holder-active');
                var city_id = event.target.value;

                $.ajax({
                    url: "{{ route('clients.parcels.city.tarifs') }}",
                    method : "POST",
                    data: {city_id : city_id},
                    dataType: 'json',
                    success: function (data) {
                        $('#delivered-fees').val(data.fees+' {{ __('DH') }}');
                        $('#returned-fees').val(data.return+' {{ __('DH') }}');
                        $('#refused-fees').val(data.refuse+' {{ __('DH') }}');
                        $('.placeholder-loader').removeClass('holder-active');
                    }
                });
            },
            save : function(event) {
                event.preventDefault();
                this.is_adding = true;

                var global_this = this;
                var formData = new FormData($('#parcel_form')[0]);

                $.ajax({
                    url: "{{ route('clients.parcels.save') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        global_this.is_adding = false;

                        Swal.fire({
                            html: data.message,
                            icon: data.success ? "success" : "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });

                        if(data.success) {
                            setTimeout(function() {
                                location.href = data.redirect;
                            },1200);
                        }
                    },
                    error: function(xhr, status, error) {
                        global_this.is_adding = false;
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

        }
    }).mount('#kt_app_body');
</script>
@endsection