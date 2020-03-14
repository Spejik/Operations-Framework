<?php
const __s = " ";
const JSON_ERROR_UNKNOWN = 9451800;
const JSON_NO_ERRORS_FOUND = 9451801;

// Do not remove any constants from texts, the results might be completely different!
const TEXTS = [
    "exceptions" => [
        "unauthorized" => "Vyžadována Autorizace",
        "invalid_request" => "Neplatný požadavek",
        "request_failed" => "Požadavek selhal:",
        "property_doesnt_exist_in" => "Položka {property} nebyla nalezena v {source}",
        "no_more_information" => "{žádné další infomace}",
    ],
    "operations" => [
        "operation_must_be_in_format" => "Operation musí být ve formátu",
        "request_method_must_be_post" => '"REQUEST_METHOD" musí být "POST"',
        "unknown" => "Neznámá" . __s,
        "operation" => "operace" . __s,
        "of_operation" => __s . "operace" . __s,
        "function" => "funkce" . __s,
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
