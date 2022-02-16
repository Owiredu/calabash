<?php
// set strict types
declare (strict_types = 1);

// declare namespace
namespace Calabash\Auxiliary;

/**
 * Helper Functions
 */
class HelperFuncs
{

    /**
     * Removes query string from a URI
     * @param string $uri The URI
     * @return string The request URI without the query string
     */
    public static function remove_query_string_from_url(string $uri): string
    {
        return preg_replace("/[?]{1}(.*)$/", "", $uri);
    }

    /**
     * Returns the full URL, including the query string when given a route
     * @param string $route The route to be use for composing the URL
     * @return string The fully composed URL
     */
    public static function get_url_from_route(string $route): string
    {
        // formulate the base URL
        $base_url = (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://') . $_SERVER["HTTP_HOST"] . "/";
        // get the query string
        $query_string = $_SERVER["QUERY_STRING"];
        // remove leading and trailing '/' from the route
        return $base_url . trim($route, " \t\n\r\0\x0B/") . '?' . $query_string;
    }

    /**
     * Inserts a header elements (without closing tags) into the head section of an html page
     * @param string $html_content The content of the html page
     * @param string $tag_name The name of the tag to insert
     * @param array $attrib_name_val_pairs An associative array of the name and value pairs of the attributes to pass into the element
     * @return string The processed html content
     */
    public static function insert_head_element(string $html_content, string $tag_name, array $attrib_name_val_pairs) {
        $meta_element = "<$tag_name";

        foreach ($attrib_name_val_pairs as $name => $val) {
            $meta_element .= " $name=\"$val\"";
        }

        $meta_element .= ">";

        return str_replace("</head>", $meta_element . "</head>", $html_content);
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
