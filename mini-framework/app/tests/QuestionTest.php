<?php

require '../../core/database/Model.php';
require '../models/Post.php';
require '../models/Comment.php';
require '../models/Answer.php';
require '../models/Question.php';

use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    public function testIsReadyForDatabase()
    {
        //simulate creation of question
        $question = new Question();
        $question->setTitle("test title");
        $question->setMainText("test maintest");
        $question->setDatetimestamp(date("Y-m-d H:i:s"));
        $question->setIdUser(1);

        //simulate add question
        $this->assertNotEquals($question->getTitle(), "");
        $this->assertNotEquals($question->getMainText(), "");
        $this->assertNotEquals($question->getDatetimestamp(), "");
        $this->assertNotEquals($question->getIdUser(), "");

        //question is ready for database
    }

    public function testHasAnswersAttached()
    {
        //simulate creation of question
        $question = new Question();
        $question->setTitle("test title");
        $question->setMainText("test maintest");
        $question->setDatetimestamp(date("Y-m-d H:i:s"));
        $question->setIdUser(1);
        $question->setAnswerList("test answer");

        $this->assertEquals(empty($question->getAnswerList()), false);
    }

    public function testHasCommentsAttached()
    {
        //simulate creation of question
        $question = new Question();
        $question->setTitle("test title");
        $question->setMainText("test maintest");
        $question->setDatetimestamp(date("Y-m-d H:i:s"));
        $question->setIdUser(1);
        $question->setCommentList("test answer");

        $this->assertEquals(empty($question->getCommentList()), false);
    }
}