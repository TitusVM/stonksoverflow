<?php
  $title = "Questions page";
  require('partials/header.php');
?>

<script>
  function showQuestionDiv(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("questionDisplay").innerHTML =
      this.responseText;
    }
    xhttp.open("GET", "question?" + id);
    xhttp.send(); 
  }
</script>

<main>
  
<h1>Questions</h1>
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
      foreach ($questions as $question) {
        echo $question->asHtmlTitleOnly();
    }?>
    </div>
  </div>
    <form action="add_question">
      <input type="submit" class="standard-field small" value="Add Question">
    </form>

  <!-- Create div on right side of screen -->
  <div id="questionDisplay" style="border: 1px solid; height: fit-content">

  </div>
</main>
<br>

<?php require('partials/footer.php'); ?>