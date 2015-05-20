<?php

defined('_JEXEC') or die; ?>

<form action="<?php echo $action ?>" method="post">
	<div class="form-group">
		<input type="text" name="name" class="form-control" placeholder="<?php echo $name; ?>">
	</div>
	<div class="form-group">
		<input type="text" name="email" class="form-control" placeholder="<?php echo $email; ?>">
	</div>
	<div class="form-group">
		<input type="text" name="phone" class="form-control" placeholder="<?php echo $phone; ?>">
	</div>
	<div class="form-group">
		<textarea name="message" class="form-control" placeholder="<?php echo $message; ?>"></textarea>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>