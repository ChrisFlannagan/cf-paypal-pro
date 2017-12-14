/** Form Processor Settings jQuery/JS */

(function($) {
    $(document).ready(function() {
        function maybe_display_nag() {
            var sandbox = false;
            if ($("#sandbox").prop("checked")) {
                sandbox = true;
            }

            var current = $("#cf-paypal-pro-restOrClassic").val();

            if (!sandbox) {
                $("#cf-paypal-pro-classic-sandbox-nag").hide();
                $("#cf-paypal-pro-rest-sandbox-nag").hide();
                $("#cf-paypal-pro-payflow-sandbox-nag").hide();
                if (current == 'rest') {
                    $("#cf-paypal-pro-rest-nag").show();
                    $("#cf-paypal-pro-classic-nag").hide();
                    $("#cf-paypal-pro-payflow-nag").hide();
                } else if (current == 'classic') {
                    $("#cf-paypal-pro-classic-nag").show();
                    $("#cf-paypal-pro-rest-nag").hide();
                    $("#cf-paypal-pro-payflow-nag").hide();
                } else if (current == 'payflow' || current == 'payflow-rec') {
                    $("#cf-paypal-pro-classic-nag").hide();
                    $("#cf-paypal-pro-rest-nag").hide();
                    $("#cf-paypal-pro-payflow-nag").show();
                }
            } else {
                $("#cf-paypal-pro-rest-nag").hide();
                $("#cf-paypal-pro-classic-nag").hide();
                $("#cf-paypal-pro-payflow-nag").hide();
                if($("#cf-paypal-pro-restOrClassic").val() == 'rest') {
                    $("#cf-paypal-pro-rest-sandbox-nag").show();
                    $("#cf-paypal-pro-classic-sandbox-nag").hide();
                    $("#cf-paypal-pro-payflow-sandbox-nag").hide();
                } else if (current == 'classic') {
                    $("#cf-paypal-pro-classic-sandbox-nag").show();
                    $("#cf-paypal-pro-rest-sandbox-nag").hide();
                    $("#cf-paypal-pro-payflow-sandbox-nag").hide();
                } else if (current == 'payflow' || current == 'payflow-rec') {
                    $("#cf-paypal-pro-classic-sandbox-nag").hide();
                    $("#cf-paypal-pro-rest-sandbox-nag").hide();
                    $("#cf-paypal-pro-payflow-sandbox-nag").show();
                }
            }
        }

        maybe_display_nag();

        $("#cf-paypal-pro-restOrClassic").change(function(e) {
            maybe_display_nag();
        });

        $("#sandbox").change(function() {
            maybe_display_nag();
        });
    });
})(jQuery);