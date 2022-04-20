<?php
  if(!isset($_SESSION['username'])) {
    header("Location: login");
      exit;
  }
    $title = "Add New Question";
    require('partials/header.php')
?>
<h1>Add New Task</h1>
<main>

    <p>
        The following form allows you to add a new question
    </p>

  <div class="container" id="question_list">
  <div class="grid-container center">
      <div class="grid-item flex-container">
        <div class="grid-titlecard">Question mainText</div>
      </div>
    </div>
    <form id="new-question-form" action ="parse_add_form" method="post">
      <input class="standard-field small" type="text" name="mainText" required>
    </form>
    <input class="standard-field small" type="submit" form="new-question-form" value="Create new Question">
  </div>
</main>
<?php require('partials/footer.php') ?>
