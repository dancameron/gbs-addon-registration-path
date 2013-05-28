<?php

class GBS_Fields extends Group_Buying_Controller {

	private static $meta_keys = array(
		'advertising_methods' => '_merchant_advertising_methods', // string
		'package' => '_merchant_package', // int
		'time_in_biz' => '_time_in_biz', // string
		'details' => '_details', // string
		'storefront_detail' => '_storefront_detail', // string
		'biz_hours' => '_biz_hours', // string
		'does_int_marketing' => '_does_int_marketing', // int
		'internet_marketing' => '_internet_marketing', // string
		'promo_methods' => '_promo_methods', // array
	); // A list of meta keys this class cares about. Try to keep them in alphabetical order.

	public static function init() {
		// Meta Boxes
		add_action( 'add_meta_boxes', array(get_class(), 'add_meta_boxes'));
		add_action( 'save_post', array( get_class(), 'save_meta_boxes' ), 10, 2 );

	}

	public static function add_meta_boxes() {
		add_meta_box('gb_merchant_meta', self::__('Custom Information'), array(get_class(), 'show_meta_boxes'), Group_Buying_Merchant::POST_TYPE, 'advanced', 'high');
	}

	public static function show_meta_boxes( $post, $metabox ) {
		switch ( $metabox['id'] ) {
			case 'gb_merchant_meta':
				self::show_meta_box($post, $metabox);
				break;
			default:
				self::unknown_meta_box($metabox['id']);
				break;
		}
	}

