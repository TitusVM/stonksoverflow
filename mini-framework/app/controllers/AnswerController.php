<?php
session_start();

require 'app/models/Answer.php';

if (!class_exists('Comment')) {
    require 'app/models/Comment.php';
}

class AnswerController
{
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

    /**
     * Function to add an anwser to the database
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
            /**
             * TODO fix redirect
             * Redirect to anwsers page with anwsers array
             */
            $this->index();
            /*return Helper::view("show_anwsers",[
                'anwser_added_success' => $anwser_added_success,
                'anwser_added_failure' => $anwser_added_failure,
            ]);*/
        }
    }

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
            $fetch = Model::fetch("anwsers", $tabArgs);
            $anwser = new Answer();
            $anwser->setId($fetch['id']);
            $anwser->setMainText($fetch['mainText']);
            $anwser->setDatetimestamp($fetch['datetimestamp']);
            $answer->setIdQuestion($fetch['idQuestion']);
            $anwser->setIdUser($fetch['idUser']);
            Helper::view("edit_anwser",[
                'anwser' => $anwser,
            ]);
        }
        else
        {
            Helper::view("login");
        }
    }

    /**
     * Function to parse edit form input
     */
    public function parseEditForm()
    {   
        /**
         * Check if the anwser field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $anwser_edited_failure = "Answer cannot be empty";
            $anwser_edited_success = "";
            return Helper::view("show_anwsers",[
                'anwser_edited_success' => $anwser_edited_success,
                'anwser_edited_failure' => $anwser_edited_failure,
            ]);
            echo "Answer empty";
        }
        /**
         * Check length of anwser is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $anwser_edited_failure = "Answer is too long";
            $anwser_edited_success = "";
            return Helper::view("show_anwsers",[
                'anwser_edited_success' => $anwser_edited_success,
                'anwser_edited_failure' => $anwser_edited_failure,
            ]);
            echo "Answer too long";
        }
        else
        {
            /**
             * Edit anwser in database
             */
            $anwser = new Answer();
            $anwser->setId($_POST['id']);
            $anwser->setMainText($_POST['mainText']);
            $anwser->setDatetimestamp($_POST['datetimestamp']);
            $answer->setIdQuestion($_POST['idQuestion']);
            $anwser->setIdUser($_POST['idUser']);

            $tabArgs = array(
                array('idUser', $anwser->getIdUser(), PDO::PARAM_INT),
                array('mainText', $anwser->getMainText(), PDO::PARAM_STR),
                array('datetimestamp', $anwser->getDatetimestamp(), PDO::PARAM_STR),
                array('idQuestion', $answer->getIdQuestion(), PDO::PARAM_INT),
                array('id', $anwser->getId(), PDO::PARAM_INT)
            );

            Model::update("Answers", $tabArgs);

            /**
             * Set success message and return to anwsers page
             */
            $anwser_edited_success = "Answer edited";
            /**
             * TODO fix redirect
             * Redirect to anwsers page with anwsers array
             */
            $this->index();
            /*return Helper::view("show_anwsers",[
                'anwser_edited_success' => $anwser_edited_success,
                'anwser_edited_failure' => $anwser_edited_failure,
            ]);*/
        }
    }

    /**
     * Delete anwser
     */
    public function delete()
    {
        $tabName = "Answers";
        $tabArgs = array(
            array('id', $_SERVER['QUERY_STRING'], PDO::PARAM_INT),
        );
        Model::delete($tabName, $tabArgs);
        
        $anwser_deleted_success = "Answer deleted";
        /**
         * TODO fix redirect
         * Redirect to anwsers page with anwsers array
         */
        $this->index();
        /*return Helper::view("show_anwsers",[
            'anwser_edited_success' => $anwser_edited_success,
            'anwser_edited_failure' => $anwser_edited_failure,
        ]);*/
        
    }

    /**
     * Add a comment to an answer
     */
    public function addCommentAnswer()
    {
        if(isset($_SESSION['username']))
        {
            echo "here";
            var_dump($_POST);
            $comment = new Comment();
            $comment->setIdAnswer($_POST['idAnswer']);
            $comment->setIdQuestion($_POST['idQuestion']);
            $comment->setMainText($_POST['mainText']);
            $comment->setDatetimestamp(date("Y-m-d h:i:s"));
            $comment->setIdUser($_POST['idUser']);

            $tabArgs = array(
                array('idQuestion', $comment->getIdQuestion(), PDO::PARAM_INT),
                array('mainText', $comment->getMainText(), PDO::PARAM_STR),
                array('datetimestamp', $comment->getDatetimestamp(), PDO::PARAM_STR),
                array('idUser', $comment->getIdUser(), PDO::PARAM_INT),
            );
            
            Model::add("Comments", $tabArgs);
            Helper::view("mainscreen");
        }   
        else
        {
            Helper::view("login");
        }
    }
}