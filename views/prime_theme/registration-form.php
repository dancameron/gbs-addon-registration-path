<form action="" method="post" enctype="multipart/form-data" id="mixed_registration_form" class="registration_form">
  <fieldset>
	<legend>Legend</legend>

	<?php if ( !is_user_logged_in() ): ?>

		<div class="control-group">
			<label class="control-label" for="gb_user_login">Username</label>
			<div class="controls">
				<input type="text" name="gb_user_login" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_user_login'] ) ) echo $_REQUEST['gb_user_login']; ?>" required>
				<span class="help-block">Example block-level help text here.</span>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="gb_user_password">Password</label>
			<div class="controls">
				<input type="password" name="gb_user_password" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_user_password'] ) ) echo $_REQUEST['gb_user_password']; ?>" required>
				<span class="help-block">Example block-level help text here.</span>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="gb_user_password2">Confirm Password</label>
			<div class="controls">
				<input type="password" name="gb_user_password2" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_user_password2'] ) ) echo $_REQUEST['gb_user_password2']; ?>" required>
				<span class="help-block">Example block-level help text here.</span>
			</div>
		</div>
	<?php endif ?>

	<div class="control-group">
		<label class="control-label" for="gb_contact_merchant_title">Company Name</label>
		<div class="controls">
			<input type="text" name="gb_contact_merchant_title" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_contact_merchant_title'] ) ) echo $_REQUEST['gb_contact_merchant_title']; ?>" required>
			<span class="help-block">Example block-level help text here.</span>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_contact_name">Contact Name</label>
		<div class="controls">
			<input type="text" name="gb_contact_name" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_contact_name'] ) ) echo $_REQUEST['gb_contact_name']; ?>" required>
			<span class="help-block">Example block-level help text here.</span>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_merchant_type">Type</label>
		<div class="controls">
			<select name="gb_merchant_type" required>
				<option>...</option>
				<?php
					$merchant_types = gb_get_merchant_types(FALSE);
					foreach ( $merchant_types as $type ): ?>
					<option value="<?php echo $type->term_id ?>" <?php selected( $type->ID, $_REQUEST['gb_merchant_type'] ) ?>><?php echo $type->name ?></option>
				<?php endforeach ?>
			</select>
			<span class="help-block">Example block-level help text here.</span>
		</div>
	</div>

	<?php if ( !is_user_logged_in() ): ?>
		<div class="control-group">
			<label class="control-label" for="gb_user_email">Email</label>
			<div class="controls">
				<input type="text" name="gb_user_email" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_user_email'] ) ) echo $_REQUEST['gb_user_email']; ?>" required>
				<span class="help-block">Example block-level help text here.</span>
			</div>
		</div>
	<?php endif ?>

	<div class="control-group">
		<label class="control-label" for="gb_contact_phone">Company Phone</label>
		<div class="controls">
			<input type="text" name="gb_contact_phone" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_contact_phone'] ) ) echo $_REQUEST['gb_contact_phone']; ?>" required>
			<span class="help-block">Example block-level help text here.</span>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="gb_contact_postal_code">Company Zip Code</label>
		<div class="controls">
			<input type="text" name="gb_contact_postal_code" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_contact_postal_code'] ) ) echo $_REQUEST['gb_contact_postal_code']; ?>" required>
			<span class="help-block">Example block-level help text here.</span>
		</div>
	</div>

	<input name="<?php echo $FORM_ACTION ?>" type="hidden" value="<?php echo $step ?>" />

	<button type="submit" class="btn">Submit</button>
  </fieldset>
</form>