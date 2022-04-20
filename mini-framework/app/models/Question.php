<?php

/**
 * The question class allows users to post Questions and stores them as Questions in the database. It is an extension of the Post class.
 */

require 'app/models/Post.php';

class Question extends Post
{
    /***************************************************\
    *                    Attributes                     *  
    \***************************************************/

    

    /***************************************************\
    *                   Public methods                  *  
    \***************************************************/

    public function asHtml()
    {
        $htmlCode = "";
        $htmlCode .= 
        "<div class=\"question\">" . $this->textAsDiv()
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
}