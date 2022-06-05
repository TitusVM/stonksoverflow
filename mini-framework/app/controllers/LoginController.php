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
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPassword']))
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