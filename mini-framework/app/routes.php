<?php

$router->define([
  // '' => 'controllers/index.php',  // by conventions all controllers are in 'controllers' folder
  '' => 'QuestionController',
  'index' => 'QuestionController',
  'login' => 'LoginController',
  'login_logout' => 'LoginController@loginLogout',
  'new_account' => 'LoginController@newAccount',
  'add_account' => 'LoginController@addAccount',
  'loginSubmit' => 'LoginController@parseInput',
  'mainscreen' => 'QuestionController',
  'add_question' => 'QuestionController@showAddView',
  'add_answer' => 'QuestionController@addAnswer',
  'add_comment' => 'QuestionController@addComment',
  'add_comment_answer' => 'AnswerController@addCommentAnswer',
  'parse_add_form' => 'QuestionController@parseInput',
  'user_questions' => 'QuestionController@userPosts',
  'edit' => 'QuestionController@edit',
  'parse_edit_form' => 'QuestionController@parseEditForm',
  'delete' => 'QuestionController@delete',
  'logout' => 'LoginController@logout',
  'question' => 'QuestionController@showQuestion'
]);
