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
      if ($failure != "") {
    ?>
       <p class="error">
       Question could not be added: <?= $failure ?>
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
      foreach ($questions as $question) {
        echo $question->asHtmlTitleOnly();
    }?>
    </div>
  </div>
  <!-- Create div on right side of screen -->
  <div id="questionDisplay">

  </div>
</main>
<br>

<?php require('partials/footer.php'); ?>