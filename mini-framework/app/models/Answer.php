<?php

/**
 * The Answer class allows users to answer Anwsers and stores them as Answers in the database. It is an extension of the Post class.
 */

require 'app/models/Post.php';

class Answer extends Post
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    private $idQuestion;

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

    public function asHtml()
    {
        $htmlCode = "";
        $htmlCode .= 
        "<div class=\"anwser\">" . $this->textAsDiv()
        . "</div>"; 
        return $htmlCode;
    }

    public function addAnwser()
    {
        $tabName = "Anwsers";
        $tabArgs = array(
            array("mainText", $this->getMainText(), PDO::PARAM_STR),
            array("datetimestamp", $this->getDatetimestamp(), PDO::PARAM_STR),
            array("idQuestion", $this->getIdQuestion(), PDO::PARAM_INT),
            array("idUser", $this->getIdUser(), PDO::PARAM_INT)
        );
        $this->add($tabName, $tabArgs);
    }
}