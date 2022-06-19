<?php

return [
  'database' => [
    'dbname' => 'appWebIIStonksOverflow',
    'username' => 'root',
    'password' => '', //'vz160' on Gandalf //'' (empty) in easyPHP
    'connection' => 'mysql:host=127.0.0.1',
    'port' => ' 3306', // '8889' default port in MAMP //  '3306' in easyPHP
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
      PDO::ATTR_PERSISTENT => true
    ]
  ],
  // if your app is not in the server's /, decomment and adapt
  // (then you MUST use relative URLs everywhere)
  'install_prefix' => 'edsa-appweb/mini-framework', // 'php' on Gandalf
];
