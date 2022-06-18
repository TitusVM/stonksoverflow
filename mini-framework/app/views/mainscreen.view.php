<?php
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        $username = "";
    }
    
  $title = "Mainscreen";
  require('partials/header.php');
?>

<script>
  setTimeout(function() {
      $('#messageDiv').fadeOut('fast');
  }, 1000); // <-- time in milliseconds

  function toggleAddCommentsAnswer(id)
  {
      let answerField = "#addCommentAnswer" + id;
      console.log(answerField);
      $(answerField).toggle("visibility");
  }

  function toggleAddAnswers(id) {
      let answerField = "#addAnswer" + id;
      console.log(answerField);
      $(answerField).toggle("visibility");
    }

    function toggleAddComments(id) {
      let commentField = "#addComment" + id;
      console.log(commentField);
      $(commentField).toggle("visibility");
    }

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
    <div id="messageDiv">
        <?php
            if (isset($success) && isset($failure))
            {
              if($success != "")
              {
                  echo "<div class='success'>" . $success . "</div>";
              }
              if($failure != "")
              {
                  echo "<div class='failure'>" . $failure . "</div>";
              }
            }
        ?>
    </div>
    <div id="mainscreenBackground">
      <div id="questionList">
        <!--<input type="text" placeholder="Search" id="search">-->
        <div id="questions">
          <?php 
            foreach ($questions as $question) {
            echo $question->asHtmlTitleOnly();
          }?>
        </div>
      </div> 
      <div id="questionDisplay">
      </div>
    </div>
<?php require('partials/footer.php'); ?>