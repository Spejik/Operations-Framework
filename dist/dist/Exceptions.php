<?php

/**
 * Class for generating Exceptions with according HTTP response codes
 */
class Exceptions
{
    public function __construct()
    {}

    /**
     * If user is unauthorized
     */
    public static function Unauthorized()
    {
        self::__ThrowException(
            OFW_TEXTS("exceptions", "unauthorized"),
            401
        );
    }

    /**
     * Throw if request was sent in a invalid shape
     */
    public static function MalformedRequest(string $msg = "")
    {
        !empty($msg) || $msg = OFW_TEXTS("exceptions", "no_more_information");
        self::__ThrowException(
            OFW_TEXTS("exceptions", "invalid_request") . ": $msg",
            400
        );
    }

    /**
     * Throw if something failed
     * @param string $msg
     */
    public static function RequestFailed(string $msg = "")
    {
        !empty($msg) || $msg = OFW_TEXTS("exceptions", "no_more_information");
        self::__ThrowException(
            OFW_TEXTS("exceptions", "request_failed") . ": $msg",
            500
        );
    }

    /**
     * Throw if a property is missing
     * @param string $property The property name
     * @param string $source The object/array in which the property should be [default: "{:/main}" (means php://input)]
     */
    public static function UnknownProperty(string $property = "", string $source = "{:/main}")
    {
        $msg = OFW_TEXTS("exceptions", "property_doesnt_exist_in");
        $msg = str_replace("{property}", $property, $msg);
        $msg = str_replace("{source}", $source, $msg);

        self::__ThrowException(
            $msg,
            412
        );
    }

    /**
     * Throws exception with code and dies
     * @param string $message Message to say
     * @param int $code HTTP Status Code
     */
    private static function __ThrowException(string $message, int $code)
    {
        @Response::$obj->msg = $message;
        Response::code($code);
        echo Response::__();
        die();
    }
}
