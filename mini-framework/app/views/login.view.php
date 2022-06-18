<?php
    $title = "Login";
    require('partials/header_login.php');
    $username = "";
    if(isset($_POST['username']))
    {
        $username = $_POST['username'];
    }
?>

<div class="loginCenter">
    <h1>Login</h1>
    <form action="loginSubmit" method="post">
        <?php
            if( isset($_SESSION['Error']) )
            {
                echo "<p class=\"error\">" . $_SESSION['Error'] . "</p>";
                unset($_SESSION['Error']);
            }
        ?>
        <input type="text" class="loginFields" name="username" placeholder="Username" required value=<?= $username ?>>
        <input type="password" class="loginFields" name="password" placeholder="Password" required>
        <input type="submit" class="submit" value="Submit" >
    </form>
    <form action="new_account" method="post">
        <input type="submit" class="newAccount" value="New Account" />
    </form>
</div>

