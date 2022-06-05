<?php

$router->define([
  // '' => 'controllers/index.php',  // by conventions all controllers are in 'controllers' folder
  '' => 'MainScreenController',
  'index' => 'MainScreenController',
  'mainscreen' => 'MainScreenController',
  'login' => 'LoginController',
  'login_logout' => 'LoginController@loginLogout',
  'new_account' => 'LoginController@newAccount',
  'add_account' => 'LoginController@addAccount',
  'loginSubmit' => 'LoginController@parseInput',
  'show_questions' => 'QuestionController',
  'add_question' => 'QuestionController@showAddView',
  'parse_add_form' => 'QuestionController@parseInput',
  'user_questions' => 'QuestionController@userQuestions',
  'edit' => 'QuestionController@edit',
  'parse_edit_form' => 'QuestionController@parseEditForm',
  'delete' => 'QuestionController@delete',
  'logout' => 'LoginController@logout',
  'question' => 'QuestionController@showQuestion'
]);
