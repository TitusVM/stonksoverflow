<?php
    $title = "New Account";
    require('partials/header.php');
    $username = "";
    if(isset($_POST['username']))
    {
        $username = $_POST['username'];
    }
?>
<h1>New Account</h1>
    <div class="container center">
        <form action="add_account" method="post">
            <input type="text" class="standard-field" name="username" placeholder="Username" required maxlength="20" value=<?= $username?>>
            <input type="password" class="standard-field" name="password" placeholder="Password" required>
            <input type="password" class="standard-field" name="confirm_password" placeholder="Confirm Password" required>
            <?php
                if( isset($_SESSION['Error']) )
                {
                        echo "<p class=\"error\">" . $_SESSION['Error'] . "</p>";
                        unset($_SESSION['Error']);
                }
            ?>
            <input type="submit" class="standard-field" value="Submit" >
        </form>
    </div>

