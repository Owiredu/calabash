<?php
// set strict types
declare (strict_types = 1);

// declare namespace
namespace Lib\Auxiliary;

/**
 * Helper Functions
 */
class HelperFuncs
{

    /**
     * Returns the full URL, including the query string when given a route
     * @param string $route The route to be use for composing the URL
     * @return string The fully composed URL
     */
    public static function get_url_from_route(string $route): string {
        // formulate the base URL
        $base_url = (stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://') . $_SERVER["HTTP_HOST"] . "/";
        // get the query string
        $query_string = $_SERVER["QUERY_STRING"];
        // remove leading and trailing '/' from the route
        return $base_url . trim($route, " \t\n\r\0\x0B/") . '?' . $query_string;
    }

    /**
     * Parses a query string from a URL
     * @param string $str The query string. Eg. ```id=1&name=John```
     * @return array A named array of the parameters in the query string
     */
    public static function parse_query_str(string $str): array
    {
        # result array
        $arr = array();

        if ($str) {
            # split on outer delimiter
            $pairs = explode('&', $str);
    
            # loop through each pair
            foreach ($pairs as $i) {
                # split into name and value
                list($name, $value) = explode('=', $i, 2);
    
                # if name already exists
                if (isset($arr[$name])) {
                    # stick multiple values into an array
                    if (is_array($arr[$name])) {
                        $arr[$name][] = $value;
                    } else {
                        $arr[$name] = array($arr[$name], $value);
                    }
                }
                # otherwise, simply stick it in a scalar
                else {
                    $arr[$name] = $value;
                }
            }
        }

        # return result array
        return $arr;
    }

}
