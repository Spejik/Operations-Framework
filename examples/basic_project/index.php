<?php

// files for loading your libraries you want to access from anywhere go here
// ...
require "main/Config.php";
// ...

require __DIR__ . "/OFW/OFW.php";

// loads the required classes
$ofw_vendor = new OFW_Vendor();
$ofw_vendor->Load();

// can the api be accessed using only POST?
const use_only_post = true;
// the folder where your functions are [default]
const functions_folder = "main/";

// loads OFW
$OFW = new OFW(use_only_post, functions_folder);

// an array of operations
// (side note: this syntax is actually valid, and would work)
const operations = [
    "operation name" => [
        "1st function name" => "Folder/Function 1",
        "2nd function name" => "Folder/Function 2",
        "3rd function name" => "...",
    ],
    "another operation name" => ["..."],
];

// searches the operations array
$OFW->LoadOperationFrom(operations);
