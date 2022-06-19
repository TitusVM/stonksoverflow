<?php

/**
 * The Post class is an abstract class to provide a parent to Question, Answer and Comment. Post will be called in child classes and will provide basic functions such as fetchAll, fetchId...
 */

if(!class_exists('Model')) {
    require 'core/database/Model.php';
}

class Post extends Model
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    private $id;

    private $mainText;
    
    private $datetimestamp;
    
    private $idUser;

    private $title;

    private $idQuestion;

    //private $upvoteCount;
    
    //private $downvoteCount;
    
    /***************************************************\
    *                 Getters and Setters               *  
    \***************************************************/
    
    public function getId()
	{
		return $this->id;
	}

    public function setId($value)
	{
		$this->id = $value;
	}

    public function getIdUser()
	{
		return $this->idUser;
	}

    public function setIdUser($value)
	{
		$this->idUser = $value;
	}

    public function getMainText()
	{
		return $this->mainText;
	}

    public function setMainText($value)
	{
		$this->mainText = $value;
	}

    public function getDatetimestamp()
	{
		return $this->datetimestamp;
	}

    public function setDatetimestamp($value)
	{
		$this->datetimestamp = $value;
	}

    public function getTitle()
	{
		return $this->title;
	}

    public function setTitle($value)
	{
		$this->title = $value;
	}

    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    public function setIdQuestion($value)
    {
        $this->idQuestion = $value;
    }

    public function getUserName()
    {
        // Model fetch user name
        $tabArgs = array(
            array("id", $this->getIdUser(), PDO::PARAM_INT)
        );
        $username = Model::fetchAttrWhere("Users", $tabArgs, "username");
        return $username['username'];
    }
    
    /***************************************************\
    *                   Public methods                  * 
    \***************************************************/

    public function textAsDiv()
    {
        $htmlCode = "";
        $htmlCode .= 
        "<div class=\"post\">"
            . "<p>" . $this->mainText . "</p>"
            . "<div class=\"post-info\" style=\"display:block;\">" 
                . "<p>" . $this->getUserName() . "</p>"
                . "<p class=\"dateTimeStamp\">" . $this->datetimestamp . "</p>"
            . "</div>"
        . "</div>";
        return $htmlCode;
    }
}