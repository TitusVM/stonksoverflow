<?php
  require('partials/question_header.php');
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>

<main>
  
<h1></h1>
   <?php
      if (isset($question_added_failure) && ($question_added_failure != "")) {
    ?>
       <p class="error">
       Question could not be added: <?= htmlentities($question_added_failure); ?>
       </p> 
    <?php } ?>

  <div class="container" id="list-header">
    <div class="grid-container center">
      <div class="grid-item flex-container" id="legend">
      </div>
    </div>
    <div id="question-list">
    <?php 
        echo $question->asHtml();
    ?>
    </div>
  </div>
</main>
<br>

<?php require('partials/footer.php'); ?>