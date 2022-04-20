<?php
session_start();

require 'app/models/Question.php';

class QuestionController
{
    public function index()
    {
        $tabArgs = array();
        $postArray = Model::fetchAll("Questions", "datetimestamp", "Post");

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

        $question_added_failure = "";
        $question_added_success = "";
        return Helper::view("show_questions",[
            'questions' => $questions,
            'question_added_success' => $question_added_success,
            'question_added_failure' => $question_added_failure,
        ]);
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
            $question_added_failure = "Question cannot be empty";
            $question_added_success = "";
            return Helper::view("show_questions",[
                'question_added_success' => $question_added_success,
                'question_added_failure' => $question_added_failure,
            ]);
        }
        /**
         * Check length of question is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $question_added_failure = "Question is too long";
            $question_added_success = "";
            return Helper::view("show_questions",[
                'question_added_success' => $question_added_success,
                'question_added_failure' => $question_added_failure,
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
            $question_added_success = "Question added";
            // TODO fix redirect
            $this->index();
            /*return Helper::view("show_questions",[
                'question_added_success' => $question_added_success,
                'question_added_failure' => $question_added_failure,
            ]);*/
        }
    }
}