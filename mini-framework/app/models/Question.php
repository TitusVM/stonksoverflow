<?php

/**
 * The question class allows users to post Questions and stores them as Questions in the database. It is an extension of the Post class.
 */

require 'app/models/Post.php';
require 'app/models/Answer.php';
require 'app/models/Comment.php';

class Question extends Post
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    private $answerList;
    private $commentList;

    /***************************************************\
    *                   Public methods                  *  
    \***************************************************/

    public function asHtml()
    {
        $htmlCode = "";
        $htmlCode .= 
        "<div class=\"question\">" . $this->getMainText()
        . "<div class=\"comments\">"
        . $this->commentListAsHtml()
        . "</div>"
        . "<div class=\"answers\">"
        . $this->answerListAsHtml()
        . "</div>"
        . "</div>"; 
        return $htmlCode;
    }

    public function addQuestion()
    {
        $tabName = "Questions";
        $tabArgs = array(
            array("mainText", $this->getMainText(), PDO::PARAM_STR),
            array("datetimestamp", $this->getDatetimestamp(), PDO::PARAM_STR),
            array("idUser", $this->getIdUser(), PDO::PARAM_INT)
        );
        $this->add($tabName, $tabArgs);
    }

    public function answerListAsHtml()
    {
        $htmlCode = "";
        if(!empty($this->answerList))
        {
            foreach ($this->answerList as $answer)
            {
                $htmlCode .= $answer->asHtml();
            }
        }
        return $htmlCode;
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

    public function getAnswerList()
    {
        return $this->answerList;
    }

    public function setAnswerList($value)
    {
        $this->answerList = $value;
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