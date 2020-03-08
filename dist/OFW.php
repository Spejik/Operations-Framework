<?php 


class OFW_Vendor
{
    public function Load()
    {
        require __DIR__ . "/.texts.php";
        new Response;
        new Exceptions;
        new JSON;
    }
}


/**
 * @param multiple $text Acts as an array for finding texts
 * Exapmle: 'OWF_TEXTS("exceptions", "unauthorized")' returns 'Authorization Required'
 */
function OFW_TEXTS(...$text)
{
    $texts = TEXTS;

    foreach ($text as $key => $value) {
        $texts = $texts[$value];
    }

    return (string)$texts;

}

/**
 * Returns any variable encapsulated in quotes, brackets..
 * You can change variables $_start and $_end__
 */
function OFW_ENCAPSULATE($text)
{
    $_start = "[";
    $_end__ = "]";

    $text = $_start . $text . $_end__;

    return $text;
}


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
        ob_flush();
        return json_encode(self::$obj);
    }
}


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
 
