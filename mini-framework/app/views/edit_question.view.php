<?php
  if(!isset($_SESSION['username'])) {
    header("Location: login");
      exit;
  }
  $title = "Edit Question";
  $username = $_SESSION['username'];

  require('partials/header.php');
?>
<h1>Edit Question</h1>
<main>
  <form id="edit-question-form" action="parse_edit_form" method="post">
    <input class="standard-field small" type="hidden" name="id" value="<?php echo $question->getId()?>" required>
    
    <input class="standard-field small" type="hidden" name="datetimestamp" value="<?php echo $question->getDatetimestamp()?>" required>
    
    <input class="standard-field small" type="hidden" name="idUser" value="<?php echo $question->getIdUser()?>" required>
    
    <input  class="standard-field small" type="text" name="mainText" value="<?php echo $question->getMainText(); ?>">
  </form>
    <input class="standard-field small" type="submit" form="edit-question-form" value="Submit">
</main>
<?php require('partials/footer.php'); ?>