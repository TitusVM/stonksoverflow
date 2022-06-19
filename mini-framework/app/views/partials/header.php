<!DOCTYPE html>

<html>
<head>
	<link rel="icon" href="favicon.png">
  	<link rel="stylesheet" type="text/css" href="css/stylesheet.css?<?php echo time(); ?>" />
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<title><?= htmlentities($title) ?></title>
</head>

<body>
	<div id="header">
		<ul>
			<li>
				<!-- picture as link element-->
				<a href="mainscreen" id="title">$tonksOverflow</a>
			</li>
			<li>
				<a href="user_questions" class="tab desktop-nav-bar">My Posts</a>
			</li>
			<li>
				<a href="add_question" class="tab desktop-nav-bar">Ask a question</a>
			</li>
			<li>
				<div id="burger-menu" onclick="burgerMenu()">
					<div></div>
					<div></div>
					<div></div>
				</div>
				<form style="float: right;" action="login_logout" method="post" id="login-logout-button">
				<?php
					if(isset($_SESSION['username'])) { ?>
					<input type="submit" class="mainscreenLogin" value="Logout">
					<?php }
					else { ?>
					<input type="submit" class="mainscreenLogin" value="Login">
					<?php }
				?>
				</form>
			</li>
			<div id="mobile-nav-bar">
				<a href="user_questions" class="mobile-nav-bar-links">My Posts</a>
				<a href="add_question" class="mobile-nav-bar-links">Ask a question</a>
				<?php
					if(isset($_SESSION['username'])) { ?>
					<a href="login_logout" class="mobile-nav-bar-links">Logout</a>
					<?php }
					else { ?>
					<a href="login_logout" class="mobile-nav-bar-links">Login</a>
					<?php }
				?>
			</div>
		</ul>
	</div>


