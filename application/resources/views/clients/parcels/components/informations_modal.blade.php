<div class="modal fade" id="informations_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-700px">
        <div class="modal-content" style="background-color:transparent;">
            <div class="card card-xl-stretch mb-xl-8">
                <div class="card-body" v-if="is_loading_informations">
                    <div class="card-px text-center pt-15 pb-15">
                        <div class="d-flex align-items-center justify-content-center" style="flex: 1">
                            <div style="text-align: center;">
                                <div class="h-80px">
                                    <span class="loader"></span>    
                                </div>
                                <h6 class="text-center">{{ __("Veuillez patienter") }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0" v-else-if="parcel == null">
                    <div class="card-px text-center pt-15 pb-15">
                        <div class="d-flex align-items-center justify-content-center" style="flex: 1;min-height: 35vh;">
                            <div style="text-align: center;">
                                <i class="ki-duotone ki-information-4 mb-2">
                                    <i class="path1 fs-5x"></i>
                                    <i class="path2 fs-5x"></i>
                                    <i class="path3 fs-5x"></i>
                                </i>
                                <h6 class="text-center">{{ __("Élément introuvable") }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0" v-else>
                    <!--begin::Header-->
                    <div class="px-9 pt-7 card-rounded h-300px w-100 bg-primary">
                        <!--begin::Heading-->
                        <div class="d-flex flex-stack">
                            <h3 class="m-0 text-white fw-bold fs-3">{{ __('Information du colis') }}</h3>
                            <div class="ms-1">
                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                    <i class="ki-outline ki-cross fs-1 text-white"></i> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center text-center flex-column text-white pt-8">
                            <span class="fw-semibold fs-7">{{ __("Code Suivi") }}</span>
                            <span class="fw-bold fs-2x pt-1">@{{ parcel.parcel_code }}</span>

                            <span class="badge badge-success placeholder-loader" v-if="parcel.parcel_from_stock == 1">
                                <i class="ki-solid ki-logistic text-white fs-2"></i>{{ __('Stock') }}
                            </span>

                            <span class="badge badge-info placeholder-loader" v-else>
                                <i class="ki-solid ki-cube-2 text-white fs-2"></i>{{ __('Normal') }}
                            </span>
                        
                        </div>
                    </div>


                    <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -100px">

                        <template v-if="parcel.parcel_from_stock == 0">
                            <div class="d-flex align-items-center mb-6">
                                <div class="symbol symbol-45px w-40px me-5">
                                    <span class="symbol-label bg-lighten">
                                        <i class="ki-outline ki-basket-ok fs-1"></i>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <span class="fs-5 text-gray-800 text-hover-primary fw-bold">{{ __('Produit')}}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold fs-5 text-gray-800 pe-1">
                                            @{{ parcel.parcel_product_name }} x @{{ parcel.parcel_product_qty }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="d-flex align-items-center mb-6">
                            <div class="symbol symbol-45px w-40px me-5">
                                <span class="symbol-label bg-lighten">
                                    <i class="ki-outline ki-user fs-1"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap w-100">
                                <div class="mb-1 pe-3 flex-grow-1">
                                    <span class="fs-5 text-gray-800 text-hover-primary fw-bold">{{ __('Destinataire')}}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold fs-5 text-gray-800 pe-1">@{{ parcel.parcel_receiver }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-6">
                            <div class="symbol symbol-45px w-40px me-5">
                                <span class="symbol-label bg-lighten">
                                    <i class="las la-phone fs-1"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap w-100">
                                <div class="mb-1 pe-3 flex-grow-1">
                                    <span class="fs-5 text-gray-800 text-hover-primary fw-bold">{{ __("Téléphone") }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold fs-5 text-gray-800 pe-1">@{{ parcel.parcel_phone }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-6">
                            <div class="symbol symbol-45px w-40px me-5">
                                <span class="symbol-label bg-lighten">
                                    <i class="ki-outline ki-geolocation fs-1"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap w-100">
                                <div class="mb-1 pe-3 flex-grow-1">
                                    <span class="fs-5 text-gray-800 text-hover-primary fw-bold">{{ __("Ville") }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold fs-5 text-gray-800 pe-1">@{{ parcel.city.name }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-6">
                            <div class="symbol symbol-45px w-40px me-5">
                                <span class="symbol-label bg-lighten">
                                    <i class="ki-outline ki-map fs-1"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap w-100">
                                <div class="mb-1 pe-3 flex-grow-1">
                                    <span class="fs-5 text-gray-800 text-hover-primary fw-bold">{{ __("Adresse") }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold fs-5 text-gray-800 pe-1">@{{ parcel.parcel_address }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-45px w-40px me-5">
                                <span class="symbol-label bg-lighten">
                                    <i class="ki-outline ki-document fs-1"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap w-100">
                                <div class="mb-1 pe-3 flex-grow-1">
                                    <span class="fs-5 text-gray-800 text-hover-primary fw-bold">{{ __("Commentaire") }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold fs-5 text-gray-800 pe-1">@{{ parcel.parcel_note }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-body shadow-sm card-rounded mt-3 mx-9 mb-9 px-6 py-9 position-relative z-index-1" v-if="parcel.parcel_from_stock == 1">
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
                                    <td data-label="{{ __('Quantité') }}">
                                        <template v-for="inventory in product.inventory">
                                            <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2" >
                                                <div class="d-flex align-items-center">
                                                    <div class="me-5">
                                                        <span class="text-gray-800 fw-bold text-hover-primary fs-7">
                                                            #@{{ inventory.inventory_var_name }} 
                                                        </span>
                                                        <span class="text-gray-400 fw-semibold fs-8 d-block text-start ps-0">@{{ inventory.inventory_ref }}</span>           
                                                    </div>

                                                    <span class="badge badge-light-success fs-4 me-1">
                                                        x @{{ inventory.inventory_qty }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="separator mb-2 border-3"></div>    
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .image-input-placeholder {
        background-image: url('{{ asset('assets/clients/media/svg/files/blank-image.svg') }}');
    }

    [data-bs-theme="dark"] .image-input-placeholder {
        background-image: url('{{ asset('assets/clients/media/svg/files/blank-image-dark.svg') }}');
    }                
</style>

@section('informations_modal')
    <script type="text/javascript">
        var current_informations = null;

        $(document).ready(function() {  
            $(document).on('click', '.info', function() {
                current_informations = $(this).data('id');
                $('#informations_modal').modal('show');
            })
        });
    </script>
    
    <script type="module">
        const { createApp } = Vue;
        console.warn = () => {};

        createApp({
            data() {
                return {
                    is_loading_informations : true,
                    parcel : null,
                }
            },
            mounted() {
                $('#informations_modal').on('show.bs.modal', () => {
                    this.$forceUpdate();
                    this.informations();
                });
            },
            methods: {
                informations : function() {
                    this.is_loading_informations = true;
                    var global_this = this;

                    $.ajax({
                        url: '{{ route('clients.parcels.informations') }}/'+current_informations,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            global_this.is_loading_informations = false;
                            if(data != null) {
                                global_this.parcel = data;
                            }
                        },
                        error: function(xhr, status, error) {
                            global_this.parcel = null;
                            global_this.is_loading_informations = false;
                            $('#informations_modal').modal('hide');
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
                moment: function ($time) {
                    return window.moment($time*1000);
                }
            }
        }).mount('#informations_modal');
    </script>
@endsection