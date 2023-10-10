<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.remove', function() {
            var current_remove = $(this).data('id');
            var current_btn = $(this);
            var url = '{{ $url }}';
            var remove_url = url.slice(0, -1)+current_remove;

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
                    current_btn.prop('disabled', true);
                    current_btn.data("data-kt-indicator", "on");

                    $.ajax({
                        url: remove_url,
                        type: 'DELETE',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            current_btn.prop('disabled', false);
                            current_btn.data("data-kt-indicator", "off");

                            if(data.success) {
                                $('.btn-refresh').trigger('click');
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
                }
            });
        })
    })
</script>