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
				<a href="show_questions" id="title">$tonksOverflow</a>
			</li>
			<li>
		<a href="user_questions" class="tab" >My Posts</a>
			</li>
			<li>
		<a href="add_question" class="tab" >Ask a question</a>
			</li>
			<li>
			<form style="float: right;" action="login_logout" method="post">
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
		</ul>
	</div>


