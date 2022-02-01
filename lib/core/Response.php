<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Lib\Core;

// require modules
require_once(__DIR__ . '/Router.php');
require_once(__DIR__ . '/../middleware/AssetsHandler.php');
require_once(__DIR__ . '/../auxiliary/HelperFuncs.php');
require_once(__DIR__ . '/../../php_modules/autoload.php');

// use namespaces
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Lib\Auxiliary\HelperFuncs;
use Lib\Middleware\AssetsHandler;

/**
 * Response class
 */
class Response {

    /**
     * File system loader for Twig
     * @var FilesystemLoader
     */
    private $loader;

    /**
     * Twig environment
     * @var Environment
     */
    private $twig;

    /**
     * Status code
     * @var int
     */
    private int $status_code = 200;

    /**
     * Response content type. Eg. application/json, text/html, etc.
     * @var string
     */
    private string $content_type;

    public function __construct()
    {
        // set Twig environment to load views from views directory
        $this->loader = new FilesystemLoader(__DIR__ . '/../../views');
        $this->twig = new Environment($this->loader);
    }

    /**
     * Sets status code
     * @param int|string $status_code Status code
     */
    public function set_status_code(int|string $status_code) {
        $this->status_code = intval($status_code);
    }

    /**
     * Sets the response content type
     * @param string $content_type The response content type. Eg. application/json, text/html, etc.
     */
    public function set_content_type(string $content_type) {
        $this->content_type = $content_type;
    }

    /**
     * Returns status code
     * @return int Status code
     */
    public function get_status_code(): int {
        return $this->status_code;
    }

    /**
     * Returns the response content type
     * @return string The response content type
     */
    public function get_content_type(): string {
        return $this->content_type;
    }
    
    /**
     * Renders a template and returns it as a response
     * @param string|TemplateWrapper $template_name — The template name
     * @param array $context
     * @throws LoaderError — When the template cannot be found
     * @throws SyntaxError — When an error occurred during compilation
     * @throws RuntimeError — When an error occurred during rendering
     */
    public function render(string $template_name, array $context = []) {
        // send response
        echo AssetsHandler::handle_asset_routes($this->twig->render($template_name, $context));
    }

    /**
     * Sends JSON response
     * @param array $json_data Response data set by user
     */
    public function json(array $json_data = []) {
        // set the content type to JSON
        header("Content-Type: application/json", true, $this->status_code);

        // compose the response data
        $response_data = array(
            "data" => $json_data,
            "status_code" => $this->status_code
        );

        // sends response 
        echo json_encode($response_data, 1);
    }

    /**
     * Redirects response to a specified route
     * @param string $route The route to which the request is sent to
     * @param bool $replace_header Whether to replace the previous header or not.
     * @param int $status_code [optional] The status code to be returned
     * @return never
     */
    public function redirect(string $route, bool $replace_header=true, int $status_code=302) {
        header("Location: " . HelperFuncs::get_url_from_route($route), $replace_header, $status_code);
        exit(0);
    }

}