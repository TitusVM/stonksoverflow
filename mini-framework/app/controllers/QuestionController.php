<?php
session_start();

require 'app/models/Question.php';

if (!class_exists('Answer')) {
    require 'app/models/Answer.php';
}

class QuestionController
{
    /***************************************************\
    *                   Public methods                  *  
    \***************************************************/

    public function index()
    {
        $questions = $this->fetchAllQuestions();
    }

    public function fetchAllQuestions()
    {
        $tabArgs = array();
        $postArray = Model::fetchAll("Questions", "datetimestamp", "Post");
        $questions = [];
        
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
                $question->setTitle($post->getTitle());
                $question->setMainText($post->getMainText());
                $question->setDatetimestamp($post->getDatetimestamp());
                $question->setIdUser($post->getIdUser());
                $questions[] = $question;
            }
            foreach($questions as $question)
            {
                $question = $this->getAnswersComments($question);
                $questionsWithPosts[] = $question;
            }
            $questions = $questionsWithPosts;
        }
        $question_added_failure = "";
        $question_added_success = "";
        return Helper::view("mainscreen",[
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
         * Check if the title and the main text are set
         */
        if(!isset($_POST['title']))
        {
            $question_added_failure = "Title is missing";
            $question_added_success = "";
            return Helper::view("mainscreen",[
                'question_added_success' => $question_added_success,
                'question_added_failure' => $question_added_failure,
            ]);
        }

        
        /**
         * Check if the question field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $question_added_failure = "Question cannot be empty";
            $question_added_success = "";
            return Helper::view("mainscreen",[
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
            return Helper::view("mainscreen",[
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
            $question->setTitle($_POST['title']);
            $question->setMainText($_POST['mainText']);
            $question->setDatetimestamp(date("Y-m-d H:i:s"));
            $question->setIdUser($_SESSION['idUser']);
            $question->addQuestion();

            /**
             * Set success message and return to questions page
             */
            $question_added_success = "Question added";
            /**
             * TODO fix redirect
             * Redirect to questions page with questions array
             */
            $this->index();
            /*return Helper::view("mainscreen",[
                'question_added_success' => $question_added_success,
                'question_added_failure' => $question_added_failure,
            ]);*/
        }
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
            $question_edited_failure = "Question cannot be empty";
            $question_edited_success = "";
            return Helper::view("mainscreen",[
                'question_edited_success' => $question_edited_success,
                'question_edited_failure' => $question_edited_failure,
            ]);
        }
        /**
         * Check length of question is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $question_edited_failure = "Question is too long";
            $question_edited_success = "";
            return Helper::view("mainscreen",[
                'question_edited_success' => $question_edited_success,
                'question_edited_failure' => $question_edited_failure,
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
            $question_edited_success = "Question edited";
            /**
             * TODO fix redirect
             * Redirect to questions page with questions array
             */
            $this->index();
            /*return Helper::view("mainscreen",[
                'question_edited_success' => $question_edited_success,
                'question_edited_failure' => $question_edited_failure,
            ]);*/
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
        
        $question_deleted_success = "Question deleted";
        /**
         * TODO fix redirect
         * Redirect to questions page with questions array
         */
        $this->index();
        /*return Helper::view("mainscreen",[
            'question_edited_success' => $question_edited_success,
            'question_edited_failure' => $question_edited_failure,
        ]);*/
    }

    /**
     * Show a single question from QUERY_STRING
     */
    public function showQuestion()
    {
        $questionId = $_SERVER['QUERY_STRING'];
        $tabArgs = array(
            array('id', $questionId, PDO::PARAM_INT),
        );
        $fetch = Model::fetch("Questions", $tabArgs);
        $question = new Question();
        $question->setId($fetch['id']);
        $question->setTitle($fetch['title']);
        $question->setMainText($fetch['mainText']);
        $question->setDatetimestamp($fetch['datetimestamp']);
        $question->setIdUser($fetch['idUser']);
        $question = $this->getAnswersComments($question);
        return Helper::view("show_question",[
            'question' => $question,
        ]);
    }

    public function getAnswersComments($question)
    {
        $answerArray = [];
        $commentArray = [];
        $tabArgs = array(
            array("idQuestion", $question->getId(), PDO::PARAM_INT)
        );
        $answerArray = Model::fetchAllWhere("Answers", $tabArgs, "datetimestamp", "Post");
        $commentArray = Model::fetchAllWhere("Comments", $tabArgs, "datetimestamp", "Post");
        

        // Test if answerArray is empty
        if(!empty($answerArray))
        {
            $answersCommentArray = [];
            $answers = [];
            foreach($answerArray as $post)
            {
                $answer = new Answer();
                $answer->setId($post->getId());
                $answer->setIdQuestion($post->getIdQuestion());
                $answer->setMainText($post->getMainText());
                $answer->setDatetimestamp($post->getDatetimestamp());
                $answer->setIdUser($post->getIdUser());
                $tabArgs = array(
                    array("idAnswer", $answer->getId(), PDO::PARAM_INT)
                );
                $answersCommentArray = Model::fetchAllWhere("Comments", $tabArgs, "datetimestamp", "Post");
                // Transform the array of objects into an array of Comments
                $answerComments = [];
                foreach($answersCommentArray as $post)
                {
                    $comment = new Comment();
                    $comment->setId($post->getId());
                    $comment->setMainText($post->getMainText());
                    $comment->setDatetimestamp($post->getDatetimestamp());
                    $comment->setIdUser($post->getIdUser());
                    $answerComments[] = $comment;
                }
                $answer->setCommentList($answerComments);
                $answers[] = $answer;
            }
            $question->setAnswerList($answers);
        }
        
        // Test if commentArray is empty
        if(!empty($commentArray))
        {
            $questionComments = [];
            foreach($commentArray as $post)
            {
                $comment = new Comment();
                $comment->setId($post->getId());
                $comment->setMainText($post->getMainText());
                $comment->setDatetimestamp($post->getDatetimestamp());
                $comment->setIdUser($post->getIdUser());
                $questionComments[] = $comment;
            }
            $question->setCommentList($questionComments);
        }
        return $question;
    }

    /**
     * Add a comment to a question
     */
    public function addComment()
    {
        if(isset($_SESSION['username']))
        {

            $comment = new Comment();
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
            $this->index();
        }
        else
        {
            Helper::view("login");
        }

    }

    /**
     * Add an answer to a question
     */
    public function addAnswer()
    {
        if(isset($_SESSION['username']))
        {

            $answer = new Answer();
            $answer->setIdQuestion($_POST['idQuestion']);
            $answer->setMainText($_POST['mainText']);
            $answer->setDatetimestamp(date("Y-m-d h:i:s"));
            $answer->setIdUser($_POST['idUser']);
    
            $tabArgs = array(
                array('idQuestion', $answer->getIdQuestion(), PDO::PARAM_INT),
                array('mainText', $answer->getMainText(), PDO::PARAM_STR),
                array('datetimestamp', $answer->getDatetimestamp(), PDO::PARAM_STR),
                array('idUser', $answer->getIdUser(), PDO::PARAM_INT),
            );
    
            Model::add("Answers", $tabArgs);
            $this->index();
        }
        else
        {
            Helper::view("login");
        }
    }

    

    public function userPosts()
    {
        $tabArgs = array(
            array('idUser', $_SESSION['idUser'], PDO::PARAM_INT),

        );
        $questionArray = Model::fetchAllWhere("Questions", $tabArgs,"datetimestamp", "Post");
        $answerArray = Model::fetchAllWhere("Answers", $tabArgs,"datetimestamp", "Post");
        $commentArray = Model::fetchAllWhere("Comments", $tabArgs,"datetimestamp", "Post");

        if(empty($questionArray))
        {
            $questions = [];
        }
        else
        {
            // Transform the array of objects into an array of questions
            foreach($questionArray as $post)
            {
                $question = new Question();
                $question->setId($post->getId());
                $question->setMainText($post->getMainText());
                $question->setDatetimestamp($post->getDatetimestamp());
                $question->setIdUser($post->getIdUser());
                $questions[] = $question;
            }
        }
        /**
         * Answers
         */
        if(empty($answerArray))
        {
            $answers = [];
        }
        else
        {
            // Transform the array of objects into an array of answers
            foreach($answerArray as $post)
            {
                $answer = new Answer();
                $answer->setId($post->getId());
                $answer->setMainText($post->getMainText());
                $answer->setDatetimestamp($post->getDatetimestamp());
                $answer->setIdUser($post->getIdUser());
                $answer->setIdQuestion($post->getIdQuestion());
                $answers[] = $answer;
            }
        }
        /**
         * Comments
         */
        if(empty($commentArray))
        {
            $comments = [];
        }
        else
        {
            // Transform the array of objects into an array of comments
            foreach($commentArray as $post)
            {
                $comment = new Comment();
                $comment->setId($post->getId());
                $comment->setMainText($post->getMainText());
                $comment->setDatetimestamp($post->getDatetimestamp());
                $comment->setIdUser($post->getIdUser());
                $comment->setIdQuestion($post->getIdQuestion());
                $comments[] = $comment;
            }
        }

        return Helper::view("user_questions",[
            'questions' => $questions,
            'answers' => $answers,
            'comments' => $comments
        ]);
    }
}