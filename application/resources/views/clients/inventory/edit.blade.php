@extends('clients.layouts.app')

@section('title', __('Modifier Produit'))

@section('currentUrl')
currentUrl = '{{ route('clients.inventory.index') }}';
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
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-lg-2x gap-2">
                        <span>{{ __("Modifier Produit") }}</span>
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
                        {{ __("Modifier Produit") }} </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        @php
            if($product->product_variant == 0)
                $inventory = $product->inventory()->first();
            else
                $inventory = $product->inventory()->get();

            $image = "none";
            if($product->product_pic != "") {
                $image = "url('".asset('images/inventory/'.$product->product_pic)."')";
            }
        @endphp
        <form action="{{ route('clients.inventory.update') }}" method="POST" id="inventory_form" class="row">
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
            <div class="col-xl-4">
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('Miniature') }}</h2>
                        </div>
                    </div>

                    <div class="card-body text-center pt-0">
                        <div class="image-input {{ $image == "none" ? "image-input-empty" : "" }} image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">

                            <div class="image-input-wrapper w-150px h-150px" style="background-image: {{ $image }}"></div>

                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="{{ __("Choisissez l'image") }}">
                                <i class="ki-outline ki-pencil fs-7"></i>
                                <input type="file" name="product_picture" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="product_picture_remove" value="0" />
                            </label>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="{{ __('Annuler') }}">
                                <i class="ki-outline ki-cross fs-2"></i> </span>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="{{ __('Supprimer') }}">
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
                                <input class="form-control form-control-solid ps-12" name="product_name" placeholder="{{ __("Nom du produit") }}" value="{{ $product->product_name }}">
                            </div>
                        </div>

                        @if($product->product_variant == 0)
                        <div class="flex-row-fluid mb-8">
                            <label class="required form-label">{{ __("Réf. du produit") }}</label>
                            <div class="position-relative">
                                <div class="d-flex position-absolute translate-middle-y top-50 start-0 ms-3">
                                    <i class="ki-outline ki-cube-2 fs-3"></i>
                                </div>
                                <input class="form-control form-control-solid ps-12" placeholder="{{ __("Réf. du produit") }}"  value="{{ $inventory->inventory_ref }}" readonly disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-8">
                                <label class="form-label">{{ __("Quantité reçu") }}</label>
                                <input type="text" class="form-control form-control-solid border-0 text-center"  placeholder="{{ __("Quantité reçu") }}" value="{{ $inventory->inventory_qty }}" readonly disabled />
                            </div>

                            <div class="col-md-6 mb-8">
                                <label class="form-label required">{{ __("Pas encore reçu") }}</label>
                                <div class="position-relative" data-kt-dialer="true" data-kt-dialer-min="0" data-kt-dialer-max="1000" data-kt-dialer-step="1" data-kt-dialer-decimals="0">
                                    <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
                                        <i class="ki-outline ki-minus-square fs-1"></i> </button>

                                    <input type="text" class="form-control form-control-solid border-0 text-center" data-kt-dialer-control="input" placeholder="{{ __("Pas encore reçu") }}" name="product_qty"  value="{{ $inventory->inventory_qty_not_received }}" />

                                    <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
                                        <i class="ki-outline ki-plus-square fs-1"></i> </button>
                                </div>
                            </div>
                        </div>
                        @endif
        

                        <div class="flex-row-fluid mb-8">
                            <label class="form-label">{{ __("Note du produit") }}</label>
                            <textarea name="product_notes" class="form-control form-control-solid" placeholder="{{ __("Note du produit") }}" rows="4">{{ $product->product_desc }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            @if($product->product_variant == 1)
            <div class="col-xl-12">
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>{{ __("Variantes") }}</h4>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-striped table-row-gray-300 table-striped">
                                <thead>
                                    <tr>
                                        <th class="min-w-150px">{{ __('Réf. de la variante') }}</th>
                                        <th class="min-w-150px">{{ __('Nom de la variante') }}</th>
                                        <th class="min-w-100px">{{ __("Quantité reçu") }}</th>
                                        <th class="min-w-100px">{{ __("Pas encore reçu") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventory as $inv)
                                    <tr>
                                        <td data-label="{{ __('Réf. de la variante') }}">
                                            <input type="hidden" name="product_ref[]" value="{{ $inv->inventory_ref }}">
                                            <input type="text" readonly disabled class="form-control form-control-solid" placeholder="{{ __('Réf. de la variante') }}" value="{{ $inv->inventory_ref }}" />
                                        </td>
                                        <td data-label="{{ __('Nom de la variante') }}">
                                            <input type="text" name="product_var_name[]" class="form-control form-control-solid" placeholder="{{ __('Nom de la variante') }}r" value="{{ $inv->inventory_var_name }}" />
                                        </td>
                                        <td data-label="{{ __("Quantité reçu") }}">
                                            <input type="text" class="form-control form-control-solid border-0 text-center" placeholder="{{ __("Quantité reçu") }}" disabled readonly value="{{ $inv->inventory_qty }}" />
                                        </td>
                                        <td data-label="{{ __("Pas encore reçu") }}">
                                            <div class="position-relative dialer" data-kt-dialer="true" data-kt-dialer-min="0" data-kt-dialer-max="1000" data-kt-dialer-step="1" data-kt-dialer-decimals="0">
                                                <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
                                                    <i class="ki-outline ki-minus-square fs-1"></i> </button>

                                                <input type="text" class="form-control form-control-solid border-0 text-center" data-kt-dialer-control="input" placeholder="{{ __("Pas encore reçu") }}" name="product_var_qty[]" value="{{ $inv->inventory_qty_not_received }}" />

                                                <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
                                                    <i class="ki-outline ki-plus-square fs-1"></i> </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

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
        // Send Save
        $('#inventory_submit').on('click', function(e) {
            e.preventDefault();
            var current_btn = $(this);
            current_btn.prop('disabled', true);
            current_btn.data("data-kt-indicator", "on");

            var formData =  new FormData($('#inventory_form')[0]);
            $.ajax({
                url: '{{ route('clients.inventory.update') }}',
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
</script>
@endsection