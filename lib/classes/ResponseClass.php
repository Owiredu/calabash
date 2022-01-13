<?php
// declare namespace
namespace Lib\Class;

// require modules
include_once(__DIR__ . '/../../php_modules/autoload.php');

// use Twig modules
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * Respons class
 */
class Response {

    private $loader;
    private $twig;

    /**
     * Status code
     * @var int
     */
    public int $status_code = 200;

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
     * Returns status code
     * @return int Status code
     */
    public function get_status_code(): int {
        return $this->status_code;
    }
    
    /**
     * Renders a template
     * @param string|TemplateWrapper $template_name — The template name
     * @param array $context
     * @throws LoaderError — When the template cannot be found
     * @throws SyntaxError — When an error occurred during compilation
     * @throws RuntimeError — When an error occurred during rendering
     */
    public function render(string $template_name, array $context = []): string {
        // send response
        return $this->twig->render($template_name, $context);
    }

    /**
     * Sends json data
     * @param array $json_data Response data set by user
     */
    public function json(array $json_data = []): string {
        // set the content type to JSON
        header("Content-Type: application/json", true, $this->status_code);

        // compose the response data
        $response_data = array(
            "data" => $json_data,
            "status_code" => $this->status_code
        );

        // send response 
        return $json_data == [] ? [] : json_encode($response_data, true);
    }

    /**
     * Redirects traffic
     * @param string $route Route path
     */
    public function redirect(string $route) {
    }

}