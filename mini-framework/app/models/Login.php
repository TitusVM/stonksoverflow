<?php

/**
 * The Login class is a class that allows users to login to the webapp.
 */
require 'core/database/Model.php';

class Login extends Model
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    private $username;

    private $password;

    /***************************************************\
    *                   Public methods                  * 
    \***************************************************/

    public function parseLogin()
    {
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];

        if($this->validateLogin())
        {
            $_SESSION['username'] = $this->username;
            $tabArgs = array(
                array('username', $this->username, PDO::PARAM_STR)
            );
            $user = Model::fetch("Users", $tabArgs);
            $_SESSION['idUser'] = $user['id'];
            Helper::view("mainscreen");
        }
        else
        {
            $_SESSION['Error'] = "Password or username is incorrect";
            Helper::view("login");
        }
    }

    public static function parseNewAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            if(isset($_POST['username']))
            {
                $username = $_POST['username'];
                $tabArgs = array(
                array("username", htmlentities($username), PDO::PARAM_STR)
                );
                $user = Model::fetch("Users", $tabArgs);
                if(!empty($user))
                {
                    $_SESSION['Error'] = "Username already exists.";
                    Helper::view("new_account");
                }
                else if(isset($_POST['password']))
                {
                    if(isset($_POST['confirmPassword']))
                    {
                        if($_POST['password'] == $_POST['confirmPassword'])
                        {
                            //$passwordNonHash = $_POST['password'];
                            //$password = hash("sha256", "titus" . $passwordNonHash . "miguel");
                            $password = $_POST['password'];
                            $tabArgs = array (
                                array("username", $username, PDO::PARAM_STR),
                                array("passwd", $password, PDO::PARAM_STR)
                            );
                            Model::add("Users", $tabArgs);
                            $tabArgs = array(
                                array("username", $username, PDO::PARAM_STR)
                            );
                            $user = Model::fetch("Users", $tabArgs);
                            $_SESSION['username'] = $username;
                            $_SESSION['idUser'] =  $user['id'];
                            Helper::view("mainscreen");
                        }
                        else
                        {
                            $_SESSION['Error'] = "Passwords aren't the same";
                            Helper::view("new_account");
                        }
                    }
                    else
                    {
                        $_SESSION['Error'] = "Password can't be empty";
                        Helper::view("new_account");
                    }
                }
                else
                {
                    $_SESSION['Error'] = "Password can't be empty";
                    Helper::view("new_account");
                }
            }
            else
            {
                $_SESSION['Error'] = "Username can't be empty";
                Helper::view("new_account");
            }
        }
    }

    public static function logout()
    {
        session_destroy();
        Helper::view("login");
    }

    public function validateLogin()
    {
        $tableName = "Users";
        $tabArgs = array(
            array("username", $this->username, PDO::PARAM_STR),
            array("passwd", $this->password, PDO::PARAM_STR)
        );
        $fetch = $this->fetch($tableName, $tabArgs);
        return !empty($fetch);
    }
}