<?php if ( $merchant_id ):
	$merchant = Group_Buying_Merchant::get_instance( $merchant_id ); ?>

	<form action="" method="post" enctype="multipart/form-data" id="mixed_registration_form" class="registration_form choose-options">
	  <fieldset>

		<div class="control-group">
			<label class="control-label" for="gb_merchant_package_option">Select Your Package Option:</label>
			<div class="controls">

				<label class="radio">
					<input type="radio" name="gb_merchant_package_option" id="gb_merchant_package_option1" value="1" <?php checked( 1, GBS_Fields::get_package( $merchant_id ) ) ?>>
					Option 1: Storefront Marketing Package - with coupon specials and business listing.
				</label>
				<label class="radio">
					<input type="radio" name="gb_merchant_package_option" id="gb_merchant_package_option2" value="2" <?php checked( 2, GBS_Fields::get_package( $merchant_id ) ) ?>>
					Option 2: Online Store/Checkout - with a full online store and featured business listing.
				</label>
				<label class="radio">
					<input type="radio" name="gb_merchant_package_option" id="gb_merchant_package_option3" value="3" <?php checked( 3, GBS_Fields::get_package( $merchant_id ) ) ?>>
					Package Options 1 & 2 (Both) - All the featured of packages A & B Included.
				</label>
			</div>
		</div>


		<div class="control-group">
			<label class="control-label" for="gb_contact_street"><?php gb_e('Street Address') ?></label><br />
			<div class="controls">
				<input type="text" name="gb_contact_street" id="gb_contact_street" value="<?php echo $merchant->get_contact_street() ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="gb_contact_city"><?php gb_e('City') ?></label><br />
			<div class="controls">
				<input type="text" name="gb_contact_city" id="gb_contact_city" value="<?php echo $merchant->get_contact_city() ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="gb_contact_state"><?php gb_e('State') ?></label><br />
			<div class="controls">
				<select name="gb_contact_state" id="gb_contact_state" class="select2" style="width:350px">
					<option></option>
					<?php $options = Group_Buying_Controller::get_state_options(); ?>
					<?php foreach ( $options as $group => $states ) : ?>
						<optgroup label="<?php echo $group ?>">
							<?php foreach ( $states as $option_key => $option_label ): ?>
								<option value="<?php echo $option_key; ?>" <?php selected( $option_key, $merchant->get_contact_state() ) ?>><?php echo $option_label; ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="gb_contact_country"><?php gb_e('Country') ?></label><br />
			<div class="controls">
				<select name="gb_contact_country" id="gb_contact_country" class="select2" style="width:350px">
					<option></option>
					<?php $options = Group_Buying_Controller::get_country_options(); ?>
					<?php foreach ( $options as $key => $label ): ?>
						<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $key, $merchant->get_contact_country() ); ?>><?php esc_html_e( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="gb_contact_website"><?php gb_e('Website') ?></label><br />
			<div class="controls">
				<input type="text" name="gb_contact_website" id="gb_contact_website" value="<?php echo $merchant->get_website() ?>" />
			</div>
		</div>

		<input name="<?php echo $FORM_ACTION ?>" type="hidden" value="<?php echo $step ?>" />

		<button type="submit" class="reg-button">Submit</button>
	  </fieldset>
	</form>

<?php else: ?>
	<p>No Merchant Available</p>
<?php endif ?>