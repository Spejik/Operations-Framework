<?php

// Response::$obj is the object that will always be outputted
Response::$obj["msg"] = "Hello from Function 1!";

if ("User is not logged in") {
    Exceptions::Unauthorized();
}
