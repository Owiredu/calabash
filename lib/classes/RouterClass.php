<?php
// declare namespace
namespace Lib\Class;

// require modules
include_once(__DIR__ . '/../interfaces/RequestInterface.php');

// use namespaces
use Lib\Interface\Request as RequestInterface;

/**
 * Router class
 */
class Router
{

    private $request;
    private $supportedHttpMethods = array(
        "GET",
        "POST",
    );

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function __call($name, $args)
    {
        list($route, $method) = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param route (string)
     */
    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
    }

    /**
     * Resolves a route
     */
    public function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);
        $method = $methodDictionary[$formatedRoute];

        if (is_null($method)) {
            $this->defaultRequestHandler();
            return;
        }

        echo call_user_func_array($method, array($this->request));
    }

    public function __destruct()
    {
        $this->resolve();
    }

}
