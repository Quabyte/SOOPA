<?php
require_once 'Core/init.php';

if(Session::exist('home')) {
	echo '<p>' . Session::flash('home') . '<p>';
}

$user = new User();
if($user->isLoggedIn()) {
?>
	<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php escape($user->data()->username); ?></a>

	<ul>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="update.php">Update Details</a></li>
		<li><a href="changepassword.php">Change Password</a></li>
	</ul>
<?php	

	if($user->hasPermission('admin')) {

	} 

} else {
	echo '<p>You need to <a href="login.php">login</a> or <a href="register.php">register</a></p>'
}