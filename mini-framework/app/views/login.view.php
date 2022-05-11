<?php
    $title = "Login";
    require('partials/header.php');
    $username = "";
    if(isset($_POST['username']))
    {
        $username = $_POST['username'];
    }
?>
<h1>Login</h1>
    <div class="container center">
        <form action="loginSubmit" method="post">
            <input type="text" class="standard-field" name="username" placeholder="Username" required value=<?= htmlentities($username) ?>>
            <input type="password" class="standard-field" name="password" placeholder="Password" required>
            <?php
                if( isset($_SESSION['Error']) )
                {
                        echo "<p class=\"error\">" . $_SESSION['Error'] . "</p>";
                        unset($_SESSION['Error']);
                }
            ?>
            <input type="submit" class="standard-field" value="Submit" >
        </form>
        <form action="new_account">
                <input type="submit" class="standard-field" value="New Account" />
        </form>
    </div>

