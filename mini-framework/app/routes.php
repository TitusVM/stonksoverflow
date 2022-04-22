<?php

$router->define([
  // '' => 'controllers/index.php',  // by conventions all controllers are in 'controllers' folder
  '' => 'IndexController',
  'index' => 'IndexController',
  'login' => 'LoginController',
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
  'about' => 'AboutController',
  'mainscreen' => 'MainScreenController'
]);
