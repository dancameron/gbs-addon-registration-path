<form action="" method="post" enctype="multipart/form-data" id="mixed_registration_form" class="registration_form">
  <fieldset>
	<legend>Legend</legend>

	<div class="control-group">

		<div class="control-group">
			<div class="controls">
				<label class="control-label" class="radio">
					<input type="radio" name="package" id="package" value="1" <?php checked( 1, GBS_Fields::get_package($merchant_id) ) ?>>
					Option 1: Storefront Marketing Package - with coupon specials and business listing.
				</label><br/>
				<label class="control-label" class="radio">
					<input type="radio" name="package" id="package" value="2" <?php checked( 2, GBS_Fields::get_package($merchant_id) ) ?>>
					Option 2: Online Store/Checkout - with a full online store and featured business listing.
				</label><br/>
				<label class="control-label" class="radio">
					<input type="radio" name="package" id="package" value="3" <?php checked( 3, GBS_Fields::get_package($merchant_id) ) ?>>
					Package Options 1 & 2 (Both) - All the featured of packages A & B Included.
				</label>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="advertising_methods"><?php gb_e('Advertising Methods') ?></label><br />

			<div class="controls">
				<textarea rows="5" cols="25" name="advertising_methods" id="advertising_methods"><?php echo GBS_Fields::get_advertising_methods($merchant_id) ?></textarea>
			</div>

		</div>
		<div class="control-group">
			<label class="control-label" for="time_in_biz"><?php gb_e('Time In Bussiness') ?></label><br />

			<div class="controls">
				<input type="text" name="time_in_biz" value="<?php echo GBS_Fields::get_time_in_biz($merchant_id) ?>" id="time_in_biz" class="large-text" >
			</div>

		</div>
		<div class="control-group">
			<label class="control-label" for="storefront_detail"><?php gb_e('Storefront Detail:') ?></label><br />
			<div class="controls">
				<textarea rows="5" cols="25" name="storefront_detail" id="storefront_detail"><?php echo GBS_Fields::get_storefront_detail($merchant_id) ?></textarea>
			</div>

		</div>
		<div class="control-group">
			<label class="control-label" for="biz_hours"><?php gb_e('Business Hours') ?></label><br />
			<div class="controls">
				<textarea rows="5" cols="25" name="biz_hours" id="biz_hours"><?php echo GBS_Fields::get_biz_hours($merchant_id) ?></textarea>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<label class="control-label" class="radio">
					<input type="radio" name="does_int_marketing" id="does_int_marketing" value="1" <?php checked( 1, GBS_Fields::get_does_int_marketing($merchant_id) ) ?>>
					Does interenet marketing.
				</label><br/>
				<label class="control-label" class="radio">
					<input type="radio" name="does_int_marketing" id="does_int_marketing" value="0" <?php checked( 0, GBS_Fields::get_does_int_marketing($merchant_id) ) ?>>
					Does not do internet marketing
				</label>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="internet_marketing"><?php gb_e('Types of Internet Marketing') ?></label><br />
			<div class="controls">
				<textarea rows="5" cols="25" name="internet_marketing" id="internet_marketing"><?php echo GBS_Fields::get_internet_marketing($merchant_id) ?></textarea>
			</div>

		</div>
		<div class="control-group">
			<div class="controls">
				<label>Promotions currently used:</label><br/>
				<input type="checkbox" name="promo_methods[]" id="promo_methods" value="coupons" <?php if ( in_array( 'coupons', GBS_Fields::get_promo_methods($merchant_id) ) ) echo 'checked' ?>>
				Coupons<br/>
				<input type="checkbox" name="promo_methods[]" id="promo_methods" value="disc_specials" <?php if ( in_array( 'disc_specials', GBS_Fields::get_promo_methods($merchant_id) ) ) echo 'checked' ?>>
				Discounts and Specials<br/>
				<input type="checkbox" name="promo_methods[]" id="promo_methods" value="incentives" <?php if ( in_array( 'incentives', GBS_Fields::get_promo_methods($merchant_id) ) ) echo 'checked' ?>>
				New Customer Incentives<br/>
				<input type="checkbox" name="promo_methods[]" id="promo_methods" value="referral_marketing" <?php if ( in_array( 'referral_marketing', GBS_Fields::get_promo_methods($merchant_id) ) ) echo 'checked' ?>>
				Referral Marketing<br/>
				<input type="checkbox" name="promo_methods[]" id="promo_methods" value="daily_deals" <?php if ( in_array( 'daily_deals', GBS_Fields::get_promo_methods($merchant_id) ) ) echo 'checked' ?>>
				Daily Deals<br/>
				<input type="checkbox" name="promo_methods[]" id="promo_methods" value="social_media" <?php if ( in_array( 'social_media', GBS_Fields::get_promo_methods($merchant_id) ) ) echo 'checked' ?>>
				Social Media<br/>
			</div>
		</div>

		<div class="control-group">
				<label class="control-label" for="details"><?php gb_e('Detail:') ?></label><br />
				<div class="controls">
					<textarea rows="5" cols="25" name="details" id="details"><?php echo GBS_Fields::get_details($merchant_id) ?></textarea>
				</div>

		</div>


	</div>

	<input name="<?php echo $FORM_ACTION ?>" type="hidden" value="<?php echo $step ?>" />

	<button type="submit" class="btn">Submit</button>
  </fieldset>
</form>
