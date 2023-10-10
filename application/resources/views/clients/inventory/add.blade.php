@extends('clients.layouts.app')

@section('title', __('Ajouter Produit'))

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
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Ajouter Produit") }}</span>
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
                        {{ __('Stock') }} 
                    </li>

                    <li class="breadcrumb-item">
                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i> </li>

                    <li class="breadcrumb-item text-gray-700">
                        {{ __("Ajouter Produit") }} </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <form action="{{ route('clients.inventory.save') }}" method="POST" id="inventory_form" class="row">
            <div class="col-xl-4">
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('Miniature') }}</h2>
                        </div>
                    </div>

                    <div class="card-body text-center pt-0">
                        <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"></div>

                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __("Choisissez l'image") }}">
                                <i class="ki-outline ki-pencil fs-7"></i>
                                <input type="file" name="product_picture" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                            </label>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('Annuler') }}">
                                <i class="ki-outline ki-cross fs-2"></i> </span>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('Supprimer') }}">
                                <i class="ki-outline ki-cross fs-2"></i> </span>
                        </div>

                        <div class="text-muted fs-7">{{ __("Choisissez l'image miniature du produit. Seuls les fichiers d'image *.png, *.jpg et *.jpeg sont acceptés") }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card card-flush py-4 mb-5">
                    <div class="card-body pt-4">
                        <div class="flex-row-fluid mb-8">
                            <label class="required form-label">{{ __("Nom du produit") }}</label>
                            <div class="position-relative">
                                <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                    <i class="ki-outline ki-purchase fs-3"></i>
                                </div>
                                <input class="form-control form-control-solid ps-12" name="product_name" placeholder="{{ __("Nom du produit") }}">
                            </div>
                        </div>

                        <div class="row" id="simple-section">
                            <div class="col-md-7">
                                <div class="flex-row-fluid mb-8">
                                    <label class="required form-label">{{ __("Réf. du produit") }}</label>
                                    <div class="position-relative">
                                        <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                            <i class="ki-outline ki-cube-2 fs-3"></i>
                                        </div>
                                        <input class="form-control form-control-solid ps-12 ref" name="product_ref" placeholder="{{ __("Réf. du produit") }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label required">{{ __("Quantité") }}</label>
                                <div class="position-relative" data-kt-dialer="true" data-kt-dialer-min="0" data-kt-dialer-max="1000" data-kt-dialer-step="1" data-kt-dialer-decimals="0">
                                    <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
                                        <i class="ki-outline ki-minus-square fs-1"></i> </button>

                                    <input type="text" class="form-control form-control-solid border-0 text-center" data-kt-dialer-control="input" placeholder="{{ __("Quantité") }}" name="product_qty" />

                                    <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
                                        <i class="ki-outline ki-plus-square fs-1"></i> </button>
                                </div>
                            </div>
                        </div>
        

                        <div class="flex-row-fluid mb-8">
                            <label class="form-label">{{ __("Note du produit") }}</label>
                            <textarea name="product_notes" class="form-control form-control-solid" placeholder="{{ __("Note du produit") }}" rows="4"></textarea>
                        </div>

                        <div class="flex-row-fluid">
                            <div class="d-flex flex-column flex-md-row">
                                <label class="form-check form-switch form-check-custom form-check-solid me-3 mb-3">
                                    <input class="form-check-input" name="products_variants" id="variantes-check" type="checkbox"/>
                                    <span class="form-check-label fw-semibold text-muted">
                                        {{ __("Variantes") }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12" id="variantes-section" style="display: none;">
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>{{ __("Variantes") }}</h4>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="variations">
                            <div class="form-group">
                                <div data-repeater-list="variations">
                                    <div data-repeater-item class="mb-4">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <input type="text" name="product_var_ref" class="ref form-control form-control-solid mb-2 mb-md-0" placeholder="{{ __('Réf. de la variante') }}" />
                                            </div>

                                            <div class="col-md-4">
                                                <input type="text" name="product_var_name" class="form-control form-control-solid mb-2 mb-md-0" placeholder="{{ __('Nom de la variante') }}r" />
                                            </div>

                                            <div class="col-md-3">
                                                <div class="position-relative dialer" data-kt-dialer="true" data-kt-dialer-min="0" data-kt-dialer-max="1000" data-kt-dialer-step="1" data-kt-dialer-decimals="0">
                                                    <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
                                                        <i class="ki-outline ki-minus-square fs-1"></i> </button>

                                                    <input type="text" class="form-control form-control-solid border-0 text-center" data-kt-dialer-control="input" placeholder="{{ __("Quantité de la variante") }}" name="product_var_qty" />

                                                    <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
                                                        <i class="ki-outline ki-plus-square fs-1"></i> </button>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger">
                                                    <i class="ki-outline ki-trash fs-5"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                                    <i class="ki-duotone ki-plus fs-3"></i>
                                    {{ __('Nouvelle Variante') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary w-sm-auto w-100" id="inventory_submit">
                        <span class="indicator-label">{{ __("Enregister") }}</span>
                        <span class="indicator-progress">
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
<script src="{{ asset('assets/clients/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script type="text/javascript">
    
    $(document).ready(function() {
        refs_mask();

        $('#variations').repeater({
            initEmpty: false,
            isFirstItemUndeletable: true,
            show: function () {
                $(this).slideDown(100);
                KTDialer.createInstances();
                refs_mask();
            },
            hide: function (deleteElement) {
                $(this).slideUp(100, deleteElement);
            }
        });

        // Switch Variantes
        $('#variantes-check').on('change', function() {
            if ($(this).prop("checked")) {
                $('#simple-section').slideUp(200, function() {
                    $('#variantes-section').slideDown(200);    
                });
            }
            else {
                $('#variantes-section').slideUp(200, function() {
                    $('#simple-section').slideDown(200);    
                });
            }
        })

        // Send Save
        $('#inventory_submit').on('click', function(e) {
            e.preventDefault();
            var current_btn = $(this);
            current_btn.prop('disabled', true);
            current_btn.data("data-kt-indicator", "on");

            var formData =  new FormData($('#inventory_form')[0]);
            $.ajax({
                url: '{{ route('clients.inventory.save') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
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

                    if(data.success) {
                        setTimeout(function() {
                            location.href = data.redirect
                        }, 1100);
                        
                    }
                },
                error: function(xhr, status, error) {
                    current_btn.prop('disabled', false);
                    current_btn.data("data-kt-indicator", "off");

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
        })
    });

    function refs_mask() {
        var refs = document.querySelectorAll('.ref');
        refs.forEach(function(ref) {
            Inputmask({
                mask: '*{1,100}',
                definitions: {
                    '*': {
                      validator: "[A-Za-z0-9\_]",
                      casing: "upper"
                    }
                }
            }).mask(ref);
        })
    }
</script>
@endsection