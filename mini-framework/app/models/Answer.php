<?php

/**
 * Test if Post class is defined and working
 */

if(!class_exists('Post')) {
    require 'app/models/Post.php';
}
elseif (!class_exists('Comment')) {
    require 'app/models/Comment.php';
}


/**
 * The Answer class allows users to answer Anwsers and stores them as Answers in the database. It is an extension of the Post class.
 */


class Answer extends Post
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    private $commentList;

    /***************************************************\
    *                   Public methods                  *  
    \***************************************************/

    public function asHtml()
    {
        $htmlCode = "";
        $htmlCode .= 
        "<div class=\"answer\">" . $this->textAsDiv()
            . "<div class=\"comments\">"
                . $this->commentListAsHtml()
                . "<button onclick=\"toggleAddCommentsAnswer(" . $this->getId() . ")\">Comment</button>"
                . "<div id=\"addCommentAnswer" . $this->getId() . "\" class=\"addCommentDiv\" style=\"display: none;\" >"
                    . "<form id=\"addCommentAnswerForm" . $this->getId() . "\" action=\"add_comment_answer\" method=\"post\">"
                        . "<input type=\"text\" name=\"idAnswer\" value=\"" . $this->getId() ."\" style=\"display:none;\"/>"
                        . "<input type=\"text\" name=\"idUser\" value=\"" . $_SESSION['idUser'] ."\" style=\"display:none;\"/>"
                    . "</form>"
                    . "<textarea name=\"mainText\" form=\"addCommentAnswerForm" . $this->getId() . "\" id=\"commentField" . $this->getId() 
                        . "\" class=\"commentField\" placeholder=\"Add a comment...\" required></textarea>"
                    . "<input type=\"submit\" form=\"addCommentAnswerForm" . $this->getId() . "\" value=\"Submit\" />"
                . "</div>"
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