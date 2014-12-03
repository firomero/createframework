<?php
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$routes = new Routing\RouteCollection();
$routes->add('es_bisiesto', new Routing\Route('/es_bisiesto/{year}', array(
    'year' => null,
    '_controller' =>  'Calendar\\Controller\\LeapYearController::indexAction',
)));
 
return $routes;
