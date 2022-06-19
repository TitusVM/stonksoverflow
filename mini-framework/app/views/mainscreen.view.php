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