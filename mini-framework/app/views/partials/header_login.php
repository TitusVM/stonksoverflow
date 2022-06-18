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
				<a href="user_questions" class="tab" >My Posts</a>
			</li>
			<li>
				<a href="add_question" class="tab" >Ask a question</a>
			</li>
		</ul>
	</div>

