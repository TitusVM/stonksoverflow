<?php
    $title = "New Account";
    require('partials/header.php');
    $username = "";
    if(isset($_POST['username']))
    {
        $username = $_POST['username'];
    }
?>

<div class="loginCenter">
    <h1>New Account</h1>
    <form action="add_account" method="post">
        <label for="username">Username : </label>
        <input type="text" class="loginFields" name="username" placeholder="Username" required maxlength="20" value=<?= $username?>>
        <label for="password">Password : </label>
        <input type="password" class="loginFields" name="password" placeholder="Password" required>
        <label for="confirmPassword">Confirm password : </label>
        <input type="password" class="loginFields" name="confirmPassword" placeholder="Confirm Password" required>
        <?php
            if( isset($_SESSION['Error']) )
            {
                    echo "<p class=\"error\">" . $_SESSION['Error'] . "</p>";
                    unset($_SESSION['Error']);
            }
        ?>
        <input type="submit" class="submit" value="Submit" >
    </form>
</div>
