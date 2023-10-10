
var SigninGeneral = function() {
    var form, button, validation, alert_zone;

    return {
        init: function() {
            form = document.querySelector("#kt_sign_in_form");
            button = document.querySelector("#kt_sign_in_submit");
            zone_alert = document.querySelector("#alert-zone");

            validation = FormValidation.formValidation(form, {
                localization: current_locale == 'ar' ? ar_MA : fr_FR,

                fields: {
                    email: {
                        validators: {
                            notEmpty: {}
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {}
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            });

            button.addEventListener("click", function(e) {
                e.preventDefault();
                zone_alert.classList.remove('d-block');
                zone_alert.classList.add('d-none');
                zone_alert.innerHTML = '';

                validation.validate().then(function(result) {
                    if(result == "Valid") {
                        button.setAttribute("data-kt-indicator", "on");
                        button.disabled = !0;
                        const formData = new FormData(form);

                        fetch(form.action, {method: 'POST',body: formData})
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.href = data.redirect;
                            } else {
                                button.setAttribute("data-kt-indicator", "off");
                                button.disabled = !1;

                                zone_alert.classList.remove('d-none');
                                zone_alert.classList.add('d-block');
                                zone_alert.innerHTML = data.message;
                            }
                        });
                    }
                });
            });
        }
    }
}();

KTUtil.onDOMContentLoaded((function() {
    SigninGeneral.init()
}));