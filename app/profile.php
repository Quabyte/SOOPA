<?php
require_once 'Core/init.php';

if(!$username = Input::get('user')) {
	Redirect::to('index.php');
} else {
	$user = new User($username);
	if(!$user->exist()) {
		Redirect::to(404);
	} else {
		$data = $user->data();
	}
	?>

	<h3><?php echo escape($data->username); ?></h3>
	<p>Fullname: <?php echo escape($data->name); ?></p>

	<?php
}