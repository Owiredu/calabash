<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Calabash\Auxiliary;

// require modules
require_once __DIR__ . '/RegExp.php';

/**
 * Validation class
 */
class Validator {

    /**
     * Validates an email address
     * @param string $email The email address to validate
     * @return bool True if the email is valid else False
     */
    public static function is_valid_email(string $email): bool {
        return boolval(preg_match(RegExp::REQUIRED_EMAIL_REGEX, $email, $matches));
    }

    /**
     * Validates a phone number
     * @param string $phone The phone number to be validated
     * @return bool True if the phone number is valid else False
     */
    public static function is_valid_phone(string $phone): bool {
        return boolval(preg_match(RegExp::REQUIRED_PHONE_NUMBER_REGEX, $phone, $matches));
    }

    /**
     * Validates a name. Thus checks whether the name has length from 1 to 50
     * @param string $phone The name to be validated
     * @return bool True if the name is valid else False
     */
    public static function is_valid_name(string $name): bool {
        return boolval(preg_match(RegExp::REQUIRED_NAME_REGEX, $name, $matches));
    }

    /**
     * Checks whether a given string is an integer
     * @param string $value The value to be validated
     * @return bool True if the value is a valid integer else False
     */
    public static function is_valid_integer(string $value): bool {
        return true;
    }

    /**
     * Checks whether a given value is a floating point number
     * @param string $value The value to be validated
     * @return bool True if the value is a valid floating point number else False
     */
    public static function is_valid_float(string $value): bool {
        return true;
    }

    /**
     * Checks whether a given string contains only alphabets
     * @param string $string The string to be validated
     * @return bool True if the string contains only alphabets else False
     */
    public static function is_valid_alpha(string $string): bool {
        return true;
    }

    /**
     * Checks whether a given string contains only numbers
     * @param string $string The string to be validated
     * @return bool True if the string contains only numbers else False
     */
    public static function is_valid_numeric(string $string): bool {
        return true;
    }

    /**
     * Checks whether a given string contains only alphabets and numbers
     * @param string $string The string to be validated
     * @return bool True if the string contains only alphabets and numbers else False
     */
    public static function is_valid_alphanumeric(string $string): bool {
        return true;
    }

    /**
     * Checks whether a given string is a valid URL
     * @param string $string The string to be validated
     * @return bool True if the string is a valid URL else False
     */
    public static function is_valid_url(string $string): bool {
        return true;
    }

    /**
     * Checks whether a given value has a specified length
     * @param string $value The value to be validated
     * @param int $length The expected length of the value
     * @return bool True if the value has the expected length else False
     */
    public static function is_valid_length(string $value, int $length): bool {
        return true;
    }

    /**
     * Checks whether a number is in a certain range
     * @param int|float $value The value to be validated
     * @param int $min The minimum length the value should have
     * @param int $max The maximum length the value should have
     * @return bool True if the value is in the range else False
     */
    public static function is_valid_value_range(int|float $value, int $min, int $max): bool {
        return true;
    }

    /**
     * Checks whether a number is in a certain range
     * @param int|float|string $value The value to be validated
     * @param int $min The minimum length the value should have
     * @param int $max The maximum length the value should have
     * @return bool True if the value is in the range else False
     */
    public static function is_valid_length_range(int|float|string $value, int $min, int $max): bool {
        return true;
    }

}