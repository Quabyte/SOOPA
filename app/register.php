<form action="" method="post">
	<div class="field">
		<label for="username">
			Username
		</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
	</div>
	<div class="field">
		<label for="password">
			Choose a password
		</label>
		<input type="password" name="password" id="password">
	</div>
	<div class="field">
		<label for="password_confirmation">
			Enter password again
		</label>
		<input type="password" name="password_confirmation" id="password_confirmation">
	</div>
	<div class="field">
		<label for="name">
			Enter your name
		</label>
		<input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
	</div>
	<input type="submit" value="Register">
</form>