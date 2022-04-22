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


<div class="container" id="list-header">
    <div class="grid-container center">
      <div class="grid-item flex-container" id="legend">
      </div>
    </div>
    <div id="question-list">
    <?php 
    foreach ($questions as $question) {
        echo $question->asHtml() . "<a href=\"edit?" . htmlentities($question->getId()) . "\">Edit</a>" . "<a href=\"delete?" . htmlentities($question->getId()) . "\">Delete</a>";
    }?>
    </div>
  </div>


</main>
<?php require('partials/footer.php'); ?>