<?php
require_once 'Core/init.php';

if(Session::exist('home')) {
	echo '<p>' . Session::flash('home') . '<p>';
}

$user = new User();
if($user->isLoggedIn()) {
?>
	<p>Hello <a href="#"><?php escape($user->data()->username);  ?></a>

	<ul>
		<li><a href="logout.php">Logout</a></li>
	</ul>
<?php	
} else {
	echo '<p>You need to <a href="login.php">login</a> or <a href="register.php">register</a></p>'
}