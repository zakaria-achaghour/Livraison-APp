<div class="modal fade" id="edit_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <div class="modal-content" v-if="is_loading_edit">
            <div class="modal-header pb-0 justify-content-end border-0">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i> 
                </div>
            </div>
            <div class="modal-body scroll-y p-0">
                <div class="card">
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
            </div>
        </div>
        <div class="modal-content" v-else-if="edit_parcel != null">
            <div class="modal-header bg-light-success d-flex align-items-center justify-content-between pb-2 border-3">
                <h2 class="d-flex flex-column">
                    <div>{{ __('Demande de modification du colis') }} : @{{ edit_parcel.code }}</div>
                    <div v-if="edit_parcel.statut == 'edited'">
                        <span class="badge badge-outline badge-info mt-2 me-1 fs-5">
                            {{ __('Une demande est déja envoyé') }}
                        </span>
                        <span class="fs-6 text-gray-500">{{ __("et cette demande est") }}</span>
                        <span class="badge badge-outline badge-warning ms-1 mt-2 fs-5">
                            {{ __('En cours') }}
                        </span>
                    </div>
                </h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i> 
                </div>
            </div>
            <div class="modal-body">
                <form id="edit_parcel_form">
                    <input type="hidden" name="parcel_code" v-model="edit_parcel.code">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="flex-row-fluid mb-4">
                                <label class="required form-label">{{ __("Destinataire") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-user"></i>
                                    </div>
                                    <input class="form-control form-control-sm form-control-solid ps-12" name="parcel_receiver" placeholder="{{ __("Destinataire") }}" id="name_inputmask" v-model="edit_parcel.receiver">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="flex-row-fluid mb-4">
                                <label class="required form-label">{{ __("Téléphone") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-whatsapp fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-sm form-control-solid ps-12" name="parcel_phone" placeholder="{{ __("Téléphone") }}" id="phone_inputmask" v-model="edit_parcel.phone">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="flex-row-fluid mb-4">
                                <label class="form-label required">{{ __("Adresse") }}</label>
                                <textarea name="parcel_address" class="form-control form-control-sm form-control-solid" placeholder="{{ __("Adresse") }}" rows="3" v-model="edit_parcel.address"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="flex-row-fluid mb-4">
                                <label class="form-label">
                                    {{ __("Commentaire") }} <small>({{ __("Autre téléphone, Date de livraison ...") }})</small>
                                </label>
                                <textarea name="parcel_note" class="form-control form-control-sm form-control-solid" placeholder="{{ __("Commentaire") }}" rows="3" v-model="edit_parcel.note"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="flex-row-fluid mb-4">
                                <label class="form-label required">{{ __("Prix") }}</label>
                                <div class="position-relative">
                                    <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                        <i class="ki-outline ki-bill fs-3"></i>
                                    </div>
                                    <input class="form-control form-control-sm form-control-solid ps-12" name="parcel_price" placeholder="{{ __("Prix") }}" id="price_inputmask" v-model="edit_parcel.price">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer pt-0">
                <button type="submit" class="btn btn-primary w-sm-auto w-100" @click="this.send_request_edit" :disabled="is_editing">
                    <span class="indicator-label" v-if="!is_editing">{{ __("Enregister") }}</span>
                    <span class="indicator-progress d-block" v-if="is_editing">
                        {{ __("Veuillez patienter ...") }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

@section('edit_modal')
    <script type="text/javascript">
        var current_edit = null;

        $(document).on('click', '.edit', function() {
            current_edit = $(this).data('id');
            $('#edit_modal').modal('show');
        })
    </script>
    
    <script type="module">
        const { createApp } = Vue;
        console.warn = () => {};

        createApp({
            data() {
                return {
                    is_loading_edit : true,
                    edit_parcel : null,
                    is_editing : false
                }
            },
            mounted() {
                $('#edit_modal').on('show.bs.modal', () => {
                    this.$forceUpdate();
                    this.request_edit();
                });
            },
            methods: {
                request_edit : function() {
                    this.is_loading_edit = true;
                    var global_this = this;

                    $.ajax({
                        url: '{{ route('clients.parcels.edit-request') }}/'+current_edit,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            global_this.is_loading_edit = false;
                            if(data.success) {
                                global_this.edit_parcel = data.parcel;
                                global_this.masks();
                            }
                            else {
                                global_this.edit_parcel = null;
                                $('#edit_modal').modal('hide');
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
                        error: function(xhr, status, error) {
                            global_this.edit_parcel = null;
                            global_this.is_loading_edit = false;
                            $('#edit_modal').modal('hide');
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
                send_request_edit : function(event) {
                    event.preventDefault();
                    var global_this = this;
                    global_this.is_editing = true;

                    var formData = new FormData($('#edit_parcel_form')[0]);

                    $.ajax({
                        url: "{{ route('clients.parcels.edit-request.send') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            global_this.is_editing = false;

                            if(data.success) {
                                global_this.edit_parcel = null;
                                $('#edit_modal').modal('hide');
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
                moment: function ($time) {
                    return window.moment($time*1000);
                },
                masks : function() {
                    $(document).ready(function(){
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
                            mask: '*{1,40}',
                            definitions: {
                                '*': {
                                  validator: "[\u0600-\u06FF0-9A-Za-z '\"]",
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
                    });
                }
            }
        }).mount('#edit_modal');
    </script>
@endsection