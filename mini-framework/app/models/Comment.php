<?php

/**
 * Test if Post class is defined and working
 */
if(!class_exists('Post')) {
    require 'app/models/Post.php';
}


/**
 * The Comment class allows users to comment Anwsers or Questions and stores them as Comments in the database. It is an extension of the Post class.
 */


class Comment extends Post
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    private $idQuestion;
    private $idAnswer;

    /***************************************************\
    *                   Public methods                  *  
    \***************************************************/

    public function getIdQuestion()
	{
		return $this->idQuestion;
	}

    public function setIdQuestion($value)
	{
		$this->idQuestion = $value;
	}

    public function getIdAnswer()
	{
		return $this->idAnswer;
	}

    public function setIdAnswer($value)
	{
		$this->idAnswer = $value;
	}

    public function asHtml()
    {
        $htmlCode = "";
        $htmlCode .= 
        "<div class=\"comment\">" . $this->textAsDiv()
        . "</div>"; 
        return $htmlCode;
    }

    public function addComment()
    {
        $tabName = "Comments";
        $tabArgs = array(
            array("mainText", $this->getMainText(), PDO::PARAM_STR),
            array("datetimestamp", $this->getDatetimestamp(), PDO::PARAM_STR),
            array("idUser", $this->getIdUser(), PDO::PARAM_INT),
            array("idQuestion", $this->getIdQuestion(), PDO::PARAM_INT),
            array("idAnswer", $this->getIdAnswer(), PDO::PARAM_INT)
        );
        $this->add($tabName, $tabArgs);
    }
}