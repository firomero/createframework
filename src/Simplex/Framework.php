<?php

namespace Simplex;
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\EventDispatcher\EventDispatcher;
 
class Framework implements HttpKernelInterface
{
    protected $matcher;
    protected $resolver;
 
    public function __construct(EventDispatcher $dispatcher,UrlMatcher $matcher, ControllerResolver $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @return mixed|Response
     */
    public function handle(Request $request,$type = self::MASTER_REQUEST, $catch = true)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
 
            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            $response = call_user_func_array($controller, $arguments);

        } catch (ResourceNotFoundException $e) {
            return new Response('Not Found', 404);
        } catch (\Exception $e) {
            return new Response('An error occurred', 500);
        }
        // dispatch a response event
        $this->dispatcher->dispatch('response', new ResponseEvent($response, $request));

        return $response;
    }
}
