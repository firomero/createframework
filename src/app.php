<?php
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

function is_leap_year($year = null) {
    if (null === $year) {
        $year = date('Y');
    }

    return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
}

class LeapYearController
{
    /**
     * @param $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('¡Sí, es bisiesto!');
        }
 
        return new Response('No no lo es.');
    }
}

$routes = new Routing\RouteCollection();
$routes->add('es_bisiesto', new Routing\Route('/es_bisiesto/{year}', array(
    'year' => null,
    '_controller' => 'LeapYearController::indexAction',
)));
 
return $routes;
