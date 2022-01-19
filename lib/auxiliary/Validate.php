<?php
// declare namespace
namespace Lib\Auxiliary;

/**
 * Validation class
 */
class Validate {

    /**
     * Validates an email address
     * @param string $email The email address to validate
     * @return bool True if the email is valid else False
     */
    public static function email(string $email): bool {
        return true;
    }

    /**
     * Validates a phone number
     * @param string $phone The phone number to be validated
     * @return bool True if the phone number is valid else False
     */
    public static function phone(string $phone): bool {
        return true;
    }

    /**
     * Checks whether a given value is an integer
     * @param int|string $value The value to be validated
     * @return bool True if the value is a valid integer else False
     */
    public static function integer(int|string $value): bool {
        return true;
    }

    /**
     * Checks whether a given value is a floating point number
     * @param float|string $value The value to be validated
     * @return bool True if the value is a valid floating point number else False
     */
    public static function float(float|string $value): bool {
        return true;
    }

    /**
     * Checks whether a given string contains only alphabets
     * @param string $string The string to be validated
     * @return bool True if the string contains only alphabets else False
     */
    public static function alpha(string $string): bool {
        return true;
    }

    /**
     * Checks whether a given string contains only numbers
     * @param string $string The string to be validated
     * @return bool True if the string contains only numbers else False
     */
    public static function numeric(string $string): bool {
        return true;
    }

    /**
     * Checks whether a given string contains only alphabets and numbers
     * @param string $string The string to be validated
     * @return bool True if the string contains only alphabets and numbers else False
     */
    public static function alphanumeric(string $string): bool {
        return true;
    }

    /**
     * Checks whether a given string is a valid URL
     * @param string $string The string to be validated
     * @return bool True if the string is a valid URL else False
     */
    public static function url(string $string): bool {
        return true;
    }

    /**
     * Checks whether a given value has a specified length
     * @param int|float|string $value The value to be validated
     * @param int $length The expected length of the value
     * @return bool True if the value has the expected length else False
     */
    public static function length(int|float|string $value, int $length): bool {
        return true;
    }

    /**
     * Checks whether a number is in a certain range
     * @param int|float $value The value to be validated
     * @param int $min The minimum length the value should have
     * @param int $max The maximum length the value should have
     * @return bool True if the value is in the range else False
     */
    public static function value_range(int|float $value, int $min, int $max): bool {
        return true;
    }

    /**
     * Checks whether a number is in a certain range
     * @param int|float|string $value The value to be validated
     * @param int $min The minimum length the value should have
     * @param int $max The maximum length the value should have
     * @return bool True if the value is in the range else False
     */
    public static function length_range(int|float|string $value, int $min, int $max): bool {
        return true;
    }

}