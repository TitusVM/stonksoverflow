<?php
session_start();

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * AnswerController controls the answer objects behaviour
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Mini-Framework
 * @package    Answer
 * @author     Titus Abele <titus.abele@he-arc.ch>
 * @author     Miguel Moreira <miguel.moreira@he-arc.ch>
 */

// {{{ requires
require 'app/models/Answer.php';

if (!class_exists('Comment')) {
    require 'app/models/Comment.php';
}
// }}}

// {{{ class AnswerController
class AnswerController
{
    // {{{ index
        
    /**
     * index() displays the list of answers
     *
     * @return void
     * @deprecated since pre-release
     */
    public function index()
    {
        $tabArgs = array();
        $anwsers = Model::fetchAll("Answers", "datetimestamp", "Answer");
        
        $anwser_added_failure = "";
        $anwser_added_success = "";
        return Helper::view("show_anwsers",[
            'anwsers' => $anwsers,
            'anwser_added_success' => $anwser_added_success,
            'anwser_added_failure' => $anwser_added_failure,
        ]);
    }
    // }}}

    // {{{ showAddView
    /**
     * showAddView() displays the form to add a new answer
     *
     * @return void
     * @deprecated since pre-release
     */
    public function showAddView()
    {
        /**
         * Check if user is logged in (necessary to add an anwser)
         */
        if(!isset($_SESSION['username']))
        {
            header("Location: login");
            exit;
        }

        Helper::view("add_anwser");
    }
    // }}}

    // {{{ parseInput
    /**
     * parseInput() parses the input from the form and creates a new answer
     *
     * @return void
     */
    public function parseInput()
    {
        /**
         * Check if user is logged in (necessary to add an anwser)
         */
        if(!isset($_SESSION['username']))
        {
            header("Location: login");
            exit;
        }
        
        /**
         * Check if the anwser field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $anwser_added_failure = "Answer cannot be empty";
            $anwser_added_success = "";
            return Helper::view("show_anwsers",[
                'anwser_added_success' => $anwser_added_success,
                'anwser_added_failure' => $anwser_added_failure,
            ]);
        }
        /**
         * Check if length of anwser is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $anwser_added_failure = "Answer is too long";
            $anwser_added_success = "";
            return Helper::view("show_anwsers",[
                'anwser_added_success' => $anwser_added_success,
                'anwser_added_failure' => $anwser_added_failure,
            ]);
        }
        else
        {
            /**
             * Add anwser to database
             */
            $anwser = new Answer();
            $anwser->setMainText($_POST['mainText']);
            $anwser->setDatetimestamp(date("Y-m-d H:i:s"));
            $anwser->setIdUser($_SESSION['idUser']);
            $answer->setIdQuestion($_POST['idQuestion']);
            $anwser->addAnswer();

            /**
             * Set success message and return to anwsers page
             */
            $anwser_added_success = "Answer added";
            header("Location: index");
            exit;
        }
    }
    // }}}

    // {{{ userAnswers
    /**
     * userAnswers() displays the list of answers of a user
     *
     * @return void
     */
    public function userAnswers()
    {
        $tabArgs = array(
            array('idUser', $_SESSION['idUser'], PDO::PARAM_INT),

        );
        $anwsers = Model::fetchAllWhere("Answers", $tabArgs, "datetimestamp", "Answer");
        
        return Helper::view("user_anwsers",[
            'anwsers' => $anwsers,
        ]);
    }
    // }}}

    // {{{ edit
    /**
     * edit() displays the form to edit an answer
     *
     * @return void
     */
    public function edit()
    {
        /**
         * Redirect to edit page
         */
        if(isset($_SESSION['username']))
        {
            $anwserId = $_SERVER['QUERY_STRING'];
            $idUser = $_SESSION['idUser'];
            $tabArgs = array(
                array('id', $anwserId, PDO::PARAM_INT),
                array('idUser', $idUser, PDO::PARAM_INT),
            );
            $fetch = Model::fetch("Answers", $tabArgs);
            $answer = new Answer();
            $answer->setId($fetch['id']);
            $answer->setMainText($fetch['mainText']);
            $answer->setDatetimestamp($fetch['datetimestamp']);
            $answer->setIdQuestion($fetch['idQuestion']);
            $answer->setIdUser($fetch['idUser']);
            Helper::view("edit_answer",[
                'answer' => $answer,
            ]);
        }
        else
        {
            Helper::view("login");
        }
    }
    // }}}


    // {{{ parseEditForm
    /**
     * parseEditForm() parses the input from the form and updates the answer
     *
     * @return void
     */
    public function parseEditForm()
    {   
        /**
         * Check if the answer field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $failure = "Answer cannot be empty";
            $success = "";
            header("Location: index");
        }
        /**
         * Check length of answer is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $failure = "Answer is too long";
            $success = "";
            header("Location: index");
        }
        else
        {
            /**
             * Edit anwser in database
             */
            $answer = new Answer();
            $answer->setId($_POST['id']);
            $answer->setMainText($_POST['mainText']);
            $answer->setDatetimestamp($_POST['datetimestamp']);
            $answer->setIdQuestion($_POST['idQuestion']);
            $answer->setIdUser($_POST['idUser']);

            $tabArgs = array(
                array('idUser', $answer->getIdUser(), PDO::PARAM_INT),
                array('mainText', $answer->getMainText(), PDO::PARAM_STR),
                array('datetimestamp', $answer->getDatetimestamp(), PDO::PARAM_STR),
                array('idQuestion', $answer->getIdQuestion(), PDO::PARAM_INT),
                array('id', $answer->getId(), PDO::PARAM_INT)
            );
            Model::update("Answers", $tabArgs);

            /**
             * Set success message and return to anwsers page
             */
            $failure = "";
            $success = "Answer edited";
            header("Location: index");
            exit;
        }
    }
    // }}}

    
    // {{{ delete
    /**
     * delete() deletes an answer
     *
     * @return void
     */
    public function delete()
    {
        $tabName = "Answers";
        $tabArgs = array(
            array('id', $_SERVER['QUERY_STRING'], PDO::PARAM_INT),
        );
        Model::delete($tabName, $tabArgs);
        
        $anwser_deleted_success = "Answer deleted";
        header("Location: index");
        exit;
    }
    // }}}

    // {{{ addCommentAnswer
    /**
     * addCommentAnswer() adds a comment to an answer
     *
     * @return void
     */
    public function addCommentAnswer()
    {
        if(isset($_SESSION['username']))
        {
            $comment = new Comment();
            $comment->setIdAnswer($_POST['idAnswer']);
            $comment->setMainText($_POST['mainText']);
            $comment->setDatetimestamp(date("Y-m-d h:i:s"));
            $comment->setIdUser($_POST['idUser']);

            $tabArgs = array(
                array('idAnswer', $comment->getIdAnswer(), PDO::PARAM_INT),
                array('mainText', $comment->getMainText(), PDO::PARAM_STR),
                array('datetimestamp', $comment->getDatetimestamp(), PDO::PARAM_STR),
                array('idUser', $comment->getIdUser(), PDO::PARAM_INT),
            );

            var_dump($tabArgs);
            
            Model::add("Comments", $tabArgs);
            header("Location: index");
        }   
        else
        {
            header("Location: login");
        }
    }
    // }}}
}
// }}}
