<div class="modal fade" id="livreur_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-400px">
        <div class="modal-content">
            <div class="modal-header pb-0 justify-content-end border-0">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i> 
                </div>
            </div>

            <div class="card card-xl-stretch mb-xl-8">
                <div class="card-body" v-if="is_loading_livreur">
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
                                <h6 class="text-center">{{ __("Désolé, mais les informations ne sont pas disponibles pour le moment. Veuillez réessayer ultérieurement.") }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" v-else>
                    <div class="d-flex flex-column border border-gray-300 rounded mb-4" v-if="parcel.city.zones.length > 0">
                        <div class="bg-primary text-white fs-5 rounded text-center p-4">
                            {{ __("Agence") }} (<span class="text-uppercase">@{{ parcel.city.zones[0].zone_name }}</span>)
                        </div>
                        <div class="d-flex align-items-center flex-grow-1 p-5" v-if="parcel.city.zones[0].moderator != null">
                            <div class="symbol symbol-50px me-4">
                                <span class="symbol-label">
                                    <i class="las la-phone fs-2qx text-success"></i>                        
                                </span>
                            </div>

                            <div class="me-2">
                                <a :href="'tel:'+parcel.city.zones[0].moderator.users_phone" class="text-gray-800 fs-6 fw-bold text-uppercase">@{{ parcel.city.zones[0].moderator.users_name }}</a>
                                
                                <a :href="'tel:'+parcel.city.zones[0].moderator.users_phone" class="text-gray-500 fw-bold d-block fs-6">@{{ parcel.city.zones[0].moderator.users_phone }}</a>
                            </div>                                         
                        </div>                                         
                    </div>

                    <div class="d-flex flex-column border border-gray-300 rounded mb-4">
                        <div class="bg-success text-white fs-5 rounded text-center p-4">
                            {{ __("Livreur") }}
                        </div>
                        <div class="d-flex align-items-center flex-grow-1 p-5" v-if="parcel.en_agence == 0 && parcel.livreur != null">
                            <div class="symbol symbol-50px me-4">
                                <span class="symbol-label">
                                    <i class="las la-phone fs-2qx text-success"></i>                        
                                </span>
                            </div>

                            <div class="me-2">
                                <a :href="'tel:'+parcel.livreur.users_phone" class="text-gray-800 fs-6 fw-bold text-uppercase">@{{ parcel.livreur.users_name }}</a>
                                
                                <a :href="'tel:'+parcel.livreur.users_phone" class="text-gray-500 fw-bold d-block fs-6">@{{ parcel.livreur.users_phone }}</a>
                            </div>                                         
                        </div> 
                        <div v-else>
                            <p class="alert alert-primary">
                                {{ __('Ce colis était en agence') }}
                            </p>
                        </div>                                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('livreur_modal')
    <script type="text/javascript">
        var current_livreur = null;

        $(document).ready(function() {  
            $(document).on('click', '.livreur', function() {
                current_livreur = $(this).data('id');
                $('#livreur_modal').modal('show');
            })
        });
    </script>
    
    <script type="module">
        const { createApp } = Vue;
        console.warn = () => {};

        createApp({
            data() {
                return {
                    is_loading_livreur : true,
                    parcel : null,
                }
            },
            mounted() {
                $('#livreur_modal').on('show.bs.modal', () => {
                    this.$forceUpdate();
                    this.load_livreur();
                });
            },
            methods: {
                load_livreur : function() {
                    this.is_loading_livreur = true;
                    var global_this = this;

                    $.ajax({
                        url: '{{ route('clients.parcels.livreur') }}/'+current_livreur,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            global_this.is_loading_livreur = false;
                            if(data != null) {
                                global_this.parcel = data;
                            }
                        },
                        error: function(xhr, status, error) {
                            global_this.parcel = null;
                            global_this.is_loading_livreur = false;
                            $('#livreur_modal').modal('hide');
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
        }).mount('#livreur_modal');
    </script>
@endsection