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
        echo $question->asHtml() . "<a href=\"edit?" . htmlentities($question->getId()) . "\">Edit</a>";
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
        echo $answer->asHtml() . "<a href=\"edit?" . htmlentities($answer->getId()) . "\">Edit</a>";
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
        echo $comment->asHtml() . "<a href=\"edit?" . htmlentities($comment->getId()) . "\">Edit</a>";
      }
    }
    else
    {
      echo "<p>No Comments yet.</p>";
    }?>
    </div>

</main>
<?php require('partials/footer.php'); ?>