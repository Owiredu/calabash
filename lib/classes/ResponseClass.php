<?php
// declare namespace
namespace Response;

// require modules
require(__DIR__ . '/../../php_modules/autoload.php');

// use Twig modules
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// set Twig environment to load views from views directory
$loader = new FilesystemLoader(__DIR__ . '/../../views');
$twig = new Environment($loader);

/**
 * Respons class
 */
class Response {

    /**
     * Status code
     * @var int
     */
    public int $status_code = 200;

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
    public function render(string $template_name, array $context = []) {
        // send response
        global $twig;
        echo $twig->render($template_name, $context);
    }

    /**
     * Sends json data
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

        // send response 
        echo $json_data == [] ? [] : json_encode($response_data, true);
    }

    /**
     * Redirects traffic
     * @param string $route Route path
     */
    public function redirect(string $route) {
    }

}