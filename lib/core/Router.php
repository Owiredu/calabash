<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Calabash\Core;

// require modules
require_once(__DIR__ . '/../auxiliary/HelperFuncs.php');
require_once(__DIR__ . '/Request.php');
require_once(__DIR__ . '/Response.php');

// use namespaces
use Calabash\Auxiliary\HelperFuncs;
use Calabash\Core\Request as HTTPRequest;
use Calabash\Core\Response as HTTPResponse;

/**
 * Router class
 */
class Router
{

    /**
     * Request object
     * @var RequestInterface
     */
    private HTTPRequest $request;

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

    public function __construct(HTTPRequest $request, HTTPResponse $response)
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
        list($base_route, $router_class) = $args;

        // add the get routes
        foreach ($router_class::$GET as $sub_route => $callback) {
            // set the method (together with its associated route) as a property of the instance of this class.
            // this is stored as a dictionary where the dictionary name is the request method (get, post, etc).
            // the index is the route string and the value is the callback function that handles that route.
            // format: $this-> <method_name(get, post, etc)> [<route>] = <callback>
            // eg. $this->get['user/'] = function(...) {}
            // eg. $this->get['/user/message'] = function(...) {}
            // eg. $this->get['/user/exit'] = function(...) {}
            $this->{"get"}[$this->format_route($base_route) . $this->format_route($sub_route)] = $callback;
        }

        // add the post routes
        foreach ($router_class::$POST as $sub_route => $callback) {
            // set the method (together with its associated route) as a property of the instance of this class.
            // this is stored as a dictionary where the dictionary name is the request method (get, post, etc).
            // the index is the route string and the value is the callback function that handles that route.
            // format: $this-> <method_name(get, post, etc)> [<route>] = <callback>
            // eg. $this->post['user/'] = function(...) {}
            // eg. $this->post['/user/login'] = function(...) {}
            // eg. $this->post['/user/register'] = function(...) {}
            $this->{"post"}[$this->format_route($base_route) . $this->format_route($sub_route)] = $callback;
        }

    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param string $route The route to be formatted
     * @return string The formatted route
     */
    private function format_route($route): string
    {
        // remove query string from the request URL
        // remove trailing '/'
        $result = rtrim(HelperFuncs::remove_query_string_from_url($route), '/');
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
            'error.html.twig', 
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
            'error.html.twig',
            ['message' => 'Not Found', 'status' => 404]
        );
    }

    /**
     * Finds the route that matches the URI pattern of the request
     * @param array $method_dictionary This is a named array containing routes and their corresponding callback functions
     *              for a particular request method
     * @return null|array Either a named array of containing the selected route and parameters or NULL
     */
    private function match_route(array $method_dictionary, string $request_uri): null|array
    {
        foreach ($method_dictionary as $route => $callback) {
            // convert urls like '/users/:uid/posts/:pid' to regular expression
            // $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url'])) . "$@D";
            $pattern = "@^" . preg_replace('/:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', $route) . "$@D";
            $params = [];
            // check if the current request params the expression
            $match = preg_match($pattern, $request_uri, $params);
            if ($match) {
                // remove the first match, which is the full URI
                array_shift($params);
                // replace the numerical indices with the exact parameter names
                $params_names = [];
                $match = preg_match_all('/:[a-zA-Z0-9\_\-]+/', $route, $params_names);
                if ($match) {
                    foreach($params as $index => $value) {
                        $new_key = ltrim($params_names[0][$index], ':');
                        $params[$new_key] = $value;
                        unset($params[$index]);
                    }
                }
                // call the callback with the matched positions as params
                // return call_user_func_array($route['callback'], $params);
                return [
                    "route" => $route, 
                    "params" => $params
                ];
            }
        }
        return null;
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
        // find the route that matches the request URI. Try with and without a trailing forward slash
        $route_match_result = $this->match_route($method_dictionary, $formatted_route) ?? $this->match_route($method_dictionary, $formatted_route . "/");

        // if no match is found for the route, send a not found response
        if (is_null($route_match_result)) {
            $this->default_request_handler();
            return;
        }

        // get the method associated with that route
        $method = $method_dictionary[$route_match_result["route"]];

        // add the matching parameters in the URL string to the request object
        $this->request->set_dynamic_uri_params($route_match_result["params"]);

        // if a method is found for the route, call the associated callback function,
        // passing in the request and response objects as arguments
        call_user_func_array($method, array($this->request, $this->response));
    }

    public function __destruct()
    {
        $this->resolve();
    }

}
