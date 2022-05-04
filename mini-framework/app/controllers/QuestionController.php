<?php
session_start();

require 'app/models/Question.php';

class QuestionController
{
    /***************************************************\
    *                   Public methods                  *  
    \***************************************************/

    public function index()
    {
        $questions = $this->fetchAllQuestions();
        $failure = "";
        $success = "";
        return Helper::view("show_questions",[
            'questions' => $questions,
            'success' => $success,
            'failure' => $failure,
        ]);
    }

    public function fetchAllQuestions()
    {
        $tabArgs = array();
        $postArray = Model::fetchAll("Questions", "datetimestamp", "Post");
        if(empty($postArray))
        {
            $questions = [];
        }
        else
        {
            // Transform the array of objects into an array of questions
            foreach($postArray as $post)
            {
                $question = new Question();
                $question->setId($post->getId());
                $question->setMainText($post->getMainText());
                $question->setDatetimestamp($post->getDatetimestamp());
                $question->setIdUser($post->getIdUser());
                $questions[] = $question;
            }
        }
        return $questions;
    }

    public function showAddView()
    {
        /**
         * Check if user is logged in (necessary to add a question)
         */
        if(!isset($_SESSION['username']))
        {
            header("Location: login");
            exit;
        }

        Helper::view("add_question");
    }

    /**
     * Function to add a question to the database
     */
    public function parseInput()
    {
        /**
         * Initialize the error messages
         */
        $failure = "";
        $success = "";

        /**
         * Check if user is logged in (necessary to add a question)
         */
        if(!isset($_SESSION['username']))
        {
            header("Location: login");
            exit;
        }
        
        /**
         * Check if the question field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $failure = "Question cannot be empty";
            $success = "";
            return Helper::view("show_questions",[
                'success' => $success,
                'failure' => $failure,
            ]);
        }
        /**
         * Check length of question is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $failure = "Question is too long";
            $success = "";
            return Helper::view("show_questions",[
                'success' => $success,
                'failure' => $failure,
            ]);
        }
        else
        {
            /**
             * Add question to database
             */
            $question = new Question();
            $question->setMainText($_POST['mainText']);
            $question->setDatetimestamp(date("Y-m-d H:i:s"));
            $question->setIdUser($_SESSION['idUser']);
            $question->addQuestion();

            /**
             * Set success message and return to questions page
             */
            $success = "Added question successfully";
            $questions = $this->fetchAllQuestions();
            return Helper::view("show_questions",[
                'success' => $success,
                'failure' => $failure,
                'questions' => $questions,
            ]);
        }
    }

    public function userQuestions()
    {
        $tabArgs = array(
            array('idUser', $_SESSION['idUser'], PDO::PARAM_INT),

        );
        $postArray = Model::fetchAllWhere("Questions", $tabArgs,"datetimestamp", "Post");
        if(empty($postArray))
        {
            $questions = [];
        }
        else
        {
            // Transform the array of objects into an array of questions
            foreach($postArray as $post)
            {
                $question = new Question();
                $question->setId($post->getId());
                $question->setMainText($post->getMainText());
                $question->setDatetimestamp($post->getDatetimestamp());
                $question->setIdUser($post->getIdUser());
                $questions[] = $question;
            }
        }
        return Helper::view("user_questions",[
            'questions' => $questions,
        ]);
    }

    public function edit()
    {
        /**
         * Redirect to edit page
         */
        if(isset($_SESSION['username']))
        {
            $questionId = $_SERVER['QUERY_STRING'];
            $idUser = $_SESSION['idUser'];
            $tabArgs = array(
                array('id', $questionId, PDO::PARAM_INT),
                array('idUser', $idUser, PDO::PARAM_INT),
            );
            $fetch = Model::fetch("Questions", $tabArgs);
            $question = new Question();
            $question->setId($fetch['id']);
            $question->setMainText($fetch['mainText']);
            $question->setDatetimestamp($fetch['datetimestamp']);
            $question->setIdUser($fetch['idUser']);
            Helper::view("edit_question",[
                'question' => $question,
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
         * Initialize the error messages
         */
        $failure = "";
        $success = "";

        /**
         * Check if the question field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $failure = "Question cannot be empty";
            $success = "";
            return Helper::view("show_questions",[
                'success' => $success,
                'failure' => $failure,
            ]);
            echo "Question empty";
        }
        /**
         * Check length of question is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $failure = "Question is too long";
            $success = "";
            return Helper::view("show_questions",[
                'success' => $success,
                'failure' => $failure,
            ]);
        }
        else
        {
            /**
             * Edit question in database
             */
            $question = new Question();
            $question->setId($_POST['id']);
            $question->setMainText($_POST['mainText']);
            $question->setDatetimestamp($_POST['datetimestamp']);
            $question->setIdUser($_POST['idUser']);

            $tabArgs = array(
                array('idUser', $question->getIdUser(), PDO::PARAM_INT),
                array('mainText', $question->getMainText(), PDO::PARAM_STR),
                array('datetimestamp', $question->getDatetimestamp(), PDO::PARAM_STR),
                array('id', $question->getId(), PDO::PARAM_INT),
            );

            Model::update("Questions", $tabArgs);

            /**
             * Set success message and return to questions page
             */
            $success = "Question edited";
            $failure = "";
            $questions = $this->fetchAllQuestions();
            return Helper::view("show_questions",[
                'success' => $success,
                'failure' => $failure,
            ]);
        }
    }

    /**
     * Delete question
     */
    public function delete()
    {
        /**
         * Initialize the error messages
         */
        $failure = "";
        $success = "";

        $tabName = "Questions";
        $tabArgs = array(
            array('id', $_SERVER['QUERY_STRING'], PDO::PARAM_INT),
        );
        Model::delete($tabName, $tabArgs);
        $success = "Question Deleted";
        $failure = "";
        $questions = $this->fetchAllQuestions();
        return Helper::view("show_questions",[
            'success' => $success,
            'failure' => $failure,
            'questions' => $questions,
        ]);
        
    }
}