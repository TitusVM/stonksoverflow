<?php
    $title = "Login";
    require('partials/header.php');
    $username = "";
    if(isset($_POST['username']))
    {
        $username = $_POST['username'];
    }
?>

<div class="loginCenter">
    <h1>Login</h1>
    <form action="loginSubmit" method="post">
        <label for="username">Username : </label>
        <input type="text" class="loginFields" name="username" placeholder="Username" required value=<?= $username ?>>
        <label for="password">Password : </label>
        <input type="password" class="loginFields" name="password" placeholder="Password" required>
        <?php
            if( isset($_SESSION['Error']) )
            {
                echo "<p class=\"error\">" . $_SESSION['Error'] . "</p>";
                unset($_SESSION['Error']);
            }
        ?>
        <input type="submit" class="submit" value="Submit" >
    </form>
    <form action="new_account" method="post">
        <input type="submit" class="newAccount" value="New Account" />
    </form>
</div>

