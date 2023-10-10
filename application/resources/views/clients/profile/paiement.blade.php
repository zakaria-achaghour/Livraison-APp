@extends('clients.profile.layouts')

@section('title', __("Mode de paiement"))

@php
	$user = auth()->user();
@endphp

@section('breadcrumb')
<li class="breadcrumb-item">
    <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> 
</li>

<li class="breadcrumb-item text-gray-700 fw-bold lh-1">
    {{ __("Mode de paiement") }} 
</li>
@endsection

@section('block')
<div id="kt_app_content" class="flex-column-fluid " v-if="is_loading">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Heading-->
            <div class="card-px text-center pt-15 pb-15">
            	<div class="d-flex align-items-center justify-content-center" style="flex: 1" v-if="is_loading">
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
<div v-else>
	<div id="kt_app_content" class="flex-column-fluid " v-if="payment_modes.length == 0">
	    <!--begin::Card-->
	    <div class="card">
	        <!--begin::Card body-->
	        <div class="card-body">
	            <!--begin::Heading-->
	            <div class="card-px text-center pt-15 pb-15">
	                <!--begin::Title-->
	                <h2 class="fs-2x fw-bold mb-0">{{ __("Ajouter Mode de paiement") }}</h2>
	                <!--end::Title-->
	                <!--begin::Description-->
	                <p class="text-gray-400 fs-4 fw-semibold py-7">
	                    {{ __("Cliquez sur le bouton ci-dessous pour lancer la configuration de Mode de paiement") }}
	                </p>
	                <!--end::Description-->
	                <!--begin::Action-->
	                <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#modal_mode_paiment">
	                    {{ __('Configuer') }}
	                </a>
	                <!--end::Action-->
	            </div>
	            <!--end::Heading-->
	            <!--begin::Illustration-->
	            <div class="text-center pb-15 px-5">
	                <img src="{{ asset('assets/clients/media/illustrations/sketchy-1/15.png') }}" alt="" class="mw-100 h-200px h-sm-325px" />
	            </div>
	            <!--end::Illustration-->
	        </div>
	        <!--end::Card body-->
	    </div>
	    <!--end::Card-->
	</div>

	<div id="kt_app_content" class="flex-column-fluid " v-else>
	    <div class="card">
	        <div class="card-body">
				<div class="row gx-9 gy-6">
				    <div class="col-xl-6" data-kt-billing-element="card" v-for="mode in payment_modes">
				        <!--begin::Card-->
				        <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
				            <!--begin::Info-->
				            <div class="d-flex flex-column py-2">
				                <div class="d-flex align-items-center fs-4 fw-bold mb-5">
				                    @{{ mode.name }}
				                    <span class="badge badge-light-success fs-7 ms-2" v-if="mode.is_default">
				                    	{{ __("Principale") }}
				                    </span>
				                </div>

				                <div class="d-flex align-items-center">
				                	<div class="w-80px me-4 ">
				                		<img :src="'{{ asset('images/bank') }}/'+mode.bank.logo" alt="" class="w-100" />	
				                	</div>
				                    
				                    <div>
				                        <div class="fs-4 fw-bold">@{{ mode.rib }}</div>
				                        <div class="fs-6 fw-semibold text-gray-400">@{{ mode.bank.name }} </div>
				                    </div>
				                </div>
				            </div>

				            <div class="d-flex align-items-center py-2">
				                <button @click="remove($event, mode)" class="btn btn-sm btn-light-danger me-3" :disabled="mode.is_deleting">
				                	<span class="indicator-label" v-if="!mode.is_deleting">{{ __("Supprimer") }}</span>
	                                <span class="indicator-progress d-block" v-if="mode.is_deleting">
	                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
	                                </span>
				                </button>	
				            </div>
				            <!--end::Actions-->
				        </div>
				        <!--end::Card-->
				    </div>

				    <div class="col-xl-6">
				        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed h-lg-100 p-6">
				            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
				                <div class="mb-3 mb-md-0 fw-semibold">
				                    <h5 class="text-gray-900 fw-bold">{{ __("Ajouter autre mode de paiement") }}</h5>
				                    <div class="fs-7 text-gray-700 pe-7">{{ __("Cliquez sur le bouton pour lancer une nouvelle configuration de mode de paiement") }}</div>
				                </div>

				                <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal" data-bs-target="#modal_mode_paiment">
				                    {{ __('Configuer') }}</a>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
		</div>
	</div>	
