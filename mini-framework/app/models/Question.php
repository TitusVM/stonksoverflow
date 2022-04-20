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
}