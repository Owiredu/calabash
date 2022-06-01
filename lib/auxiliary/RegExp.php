<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Calabash\Auxiliary;

/**
 * Regular expression definitions
 */
class RegExp {

    /**
     * Represents a space character of length 2 or more
     * @var string
     */
    const MULTIPLE_SPACES_REGEX = "/[\s]{2,}/";

    /**
     * Represents a single space character
     * @var string
     */
    const SINGLE_SPACE_REGEX = "/[\s]/";

    /**
     * Represents a non-numeric character
     * @var string
     */
    const NON_NUMERIC_REGEX = "/\D/";

    /**
     * Represents a numeric character
     * @var string
     */
    const NUMERIC_REGEX = "/\d/";

    /**
     * Represents a string that should not start with empty spaces and should be from 3 to 50 characters long
     * @var string
     */
    const REQUIRED_NAME_REGEX = "/^[^\s]{1}.{1,50}[^\s]{1}$/";

    /**
     * Represents a string that should not start with empty spaces and should be from 3 to 50 characters long
     * OR should be an empty string
     * @var string
     */
    const OPTIONAL_NAME_REGEX = "/^[^\s]{1}.{1,50}[^\s]{1}$|^$/";

    /**
     * Represents a string that should be numbers only and have 10 to 15 characters
     * @var string
     */
    const REQUIRED_PHONE_NUMBER_REGEX = "/^[\d]{10,15}$/";

    /**
     * Represents a string that should be numbers only and have 10 to 15 characters OR should be an empty string
     * @var string
     */
    const OPTIONAL_PHONE_NUMBER_REGEX = "/^[\d]{10,15}$|^$/";

    /**
     * Represents a valid email string
     * @var string
     */
    const REQUIRED_EMAIL_REGEX = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";

    /**
     * Represents a valid email string OR an empty string
     * @var string
     */
    const OPTIONAL_EMAIL_REGEX = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$|^$/";
}