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

    private $idUser;

    /***************************************************\
    *                 Getters and Setters               *  
    \***************************************************/

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($value)
    {
        $this->username = $value;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($value)
    {
        $this->password = $value;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($value)
    {
        $this->idUser = $value;
    }

    /***************************************************\
    *                   Public methods                  * 
    \***************************************************/

    public function parseLogin()
    {
        if($this->validateLogin())
        {
            $_SESSION['username'] = $this->username;
            $tabArgs = array(
                array('username', $this->username, PDO::PARAM_STR)
            );
            $user = Model::fetch("Users", $tabArgs);
            $_SESSION['idUser'] = $user['id'];
            return true;
        }
        else
        {
            $_SESSION['Error'] = "Username or password is incorrect.";
            return false;
        }
    }

    public function addAccount()
    {
        //$passwordNonHash = $_POST['password'];
        //$password = hash("sha256", "titus" . $passwordNonHash . "miguel");
        $tabArgs = array (
            array("username", $this->username, PDO::PARAM_STR),
            array("passwd", $this->password, PDO::PARAM_STR)
        );
        Model::add("Users", $tabArgs);
        $tabArgs = array(
            array("username", $this->username, PDO::PARAM_STR)
        );
        $user = Model::fetch("Users", $tabArgs);
        $_SESSION['username'] =  $user['username'];
        $_SESSION['idUser'] =  $user['id'];
        $this->idUser = $user['id'];
    }

    public static function logout()
    {
        session_destroy();
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