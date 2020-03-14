<?php

/**
 * Class for JSON validation
 */
class JSON
{
    /**
     * @param string $string Validates JSON and returns an error message if invalid
     * @return null|string Returns NULL if JSON is valid, else returns a error message
     */
    public static function validate(string $string)
    {
        // decode the JSON data
        $result = json_decode($string);

        // store any errors into a variable
        $json_last_error = json_last_error();

        // find text for this error
        $error = OFW_TEXTS("JSON", $json_last_error);

        // if there are no errors in the JSON
        if ($error == JSON_NO_ERRORS_FOUND) {
            return null;
        } else
        // if there are any errors and the error is empty, assume it's an unknown error
        if ($error != JSON_NO_ERRORS_FOUND && empty($error)) {
            $error = OFW_TEXTS("JSON", JSON_ERROR_UNKNOWN);
        }

        // return message
        return $error;
    }
}
