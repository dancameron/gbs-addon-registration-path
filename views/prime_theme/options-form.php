<form action="" method="post" enctype="multipart/form-data" id="mixed_registration_form" class="registration_form">
  <fieldset>
	<legend>Legend</legend>

	<div class="control-group">
		<label class="control-label" for="gb_contact_merchant_title">Company Name</label>
		<div class="controls">
			<input type="text" name="gb_contact_merchant_title" placeholder="Placeholder text..." value="<?php if ( isset( $_REQUEST['gb_contact_merchant_title'] ) ) echo $_REQUEST['gb_contact_merchant_title']; ?>" required>
			<span class="help-block">Example block-level help text here.</span>
		</div>
	</div>

	<input name="<?php echo $FORM_ACTION ?>" type="hidden" value="<?php echo $step ?>" />

	<button type="submit" class="btn">Submit</button>
  </fieldset>
</form>
