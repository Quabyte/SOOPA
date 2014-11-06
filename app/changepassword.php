<?php
require_once 'Core/init.php';

$user = new User();

if(!$user->isLoggedIn) {
	Redirect::to('index.php');
}

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {

		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true,
				'min' => 6
			),
			'password_new' => array(
				'required' => true,
				'min' => 6
			),
			'password_new_confirmation' => array(
				'reqiured' => true,
				'min' => 6,
				'matches' => 'password_new'
			)
		));

		if($validation->passed()) {

			if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
				echo 'Your curren password is wrong.';
			} else {
				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(Input::get('password_new'), $salt);
					'salt' => $salt
				));

				Session::flash('home', 'your password has been changed.');
				Redirect::to('index.php');
			}

		} else {
			foreach($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}

?>

<form action="" method="post">
	<div class="field">
		<label for="password_current">
			Current password
		</label>
		<input type="password" name="password_current" id="password_current">
	</div>
	<div class="field">
		<label for="password_new">
			New password
		</label>
		<input type="password" name="password_new" id="password_new">
	</div>
	<div class="field">
		<label for="password_new_confirmation">
			New password again
		</label>
		<input type="password" name="password_new_confirmation" id="password_new_confirmation">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate() ?>">
	<input type="submit" value="Change">
</form>