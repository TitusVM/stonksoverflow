<?php
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    if(!isset($questions))
    {
        header("Location: show_questions");
    }
    
  $title = "Mainscreen";
  $username = $_SESSION['username'];
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

    <div id="mainscreenBackground">
      <div id="questionList">
        <input type="text" placeholder="Search" id="search">
        <div id="questions">
          <?php 
            foreach ($questions as $question) {
            echo $question->asHtmlTitleOnly();
          }?>
        </div>
      </div> 
      <div id="questionDisplay">
        <form action="login_logout" method="post">
          <?php
            if(isset($_SESSION['username'])) { ?>
              <input type="submit" class="mainscreenLogin" value="Logout">
            <?php }
            else { ?>
              <input type="submit" class="mainscreenLogin" value="Login">
            <?php }
          ?>
        </form>
      </div>
    </div>
<?php require('partials/footer.php'); ?>