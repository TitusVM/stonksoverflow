<?php
  if(!isset($_SESSION['username'])) {
    header("Location: login");
      exit;
  }
  $title = "Edit Question";
  $username = $_SESSION['username'];

  require('partials/header.php');
?>
<main>
  <div class="new-question" >
  <h1>Edit Question</h1>  
    <form id="edit-question-form" action="parse_edit_form" method="post">
      <input type="hidden" name="id" value="<?php echo htmlentities($question->getId())?>" required>
      
      <input type="hidden" name="datetimestamp" value="<?php echo htmlentities($question->getDatetimestamp())?>" required>
      
      <input type="hidden" name="idUser" value="<?php echo htmlentities($question->getIdUser())?>" required>
      
      <input type="text" name="title" value="<?php echo htmlentities($question->getTitle())?>">
    </form>
      <textarea name="mainText" cols="50" rows="10" form="edit-question-form" required><?php echo htmlentities($question->getMainText())?></textarea>
      <input id="submit-btn" type="submit" form="edit-question-form" value="Submit">
  </div>
</main>
<?php require('partials/footer.php'); ?>