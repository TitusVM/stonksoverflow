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
            $login->parseLogin();
        }
        else
        {
            echo "No username or password";
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
            Login::parseNewAccount();
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
    }
}