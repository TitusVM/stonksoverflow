<?php
  if(!isset($_SESSION['username'])) {
    header("Location: login");
      exit;
  }
    $title = "Add New Question";
    require('partials/header.php')
?>
<main>
  <div class="new-question" >
    <h1>Ask a Question</h1>
    <form id="new-question-form" action ="parse_add_form" method="post">
    </form>
    <textarea name="title" form="new-question-form" id="textArea" cols="30" rows="2" placeholder="An interesting title" required></textarea>
    <textarea name="mainText" form="new-question-form" id="textArea" cols="30" rows="10" placeholder="A detailed description" required></textarea>
    <input id="submit-btn" type="submit" form="new-question-form" value="Create new Question" >

  </div>
</main>
<?php require('partials/footer.php') ?>
