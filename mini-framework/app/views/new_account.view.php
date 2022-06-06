<?php
    $title = "New Account";
    require('partials/header.php');
?>

<div class="loginCenter">
    <h1>New Account</h1>
        <?php
            if( isset($_SESSION['Error']) )
            {
                    echo "<p class=\"error\">" . $_SESSION['Error'] . "</p>";
                    unset($_SESSION['Error']);
            }
        ?>
    <form action="add_account" method="post">
        <input type="text" class="loginFields" name="username" placeholder="Username" required maxlength="20" value=<?= $username?>>
        <input type="password" class="loginFields" name="password" placeholder="Password" required>
        <input type="password" class="loginFields" name="confirmPassword" placeholder="Confirm Password" required>
        <input type="submit" class="submit" value="Submit" >
    </form>
</div>
