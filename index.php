<?php

// Autoloader
function autoloader(string $class): void
{
  if (preg_match('/Controller$/', $class))
    require("./app/Controller/" . $class . ".php");
  else
    require("./app/Model/" . $class . ".php");
}
spl_autoload_register('autoloader');

// Database connection
$Db = new Db;
Db::connect("127.0.0.1", "cms_db", "root", "");

echo 'Simple website CMS';

?>
