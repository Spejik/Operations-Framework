<?php

// Response::$obj is the object that will always be outputted
Response::$obj["msg"] = "Hello there, this is Function 2!";

if ("There is an missing property in user input") {
    Exceptions::UnknownProperty("The missing property name");
}

if ("User forgot to do something important") {
    Exceptions::MalformedRequest("You forgot to do something important");
}

if ("Something explodes") {
    Exceptions::RequestFailed("Our server is on fire");
}

// JSON::validate returns null if no errors were found, else, it returns an error message
$invalid_json = "The JSON user might input, but they probably won't do that";
if (is_null(JSON::validate($invalid_json))) {
    Exceptions::RequestFailed(JSON::validate($invalid_json));
}
