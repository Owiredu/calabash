<?php
// set strict types
declare (strict_types = 1);

// declare namespace
namespace Lib\Middleware;

/**
 * Assets Handler class
 */
class AssetsHandler
{

    /**
     * Supported asset file extensions
     * @var string[]
     */
    public const SUPPORTED_ASSET_EXTENSIONS = [
        "png", "jpg", "jpeg", "gif", "ico",
        "css", "js"
    ];

    /**
     * Determines whether a path to append the prefix to a URI or not.
     * It appends the prefix the path is relative but does nothing if a 
     * URL is provided.
     * @param string $uri The URI to be examined
     * @param string $prefix The prefix to be used
     * @return string The resulting URI after examination and edit (if necessary)
     */
    private static function get_uri_prefix(string $uri, string $prefix="/calabash/public/")
    {
    $protocols = ["file://", "http://", "https://", "rstp://"/*, "/"*/]; // do not support absolute paths.
        foreach ($protocols as $p) {
            if (substr(ltrim($uri), 0, strlen($p)) === $p) {
                return "";
            }
        }
        return $prefix;
    }

    /**
     * Identifies and sets the correct assets paths. It appends /public/ as the 
     * prefix of paths only so that the assets are loaded from the public directory.
     * #### NB: All paths must be relative and assumed to be in the public directory in order to avoid reading files outside the project's root directory.
     * @param string $template The content of the template
     * @return string The processed template
     */
    public static function handle_asset_routes(string $template): string
    {
        // supported asset extensions
        $supported_asset_extensions = join("|", self::SUPPORTED_ASSET_EXTENSIONS);

        // define patterns for href
        $pattern_href_1 = "/<[\s]{0,}(a|link|area|base)[\s]+href[\s]{0,}=[\s]{0,}(?:(?:\"([^\"]+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\"))/i"; // use case: <a href="fish.jpg" rel="icon" type="image/x-icon"/>
        $pattern_href_2 = "/<[\s]{0,}(a|link|area|base)[\s]+href[\s]{0,}=[\s]{0,}(?:(?:\'([^\']+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\'))/i"; // use case: <a href='fish.jpg' rel="icon" type="image/x-icon" />
        $pattern_href_3 = "/<[\s]{0,}(a|link|area|base)([^>]+)[\s]href[\s]{0,}=[\s]{0,}(?:(?:\"([^\"]+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\"))/i"; // use case: <link rel="icon" type="image/x-icon" href="favicon.ico">
        $pattern_href_4 = "/<[\s]{0,}(a|link|area|base)([^>]+)[\s]href[\s]{0,}=[\s]{0,}(?:(?:\'([^\']+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\'))/i"; // use case: <link rel="icon" type="image/x-icon" href='favicon.ico'>

        // define patterns for src
        $pattern_src_1 = "/<[\s]{0,}(img|script|audio|video|embed|iframe|input|source|track)[\s]+src[\s]{0,}=[\s]{0,}(?:(?:\"([^\"]+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\"))/i"; // use case: <img src="fish.jpg" rel="icon" type="image/x-icon"/>
        $pattern_src_2 = "/<[\s]{0,}(img|script|audio|video|embed|iframe|input|source|track)[\s]+src[\s]{0,}=[\s]{0,}(?:(?:\'([^\']+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\'))/i"; // use case: <img src='fish.jpg' rel="icon" type="image/x-icon" />
        $pattern_src_3 = "/<[\s]{0,}(img|script|audio|video|embed|iframe|input|source|track)([^>]+)[\s]src[\s]{0,}=[\s]{0,}(?:(?:\"([^\"]+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\"))/i"; // use case: <img width="100px" src="favicon.ico">
        $pattern_src_4 = "/<[\s]{0,}(img|script|audio|video|embed|iframe|input|source|track)([^>]+)[\s]src[\s]{0,}=[\s]{0,}(?:(?:\'([^\']+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\'))/i"; // use case: <img width="100px" src='favicon.ico'>

        // define patterns for src
        $pattern_srcset_1 = "/<[\s]{0,}(source)[\s]+srcset[\s]{0,}=[\s]{0,}(?:(?:\"([^\"]+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\"))/i"; // use case: <source srcset="fish.jpg" media="(min-width:650px)"/>
        $pattern_srcset_2 = "/<[\s]{0,}(source)[\s]+srcset[\s]{0,}=[\s]{0,}(?:(?:\'([^\']+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\'))/i"; // use case: <source srcset='fish.jpg' media="(min-width:650px)" />
        $pattern_srcset_3 = "/<[\s]{0,}(source)([^>]+)[\s]srcset[\s]{0,}=[\s]{0,}(?:(?:\"([^\"]+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\"))/i"; // use case: <source media="(min-width:650px)" srcset="favicon.ico">
        $pattern_srcset_4 = "/<[\s]{0,}(source)([^>]+)[\s]srcset[\s]{0,}=[\s]{0,}(?:(?:\'([^\']+)(\.(" . $supported_asset_extensions . ")[\s]{0,})\'))/i"; // use case: <source media="(min-width:650px)" srcset='favicon.ico'>

        // make replacements
        $result = preg_replace_callback_array(
            [
                // for href
                $pattern_href_1 => fn(array $matches) => '<' . $matches[1] . ' href="' . self::get_uri_prefix($matches[2]) . $matches[2] . $matches[3] . '"',
                $pattern_href_2 => fn(array $matches) => '<' . $matches[1] . ' href="' . self::get_uri_prefix($matches[2]) . $matches[2] . $matches[3] . '"',
                $pattern_href_3 => fn(array $matches) => '<' . $matches[1] . ' ' . $matches[2] . ' href="' . self::get_uri_prefix($matches[3]) . $matches[3] . $matches[4] . '"',
                $pattern_href_4 => fn(array $matches) => '<' . $matches[1] . ' ' . $matches[2] . ' href="' . self::get_uri_prefix($matches[3]) . $matches[3] . $matches[4] . '"',

                // for src
                $pattern_src_1 => fn(array $matches) => '<' . $matches[1] . ' src="' . self::get_uri_prefix($matches[2]) . $matches[2] . $matches[3] . '"',
                $pattern_src_2 => fn(array $matches) => '<' . $matches[1] . ' src="' . self::get_uri_prefix($matches[2]) . $matches[2] . $matches[3] . '"',
                $pattern_src_3 => fn(array $matches) => '<' . $matches[1] . ' ' . $matches[2] . ' src="' . self::get_uri_prefix($matches[3]) . $matches[3] . $matches[4] . '"',
                $pattern_src_4 => fn(array $matches) => '<' . $matches[1] . ' ' . $matches[2] . ' src="' . self::get_uri_prefix($matches[3]) . $matches[3] . $matches[4] . '"',

                // for srcset
                $pattern_srcset_1 => fn(array $matches) => '<' . $matches[1] . ' srcset="' . self::get_uri_prefix($matches[2]) . $matches[2] . $matches[3] . '"',
                $pattern_srcset_2 => fn(array $matches) => '<' . $matches[1] . ' srcset="' . self::get_uri_prefix($matches[2]) . $matches[2] . $matches[3] . '"',
                $pattern_srcset_3 => fn(array $matches) => '<' . $matches[1] . ' ' . $matches[2] . ' srcset="' . self::get_uri_prefix($matches[3]) . $matches[3] . $matches[4] . '"',
                $pattern_srcset_4 => fn(array $matches) => '<' . $matches[1] . ' ' . $matches[2] . ' srcset="' . self::get_uri_prefix($matches[3]) . $matches[3] . $matches[4] . '"',
            ],
            $template
        );
        return $result;
    }

}
