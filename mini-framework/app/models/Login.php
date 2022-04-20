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
            $user = Model::fetch("users", $tabArgs);
            $_SESSION['userId'] = $user['id'];
            header("Location: index");
            exit;
        };
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
    }

    public function validateLogin()
    {
        $tableName = "users";
        $tabArgs = array(
            array("username", $this->username, PDO::PARAM_STR),
            array("passwd", $this->password, PDO::PARAM_STR)
        );
        $fetch = $this->fetch($tableName, $tabArgs);
        return !empty($fetch);
    }
}