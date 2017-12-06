/** Form Processor Settings jQuery/JS */

(function($) {
    $(document).ready(function() {
        function maybe_display_nag() {
            var sandbox = false;
            if ($("#sandbox").prop("checked")) {
                sandbox = true;
            }

            console.log(sandbox);



            if (!sandbox) {
                $("#cf-paypal-pro-classic-sandbox-nag").hide();
                $("#cf-paypal-pro-rest-sandbox-nag").hide();
                if($("#cf-paypal-pro-restOrClassic").val() == 'rest') {
                    $("#cf-paypal-pro-rest-nag").show();
                    $("#cf-paypal-pro-classic-nag").hide();
                } else {
                    $("#cf-paypal-pro-classic-nag").show();
                    $("#cf-paypal-pro-rest-nag").hide();
                }
            } else {
                $("#cf-paypal-pro-rest-nag").hide();
                $("#cf-paypal-pro-classic-nag").hide();
                if($("#cf-paypal-pro-restOrClassic").val() == 'rest') {
                    $("#cf-paypal-pro-rest-sandbox-nag").show();
                    $("#cf-paypal-pro-classic-sandbox-nag").hide();
                } else {
                    $("#cf-paypal-pro-classic-sandbox-nag").show();
                    $("#cf-paypal-pro-rest-sandbox-nag").hide();
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