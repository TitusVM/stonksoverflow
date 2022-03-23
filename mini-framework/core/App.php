<?php

/**
 *
 */
class App
{
  private static $app = [];

  public static function get($c)
  {
    return self::$app[$c];
  }

  public static function set($k, $v)
  { 
     self::$app[$k] = $v;
  }

  public static function load_config($fileName)
  {
     self::$app['config'] = require($fileName);
  }
}
