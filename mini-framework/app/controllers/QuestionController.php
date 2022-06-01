<?php
session_start();

require 'app/models/Question.php';

class QuestionController
{
    public function index()
    {
        $questionArray = Model::fetchAll("Questions", "datetimestamp", "Post");
        
        /**
         * TODO make this better
         */
        if(empty($questionArray))
        {
            $question = new Question();
            $question->setMainText("No questions yet");
            $question->setDatetimestamp(date("Y-m-d H:i:s"));
            $question->setIdUser($_SESSION['idUser']);
            $questions[] = $question;
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
            foreach($questions as $question)
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
            }
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
            /**
             * TODO fix redirect
             * Redirect to questions page with questions array
             */
            $this->index();
            /*return Helper::view("show_questions",[
                'question_added_success' => $question_added_success,
                'question_added_failure' => $question_added_failure,
            ]);*/
        }
    }

    public function userQuestions()
    {
        $tabArgs = array(
            array('idUser', $_SESSION['idUser'], PDO::PARAM_INT),

        );
        $questionArray = Model::fetchAllWhere("Questions", $tabArgs,"datetimestamp", "Post");
        
        /**
         * TODO make this better
         */
        // if questionArray is empty add a placeholder question
        if(empty($questionArray))
        {
            $question = new Question();
            $question->setMainText("No questions yet");
            $question->setDatetimestamp(date("Y-m-d H:i:s"));
            $question->setIdUser($_SESSION['idUser']);
            $questions[] = $question;
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
         * Check if the question field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $question_edited_failure = "Question cannot be empty";
            $question_edited_success = "";
            return Helper::view("show_questions",[
                'question_edited_success' => $question_edited_success,
                'question_edited_failure' => $question_edited_failure,
            ]);
            echo "Question empty";
        }
        /**
         * Check length of question is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $question_edited_failure = "Question is too long";
            $question_edited_success = "";
            return Helper::view("show_questions",[
                'question_edited_success' => $question_edited_success,
                'question_edited_failure' => $question_edited_failure,
            ]);
            echo "Question too long";
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
            /*return Helper::view("show_questions",[
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
        /*return Helper::view("show_questions",[
            'question_edited_success' => $question_edited_success,
            'question_edited_failure' => $question_edited_failure,
        ]);*/
        
    }
}