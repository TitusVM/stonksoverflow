<?php
  $title = "Questions page";
  require('partials/header.php');
?>

<main>
  
<h1>Questions</h1>
   <?php
      if ($failure != "") {
    ?>
       <p class="error">
       Question could not be added: <?= htmlentities($failure); ?>
       </p> 
    <?php } ?>

  <div class="container" id="list-header">
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
        echo $question->asHtml();
      }
    }
    else
    {
      echo "<p>No questions yet.<\p>";
    }?>
    </div>
  </div>
    <form action="add_question">
      <input type="submit" class="standard-field small" value="Add Question">
    </form>

</main>
<br>

<?php require('partials/footer.php'); ?>