</div>

@endsection

@section('after_js')
    <div class="modal fade" id="modal_mode_paiment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ __("Ajouter Mode de paiement") }}</h2>

                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i> </div>
                </div>

                <div class="modal-body py-lg-10 px-lg-10">
                	<div class="stepper stepper-pills" id="stepper_paiment_form">
                        <!--begin::Nav-->
                        <div class="stepper-nav flex-md-center flex-wrap mb-10">
                            <!--begin::Step 1-->
                            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                            	<div class="stepper-icon w-40px h-40px">
					                <i class="stepper-check fas fa-check"></i>
					                <span class="stepper-number">1</span>
					            </div>
                            	<div class="stepper-label">
	                                <h3 class="stepper-title">
	                                    {{ __('Type de Mode') }}
	                                </h3>
	                            </div>
                            </div>

                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                            	<div class="stepper-icon w-40px h-40px">
					                <i class="stepper-check fas fa-check"></i>
					                <span class="stepper-number">2</span>
					            </div>
                            	<div class="stepper-label">
	                                <h3 class="stepper-title">
	                                    {{ __('Informations sur le Mode') }}
	                                </h3>
	                            </div>
                            </div>
                        </div>

                        <form action="{{ route('clients.profile.paiement.add') }}" method="POST" id="payment_mode_form">
	                		@csrf
	                		<div class="mb-5">
					            <!--begin::Step 1-->
					            <div class="flex-column mx-auto w-100 mw-500px current" data-kt-stepper-element="content">
					            	<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-12 p-6">
										<i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
									    <div class="d-flex flex-stack flex-grow-1 ">
									        <div class=" fw-semibold">
									            <div class="fs-6 text-gray-700 ">
									            	{{ __("Les options de paiement par chèque bancaire et en espèces seront bientôt disponibles. Merci de votre patience")}}
									            </div>
									        </div>
									    </div>
									</div>

		                			<div class="fv-row">
	                                    <label class="d-flex flex-stack mb-5 cursor-pointer border p-4 rounded bg-light">
	                                        <span class="d-flex align-items-center me-2">
	                                            <span class="symbol symbol-50px me-6">
	                                                <span class="symbol-label bg-light-primary">
	                                                    <i class="ki-outline ki-credit-cart fs-1 text-primary"></i> </span>
	                                            </span>
	                                            <span class="d-flex flex-column">
	                                                <span class="fw-bold fs-6">{{ __("Virement Bancaire") }}</span>
	                                                <span class="fs-7 text-muted">
	                                                	{{ __("Optez pour le virement bancaire pour une transaction sécurisée et rapide")}}
	                                                </span>
	                                            </span>
	                                        </span>

	                                        <span class="form-check form-check-custom form-check-solid">
	                                            <input class="form-check-input" id="default_mode_radio" type="radio" name="type" value="virement" checked />
	                                        </span>
	                                    </label>

	                                    <label class="d-flex flex-stack mb-5 cursor-pointer border p-4 rounded bg-light ribbon ribbon-end ribbon-clip">
	                                    	<div class="ribbon-label">
            									{{ __("Bientôt") }}
        										<span class="ribbon-inner bg-danger"></span>
											</div>
	                                        <span class="d-flex align-items-center me-2 bw-filter">
	                                            <span class="symbol symbol-50px me-6">
	                                                <span class="symbol-label bg-light-danger  ">
	                                                    <i class="ki-outline ki-bank fs-1 text-danger"></i> </span>
	                                            </span>
	                                            <span class="d-flex flex-column">
	                                                <span class="fw-bold fs-6">{{ __("Chèque bancaire") }}</span>
	                                                <span class="fs-7 text-muted">{{ __("Le chèque bancaire est une option pratique pour effectuer votre paiement de manière traditionnelle.") }}</span>
	                                            </span>
	                                        </span>

	                                        <span class="form-check form-check-custom form-check-solid">
	                                            <input class="form-check-input" type="radio" name="type" value="cheque" disabled />
	                                        </span>
	                                    </label>

	                                    <label class="d-flex flex-stack cursor-pointer border p-4 rounded bg-light ribbon ribbon-end ribbon-clip">
	                                    	<div class="ribbon-label">
            									{{ __("Bientôt") }}
        										<span class="ribbon-inner bg-danger"></span>
											</div>

	                                        <span class="d-flex align-items-center me-2 bw-filter">
	                                            <span class="symbol symbol-50px me-6">
	                                                <span class="symbol-label bg-light-success">
	                                                    <i class="ki-outline ki-bill fs-1 text-success"></i> </span>
	                                            </span>
	                                            <span class="d-flex flex-column">
	                                                <span class="fw-bold fs-6">{{ __("Espèce") }}</span>
	                                                <span class="fs-7 text-muted">{{ __("Le règlement en espèces vous offre la flexibilité de régler votre commande directement en personne.") }}</span>
	                                            </span>
	                                        </span>
	                                        <span class="form-check form-check-custom form-check-solid">
	                                            <input class="form-check-input" type="radio" name="type" value="espece" disabled />
	                                        </span>
	                                    </label>
	                                </div>
		                		</div>

		                		<div class="flex-column" data-kt-stepper-element="content">
		                			<div class="paiment-type" id="type-virement">
		                				<div class="row mb-5">
				                			@foreach(\App\Models\Bank::all() as $key => $bank)
				                			<div class="col">
				                				<input type="radio" class="btn-check" name="bank_id" value="{{ $bank->id }}"  id="bank_radio_{{$key}}"/>
												<label class="btn btn-outline btn-outline-dashed btn-active-light-primary bg-light p-6 d-flex flex-column align-items-center mb-5" for="bank_radio_{{$key}}">
													<div class="w-90px">
														<img class="w-100" src="{{ asset('images/bank/'.$bank->logo) }}" />
													</div>
												    

												    <span class="d-block text-center fs-7">
												        {{ $bank->name }}
												    </span>
												</label>
				                			</div>
				                			@endforeach
				                		</div>

				            			<div class="mb-5">
				                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
				                                <span class="required">{{ __("Nom complet") }}</span>
				                            </label>

				                            <input type="text" id="name_inputmask" class="form-control form-control-lg form-control-solid" name="name" value="" />
				                        </div>

				            			<div class="mb-5">
				                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
				                                <span class="required">{{ __("Numero du compte") }}</span>
				                                <span class="ms-1" data-bs-toggle="tooltip" title="RIB">
				                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
				                                </span>
				                            </label>

				                            <input type="text" id="rib_inputmask" class="form-control form-control-lg form-control-solid" name="rib"  value="" />
				                        </div>
		                			</div>

		                			<div class="paiment-type" id="type-cheque" style="display:none;">
		                				<div class="mb-5">
				                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
				                                <span class="required">{{ __("Nom complet") }}</span>
				                            </label>

				                            <input type="text" id="name_inputmask" class="form-control form-control-lg form-control-solid" name="name" value="" disabled />
				                        </div>
		                			</div>

		                			<div class="paiment-type" id="type-espece" style="display:none;">
		                				<div class="mb-5">
				                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
				                                <span class="required">{{ __("Nom complet") }}</span>
				                            </label>

				                            <input type="text" id="name_inputmask" class="form-control form-control-lg form-control-solid" name="name" value="" disabled />
				                        </div>

				            			<div class="mb-5">
				                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
				                                <span class="required">{{ __("CIN") }}</span>
				                            </label>

				                            <input type="text" id="cin_inputmask" class="form-control form-control-lg form-control-solid" name="cin" value="" disabled />
				                        </div>
		                			</div>
		                		</div>
		                	</div>

	                		<div class="d-flex flex-stack">
                                <div class="me-2">
                                    <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                        <i class="ki-outline ki-arrow-left fs-3 me-1"></i> {{ __("Retour") }}
                                    </button>
                                </div>

                                <div>
                                    <button @click="save($event)" id="submit_bank" class="btn btn-lg btn-primary" data-kt-stepper-action="submit" :disabled="is_adding">
		                                <span class="indicator-label" v-if="!is_adding">{{ __("Enregistrer") }}</span>
		                                <span class="indicator-progress d-block" v-if="is_adding">
		                                    {{ __("Veuillez patienter ...") }}
		                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
		                                </span>
		                            </button>
                                    <button class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                        {{ __("Suivant") }}
                                        <i class="ki-outline ki-arrow-right fs-3 ms-1 me-0"></i> 
                                    </button>
                                </div>
                            </div>
	                	</form>
                    </div>
                	
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
    	KTUtil.onDOMContentLoaded((function() {
    		// ***********
    		// MASK
    		// ***********
	    	Inputmask({
	    		mask : "A{1,2}9{3,6}",
			    definitions: {
			      'A': {
			        validator: "[A-Za-z]",
			        casing: "upper"
			      },
			      '9': {
			        validator: "[0-9]",
			      }
			    }
			}).mask("#cin_inputmask");

			Inputmask({
			    "mask" : "999 999 9999999999999999 99",
			    "placeholder": "000 000 0000000000000000 00",
			}).mask("#rib_inputmask");

			Inputmask({
			    mask: '*{1,50}', // Allow up to 50 characters for each part
				definitions: {
					'*': {
					  validator: "[A-Za-z '\"]",
					  casing: "upper"
					}
				}
			}).mask("#name_inputmask");

			// ***********
    		// STEPPER
    		// ***********
    		// ***********
			var element = document.querySelector("#stepper_paiment_form");
			var stepper = new KTStepper(element);
			stepper.on("kt.stepper.next", function (stepper) {
			    stepper.goNext(); // go next step
			});
			stepper.on("kt.stepper.previous", function (stepper) {
			    stepper.goPrevious(); // go previous step
			});


			// ***********
    		// RADIOS
    		// ***********
			const radioButtons = document.getElementsByName('type');
			const blocks = document.querySelectorAll('.paiment-type');
			radioButtons.forEach(radioButton => {
			radioButton.addEventListener('change', function() {
				blocks.forEach(block => {
					block.style.display = 'none';
				});

				const selectedValue = this.value;
				const selectedBlock = document.getElementById("type-"+selectedValue);
					selectedBlock.style.display = 'block';
				});
			});
		}));
    </script>

	<script src="{{ asset('assets/global/js/vue.js') }}"></script>
    <script type="module">
		const { createApp } = Vue;
		console.warn = () => {};

		createApp({
			data() {
				return {
					is_loading: true,
					is_adding : false,
					payment_modes : []
				}
			},
			mounted() {
				this.load();
			},
			methods: {
				load : function() {
					this.is_loading = true;
					fetch('{{ route('clients.profile.paiement.all') }}', {method: 'GET'})
			            .then(response => response.json())
			            .then(data => {
			            	this.is_loading = false;

			            	// Add the isLoading property to each payment mode
				            data.forEach(paymentMode => {
				                paymentMode.is_deleting = false;
				            });

			            	this.payment_modes = data;
	        			});
				},
				save : function(event) {
					event.preventDefault();
					var global_this = this;
					global_this.is_adding = true;

	                var form_mode = document.getElementById("payment_mode_form");
					const formData = new FormData(form_mode);

	                fetch(form_mode.action, {method: 'POST',body: formData})
			            .then(response => response.json())
			            .then(data => {
			            	global_this.is_adding = false;

			            	if(data.success) {
			            		$('#modal_mode_paiment').modal('hide');
			            		form_mode.reset();

			            		// select default mode
			            		document.getElementById('default_mode_radio').checked = true;

			            		// STEPPER
			            		var element = document.querySelector("#stepper_paiment_form");
								var stepper = KTStepper.getInstance(element);
								stepper.goPrevious();

			            		global_this.load();
			            	}
			            	else {
			            		swal.fire({
		                            html: data.message,
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
				remove : function(event, mode) {
					event.preventDefault();
					var global_this = this;

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
		            		mode.is_deleting = true;
							fetch('{{ route('clients.profile.paiement.delete') }}/'+mode.id, 
								{
									method: 'DELETE',
									headers: {
								        'X-CSRF-TOKEN': '{{ csrf_token() }}'
								    },
								})
					            .then(response => response.json())
					            .then(data => {
					            	mode.is_deleting = false;

					            	if(data.success) {
					            		global_this.load();
					            	}
			        			});
				        }
			        });
				}
	        }
		}).mount('#kt_app_body');
	</script>
@endsection