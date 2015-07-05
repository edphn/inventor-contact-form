<?php

defined('_JEXEC') or die; ?>

<?php if (isset($validator) && ! $validator->errors()) :?>
	<div class="alert alert-success" role="alert">
		<?php echo JText::_('MOD_WIREFLY_CONTACT_FORM_FRONT_SENDING_SUCCESS'); ?>
	</div>
<?php endif; ?>

<form action="<?php echo $action ?>" method="post">
	<div class="form-group <?php echo isset($validator) && $validator->hasError('name') ? 'has-error' : ''; ?>">
		<input type="text" name="name" class="form-control" placeholder="<?php echo $labels['name']; ?>" value="<?php echo $name; ?>">
		<?php if (isset($validator) && $validator->hasError('name')) : ?>
			<span class="help-block"><?php echo $validator->error('name'); ?></span>
		<?php endif; ?>
	</div>
	<div class="form-group <?php echo isset($validator) && $validator->hasError('email') ? 'has-error' : ''; ?>">
		<input type="text" name="email" class="form-control" placeholder="<?php echo $labels['email']; ?>" value="<?php echo $email; ?>">
		<?php if (isset($validator) && $validator->hasError('email')) : ?>
			<span class="help-block"><?php echo $validator->error('email'); ?></span>
		<?php endif; ?>
	</div>
	<?php if ($isPhoneFieldActive) : ?>
		<div class="form-group">
			<input type="text" name="phone" class="form-control" placeholder="<?php echo $labels['phone']; ?>" value="<?php echo $phone; ?>">
		</div>
	<?php endif; ?>
	<div class="form-group <?php echo isset($validator) && $validator->hasError('message') ? 'has-error' : ''; ?>">
		<textarea name="message" class="form-control" placeholder="<?php echo $labels['message']; ?>"><?php echo $message; ?></textarea>
		<?php if (isset($validator) && $validator->hasError('message')) : ?>
			<span class="help-block"><?php echo $validator->error('message'); ?></span>
		<?php endif; ?>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default"><?php echo $labels['submit']; ?></button>
	</div>
</form>