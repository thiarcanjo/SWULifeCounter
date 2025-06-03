<?php
/**
*
*/
require_once __DIR__.'/../cors_headers.php';

spl_autoload_register(function ($class)
{
  $class = str_replace('\\','/',$class);
  $file = dirname(__FILE__).'/../'. $class. '.php';

   if(file_exists($file))
   {
      include $file;
   }
   else exit('FILE NOT FOUND! FILE: '. $file);
});

?>
