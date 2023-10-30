@extends('clients.layouts.app')

@section('title', __('Modifier Colis'))

@section('currentUrl')
currentUrl = '{{ route('clients.parcels.from-inventory') }}';
@endsection

@section('after_css')
<style>
    .image-input-placeholder {
        background-image: url('{{ asset('assets/clients/media/svg/files/blank-image.svg') }}');
    }

    [data-bs-theme="dark"] .image-input-placeholder {
        background-image: url('{{ asset('assets/clients/media/svg/files/blank-image-dark.svg') }}');
    }                
</style>
@endsection

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
        <div class="d-flex flex-stack flex-row-fluid">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="page-title d-flex align-items-center me-3">
                    <h1 class="page-heading d-flex flex-row justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Modifier Colis") }}</span>

                        <span class="badge badge-success placeholder-loader">
                            <i class="ki-solid ki-logistic text-white me-1"></i>{{ __('Stock') }}
                        </span>
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
                        <a href="{{ route('clients.parcels.waiting-pick-up') }}" class="text-hover-primary">
                            {{ __('Colis') }} 
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("Modifier Colis") }} </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content pt-2 flex-column-fluid ">
        <form action="{{ route('clients.parcels.update') }}" method="POST" id="parcel_form">
            <input type="hidden" name="parcel_id" value="{{ $parcel->parcel_id }}">
            <div class="card p-0 mb-5">
                <div class="card-body pt-5 pb-0">
                    <ul class="nav nav-pills nav-pills-custom row position-relative mx-0">
                        <li class="nav-item col-6 mx-0 p-0">

                            <a class="nav-link {{ !request()->has('active') || request()->query('active') != 'products' ? 'active' : '' }} d-flex justify-content-center w-100 border-0 h-100" data-bs-toggle="pill" href="#tab_1">
                                <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">
                                    {{ __('Information de colis') }}
                                </span>
                                <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                            </a>
                        </li>
                        
                        <li class="nav-item col-6 mx-0 px-0">
                            <a class="nav-link {{ request()->has('active') && request()->query('active') == 'products' ? 'active' : '' }} d-flex justify-content-center w-100 border-0 h-100" data-bs-toggle="pill" href="#tab_2">
                                <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">
                                    {{ __('Produit de colis') }}
                                </span>
                                <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                            </a>
                        </li>
                       
                        <span class="position-absolute z-index-1 bottom-0 w-100 h-4px bg-light rounded"></span>
                    </ul>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade {{ !request()->has('active') || request()->query('active') != 'products' ? 'show active' : '' }}" id="tab_1">
                    <div class="card card-flush pt-3 mb-5">
                        <div class="card-body pb-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="required form-label">{{ __("Code suivi") }}</label>
                                        <div class="position-relative">
                                            <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                                <i class="ki-outline ki-cube-2 fs-3"></i>
                                            </div>
                                            <input class="form-control form-control-solid ps-12" name="parcel_code" placeholder="{{ __("Code suivi") }}" value="{{ $parcel->parcel_code }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="required form-label">{{ __("Destinataire") }}</label>
                                        <div class="position-relative">
                                            <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                                <i class="ki-outline ki-user"></i>
                                            </div>
                                            <input class="form-control form-control-solid ps-12" name="parcel_receiver" placeholder="{{ __("Destinataire") }}" id="name_inputmask" value="{{ $parcel->parcel_receiver }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="required form-label">{{ __("Téléphone") }}</label>
                                        <div class="position-relative">
                                            <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                                <i class="ki-outline ki-whatsapp fs-3"></i>
                                            </div>
                                            <input class="form-control form-control-solid ps-12" name="parcel_phone" placeholder="{{ __("Téléphone") }}" id="phone_inputmask" value="{{ $parcel->parcel_phone }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="form-label required">{{ __("Prix") }}</label>
                                        <div class="position-relative">
                                            <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                                <i class="ki-outline ki-bill fs-3"></i>
                                            </div>
                                            <input class="form-control form-control-solid ps-12" name="parcel_price" placeholder="{{ __("Prix") }}" id="price_inputmask" value="{{ $parcel->parcel_price }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-4">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="form-label required">{{ __("Ville") }}</label>
                                        <select class="form-control form-control-solid cities-select2" name="parcel_city">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-8">
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
                                        <textarea name="parcel_address" class="form-control form-control-solid" placeholder="{{ __("Adresse") }}" data-kt-autosize="true" rows="4">{{ $parcel->parcel_address }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6">
                                    <div class="flex-row-fluid mb-8">
                                        <label class="form-label">
                                            {{ __("Commentaire") }} <small>({{ __("Autre téléphone, Date de livraison ...") }})</small>
                                        </label>
                                        <textarea name="parcel_note" class="form-control form-control-solid" placeholder="{{ __("Commentaire") }}" data-kt-autosize="true" rows="4">{{ $parcel->parcel_note }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="flex-row-fluid">
                                        <label class="form-label required">{{ __("Options") }}</label>
                                        <div class="d-flex flex-column flex-md-row">
                                            <label class="form-check form-switch form-check-custom form-check-solid me-3 mb-3">
                                                <input class="form-check-input" name="parcel_open" type="checkbox"  {{ $parcel->parcel_open == "1" ? "checked" : '' }}/>
                                                <span class="form-check-label fw-semibold text-muted">
                                                    {{ __("Peut ouvrir le colis") }}
                                                </span>
                                            </label>

                                            <label class="form-check form-switch form-check-custom form-check-solid me-3 mb-3">
                                                <input class="form-check-input" name="parcel_replace" {{ $parcel->parcel_replace == "1" ? "checked" : '' }} type="checkbox"/>
                                                <span class="form-check-label fw-semibold text-muted">
                                                    {{ __("Colis à remplacer") }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade {{ request()->has('active') && request()->query('active') == 'products' ? 'show active' : '' }}" id="tab_2">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-5">
                                <div class="card-header border-3 bg-success">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-white">{{ __('Les produits disponibles en stock') }}</span>
                                    </h3>
                                </div>
                                <div class="card-body scroll hover-scroll-y vh-75">
                                    <div class="d-flex align-items-center justify-content-center h-100" v-if="all.is_loading">
                                        <div style="text-align: center;">
                                            <div class="h-80px">
                                                <span class="loader"></span>    
                                            </div>
                                            
                                            <h6 class="text-center">{{ __("Veuillez patienter") }}</h6>
                                        </div>
                                    </div>
                                    <div v-else-if="all.products.length == 0">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <div style="text-align: center;">
                                                <i class="ki-duotone ki-information-4 mb-4" style="font-size: 6rem">
                                                    <i class="path1"></i>
                                                    <i class="path2"></i>
                                                    <i class="path3"></i>
                                                </i>
                                                <h6 class="text-center">{{ __("Aucun produit affecté à ce colis") }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <template v-else>
                                       <table class="table table-striped table-respo table-row-bordered table-row-gray-300 align-middle">
                                            <tbody>
                                                <tr v-for="product in all.products">
                                                    <td data-label="{{ __('Produit') }}">
                                                        <div class="d-flex justify-content-center justify-content-md-start align-items-center">
                                                            <div class="symbol symbol-60px me-3">
                                                                <div class="symbol-label" :style="{
                                                                    backgroundImage: 'url({{ asset('images/inventory')}}/'+encodeURIComponent(product.product_pic) +')'}" v-if="product.product_pic != ''"></div>
                                                                <div class="symbol-label image-input-placeholder" v-else></div>
                                                            </div>

                                                            <div class="d-flex flex-column justify-content-center">
                                                                <span class="text-gray-800 fw-bold fs-6">
                                                                    @{{ product.product_name }}
                                                                </span>
                                                                <span class="badge badge-success fs-8" v-if="product.product_variant == 1">
                                                                    {{ __("Produit avec variantes") }}
                                                                </span>
                                                                <span class="badge badge-primary fs-8" v-else>
                                                                    {{ __("Produit simple") }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td data-label="{{ __('Stock') }}">
                                                        <template v-for="inventory in product.avalaible_inventory">
                                                            <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2" >
                                                                <div class="">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-5">
                                                                            <span class="text-gray-800 fw-bold text-hover-primary fs-7">
                                                                                #@{{ inventory.inventory_var_name }} 
                                                                            </span>
                                                                            <span class="text-gray-400 fw-semibold fs-8 d-block text-start ps-0">@{{ inventory.inventory_ref }}</span>           
                                                                        </div>

                                                                        <div class="pulse-success">
                                                                            <span class="pulse-ring" style="top:-25%"></span>
                                                                            <span class="badge badge-light-success fs-4 me-1">x@{{ inventory.inventory_qty }}</span>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="d-flex align-items-center"> 
                                                                    <button class="btn btn-icon btn-success btn-sm border-0" @click="add($event, inventory)" :disabled="inventory.is_adding == 1">
                                                                        
                                                                        <span class="indicator-label" v-if="inventory.is_adding == 0">
                                                                            <i class="ki-outline ki-plus text-white"></i>
                                                                        </span>
                                                                        <span class="indicator-progress d-block" v-if="inventory.is_adding == 1">
                                                                            <span class="spinner-border spinner-border-sm align-middle"></span>
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="separator mb-2 border-3"></div>    
                                                        </template>
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </template>       
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card mb-5">
                                <div class="card-header border-3 bg-danger">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-white">{{ __("Liste des produits affectés à ce colis") }}</span>
                                    </h3>
                                </div>
                                <div class="card-body scroll hover-scroll-y vh-75">
                                    <div class="d-flex align-items-center justify-content-center h-100" v-if="parcel.is_loading">
                                        <div style="text-align: center;">
                                            <div class="h-80px">
                                                <span class="loader"></span>    
                                            </div>
                                            
                                            <h6 class="text-center">{{ __("Veuillez patienter") }}</h6>
                                        </div>
                                    </div>
                                    <div v-else-if="parcel.products.length == 0">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <div style="text-align: center;">
                                                <i class="ki-duotone ki-information-4 mb-4" style="font-size: 6rem">
                                                    <i class="path1"></i>
                                                    <i class="path2"></i>
                                                    <i class="path3"></i>
                                                </i>
                                                <h6 class="text-center">{{ __("Aucun produit affecté à ce colis") }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <template v-else>
                                        <table class="table table-striped table-respo table-row-bordered table-row-gray-300 align-middle">
                                            <tbody>
                                                <tr v-for="product in parcel.products">
                                                    <td data-label="{{ __('Produit') }}">
                                                        <div class="d-flex justify-content-center justify-content-md-start align-items-center">
                                                            <div class="symbol symbol-60px me-3">
                                                                <div class="symbol-label" :style="{
                                                                    backgroundImage: 'url({{ asset('images/inventory')}}/'+encodeURIComponent(product.product_pic) +')'}" v-if="product.product_pic != ''"></div>
                                                                <div class="symbol-label image-input-placeholder" v-else></div>
                                                            </div>

                                                            <div class="d-flex flex-column justify-content-center">
                                                                <span class="text-gray-800 fw-bold fs-6">
                                                                    @{{ product.product_name }}
                                                                </span>
                                                                <span class="badge badge-success fs-8" v-if="product.product_variant == 1">
                                                                    {{ __("Produit avec variantes") }}
                                                                </span>
                                                                <span class="badge badge-primary fs-8" v-else>
                                                                    {{ __("Produit simple") }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td data-label="{{ __('Quantité Affecté') }}">
                                                        <template v-for="inventory in product.inventory">
                                                            <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2" >
                                                                <div class="">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-5">
                                                                            <span class="text-gray-800 fw-bold text-hover-primary fs-7">
                                                                                #@{{ inventory.inventory_var_name }} 
                                                                            </span>
                                                                            <span class="text-gray-400 fw-semibold fs-8 d-block text-start ps-0">@{{ inventory.inventory_ref }}</span>           
                                                                        </div>

                                                                        <div class="">
                                                                            <span class="badge badge-light-danger fs-4 me-1">x@{{ inventory.affected_content.length }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="d-flex align-items-center"> 
                                                                    <button class="btn btn-icon btn-danger btn-sm border-0" @click="remove($event, inventory)" :disabled="inventory.is_removing == 1">
                                                                        <span class="indicator-label" v-if="inventory.is_removing == 0">
                                                                            <i class="ki-outline ki-minus text-white"></i>
                                                                        </span>
                                                                        <span class="indicator-progress d-block" v-if="inventory.is_removing == 1">
                                                                            <span class="spinner-border spinner-border-sm align-middle"></span>
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="separator mb-2 border-3"></div>    
                                                        </template>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </template>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary w-sm-auto w-100" @click="this.update" :disabled="is_editing">
                    <span class="indicator-label" v-if="!is_editing">{{ __("Enregister") }}</span>
                    <span class="indicator-progress d-block" v-if="is_editing">
                        {{ __("Veuillez patienter ...") }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
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
                is_editing : false,
                current_parcel : {{ $parcel->parcel_id }},
                all : {
                    is_loading : true,
                    is_error : false,
                    products : []
                },
                parcel : {
                    is_loading : true,
                    is_error : false,
                    products : []
                }
            }
        },
        mounted() {
            this.mask();
            this.load();
            this.all_inventory_for_parcel();
            this.parcel_products();
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
                        $('.cities-select2').val('{{ $parcel->parcel_city }}').trigger('change');
                    }
                });                
            },
            remove : function(event, inventory) {
                event.preventDefault();
                inventory.is_removing = 1;

                var global_this = this;

                $.ajax({
                    url: "{{ route('clients.parcels.from-inventory.remove_parcel_products') }}",
                    type: 'POST',
                    data : {
                        inventory_id : inventory.inventory_id,
                        parcel_id : this.current_parcel
                    },
                    dataType: 'json',
                    success: function (data) {
                        inventory.is_removing = 0;

                        if(data.success) {
                            global_this.all_inventory_for_parcel();
                            global_this.parcel_products();
                            //inventory.inventory_qty = inventory.inventory_qty + 1;
                        }
                        else {
                            Swal.fire({
                                html: data.message,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            });
                        }
                    },
                    error: function() {
                        inventory.is_removing = 0;

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
            },
            add : function(event, inventory) {
                event.preventDefault();
                inventory.is_adding = 1;
                var global_this = this;

                $.ajax({
                    url: "{{ route('clients.parcels.from-inventory.add_parcel_products') }}",
                    type: 'POST',
                    data : {
                        inventory_id : inventory.inventory_id,
                        parcel_id : this.current_parcel
                    },
                    dataType: 'json',
                    success: function (data) {
                        inventory.is_adding = 0;

                        if(data.success) {
                            global_this.parcel_products();
                            inventory.inventory_qty = inventory.inventory_qty - 1;
                        }
                        else {
                            Swal.fire({
                                html: data.message,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            });
                        }
                    },
                    error: function() {
                        inventory.is_adding = 0;

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
            },
            parcel_products : function() {
                var global_this = this;
                global_this.parcel.is_loading = true;
                global_this.parcel.is_error = false;
                $.ajax({
                    url: "{{ route('clients.parcels.from-inventory.parcel_products', ['id' => $parcel->parcel_id]) }}",
                    dataType: 'json',
                    success: function (data) {
                        global_this.parcel.is_loading = false;
                        global_this.parcel.is_error = false;
                        global_this.parcel.products = data.products;
                    },
                    error: function() {
                        global_this.parcel.is_loading = false;
                        global_this.parcel.is_error = true;
                        global_this.parcel.message = '{{ __("Une erreur est survenue. Veuillez réessayer à nouveau.") }}';
                    }
                });
            },
            all_inventory_for_parcel : function () {
                var global_this = this;
                global_this.all.is_loading = true;
                global_this.all.is_error = false;
                $.ajax({
                    url: "{{ route('clients.parcels.from-inventory.load_for_parcel') }}",
                    dataType: 'json',
                    success: function (data) {
                        global_this.all.is_loading = false;
                        global_this.all.is_error = false;
                        global_this.all.products = data.products;
                    },
                    error: function() {
                        global_this.all.is_loading = false;
                        global_this.all.is_error = true;
                        global_this.all.message = '{{ __("Une erreur est survenue. Veuillez réessayer à nouveau.") }}';
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
            update : function(event) {
                event.preventDefault();
                this.is_editing = true;

                var global_this = this;
                var formData = new FormData($('#parcel_form')[0]);

                $.ajax({
                    url: "{{ route('clients.parcels.update') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        global_this.is_editing = false;

                        if(data.success) {
                            setTimeout(function(){ 
                                window.location = data.redirect;
                            }, 1500)
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
                        global_this.is_editing = false;
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
            },
            mask : function() {
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
            }
            /*,
            increment_inventory : function(inventory_s) {
                for(product in this.all.products) {
                    for(inventory in product.inventory) {
                        if(inventory.inventory_id == inventory_s.inventory_id) {
                            inventory.inventory_qty = inventory.inventory_qty + 1;
                            inventory_s.affected.shift();
                            break;
                        }
                    }
                }
            }*/

        }
    }).mount('#kt_app_body');
</script>
@endsection