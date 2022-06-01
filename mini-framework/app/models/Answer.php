<?php

/**
 * The Answer class allows users to answer Anwsers and stores them as Answers in the database. It is an extension of the Post class.
 */

class Answer extends Post
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    private $idQuestion;
    private $commentList;

    /***************************************************\
    *                   Public methods                  *  
    \***************************************************/

    public function asHtml()
    {
        $htmlCode = "";
        $htmlCode .= 
        "<div class=\"answers\">" . $this->textAsDiv()
        . "<div class=\"comments\">"
        . $this->commentListAsHtml()
        . "</div>"
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
    
    public function commentListAsHtml()
    {
        $htmlCode = "";
        if(!empty($this->commentList))
        {
            foreach ($this->commentList as $comment)
            {
                $htmlCode .= $comment->asHtml();
            }
        }
        return $htmlCode;
    }
   
    public function getIdQuestion()
	{
		return $this->idQuestion;
	}

    public function setIdQuestion($value)
	{
		$this->idQuestion = $value;
	}

    public function getCommentList()
    {
        return $this->commentList;
    }

    public function setCommentList($value)
    {
        $this->commentList = $value;
    }
}
