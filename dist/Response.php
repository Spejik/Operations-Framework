<?php

/**
 * Class that contains response and code generation functions
 */
class Response
{
    /**
     * Publicly acessible object that contains the main response
     */
    public static $obj;

    public function __construct()
    {
        self::$obj = (object) [];
        @self::$obj->code = 200;
    }

    /**
     * Changes the status code
     */
    public static function code(int $code)
    {
        self::$obj->code = $code;
    }

    /**
     * Returns Response::$obj JSON
     * Recommended to use because of headers
     */
    public static function __()
    {
        ob_start();
        header('Content-type: application/json; charset=UTF-8');

        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
        ob_flush();
        return json_encode(self::$obj);
    }
}
