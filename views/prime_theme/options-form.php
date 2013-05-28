<?php if ( $merchant_id ): ?>

	<form action="" method="post" enctype="multipart/form-data" id="mixed_registration_form" class="registration_form">
	  <fieldset>
		<legend>Legend</legend>

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

		<input name="<?php echo $FORM_ACTION ?>" type="hidden" value="<?php echo $step ?>" />

		<button type="submit" class="btn">Submit</button>
	  </fieldset>
	</form>

<?php else: ?>
	<p>No Merchant Available</p>
<?php endif ?>