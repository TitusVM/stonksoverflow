<!DOCTYPE html>

<html>
<head>
  	<link rel="stylesheet" type="text/css" href="css/stylesheet.css?<?php echo time(); ?>" />
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<title>MainScreen</title>
</head>

<body>
    <div>
        <div id="questionList">
            <input type="text" placeholder="Search">
            <div id="questionLinks">
                <a href="">Question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
                <a href="">Another question</a>
            </div>
        </div> 
        <div id="questionDisplay">
            <p id="questionName">Question</p>
            <div class="questionAnswer">
                <p>Question</p>
            </div>  
            <button type="button" class="showComments">Show comments</button>
            <p class="comments">Question comment</p>

            <div class="questionAnswer">
                <p>Answer</p>
            </div>  
            <button type="button" class="showComments">Show comments</button>
            <p class="comments">Answer comment</p>

            <div class="questionAnswer">
                <p>Another answer</p>
            </div>  
            <button type="button" class="showComments">Show comments</button>
            <p class="comments">Another answer comment</p>
        </div>
    </div>
</body>
</html>

