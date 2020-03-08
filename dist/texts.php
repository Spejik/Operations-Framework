<?php
const __s = " ";
const JSON_ERROR_UNKNOWN = 9451800;
const JSON_NO_ERRORS_FOUND = 9451801;

// Do not remove any constants from texts, the results might be completely different!
const TEXTS = [
    "exceptions" => [
        "unauthorized" => "Authorization Required",
        "invalid_request" => "Invalid request",
        "request_failed" => "Request failed",
        "property_doesnt_exist_in" => "Property {property} doesn't exist in {source}",
        "no_more_information" => "{no more information}",
    ],
    "operations" => [
        "operation_must_be_in_format" => "Operation must be in format:",
        "request_method_must_be_post" => '"REQUEST_METHOD" must be "POST"',
        "unknown" => "Unknown" . __s,
        "operation" => "operation" . __s,
        "of_operation" => __s . "of operation" . __s,
        "function" => "function" . __s,
    ],
    "JSON" => [
        JSON_ERROR_NONE => JSON_NO_ERRORS_FOUND,
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded.',
        JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON.',
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded.',
        JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON.',
        JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded.',
        JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded.',
        JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded.',
        JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given.',
        JSON_ERROR_UNKNOWN => 'Unknown JSON error occured.',
    ],
];
