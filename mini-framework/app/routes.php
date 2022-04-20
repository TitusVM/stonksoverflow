<?php

$router->define([
  // '' => 'controllers/index.php',  // by conventions all controllers are in 'controllers' folder
  '' => 'IndexController',
  'index' => 'IndexController',
  'login' => 'LoginController',
  'loginSubmit' => 'LoginController@parseInput',
  'show_questions' => 'QuestionController',
  'about' => 'AboutController',
  'mainscreen' => 'MainScreenController'
]);
