<?php
// declare namespace
namespace Lib\Core\Class;

// require modules
require_once(__DIR__ . '/RequestInterface.php');
require_once(__DIR__ . '/ResponseClass.php');

// use namespaces
use Lib\Core\Interface\Request as RequestInterface;
use Lib\Core\Class\Response as HTTPResponse;

/**
 * Router class
 */
class Router
{

    /**
     * Request object
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * Response object
     * @var HTTPResponse
     */
    private HTTPResponse $response;

    /**
     * Supported HTTP methods
     * @var array
     */
    private $supported_http_methods = array(
        "GET",
        "POST",
    );

    public function __construct(RequestInterface $request, HTTPResponse $response)
    {
        // initialize the request and response objects
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * This method is invoked automatically when a non-existing method or inaccessible method is called.
     * @param string $name The name of the method that is called on this class' instance
     * @param array $args An array of arguments passed to the method call
     */
    public function __call($name, $args)
    {
        // get the route and the method that handles it from the arguments array
        list($route, $method) = $args;

        // set the method (together with its associated route) as a property of the instance of this class.
        // this is stored as a dictionary where the dictionary name is the request method (get, post, etc).
        // the index is the route string and the value is the callback function that handles that route.
        // format: $this-> <method_name(get, post, etc)> [<route>] = <callback>
        // eg. $this->get['/'] = function(...) {}
        // eg. $this->get['/user'] = function(...) {}
        $this->{strtolower($name)}[$this->format_route($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param string $route The route to be formatted
     * @return string The formatted route
     */
    private function format_route($route): string
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    /**
     * Handle an invalid method call
     */
    private function invalid_method_handler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
        $this->response->render(
            'error.html', 
            ['message' => "Method Not Allowed", 'status' => 405]
        );
    }

    /**
     * Handle routes that cannot be found
     */
    private function default_request_handler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
        $this->response->render(
            'error.html', 
            ['message' => 'Not Found', 'status' => 404]
        );
    }

    /**
     * Resolves a route
     */
    public function resolve()
    {
        // get the request method (get, post, etc) dictionary
        $method_dictionary = $this->{strtolower($this->request->requestMethod)};

        // check if the request method is in the list of supported methods
        // if not in the list of supported methods, call the invalid method handler
        if (!in_array(strtoupper($this->request->requestMethod), $this->supported_http_methods)) {
            $this->invalid_method_handler();
            return;
        }

        // format the request URI and use the resulting value as the route
        $formatted_route = $this->format_route($this->request->requestUri);
        
        // get the method associated with that route
        $method = $method_dictionary[$formatted_route];

        // if no method is associated with the route, send a not found response
        if (is_null($method)) {
            $this->default_request_handler();
            return;
        }

        // if a method is found for the route, call the associated callback function,
        // passing in the request and response objects as arguments
        call_user_func_array($method, array($this->request, $this->response));
    }

    public function __destruct()
    {
        $this->resolve();
    }

}
