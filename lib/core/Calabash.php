<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Lib\Core;

// require routers
require_once(__DIR__ . '/Request.php');
require_once(__DIR__ . '/Response.php');
require_once(__DIR__ . '/Router.php');

// use namespaces
use Lib\Core\Request as HTTPRequest;
use Lib\Core\Response as HTTPResponse;
use Lib\Core\Router as HTTPRouter;

/**
 * Calabash main app
 */
class Calabash {
    /**
     * The main router for the application
     * @var HTTPRouter
     */
    private HTTPRouter $router;

    function __construct()
    {
        // initialize the application router with request and response objects
        $this->router = new HTTPRouter(new HTTPRequest, new HTTPResponse);
    }

    /**
     * Adds a router to the application.
     * @param string $base_path The router class' base path
     * @param class $router_class The router class. eg. IndexRouter::class, UserRouter::class
     */
    public function add_router(string $base_path, $router_class) {
        // add router
        $this->router->add($base_path, $router_class);
    }

    /**
     * Sets cookies
     * @param string $name The name of the cookie.
     * @param string $value [optional] The value of the cookie. This value is stored on the clients computer; 
     *                      do not store sensitive information. Assuming the name is 'cookiename', 
     *                      this value is retrieved through $_COOKIE['cookiename']
     * @param array $options [optional] An associative array which may have any of the keys expires, path, 
     *                      domain, secure, httponly and samesite. The values have the same meaning as described 
     *                      for the parameters with the same name. The value of the samesite element should be 
     *                      either Lax or Strict. If any of the allowed options are not given, their default 
     *                      values are the same as the default values of the explicit parameters. If the samesite 
     *                      element is omitted, no SameSite cookie attribute is set.
     * @return bool If output exists prior to calling this function, setcookie will fail and return false. If 
     *              setcookie successfully runs, it will return true. This does not indicate whether the user 
     *              accepted the cookie.
     * @link https://php.net/manual/en/function.setcookie.php
     */
    public function set_cookies(string $name, string $value = "", array $options = []): bool {
        return setcookie(
            $name,
            $value,
            $options
        );
    }
}