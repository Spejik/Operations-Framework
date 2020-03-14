<?php

/**
 * Main OFW class
 */
class OFW
{

    private static $__OPERATION;
    private static $__FUNCTIONS_FOLDER;

    /**
     * @param bool $must_be_post Set to false if request can use GET (not recommended) [default: true]
     * @param string $functions_folder Root folder for functions [default: "main/"]
     */
    public function __construct(bool $must_be_post = true, string $functions_folder = "main/")
    {
        self::$__FUNCTIONS_FOLDER = $functions_folder;

        /**
         * If request method is OPTIONS, return 204
         */
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            ob_start();

            header("HTTP/1.1 204 NO CONTENT");

            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Pragma: no-cache");
            header("Expires: 0");

            ob_end_flush();
            die();
        }

        // If requests must be post
        if ($must_be_post) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                //? Malformed Request: request_method must be POST
                throw Exceptions::MalformedRequest(
                    OFW_TEXTS("operations", "request_method_must_be_post")
                );
            }
        }

        // Decodes and validates php://input
        $p_i = (string)file_get_contents("php://input");
        if (!JSON::validate($p_i)) {
            $_POST = (object)json_decode($p_i);
        } else {
            Exceptions::RequestFailed(JSON::validate($p_i));
        }

        // Tests if POST contains operation field
        if (isset($_POST->operation)) {
            // sets the operation
            self::$__OPERATION = $_POST->operation;
        } else {
            //? Unknown property [operation]
            Exceptions::UnknownProperty(
                OFW_TEXTS("operations", "operation")
            );
        }

        // Splits operation name from function name
        self::$__OPERATION = explode("\\", self::$__OPERATION);

        // If there are more than 2 entries (operation, function)
        if (count(self::$__OPERATION) != 2) {
            //? Malformed Request: Operation must be in format [format]
            Exceptions::MalformedRequest(
                OFW_TEXTS("operations", "operation_must_be_in_format") . " operation\\function"
            );
        }
    }

    /**
     * @param array $_UDO
     * (User Defined Operations / Array of Operations)
     * Should look like:
     *  "Operation Name" => [
     *      "Function Name" => "Path To File To Execute (must be without .php)"
     *  ]
     */
    public static function LoadOperationFrom(array $_UDO)
    {

        $_OPERATION = self::$__OPERATION;

        if (isset($_UDO[$_OPERATION[0]])) {
            $operation_name = $_UDO[$_OPERATION[0]];

            if (isset($operation_name[$_OPERATION[1]])) {
                $opeartion_function = $operation_name[$_OPERATION[1]];

                require __DIR__ . "/../" . self::$__FUNCTIONS_FOLDER . $opeartion_function . ".php";

                echo Response::__();
            } else {
                //? Request Failed: Unknown function [function] of operation [operation]
                Exceptions::RequestFailed(OFW_TEXTS("operations", "unknown") .
                    OFW_TEXTS("operations", "function") . OFW_ENCAPSULATE($_OPERATION[1]) .
                    OFW_TEXTS("operations", "of_operation") . OFW_ENCAPSULATE($_OPERATION[0])
                );
            }
        } else {
            //? Request Failed: Unknown operation [operation]
            Exceptions::RequestFailed(
                OFW_TEXTS("operations", "unknown") .
                OFW_TEXTS("operations", "operation") . OFW_ENCAPSULATE($_OPERATION[0])
            );
        }
    }
}
