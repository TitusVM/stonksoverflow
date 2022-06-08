<?php
session_start();

require 'app/models/Login.php';

class LoginController
{
    public function index()
    {
        if(isset($_SESSION['username']))
        {
            header("Location: mainscreen");
            exit;
        }
        else
        {
            if(isset($_POST['username']))
            {
                $username = $_POST['username'];
            }
            else
            {
                $username = "";
            }
            Helper::view("login",[
                'username' => $username,
            ]);
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
        if(isset($_POST['username']))
        {
            $username = $_POST['username'];
        }
        else
        {
            $username = "";
        }
        Helper::view("new_account",[
            'username' => $username,
        ]);
    }

    public function addAccount()
    {
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPassword']))
        {
            if($_POST['password'] == $_POST['confirmPassword'])
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
                }
                else
                {
                    $login->addAccount(); 
                }
            }
            else
            {
                $_SESSION['Error'] = "Passwords don't match.";
            }
        }
        else
        {
            $_SESSION['Error'] = "Password can't be empty";
        }
    }

    public function logout()
    {
        Login::logout();
        Helper::view("index");
    }

    public function loginLogout()
    {
        if(isset($_SESSION['username'])){
            Login::logout();
        }
        else {
            Helper::view("login");
        }
    }
}