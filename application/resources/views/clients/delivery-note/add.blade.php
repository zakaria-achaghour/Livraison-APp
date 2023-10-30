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

    <div id="kt_app_content" class="app-content pt-2 flex-column-fluid ">
        @if($parcelsCount == 0)
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
                                    <h3 class="card-title d-flex align-items-center flex-row justify-center">
                                        <span class="card-label fw-bold text-white">{{ __('New Colis') }}</span>
                                        <span class="badge badge-light-dark">{{$parcelsCount}}</span>
                                    </h3>
                                </div>
                                <div class="card-body scroll hover-scroll-y vh-75">
                                    <div class="d-flex align-items-center justify-content-center h-100" v-if="parcels.isLoading">
                                        <div style="text-align: center;">
                                            <div class="h-80px">
                                                <span class="loader"></span>    
                                            </div>
                                            
                                            <h6 class="text-center">{{ __("Veuillez patienter") }}</h6>
                                        </div>
                                    </div>
                                    <div v-else-if="parcels.parcels.length == 0">
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
                                    {{-- template if data exist --}}
                                    <template v-else>
                                        <table class="table table-striped table-respo table-row-bordered table-row-gray-300 align-middle table-row-gray-300 fs-6 gy-5 datatable-browse">
                                            <tbody>
                                                <tr v-for="parcel in parcels.parcels">
                                                    <td data-label="{{ __('Parcels') }}">
                                                        <div class="d-flex justify-content-center justify-content-md-start align-items-center">

                                                            <div class="d-flex flex-column justify-content-center">
                                                                <b class="text-uppercase placeholder-loader"> @{{ parcel.parcel_code }}</b>
                                                                @{{parcel.parcel_amana_code == 1 ?'<br/>'. parcel.parcel_amana_code: ''}}<br/>
                                                                <br/><span class="badge badge-info placeholder-loader"><i class="ki-solid ki-cube-2 text-white me-1"></i>{{__('Normal')}} </span>
                                                                <span class="badge badge-warning me-1 placeholder-loader" v-if="parcel.parcel_replace == 1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Colis à remplacer') }}">
                                                                    <i class="ki-solid ki-arrow-right-left text-white"></i>
                                                                  </span>
                                                                  
                                                                  <span class="badge badge-primary placeholder-loader" v-if="parcel.parcel_edited == 1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Colis a été modifié') }}">
                                                                    <i class="ki-solid ki-pencil text-white"></i>
                                                                  </span>
                                                               </div>
                                                        </div>
                                                    </td>
                                                    <td data-label="{{ __('Reciver') }}">
                                                    
                                                            <div class="d-flex align-items-center justify-content-center justify-content-md-start">

                                                                    <div class="symbol symbol-circle symbol-40px me-2 placeholder-loader">
                                                                        <div class="symbol-label fs-5 fw-semibold bg-success text-inverse-success">@{{ getAvatarLetters(parcel.parcel_receiver) }}</div>
                                                                    </div>
                                                                    <div class="">
                                                                        <span class="text-gray-700 fw-bold text-hover-primary fs-8 placeholder-loader">@{{ parcel.parcel_receiver }}</span>
                                                                        <span class="text-gray-400 fw-semibold fs-7 d-block ps-0 placeholder-loader">@{{ parcel.parcel_phone }}</span> 
                                                                        <span class="text-gray-800 fs-7 d-block ps-0 placeholder-loader">@{{ parcel.city.name }}</span>  
                                                                    </div>
                                                            </div>
                                                            <div class="separator mb-2 border-3"></div>    
                                                       
                                                        
                                                    </td>

                                                    <td data-label="{{ __('Actions') }}">
                                                        <div class="d-flex align-items-center"> 
                                                            <button class="btn btn-icon btn-success btn-sm border-0"
                                                             {{-- @click="add($event, inventory)" :disabled="inventory.is_adding == 1" --}}
                                                             >
                                                                
                                                                <span class="indicator-label" v-if="parcels.isAdding == 0">
                                                                    <i class="ki-outline ki-plus text-white"></i>
                                                                </span>
                                                                <span class="indicator-progress d-block" v-if="parcel.isAdding == 1">
                                                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                                                </span>
                                                            </button>
                                                        </div>
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
                                    <span class="card-label fw-bold text-white">{{ __("Liste of Colis affected to Delivery note") }}</span>
                                </h3>
                            </div>
                            <div class="card-body scroll hover-scroll-y vh-75">
                                <div class="d-flex align-items-center justify-content-center h-100" v-if="deliveryNote.isLoading">
                                    <div style="text-align: center;">
                                        <div class="h-80px">
                                            <span class="loader"></span>    
                                        </div>
                                        
                                        <h6 class="text-center">{{ __("Veuillez patienter") }}</h6>
                                    </div>
                                </div>
                                <div v-else-if="deliveryNote.parcels.length == 0">
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <div style="text-align: center;">
                                            <i class="ki-duotone ki-information-4 mb-4" style="font-size: 6rem">
                                                <i class="path1"></i>
                                                <i class="path2"></i>
                                                <i class="path3"></i>
                                            </i>
                                            <h6 class="text-center">{{ __("No Colis Affected to Delivery Note") }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <template v-else>
                                    
                                </template>  
                            </div>
                        </div>

                    </div>
                </div>

                </div>

                {{-- <div class="card-footer py-6">
                    <button type="submit" class="btn btn-primary w-sm-auto w-100" @click="this.save" :disabled="is_adding">
                        <span class="indicator-label" v-if="!is_adding">{{ __("Enregister") }}</span>
                        <span class="indicator-progress d-block" v-if="is_adding">
                            {{ __("Veuillez patienter ...") }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div> --}}
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
                is_adding : false,
                parcels : {
                    isLoading : true,
                    isError : false,
                    isAdding: false,
                    message: '',
                    parcels : []
                },
                deliveryNote : {
                    isLoading : true,
                    isError : false,
                    parcels : []
                }
            }
        },
        mounted() {
            // function to in load
            this.getNewAndWaitingParcels();
        },
        methods: {
            getNewAndWaitingParcels : function() {
                var global_this = this;
                global_this.parcels.isLoading = true;
                global_this.parcels.isError = false;
                $.ajax({
                    url: "{{ route('clients.delivery-note.parcels.load') }}",
                    dataType: 'json',
                    success: function (data) {
                        global_this.parcels.isLoading = false;
                        global_this.deliveryNote.isLoading = false;
                        global_this.parcels.isError = false;
                        global_this.deliveryNote.isError = false;
                        global_this.parcels.parcels = data.parcels;
                    },
                    error: function() {
                        global_this.parcels.isLoading = false;
                        global_this.parcels.isError = true;
                        global_this.parcels.message = '{{ __("Une erreur est survenue. Veuillez réessayer à nouveau.") }}';
                    }
                });
            },
            getAvatarLetters: function(parcelReceiver) {
                let names = parcelReceiver.trim().split(" ");

                if (names.length === 0) {
                    return "?";
                } else if (names.length === 1) {
                    return names[0].substring(0, 2).toUpperCase();
                } else {
                    return (names[0].substring(0, 1) + names[1].substring(0, 1)).toUpperCase();
                }
            }
        }
    }).mount('#parcel_form');
</script>
@endsection