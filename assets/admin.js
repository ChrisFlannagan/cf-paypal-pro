( function( $ ){
    if( 'object' == typeof  CF_PayPal_Pro ){
        new CFPPP( CF_PayPal_Pro, jQuery );
    }
})( jQuery );

function CFPPP( config, $ ){
    Vue.component('cf-paypal-pro', {
        template: '#cf-paypal-pro-tmpl',
        data: function () {
            return {
                apikey: String,
                secret: String
            }
        },
        mounted: function () {
            this.getSettings();
        },
        methods : {
            getSettings: function () {
                var self = this;
                $.ajax({
                    method: 'GET',
                    url: config.api,
                    beforeSend: function ( xhr ) {
                        xhr.setRequestHeader( 'X-WP-Nonce', config.nonce );
                    },
                    complete: function (r) {
                        self.setSettings( r.responseJSON );
                    },
                    error: function (r) {
                        alert('FAIL');
                    }

                });
            },
            updateSettings: function () {
                var self = this;
                var apikey = this.apikey;
                var secret = this.secret;
                var $spinner = $( '#cf-paypal-pro-spinner' );
                var $feedback = $( '#cf-paypal-pro-feedback' );
                $spinner.show().attr( 'aria-hidden', false );
                $feedback.html( '' );
                $.ajax({
                    method: 'POST',
                    url: config.api,
                    beforeSend: function ( xhr ) {
                        xhr.setRequestHeader( 'X-WP-Nonce', config.nonce );
                    },
                    data: {
                        apikey: apikey,
                        secret: secret
                    },
                    complete: function (r) {
                        self.setSettings( r.responseJSON );
                        $( '#cf-paypal-pro-feedback' ).html( '<p class="notice notice-success">' + CF_PayPal_Pro.strings.saved + '</p>' );
                        $spinner.hide().attr( 'aria-hidden', true );

                    },
                    error: function (r) {
                        alert('FAIL');
                    }
                });
            },
            setSettings: function ( settings ) {
                this.$set( this, 'apikey', settings.apikey );
                this.$set( this, 'secret', settings.secret );
            },
            onSubmit: function () {
                this.updateSettings();
            }
        }
    });

    new Vue({
        el: '#cf-paypal-pro',

    });
}