	private static function show_meta_box( $post, $metabox ) {
		?>
			<table class="form-table">
				<tbody>
					<tr>
						<td>
							<label class="radio">
								<input type="radio" name="<?php echo self::$meta_keys['package'] ?>" id="<?php echo self::$meta_keys['package'] ?>" value="1" <?php checked( 1, self::get_package($post->ID) ) ?>>
								Option 1: Storefront Marketing Package - with coupon specials and business listing.
							</label><br/>
							<label class="radio">
								<input type="radio" name="<?php echo self::$meta_keys['package'] ?>" id="<?php echo self::$meta_keys['package'] ?>" value="2" <?php checked( 2, self::get_package($post->ID) ) ?>>
								Option 2: Online Store/Checkout - with a full online store and featured business listing.
							</label><br/>
							<label class="radio">
								<input type="radio" name="<?php echo self::$meta_keys['package'] ?>" id="<?php echo self::$meta_keys['package'] ?>" value="3" <?php checked( 3, self::get_package($post->ID) ) ?>>
								Package Options 1 & 2 (Both) - All the featured of packages A & B Included.
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label for="<?php echo self::$meta_keys['advertising_methods'] ?>"><?php gb_e('Advertising Methods') ?></label><br />
							<textarea rows="5" cols="25" name="<?php echo self::$meta_keys['advertising_methods'] ?>" id="<?php echo self::$meta_keys['advertising_methods'] ?>"><?php echo self::get_advertising_methods($post->ID) ?></textarea>

						</td>
					</tr>
					<tr>
						<td>
							<label for="<?php echo self::$meta_keys['time_in_biz'] ?>"><?php gb_e('Time In Bussiness') ?></label><br />
							<input type="text" name="<?php echo self::$meta_keys['time_in_biz'] ?>" value="<?php echo self::get_time_in_biz($post->ID) ?>" id="<?php echo self::$meta_keys['time_in_biz'] ?>" class="large-text" >

						</td>
					</tr>
					<tr>
						<td>
							<label for="<?php echo self::$meta_keys['storefront_detail'] ?>"><?php gb_e('Storefront Detail:') ?></label><br />
							<textarea rows="5" cols="25" name="<?php echo self::$meta_keys['storefront_detail'] ?>" id="<?php echo self::$meta_keys['storefront_detail'] ?>"><?php echo self::get_storefront_detail($post->ID) ?></textarea>

						</td>
					</tr>
					<tr>
						<td>
							<label for="<?php echo self::$meta_keys['biz_hours'] ?>"><?php gb_e('Business Hours') ?></label><br />
							<textarea rows="5" cols="25" name="<?php echo self::$meta_keys['biz_hours'] ?>" id="<?php echo self::$meta_keys['biz_hours'] ?>"><?php echo self::get_biz_hours($post->ID) ?></textarea>

						</td>
					</tr>
					<tr>
						<td>
							<label class="radio">
								<input type="radio" name="<?php echo self::$meta_keys['does_int_marketing'] ?>" id="<?php echo self::$meta_keys['does_int_marketing'] ?>" value="1" <?php checked( 1, self::get_does_int_marketing($post->ID) ) ?>>
								Does interenet marketing.
							</label><br/>
							<label class="radio">
								<input type="radio" name="<?php echo self::$meta_keys['does_int_marketing'] ?>" id="<?php echo self::$meta_keys['does_int_marketing'] ?>" value="0" <?php checked( 0, self::get_does_int_marketing($post->ID) ) ?>>
								Does not do internet marketing
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label for="<?php echo self::$meta_keys['internet_marketing'] ?>"><?php gb_e('Types of Internet Marketing') ?></label><br />
							<textarea rows="5" cols="25" name="<?php echo self::$meta_keys['internet_marketing'] ?>" id="<?php echo self::$meta_keys['internet_marketing'] ?>"><?php echo self::get_internet_marketing($post->ID) ?></textarea>

						</td>
					</tr>
					<tr>
						<td>
							<label>Promotions currently used:</label><br/>
							<input type="checkbox" name="<?php echo self::$meta_keys['promo_methods'] ?>[]" id="<?php echo self::$meta_keys['promo_methods'] ?>" value="coupons" <?php if ( in_array( 'coupons', self::get_promo_methods($post->ID) ) ) echo 'checked' ?>>
							Coupons<br/>
							<input type="checkbox" name="<?php echo self::$meta_keys['promo_methods'] ?>[]" id="<?php echo self::$meta_keys['promo_methods'] ?>" value="disc_specials" <?php if ( in_array( 'disc_specials', self::get_promo_methods($post->ID) ) ) echo 'checked' ?>>
							Discounts and Specials<br/>
							<input type="checkbox" name="<?php echo self::$meta_keys['promo_methods'] ?>[]" id="<?php echo self::$meta_keys['promo_methods'] ?>" value="incentives" <?php if ( in_array( 'incentives', self::get_promo_methods($post->ID) ) ) echo 'checked' ?>>
							New Customer Incentives<br/>
							<input type="checkbox" name="<?php echo self::$meta_keys['promo_methods'] ?>[]" id="<?php echo self::$meta_keys['promo_methods'] ?>" value="referral_marketing" <?php if ( in_array( 'referral_marketing', self::get_promo_methods($post->ID) ) ) echo 'checked' ?>>
							Referral Marketing<br/>
							<input type="checkbox" name="<?php echo self::$meta_keys['promo_methods'] ?>[]" id="<?php echo self::$meta_keys['promo_methods'] ?>" value="daily_deals" <?php if ( in_array( 'daily_deals', self::get_promo_methods($post->ID) ) ) echo 'checked' ?>>
							Daily Deals<br/>
							<input type="checkbox" name="<?php echo self::$meta_keys['promo_methods'] ?>[]" id="<?php echo self::$meta_keys['promo_methods'] ?>" value="social_media" <?php if ( in_array( 'social_media', self::get_promo_methods($post->ID) ) ) echo 'checked' ?>>
							Social Media<br/>
						</td>
					</tr>

					<tr>
						<td>
							<label for="<?php echo self::$meta_keys['details'] ?>"><?php gb_e('Detail:') ?></label><br />
							<textarea rows="5" cols="25" name="<?php echo self::$meta_keys['details'] ?>" id="<?php echo self::$meta_keys['details'] ?>"><?php echo self::get_details($post->ID) ?></textarea>

						</td>
					</tr>
				</tbody>
			</table>
		<?php
	}

	public static function save_meta_boxes( $post_id, $post ) {
		// only continue if it's an account post
		if ( $post->post_type != Group_Buying_Merchant::POST_TYPE ) {
			return;
		}
		// don't do anything on autosave, auto-draft, bulk edit, or quick edit
		if ( wp_is_post_autosave( $post_id ) || $post->post_status == 'auto-draft' || defined('DOING_AJAX') || isset($_GET['bulk_edit']) ) {
			return;
		}
		self::save_meta_box($post_id, $post);
	}

