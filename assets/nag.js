/** Form Processor Settings jQuery/JS */

(function($) {
    $(document).ready(function() {
        function maybe_display_nag() {
            if($("#cf-paypal-pro-restOrClassic").val() == 'rest') {
                $("#cf-paypal-pro-rest-nag").show();
                $("#cf-paypal-pro-classic-nag").hide();
            } else {
                $("#cf-paypal-pro-classic-nag").show();
                $("#cf-paypal-pro-rest-nag").hide();
            }
        }

        maybe_display_nag();

        $("#cf-paypal-pro-restOrClassic").change(function(e) {
            maybe_display_nag();
        });
    });
})(jQuery);