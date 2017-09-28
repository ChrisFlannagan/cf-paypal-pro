<?php
return array(
	'_last_updated' => 'Thu, 28 Sep 2017 01:43:57 +0000',
	'ID' => 'paypal-subscription',
	'cf_version' => '1.5.6.1',
	'name' => 'PayPal Subscription Example Form',
	'scroll_top' => 0,
	'success' => 'Form has been successfully submitted. Thank you.			',
	'db_support' => 1,
	'pinned' => 0,
	'hide_form' => 1,
	'check_honey' => 1,
	'avatar_field' => '',
	'form_ajax' => 1,
	'custom_callback' => '',
	'layout_grid' =>
		array(
			'fields' =>
				array(
					'fld_8141437' => '1:1',
					'fld_264963' => '1:2',
					'fld_2810404' => '2:1',
					'fld_4213451' => '2:2',
					'fld_1396494' => '3:1',
					'fld_1579640' => '4:1',
					'fld_1884490' => '4:1',
					'fld_3796314' => '5:1',
					'fld_5912547' => '5:2',
					'fld_5184858' => '5:3',
					'fld_4174260' => '6:1',
					'fld_7112790' => '6:2',
					'fld_7098987' => '7:1',
					'fld_4937781' => '7:2',
					'fld_3601762' => '8:1',
					'fld_8530736' => '9:1',
				),
			'structure' => '6:6|6:6|12|12|6:4:2|8:4|6:6|12|12',
		),
	'fields' =>
		array(
			'fld_8141437' =>
				array(
					'ID' => 'fld_8141437',
					'type' => 'text',
					'label' => 'First Name',
					'slug' => 'first_name',
					'conditions' =>
						array(
							'type' => '',
						),
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'type_override' => 'text',
							'mask' => '',
						),
				),
			'fld_264963' =>
				array(
					'ID' => 'fld_264963',
					'type' => 'text',
					'label' => 'Last Name',
					'slug' => 'last_name',
					'conditions' =>
						array(
							'type' => '',
						),
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'type_override' => 'text',
							'mask' => '',
						),
				),
			'fld_2810404' =>
				array(
					'ID' => 'fld_2810404',
					'type' => 'text',
					'label' => 'First Name On Card',
					'slug' => 'first_name_on_card',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'type_override' => 'text',
							'mask' => '',
						),
				),
			'fld_4213451' =>
				array(
					'ID' => 'fld_4213451',
					'type' => 'text',
					'label' => 'Last Name On Card',
					'slug' => 'last_name_on_card',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'type_override' => 'text',
							'mask' => '',
						),
				),
			'fld_1396494' =>
				array(
					'ID' => 'fld_1396494',
					'type' => 'email',
					'label' => 'Email',
					'slug' => 'email',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
						),
				),
			'fld_1579640' =>
				array(
					'ID' => 'fld_1579640',
					'type' => 'text',
					'label' => 'Address Line 1',
					'slug' => 'address_line_1',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'type_override' => 'text',
							'mask' => '',
						),
				),
			'fld_1884490' =>
				array(
					'ID' => 'fld_1884490',
					'type' => 'text',
					'label' => 'Address Line 2',
					'slug' => 'address_line_2',
					'conditions' =>
						array(
							'type' => '',
						),
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'type_override' => 'text',
							'mask' => '',
						),
				),
			'fld_3796314' =>
				array(
					'ID' => 'fld_3796314',
					'type' => 'text',
					'label' => 'City',
					'slug' => 'city',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'type_override' => 'text',
							'mask' => '',
						),
				),
			'fld_5912547' =>
				array(
					'ID' => 'fld_5912547',
					'type' => 'text',
					'label' => 'Zip Code',
					'slug' => 'zip_code',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'type_override' => 'text',
							'mask' => '',
						),
				),
			'fld_5184858' =>
				array(
					'ID' => 'fld_5184858',
					'type' => 'states',
					'label' => 'State/Province',
					'slug' => 'stateprovince',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
						),
				),
			'fld_4174260' =>
				array(
					'ID' => 'fld_4174260',
					'type' => 'credit_card_number',
					'label' => 'Card Number',
					'slug' => 'card_number',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'exp' => '',
						),
				),
			'fld_7112790' =>
				array(
					'ID' => 'fld_7112790',
					'type' => 'credit_card_cvc',
					'label' => 'CVC/CVV',
					'slug' => 'cvccvv',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default' => '',
							'credit_card_field' => '',
						),
				),
			'fld_7098987' =>
				array(
					'ID' => 'fld_7098987',
					'type' => 'credit_card_exp',
					'label' => 'Expiration Date',
					'slug' => 'expiration_date',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '  /  ',
							'default' => '',
						),
				),
			'fld_4937781' =>
				array(
					'ID' => 'fld_4937781',
					'type' => 'dropdown',
					'label' => 'Card Type',
					'slug' => 'card_type',
					'conditions' =>
						array(
							'type' => '',
						),
					'required' => 1,
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default_option' => '',
							'auto_type' => '',
							'taxonomy' => 'category',
							'post_type' => 'post',
							'value_field' => 'name',
							'orderby_tax' => 'name',
							'orderby_post' => 'name',
							'order' => 'ASC',
							'default' => 'opt758130',
							'option' =>
								array(
									'opt758130' =>
										array(
											'calc_value' => 'visa',
											'value' => 'visa',
											'label' => 'visa',
										),
									'opt1753366' =>
										array(
											'calc_value' => 'mastercard',
											'value' => 'mastercard',
											'label' => 'mastercard',
										),
									'opt2500518' =>
										array(
											'calc_value' => 'amex',
											'value' => 'amex',
											'label' => 'amex',
										),
									'opt3476076' =>
										array(
											'calc_value' => 'discover',
											'value' => 'discover',
											'label' => 'discover',
										),
								),
						),
				),
			'fld_8530736' =>
				array(
					'ID' => 'fld_8530736',
					'type' => 'button',
					'label' => 'Submit Payment',
					'slug' => 'submit_payment',
					'conditions' =>
						array(
							'type' => '',
						),
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'type' => 'submit',
							'class' => 'btn btn-default',
							'target' => '',
						),
				),
			'fld_3601762' =>
				array(
					'ID' => 'fld_3601762',
					'type' => 'dropdown',
					'label' => 'Subscription Level',
					'slug' => 'subscription_level',
					'conditions' =>
						array(
							'type' => '',
						),
					'caption' => '',
					'config' =>
						array(
							'custom_class' => '',
							'placeholder' => '',
							'default_option' => '',
							'auto_type' => '',
							'taxonomy' => 'category',
							'post_type' => 'post',
							'value_field' => 'name',
							'orderby_tax' => 'count',
							'orderby_post' => 'ID',
							'order' => 'ASC',
							'option' =>
								array(
									'opt544275' =>
										array(
											'calc_value' => 'Basic Subscription: $10',
											'value' => 'Basic Subscription: $10',
											'label' => 'Basic Subscription: $10',
										),
									'opt1848801' =>
										array(
											'calc_value' => 'Premium Subscription: $25',
											'value' => 'Premium Subscription: $25',
											'label' => 'Premium Subscription: $25',
										),
								),
							'default' => 'opt1848801',
						),
				),
		),
	'page_names' =>
		array(
			0 => 'Page 1',
		),
	'mailer' =>
		array(
			'on_insert' => 1,
			'sender_name' => 'Caldera Forms Notification',
			'sender_email' => 'dev-email@flywheel.local',
			'reply_to' => '',
			'email_type' => 'html',
			'recipients' => '',
			'bcc_to' => '',
			'email_subject' => 'PayPal Subscription',
			'email_message' => '{summary}',
		),
	'processors' =>
		array(
			'fp_13930940' =>
				array(
					'ID' => 'fp_13930940',
					'runtimes' =>
						array(
							'insert' => 1,
						),
					'type' => 'cf_paypal_pro',
					'config' =>
						array(
							'cf-paypal-pro-restOrClassic' => 'rest',
							'cf-paypal-pro-currency' => 'USD',
							'amount' => 99,
							'cardholderFirstName' => '%first_name_on_card%',
							'cardholderLastName' => '%last_name_on_card%',
							'card_number' => 'fld_4174260',
							'_required_bounds' =>
								array(
									0 => 'card_number',
									1 => 'card_exp',
									2 => 'card_cvc',
									3 => 'customer_email',
								),
							'card_exp' => 'fld_7098987',
							'card_cvc' => 'fld_7112790',
							'type_of_card' => '%card_type%',
							'first_name' => '%first_name%',
							'last_name' => '%last_name%',
							'customer_email' => 'fld_1396494',
							'card_address' => '%address_line_1%',
							'card_address_2' => '%address_line_2%',
							'card_city' => '%city%',
							'card_state' => '%stateprovince%',
							'card_zip' => '%zip_code%',
							'card_country' => 'US',
						),
					'conditions' =>
						array(
							'type' => '',
						),
				),
		),
	'conditional_groups' =>
		array(
		),
	'settings' =>
		array(
			'responsive' =>
				array(
					'break_point' => 'sm',
				),
		),
	'version' => '1.5.6.1',
);