<form action="" method="post" enctype="multipart/form-data" id="mixed_registration_form" class="registration_form">
  <fieldset>

	<?php if ( !is_user_logged_in() ): ?>

		<div class="control-group">
			<label class="control-label" for="gb_user_login">Username</label>
			<div class="controls">
				<input type="text" name="gb_user_login" placeholder="" value="<?php if ( isset( $_REQUEST['gb_user_login'] ) ) echo $_REQUEST['gb_user_login']; ?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="gb_user_password">Password</label>
			<div class="controls">
				<input type="password" name="gb_user_password" placeholder="" value="<?php if ( isset( $_REQUEST['gb_user_password'] ) ) echo $_REQUEST['gb_user_password']; ?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="gb_user_password2">Confirm Password</label>
			<div class="controls">
				<input type="password" name="gb_user_password2" placeholder="" value="<?php if ( isset( $_REQUEST['gb_user_password2'] ) ) echo $_REQUEST['gb_user_password2']; ?>" required>
			</div>
		</div>
	<?php endif ?>

	<div class="control-group">
		<label class="control-label" for="gb_contact_merchant_title">Company Name</label>
		<div class="controls">
			<input type="text" name="gb_contact_merchant_title" placeholder="" value="<?php if ( isset( $_REQUEST['gb_contact_merchant_title'] ) ) echo $_REQUEST['gb_contact_merchant_title']; ?>" required>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_contact_merchant_description">Company Description</label>
		<div class="controls">
			<textarea name="gb_contact_merchant_description" required><?php if ( isset( $_REQUEST['gb_contact_merchant_description'] ) ) echo $_REQUEST['gb_contact_merchant_description']; ?></textarea>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_contact_merchant_thumbnail">Business Image</label>
		<div class="controls">
			<input type="file" name="gb_contact_merchant_thumbnail" id="gb_contact_merchant_thumbnail">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_contact_name">Contact Name</label>
		<div class="controls">
			<input type="text" name="gb_contact_name" placeholder="" value="<?php if ( isset( $_REQUEST['gb_contact_name'] ) ) echo $_REQUEST['gb_contact_name']; ?>" required>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_merchant_type">Business Type</label>
		<div class="controls">
			<select name="gb_merchant_type" required>
				<option selected="selected">...</option>
				<?php
					$merchant_types = gb_get_merchant_types( FALSE );
					foreach ( $merchant_types as $type ): ?>
					<option value="<?php echo $type->term_id ?>" <?php selected( $type->ID, $_REQUEST['gb_merchant_type'] ) ?>><?php echo $type->name ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>

	<?php if ( !is_user_logged_in() ): ?>
		<div class="control-group">
			<label class="control-label" for="gb_user_email">Email</label>
			<div class="controls">
				<input type="text" name="gb_user_email" placeholder="" value="<?php if ( isset( $_REQUEST['gb_user_email'] ) ) echo $_REQUEST['gb_user_email']; ?>" required>
			</div>
		</div>
	<?php endif ?>

	<div class="control-group">
		<label class="control-label" for="gb_contact_phone">Company Phone</label>
		<div class="controls">
			<input type="text" name="gb_contact_phone" placeholder="" value="<?php if ( isset( $_REQUEST['gb_contact_phone'] ) ) echo $_REQUEST['gb_contact_phone']; ?>" required>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_contact_website">Website</label>
		<div class="controls">
			<input type="text" name="gb_contact_website" id="gb_contact_website" value="<?php if ( isset( $_REQUEST['gb_contact_website'] ) ) echo $_REQUEST['gb_contact_website']; ?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_contact_facebook">Facebook</label>
		<div class="controls">
			<input type="text" name="gb_contact_facebook" id="gb_contact_facebook" value="<?php if ( isset( $_REQUEST['gb_contact_facebook'] ) ) echo $_REQUEST['gb_contact_facebook']; ?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_contact_twitter">Twitter</label>
		<div class="controls">
			<input type="text" name="gb_contact_twitter" id="gb_contact_twitter" value="<?php if ( isset( $_REQUEST['gb_contact_twitter'] ) ) echo $_REQUEST['gb_contact_twitter']; ?>">
		</div>
	</div>

	<input name="<?php echo $FORM_ACTION ?>" type="hidden" value="<?php echo $step ?>" />

	<button type="submit" class="reg-button">Submit Registration</button>
  </fieldset>
</form>
