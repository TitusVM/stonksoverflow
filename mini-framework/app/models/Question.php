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
elseif (!class_exists('Answer')) {
    require 'app/models/Answer.php';
}

/**
 * The question class allows users to post Questions and stores them as Questions in the database. It is an extension of the Post class.
 */


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
        "<div class=\"title\">
            <h2> " .
                 $this->getTitle() . "
            </h2>
        </div>" 
        . 
        "<div class=\"question\">" . $this->getMainText()
        . "<div class=\"comments\">"
        . $this->commentListAsHtml()
        
        . "<button onclick=\"toggleAddComments(" . $this->getId() . ")\">Comment</button>"
        . "<div id=\"addComment" . $this->getId() . "\" class=\"addCommentDiv\" style=\"display: none;\" >"
            . "<form id=\"addCommentForm\" action=\"add_comment\" method=\"post\">"
                . "<input type=\"text\" name=\"idQuestion\" value=\"" . $this->getId() ."\" style=\"display:none;\"/>"
                . "<input type=\"text\" name=\"idUser\" value=\"" . $_SESSION['idUser'] ."\" style=\"display:none;\"/>"
            . "</form>"
            . "<textarea name=\"mainText\" form=\"addCommentForm\" id=\"commentField" . $this->getId() 
                . "\" class=\"commentField\" placeholder=\"Add a comment...\" required></textarea>"
            . "<input type=\"submit\" form=\"addCommentForm\" value=\"Submit\" />"
        . "</div>"
        . "</div>"
        . "<div class=\"answers\">"
        . $this->answerListAsHtml()
        . "</div>"
        . "<button onclick=\"toggleAddAnswers(" . $this->getId() . ")\">Answer</button>"
        . "<div id=\"addAnswer" . $this->getId() . "\" class=\"addAnswerDiv\" style=\"display: none;\" >"
            . "<form id=\"addAnswerForm\" action=\"add_answer\" method=\"post\">"
                . "<input type=\"text\" name=\"idQuestion\" value=\"" . $this->getId() ."\" style=\"display:none;\"/>"
                . "<input type=\"text\" name=\"idUser\" value=\"" . $_SESSION['idUser'] ."\" style=\"display:none;\"/>"
            . "</form>"
            . "<textarea name=\"mainText\" form=\"addAnswerForm\" id=\"answerField" . $this->getId() 
                . "class=\"answerField\" placeholder=\"Add an answer...\" required></textarea>"
            . "<input type=\"submit\" form=\"addAnswerForm\" value=\"Submit\" />"
            . "</div>"
        . "</div>"; 
        return $htmlCode;
    }

    public function asHtmlTitleOnly()
    {
        $htmlCode = "";
        $htmlCode .=
        "<div class=\"questionTitle\" >
            <h2>
                <a onclick=\"showQuestionDiv(" . $this->getId() . ")\" style=\"user-select: none\">" . $this->getTitle() . "</a>
            </h2>"
            . "<div class=\"post-info\" style=\"display:block;\">" 
                . "<p>" . $this->getUserName() . "</p>"
                . "<p>" . $this->getDateTimeStamp() . "</p>"
            . "</div>"
        . "</div>";
        return $htmlCode;
    }

    public function addQuestion()
    {
        $tabName = "Questions";
        $tabArgs = array(
            array("title", $this->getTitle(), PDO::PARAM_STR),
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