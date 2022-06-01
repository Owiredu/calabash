<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Calabash\Auxiliary;

// require modules
require_once __DIR__ . '/RegExp.php';

/**
 * Sanitization functions using regular expressions
 */
class Sanitizer {

    /**
     * Removes non-numeric characters from a string
     * @param string $input_str The string to be sanitized
     * @return string The sanitized string
     */
    public static function remove_non_numeric_chars(string $input_str): string {
        return preg_replace(RegExp::NON_NUMERIC_REGEX, "", $input_str);
    }

    /**
     * Replaces two or more contiguous spaces with a single space.
     * @param string $input_str The string to be sanitized
     * @return string The sanitized string
     */
    public static function shrink_multi_space(string $input_str): string {
        return preg_replace(RegExp::MULTIPLE_SPACES_REGEX, "", $input_str);
    }

    /**
     * Removes spaces from a string
     * @param string $input_str The string to be sanitized
     * @return string The sanitized string
     */
    public static function remove_spaces(string $input_str): string {
        return preg_replace(RegExp::SINGLE_SPACE_REGEX, "", $input_str);
    }

}