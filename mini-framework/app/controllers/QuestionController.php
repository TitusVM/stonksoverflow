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
}