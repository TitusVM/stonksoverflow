<?php
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    $title = "Home";
    require('partials/header.php')
    
?>
<h1>Home</h1>
<div class="container center">
    <p>
        Bienvenu(e) sur la page d'accueil, vous pouvez aller vous connecter ici : <a href="login">Login</a>
        Pour voir la liste de questions et réponses : <a href="show_questions">Questions</a>
    </p>
    <?php
        if( isset($_SESSION['Error']) )
        {
                echo "<p class=\"error\">" . $_SESSION['Error'] . "</p>";
                unset($_SESSION['Error']);
        }
        else if (isset($_SESSION['username']))
        {
            echo "<p>Vous êtes connecté en tant que " . $_SESSION['username'] . "</p>";
        }
    ?>
</div>


<?php require('partials/footer.php') ?>
