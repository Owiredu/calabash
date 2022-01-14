<?php
// declare namespace
namespace Lib\Class;

// require modules
require_once(__DIR__ . '/../interfaces/RequestInterface.php');

// use namespaces
use Lib\Interface\Request as RequestInterface;

/**
 * Request class
 */
class Request implements RequestInterface
{

    public function __construct()
    {
        $this->bootstrap_self();
    }

    /**
     * Sets the keys of the $_SERVER superglobals as 
     * properties of the Request object and assign their values.
     */
    private function bootstrap_self()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->to_camel_case($key)} = $value;
        }
    }

    /**
     * Converts snake cases a string into camel case
     * @param string $string The snake case string to be converted
     * @return string The camel case string
     */
    private function to_camel_case($string): string
    {
        // covert the string to lower case
        $result = strtolower($string);

        // find parts of the string with underscores
        preg_match_all('/_[a-z]/', $result, $matches);

        // remove the underscores and replace them with equivalent camel casing variants
        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * Return the body of a request
     * @return void|array The body of the request
     */
    public function body()
    {
        // return no body data if the request is a get request
        if ($this->requestMethod === "GET") {
            return;
        }

        // return the data in a post request
        if ($this->requestMethod === "POST") {
            $body = array();
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }

}
