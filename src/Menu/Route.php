<?php

namespace CF_PayPal_Pro\Menu;

class Route implements \Caldera_Forms_API_Route {

	/**
	 * @inheritdoc
	 */
	public function add_routes( $namespace ) {
		$base = 'add-ons/cf-paypal-pro/settings';
		register_rest_route( $namespace, $base, array(
			'methods'             => 'POST',
			'callback'            => array( $this, 'save_settings' ),
			'permission_callback' => array( $this, 'permissions'),
			'args'                => array(
				'apikey' => array(
					'required' => false,
				),
				'secret'  => array(
					'required' => false,
				),
			)
		) );
		register_rest_route( $namespace, $base, array(
			'methods'             => 'GET',
			'callback'            => array( $this, 'get_settings' ),
			'permission_callback' => array( $this, 'permissions'),
		) );
	}
	/**
	 * Get settings via REST API
	 *
	 * @since 0.0.1
	 *
	 * @return \Caldera_Forms_API_Response
	 */
	public function get_settings(){
		return $this->return_settings();
	}
	/**
	 * Save settings via REST API
	 *
	 * @since 0.0.1
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \Caldera_Forms_API_Response
	 */
	public function save_settings( \WP_REST_Request $request ){
		$status = 200;
		$secret = $request[ Settings::SECRET ];
		if( $secret ){
			$status = 201;
			Settings::save_secret( $secret );
		}
		$apikey = $request[ Settings::APIKEY ];
		if( $apikey ){
			$status = 201;
			Settings::save_apikey( $apikey );
		}

		$secret = $request[ Settings::SANDBOX_SECRET ];
		if( $secret ){
			$status = 201;
			Settings::save_sandbox_secret( $secret );
		}
		$apikey = $request[ Settings::SANDBOX_APIKEY ];
		if( $apikey ){
			$status = 201;
			Settings::save_sandbox_apikey( $apikey );
		}


		$username = $request[ Settings::USERNAME ];
		if( $username ){
			$status = 201;
			Settings::save_classic_username( $username );
		}
		$pass = $request[ Settings::PASS ];
		if( $pass ){
			$status = 201;
			Settings::save_classic_pass( $pass );
		}
		$signature = $request[ Settings::SIGNATURE ];
		if( $signature ){
			$status = 201;
			Settings::save_classic_signature( $signature );
		}

		$username = $request[ Settings::SANDBOX_USERNAME ];
		if( $username ){
			$status = 201;
			Settings::save_classic_sandbox_username( $username );
		}
		$pass = $request[ Settings::SANDBOX_PASS ];
		if( $pass ){
			$status = 201;
			Settings::save_classic_sandbox_pass( $pass );
		}
		$signature = $request[ Settings::SANDBOX_SIGNATURE ];
		if( $signature ){
			$status = 201;
			Settings::save_classic_sandbox_signature( $signature );
		}
		return $this->return_settings( $status );
	}
	/**
	 * Create response for both requests with saved settings
	 *
	 * @since 0.0.1
	 *
	 * @param int $status status code
	 *
	 * @return \Caldera_Forms_API_Response
	 */
	protected function return_settings( $status = 200 ){
		return new \Caldera_Forms_API_Response( Settings::get_settings(), $status );
	}
	/**
	 * Permissions check
	 *
	 * @since 0.0.1
	 *
	 * @return bool
	 */
	public function permissions(){
		return current_user_can( \Caldera_Forms::get_manage_cap( 'cf-paypal-pro' ) );
	}

}