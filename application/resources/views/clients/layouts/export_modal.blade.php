<div class="modal fade" id="export_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-400px">
        <div class="modal-content">
        	<div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i> 
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-5 my-5">
                <form id="kt_subscriptions_export_form" class="form" action="#">
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-semibold form-label mb-5">
                        	{{ __("Sélectionner le format d'exportation : ")}}
                        </label>

                        <select data-control="select2" data-placeholder="{{ __("Sélectionner le format d'exportation : ")}}" data-hide-search="true" class="form-select form-select-solid format-export">
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary btn-export">
                            <span class="indicator-label">
                                {{ __('Exporter') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>