<?php
  if(!isset($_SESSION['username'])) {
    header("Location: login");
      exit;
  }
  $title = "My Questions";
  $username = $_SESSION['username'];
  require('partials/header.php');
?>
<h1>User <?php echo $username?>'s Questions</h1>
<main>


    <div class="grid-container center">
      <div class="grid-item flex-container" id="legend">
      </div>
    </div>
    <div id="question-list">
    <?php 
    if ($questions != null) 
    {
      foreach ($questions as $question) 
      {
        echo "<p>" . $question->getMainText() . "  " . "<a href=\"editQuestion?" . htmlentities($question->getId()) . "\">✏</a>". "</p>";
      }
    }
    else
    {
      echo "<p>No questions yet.</p>";
    }?>
    </div>
    </div>

  <h1>User <?php echo $username?>'s Answers</h1>
  <div id="answer-list">
    <?php 
    if ($answers != null) 
    {
      foreach ($answers as $answer) 
      {
        echo "<p>" . $answer->getMainText() . "  " . "<a href=\"editAnswer?" . htmlentities($answer->getId()) . "\">✏</a>". "</p>";
      }
    }
    else
    {
      echo "<p>No Answers yet.</p>";
    }?>
    </div>

  <h1>User <?php echo $username?>'s Comments</h1>
  <div id="comment-list">
    <?php 
    if ($comments != null) 
    {
      foreach ($comments as $comment) 
      {
        echo "<p>" . $comment->getMainText() . "  " . "<a href=\"editComment?" . htmlentities($comment->getId()) . "\">✏</a>". "</p>";
      }
    }
    else
    {
      echo "<p>No Comments yet.</p>";
    }?>
    </div>

</main>
<?php require('partials/footer.php'); ?>