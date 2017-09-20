(function($) {
    $(document).ready(function() {
       $("#show_hide_cfppp_rest_help").click(function(e) {
           $("#ppp-rest-help").toggle();
       });
        $("#show_hide_cfppp_soap_help").click(function(e) {
            $("#ppp-soap-help").toggle();
        });
    });
})(jQuery);