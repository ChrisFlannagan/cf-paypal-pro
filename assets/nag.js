/** Form Processor Settings jQuery/JS */

(function($) {
    $(document).ready(function() {
        function maybe_display_nag() {
            var selected = $("#cf-paypal-pro-restOrClassic").val();
            if (selected == 'rest') {
                $("#cf-paypal-pro-rest-nag").show();
                $("#cf-paypal-pro-classic-nag").hide();
                $("#cf-paypal-pro-payflow-nag").hide();
            }

            if (selected == 'classic') {
                $("#cf-paypal-pro-classic-nag").show();
                $("#cf-paypal-pro-rest-nag").hide();
                $("#cf-paypal-pro-payflow-nag").hide();
            }

            if (selected == 'payflow' || selected == 'payflow-rec' ) {
                $("#cf-paypal-pro-payflow-nag").show();
                $("#cf-paypal-pro-classic-nag").hide();
                $("#cf-paypal-pro-rest-nag").hide();
            }

            if (selected == 'payflow-rec') {
                $("#cf-paypal-pro-recurringPeriod-wrap").show();
            } else {
                $("#cf-paypal-pro-recurringPeriod-wrap").hide();
            }
        }

        maybe_display_nag();

        $("#cf-paypal-pro-restOrClassic").change(function(e) {
            maybe_display_nag();
        });
    });
})(jQuery);