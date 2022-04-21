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
    <?php
    echo $questionId;
    ?>
</main>
<?php require('partials/footer.php'); ?>