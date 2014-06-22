<?php
require_once __DIR__.'/vendor/symfony/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
use Symfony\Component\ClassLoader\UniversalClassLoader;
$loader = new UniversalClassLoader();
$loader->register();
if (isset($_GET['name']))
{
  $input = $_GET['name'];
 
printf('Hello %s', $_GET['name']);
	
}




