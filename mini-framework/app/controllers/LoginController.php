<?php
session_start();

require 'app/models/Login.php';

class LoginController
{
    public function index()
    {
        if(isset($_SESSION['username']))
        {
            header("Location: index");
            exit;
        }
        else
        {
            Helper::view("login");
        }
    }

    public function parseInput()
    {
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            $login = new Login();
            $login->setUsername($_POST['username']);
            $login->setPassword($_POST['password']);
            if($login->parseLogin())
            {
                Helper::view("index");
            }
            else
            {
                Helper::view("login");
            }
        }
        else
        {
            $_SESSION['Error'] = "Please enter username and password to login.";
            Helper::view("login");
        }
    }

    public function newAccount()
    {
        Helper::view("new_account");
    }

    public function addAccount()
    {
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']))
        {
            if($_POST['password'] == $_POST['confirm_password'])
            {
                $login = new Login();
                $login->setUsername($_POST['username']);
                $login->setPassword($_POST['password']);
                $tabArgs = array(
                    array("username", htmlentities($login->getUsername()), PDO::PARAM_STR)
                );
                $user = Model::fetch("Users", $tabArgs);
                if(!empty($user))
                {
                    $_SESSION['Error'] = "Username already exists.";
                    Helper::view("new_account");
                }
                else
                {
                    $login->addAccount();
                    Helper::view("index");   
                }
            }
            else
            {
                $_SESSION['Error'] = "Passwords don't match.";
                Helper::view("new_account");
            }
        }
        else
        {
            $_SESSION['Error'] = "Password can't be empty";
            Helper::view("new_account");
        }
    }

    public function logout()
    {
        Login::logout();
        Helper::view("index");
    }
}