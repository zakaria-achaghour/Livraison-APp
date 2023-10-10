<div class="modal fade" id="suivi_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
        <div class="modal-content">
        	<div class="modal-header pb-0 justify-content-end border-0">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i> 
                </div>
            </div>

            <div class="modal-body scroll-y p-0">
			    <div class="card" v-if="is_loading_tracking">
			        <div class="card-body">
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
			    </div>
                <div class="card-body p-0" v-else-if="parcel_history.length == 0 && call_history.length == 0">
                    <div class="card-px text-center pt-15 pb-15">
                        <div class="d-flex align-items-center justify-content-center" style="flex: 1;min-height: 50vh;">
                            <div style="text-align: center;">
                                <i class="ki-duotone ki-information-4 mb-2">
                                    <i class="path1 fs-5x"></i>
                                    <i class="path2 fs-5x"></i>
                                    <i class="path3 fs-5x"></i>
                                </i>
                                <h6 class="text-center">{{ __("Aucun historique de colis trouvé") }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion" id="kt_accordion_1" v-else>
                    <div class="accordion-item" v-if="parcel_history.length > 0">
                        <h2 class="accordion-header" id="kt_accordion_1_header_1">
                            <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                                {{ __('Détails du suivi') }}
                            </button>
                        </h2>
                        <div id="kt_accordion_1_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                            <div class="accordion-body">
                                <div class="timeline">
                                    <div class="timeline-item" v-for="status in parcel_history">
                                        <div class="timeline-line w-40px"></div>

                                        <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                            <div class="symbol-label bg-light">
                                                <i class="ki-outline ki-time fs-2 text-gray-500"></i> 
                                            </div>
                                        </div>

                                        <div class="timeline-content mb-5">
                                            <div class="pe-3">
                                                <div class="fs-5 fw-semibold mb-2">
                                                    {{ __('Le') }} @{{ moment(status.parcel_history_time).format("DD/MM/YYYY [à] HH[h]mm") }}
                                                </div> 
                                            </div>

                                            <div class="overflow-auto pb-5">
                                                <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-3 mb-1">
                                                    <span class="">
                                                        {{ __('Status de livraison') }}
                                                    </span>
                                                    <div class="pe-2">
                                                        <template v-if="status.parcel_history_status == 'IN_PROGRESS' && status.parcel_history_status_second != '' && status.parcel_history_status_second != null" >
                                                        <span class="fs-7 badge ms-2 text-white" :style="{'background-color': all_status[status.parcel_history_status_second].color}" >
                                                            @{{ all_status[status.parcel_history_status_second].text }}
                                                            <span v-if="status.parcel_history_status_second == 'POSTPONED'">
                                                                <span class="ms-1" v-if="status.parcel_history_data != null">
                                                                    {{ __('au') }} @{{ moment(status.parcel_history_data).format("DD/MM/YYYY") }}
                                                                </span>
                                                            </span>
                                                            <span v-if="status.parcel_history_status_second == 'PROGRAMMER'">
                                                                <span class="ms-1" v-if="status.parcel_history_data != null">
                                                                    {{ __('pour le') }} @{{ moment(status.parcel_history_data).format("DD/MM/YYYY") }}
                                                                </span>
                                                            </span>
                                                        </span>
                                                        </template>
                                                        <template v-else>
                                                        <span class="fs-7 badge ms-2 text-white" :style="{'background-color': all_status[status.parcel_history_status].color}">
                                                            @{{ all_status[status.parcel_history_status].text }} 
                                                            <span class="ms-1" v-if="status.parcel_movments != 0 && status.parcel_movments != null">
                                                                <span v-if="status.parcel_history_status == 'PICKED_UP'">
                                                                     {{ __('à') }} 
                                                                 </span>
                                                                <span v-else-if="status.parcel_history_status == 'RECEIVED'">
                                                                     {{ __('par') }} 
                                                                 </span>
                                                                <span v-else-if="status.parcel_history_status == 'SENT'">
                                                                     {{ __('vers') }} 
                                                                 </span>
                                                                 
                                                                 <span v-if="status.movments_zone != NULL" class="text-capitalize">
                                                                    @{{ status.movments_zone.zone_name }}
                                                                </span>
                                                                <span v-else="" class="text-capitalize">
                                                                    ------
                                                                </span>
                                                            </span>
                                                        </span>
                                                         </template>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-3">
                                                    <span class="">
                                                        {{ __('Etat de paiment') }}
                                                    </span>
                                                    <div class="pe-2">
                                                        <span class="fs-7 badge ms-2 text-white" :style="{'background-color': all_status[status.parcel_history_situation].color}">@{{ all_status[status.parcel_history_situation].text }}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-3" v-if="status.parcel_history_comment != null && status.parcel_history_comment != ''">
                                                    <span class="">
                                                        <b>{{ __('Commentaire') }}</b> : @{{ status.parcel_history_comment }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" v-if="call_history.length > 0">
                        <h2 class="accordion-header" id="kt_accordion_1_header_2">
                            <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="false" aria-controls="kt_accordion_1_body_2">
                                {{ __("Historique d'appel") }}
                            </button>
                        </h2>
                        <div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                            <div class="accordion-body">
                                <div class="d-flex align-items-center mb-3" v-for="history in call_history">
                                    <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-primary"></span>

                                    <div class="flex-grow-1 me-5">
                                        <div class="text-gray-800 fw-semibold fs-4">
                                            <span class="text-gray-400 fw-semibold fs-7">{{ __('Le') }}</span>
                                            @{{ moment(history.parcel_call_history_time).format("DD/MM/YYYY [à] HH[h]mm") }}
                                        </div>
                                        <div>
                                            <span class="text-gray-500 fw-semibold fs-7">{{ __('Appelé par') }} : </span>
                                            <span class="text-gray-700 fw-semibold fs-6">
                                                @{{ history.parcel_call_history_livreur_phone }}
                                            </span>    
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('suivi_modal')
    <script type="text/javascript">
        var current_tracking = null;

        // SUIVI
        $(document).on('click', '.track', function() {
            current_tracking = $(this).data('id');
            $('#suivi_modal').modal('show');
        });

        // ONE COLLAPSE OPEN
        $(document).on('hide.bs.collapse', '.accordion-item', function(event) {
            if ($(this).parent().find(".accordion-collapse.show").length === 1) {
                event.preventDefault();
            }
        })
    </script>
    
    <script type="module">
        const { createApp } = Vue;
        console.warn = () => {};

        createApp({
            data() {
                return {
                    is_loading_tracking : true,
                    parcel_history : [],
                    call_history : [],
                    all_status : []
                }
            },
            mounted() {
                $('#suivi_modal').on('show.bs.modal', () => {
                    this.$forceUpdate();
                    this.tracking();
                });
            },
            methods: {
                tracking : function() {
                    this.is_loading_tracking = true;
                    var global_this = this;

                    $.ajax({
                        url: '{{ route('clients.parcels.tracking') }}/'+current_tracking,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if(data.history.length > 0) {
                                global_this.all_status = data.status;
                                global_this.parcel_history = data.history;
                                global_this.call_history = data.historyCall;
                            }

                            global_this.is_loading_tracking = false;
                        },
                        error: function(xhr, status, error) {
                            global_this.all_status = null;
                            global_this.parcel_history = null;
                            global_this.call_history = null;
                            global_this.is_loading_tracking = false;
                            $('#suivi_modal').modal('hide');
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
        }).mount('#suivi_modal');
    </script>
@endsection