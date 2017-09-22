/** Settings Functionality in Vue.js */

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
                apikey: '',
                secret: '',
                sandbox_apikey: '',
                sandbox_secret: '',
                classic_username: '',
                classic_pass: '',
                classic_signature: '',
                classic_sandbox_username: '',
                classic_sandbox_pass: '',
                classic_sandbox_signature: ''
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
                var sandbox_apikey = this.sandbox_apikey;
                var sandbox_secret = this.sandbox_secret;
                var classic_username = this.classic_username;
                var classic_pass = this.classic_pass;
                var classic_signature = this.classic_signature;
                var classic_sandbox_username = this.classic_sandbox_username;
                var classic_sandbox_pass = this.classic_sandbox_pass;
                var classic_sandbox_signature = this.classic_sandbox_signature;
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
                        secret: secret,
                        sandbox_apikey: sandbox_apikey,
                        sandbox_secret: sandbox_secret,
                        classic_username: classic_username,
                        classic_pass: classic_pass,
                        classic_signature: classic_signature,
                        classic_sandbox_username: classic_sandbox_username,
                        classic_sandbox_pass: classic_sandbox_pass,
                        classic_sandbox_signature: classic_sandbox_signature
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
                this.$set( this, 'sandbox_apikey', settings.sandbox_apikey );
                this.$set( this, 'sandbox_secret', settings.sandbox_secret );
                this.$set( this, 'classic_username', settings.classic_username );
                this.$set( this, 'classic_pass', settings.classic_pass );
                this.$set( this, 'classic_signature', settings.classic_signature );
                this.$set( this, 'classic_sandbox_username', settings.classic_sandbox_username );
                this.$set( this, 'classic_sandbox_pass', settings.classic_sandbox_pass );
                this.$set( this, 'classic_sandbox_signature', settings.classic_sandbox_signature );
            },
            onSubmit: function () {
                this.updateSettings();
            }
        }
    });

    new Vue({
        el: '#cf-paypal-pro'
    });
}