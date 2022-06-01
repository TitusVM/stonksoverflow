<?php
session_start();

require 'app/models/Comment.php';

class CommentController
{
    public function index()
    {
        $tabArgs = array();
        $comments = Model::fetchAll("Comments", "datetimestamp", "Comment");
        
        $comment_added_failure = "";
        $comment_added_success = "";
        return Helper::view("show_comments",[
            'comments' => $comments,
            'comment_added_success' => $comment_added_success,
            'comment_added_failure' => $comment_added_failure,
        ]);
    }

    public function showAddView()
    {
        /**
         * Check if user is logged in (necessary to add an comment)
         */
        if(!isset($_SESSION['username']))
        {
            header("Location: login");
            exit;
        }

        Helper::view("add_comment");
    }

    /**
     * Function to add an comment to the database
     */
    public function parseInput()
    {
        /**
         * Check if user is logged in (necessary to add an comment)
         */
        if(!isset($_SESSION['username']))
        {
            header("Location: login");
            exit;
        }
        
        /**
         * Check if the comment field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $comment_added_failure = "Comment cannot be empty";
            $comment_added_success = "";
            return Helper::view("show_comments",[
                'comment_added_success' => $comment_added_success,
                'comment_added_failure' => $comment_added_failure,
            ]);
        }
        /**
         * Check if length of comment is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $comment_added_failure = "comment is too long";
            $comment_added_success = "";
            return Helper::view("show_comments",[
                'comment_added_success' => $comment_added_success,
                'comment_added_failure' => $comment_added_failure,
            ]);
        }
        else
        {
            /**
             * Add comment to database
             */
            $comment = new Comment();
            $comment->setMainText($_POST['mainText']);
            $comment->setDatetimestamp(date("Y-m-d H:i:s"));
            $comment->setIdUser($_SESSION['idUser']);
            $comment->setIdQuestion($_POST['idQuestion']);
            $comment->setIdAnswer($_POST['idAnswer']);
            $comment->addAnswer();

            /**
             * Set success message and return to comments page
             */
            $comment_added_success = "Comment added";
            /**
             * TODO fix redirect
             * Redirect to comments page with comments array
             */
            $this->index();
            /*return Helper::view("show_comments",[
                'comment_added_success' => $comment_added_success,
                'comment_added_failure' => $comment_added_failure,
            ]);*/
        }
    }

    public function userComments()
    {
        $tabArgs = array(
            array('idUser', $_SESSION['idUser'], PDO::PARAM_INT),

        );
        $comments = Model::fetchAllWhere("Comments", $tabArgs, "datetimestamp", "Comment");
        
        return Helper::view("user_comments",[
            'comments' => $comments,
        ]);
    }

    public function edit()
    {
        /**
         * Redirect to edit page
         */
        if(isset($_SESSION['username']))
        {
            $commentId = $_SERVER['QUERY_STRING'];
            $idUser = $_SESSION['idUser'];
            $tabArgs = array(
                array('id', $commentId, PDO::PARAM_INT),
                array('idUser', $idUser, PDO::PARAM_INT),
            );
            $fetch = Model::fetch("comments", $tabArgs);
            $comment = new Comment();
            $comment->setId($fetch['id']);
            $comment->setMainText($fetch['mainText']);
            $comment->setDatetimestamp($fetch['datetimestamp']);
            $comment->setIdQuestion($fetch['idQuestion']);
            $comment->setIdAnswer($fetch['idAnswer']);
            $comment->setIdUser($fetch['idUser']);
            Helper::view("edit_comment",[
                'comment' => $comment,
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
         * Check if the comment field has been filled out
         */
        if(!isset($_POST['mainText']) || $_POST['mainText'] == "")
        {
            $comment_edited_failure = "Comment cannot be empty";
            $comment_edited_success = "";
            return Helper::view("show_comments",[
                'comment_edited_success' => $comment_edited_success,
                'comment_edited_failure' => $comment_edited_failure,
            ]);
            echo "Comment empty";
        }
        /**
         * Check length of comment is not too long
         */
        else if(strlen($_POST['mainText']) > 255)
        {
            $comment_edited_failure = "Comment is too long";
            $comment_edited_success = "";
            return Helper::view("show_comments",[
                'comment_edited_success' => $comment_edited_success,
                'comment_edited_failure' => $comment_edited_failure,
            ]);
            echo "Comment too long";
        }
        else
        {
            /**
             * Edit comment in database
             */
            $comment = new Comment();
            $comment->setId($_POST['id']);
            $comment->setMainText($_POST['mainText']);
            $comment->setDatetimestamp($_POST['datetimestamp']);
            $comment->setIdQuestion($_POST['idQuestion']);
            $comment->setIdAnswer($_POST['idAnswer']);
            $comment->setIdUser($_POST['idUser']);

            $tabArgs = array(
                array('idUser', $comment->getIdUser(), PDO::PARAM_INT),
                array('mainText', $comment->getMainText(), PDO::PARAM_STR),
                array('datetimestamp', $comment->getDatetimestamp(), PDO::PARAM_STR),
                array('idQuestion', $comment->getIdQuestion(), PDO::PARAM_INT),
                array('idAnswer', $comment->getIdAnswer(), PDO::PARAM_INT),
                array('id', $comment->getId(), PDO::PARAM_INT)
            );

            Model::update("Comments", $tabArgs);

            /**
             * Set success message and return to comments page
             */
            $comment_edited_success = "Comment edited";
            /**
             * TODO fix redirect
             * Redirect to comments page with comments array
             */
            $this->index();
            /*return Helper::view("show_comments",[
                'comment_edited_success' => $comment_edited_success,
                'comment_edited_failure' => $comment_edited_failure,
            ]);*/
        }
    }

    /**
     * Delete comment
     */
    public function delete()
    {
        $tabName = "Comments";
        $tabArgs = array(
            array('id', $_SERVER['QUERY_STRING'], PDO::PARAM_INT),
        );
        Model::delete($tabName, $tabArgs);
        
        $comment_deleted_success = "Comment deleted";
        /**
         * TODO fix redirect
         * Redirect to comments page with comments array
         */
        $this->index();
        /*return Helper::view("show_comments",[
            'comment_edited_success' => $comment_edited_success,
            'comment_edited_failure' => $comment_edited_failure,
        ]);*/
        
    }
}