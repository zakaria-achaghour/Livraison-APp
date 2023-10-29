@extends('clients.layouts.app')

@section('title', __('Nouveau Bon de Livraison'))

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
        <div class="d-flex flex-stack flex-row-fluid">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="page-title d-flex align-items-center me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Nouveau Bon de Livraison") }}</span>
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
                        {{ __("Bon de Livraison") }} </li>
                </ul>
            </div>
        </div>
    </div>

    @php
    $count_new_parcels = request()->user()->newParcels()->count();
    @endphp

    <div id="kt_app_content" class="app-content pt-2 flex-column-fluid ">
        @if($count_new_parcels == 0)
        <div class="card card-flush pt-3 mb-5">
            <div class="card-body pb-2">
                <div class="d-flex align-items-center justify-content-center" style="flex: 1;min-height: 50vh;">
                    <div style="text-align: center;">
                        <i class="ki-duotone ki-information-4 text-warning fs-7x mb-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                            <i class="path3"></i>
                        </i>
                        <h5 class="fs-3 text-center">{{ __("Aucun nouveau colis trouvé") }}</h5>
                        <p class="fs-5">
                            {{ __('Veuillez ajouter au moins un colis pour créer un nouveau bon de livraison.') }}
                        </p>
                        <a class="btn btn-success" href="{{ route('clients.parcels.add') }}">{{ __('Nouveau colis') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <form action="{{ route('clients.delivery-note.save') }}" method="POST" id="parcel_form">
            <div class="card card-flush pt-3 mb-5">
                <div class="card-body pb-2">
                    

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-5">
                                <div class="card-header border-3 bg-success">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-white">{{ __('New Colis') }}</span>
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
                                    {{-- <div v-else-if="all.products.length == 0"> --}}
                                    <div v-else-if="all.colis.length == 0">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <div style="text-align: center;">
                                                <i class="ki-duotone ki-information-4 mb-4" style="font-size: 6rem">
                                                    <i class="path1"></i>
                                                    <i class="path2"></i>
                                                    <i class="path3"></i>
                                                </i>
                                                <h6 class="text-center">{{ __("No parcels") }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <template v-else>
                                        <table class="table table-striped table-respo table-row-bordered table-row-gray-300 align-middle">
                                            <tbody>
                                                <tr v-for="parcel in all.parcels">
                                                    <td data-label="{{ __('Produit') }}">
                                                        <div class="d-flex justify-content-center justify-content-md-start align-items-center">
                                                            <div class="symbol symbol-60px me-3">
                                                                {{-- <div class="symbol-label" :style="{
                                                                    backgroundImage: 'url({{ asset('images/inventory')}}/'+encodeURIComponent(product.product_pic) +')'}" v-if="product.product_pic != ''"></div>
                                                                <div class="symbol-label image-input-placeholder" v-else></div> --}}

                                                                Image
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
                                                    {{-- <td data-label="{{ __('Stock') }}">
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
                                                        
                                                    </td> --}}
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
        @endif
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
            
        },
        methods: {

        }
    }).mount('#parcel_form');
</script>
@endsection