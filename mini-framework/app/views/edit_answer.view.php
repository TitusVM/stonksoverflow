<?php
  if(!isset($_SESSION['username'])) {
    header("Location: login");
      exit;
  }
  $title = "Edit answer";
  $username = $_SESSION['username'];

  require('partials/header.php');
?>
<main>
  <div class="new-question">
  <h1>Edit answer</h1>  
    <form id="edit-answer-form" action="parse_edit_answer_form" method="post">
      <input type="hidden" name="id" value="<?php echo htmlentities($answer->getId())?>" required>

      <input type="hidden" name="idQuestion" value="<?php echo htmlentities($answer->getIdQuestion())?>" required>
      
      <input type="hidden" name="datetimestamp" value="<?php echo htmlentities($answer->getDatetimestamp())?>" required>
      
      <input type="hidden" name="idUser" value="<?php echo htmlentities($answer->getIdUser())?>" required>
    </form>
      <textarea name="mainText" cols="50" rows="10" form="edit-answer-form" required><?php echo htmlentities($answer->getMainText())?></textarea>
      <input id="submit-btn" type="submit" form="edit-answer-form" value="Submit">
  </div>
</main>
<?php require('partials/footer.php'); ?>