	private static function save_meta_box( $post_id, $post ) {
		$advertising_methods = isset( $_POST[self::$meta_keys['advertising_methods']] ) ? $_POST[self::$meta_keys['advertising_methods']] : '';
		$package = isset( $_POST[self::$meta_keys['package']] ) ? $_POST[self::$meta_keys['package']] : '';
		$time_in_biz = isset( $_POST[self::$meta_keys['time_in_biz']] ) ? $_POST[self::$meta_keys['time_in_biz']] : '';
		$details = isset( $_POST[self::$meta_keys['details']] ) ? $_POST[self::$meta_keys['details']] : '';
		$promo_methods = isset( $_POST[self::$meta_keys['promo_methods']] ) ? $_POST[self::$meta_keys['promo_methods']] : '';
		$internet_marketing = isset( $_POST[self::$meta_keys['internet_marketing']] ) ? $_POST[self::$meta_keys['internet_marketing']] : '';
		$does_int_marketing = isset( $_POST[self::$meta_keys['does_int_marketing']] ) ? $_POST[self::$meta_keys['does_int_marketing']] : '';
		$biz_hours = isset( $_POST[self::$meta_keys['biz_hours']] ) ? $_POST[self::$meta_keys['biz_hours']] : '';
		$storefront_detail = isset( $_POST[self::$meta_keys['storefront_detail']] ) ? $_POST[self::$meta_keys['storefront_detail']] : '';

		self::set_advertising_methods( $post_id, $advertising_methods );
		self::set_package( $post_id, $package );
		self::set_time_in_biz( $post_id, $time_in_biz );
		self::set_details( $post_id, $details );
		self::set_promo_methods( $post_id, $promo_methods );
		self::set_internet_marketing( $post_id, $internet_marketing );
		self::set_does_int_marketing( $post_id, $does_int_marketing );
		self::set_biz_hours( $post_id, $biz_hours );
		self::set_storefront_detail( $post_id, $storefront_detail );
	}

	public static function get_advertising_methods( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$advertising_methods = $merchant->get_post_meta( self::$meta_keys['advertising_methods'] );
		return $advertising_methods;
	}

	public static function set_advertising_methods( $merchant_id, $advertising_methods ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['advertising_methods'] => $advertising_methods
		));
		return $advertising_methods;
	}

	public static function get_package( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$package = $merchant->get_post_meta( self::$meta_keys['package'] );
		return $package;
	}

	public static function set_package( $merchant_id, $package ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['package'] => $package
		));
		return $package;
	}

	public static function get_time_in_biz( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$time_in_biz = $merchant->get_post_meta( self::$meta_keys['time_in_biz'] );
		return $time_in_biz;
	}

	public static function set_time_in_biz( $merchant_id, $time_in_biz ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['time_in_biz'] => $time_in_biz
		));
		return $time_in_biz;
	}

	public static function get_details( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$details = $merchant->get_post_meta( self::$meta_keys['details'] );
		return $details;
	}

	public static function set_details( $merchant_id, $details ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['details'] => $details
		));
		return $details;
	}

	public static function get_promo_methods( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$promo_methods = (array)$merchant->get_post_meta( self::$meta_keys['promo_methods'] );
		return $promo_methods;
	}

	public static function set_promo_methods( $merchant_id, $promo_methods ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['promo_methods'] => $promo_methods
		));
		return $promo_methods;
	}

	public static function get_internet_marketing( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$internet_marketing = $merchant->get_post_meta( self::$meta_keys['internet_marketing'] );
		return $internet_marketing;
	}

	public static function set_internet_marketing( $merchant_id, $internet_marketing ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['internet_marketing'] => $internet_marketing
		));
		return $internet_marketing;
	}

	public static function get_does_int_marketing( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$does_int_marketing = $merchant->get_post_meta( self::$meta_keys['does_int_marketing'] );
		return $does_int_marketing;
	}

	public static function set_does_int_marketing( $merchant_id, $does_int_marketing ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['does_int_marketing'] => $does_int_marketing
		));
		return $does_int_marketing;
	}

	public static function get_biz_hours( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$biz_hours = $merchant->get_post_meta( self::$meta_keys['biz_hours'] );
		return $biz_hours;
	}

	public static function set_biz_hours( $merchant_id, $biz_hours ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['biz_hours'] => $biz_hours
		));
		return $biz_hours;
	}

	public static function get_storefront_detail( $merchant_id ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$storefront_detail = $merchant->get_post_meta( self::$meta_keys['storefront_detail'] );
		return $storefront_detail;
	}

	public static function set_storefront_detail( $merchant_id, $storefront_detail ) {
		$merchant = Group_Buying_Merchant::get_instance($merchant_id);
		$merchant->save_post_meta( array(
			self::$meta_keys['storefront_detail'] => $storefront_detail
		));
		return $storefront_detail;
	}


}
