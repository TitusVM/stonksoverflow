<?php
  if(!isset($_SESSION['username'])) {
    header("Location: login");
      exit;
  }
  $title = "Edit comment";
  $username = $_SESSION['username'];

  require('partials/header.php');
?>
<main>
  <div class="new-question">
  <h1>Edit comment</h1>  
    <form id="edit-comment-form" action="parse_edit_comment_form" method="post">
      <input type="hidden" name="id" value="<?php echo htmlentities($comment->getId())?>" required>

      <input type="hidden" name="idQuestion" value="<?php echo htmlentities($comment->getIdQuestion())?>" required>

      <input type="hidden" name="idAnswer" value="<?php echo htmlentities($comment->getIdAnswer())?>" required>      
      
      <input type="hidden" name="datetimestamp" value="<?php echo htmlentities($comment->getDatetimestamp())?>" required>
      
      <input type="hidden" name="idUser" value="<?php echo htmlentities($comment->getIdUser())?>" required>
    </form>
      <textarea name="mainText" cols="50" rows="10" form="edit-comment-form" required><?php echo htmlentities($comment->getMainText())?></textarea>
      <input id="submit-btn" type="submit" form="edit-comment-form" value="Submit">
  </div>
</main>
<?php require('partials/footer.php'); ?>