<?php

/**
 * The Post class is an abstract class to provide a parent to Question, Answer and Comment. Post will be called in child classes and will provide basic functions such as fetchAll, fetchId...
 */

require 'core/database/Model.php';

class Post extends Model
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    private $id;

    private $mainText;
    
    private $datetimestamp;
    
    private $idUser;

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
    
    /***************************************************\
    *                   Public methods                  * 
    \***************************************************/

    public function textAsDiv()
    {
        $htmlCode = "";
        $htmlCode .= 
        "<div class=\"post\">
            <p>" . htmlentities($this->mainText) . "</p>"
        . "</div>";
        return $htmlCode;
    }
}
