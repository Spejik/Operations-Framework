<?php

$compiler["Vendor"] = file_get_contents(__DIR__ . "/Vendor.php");
$compiler["Texts"] = file_get_contents(__DIR__ . "/Texts.php");
$compiler["Exceptions"] = file_get_contents(__DIR__ . "/Exceptions.php");
$compiler["JSON"] = file_get_contents(__DIR__ . "/JSON.php");
$compiler["Response"] = file_get_contents(__DIR__ . "/Response.php");
$compiler["Operations"] = file_get_contents(__DIR__ . "/Operations.php");

$compiler["Texts.EN"] = file_get_contents(__DIR__ . "/texts/en.php");
$compiler["Texts.CZ"] = file_get_contents(__DIR__ . "/texts/cz.php");

foreach ($compiler as $key => $value) {
    file_put_contents(__DIR__ . "/../dist/$key.php", $value);
}

echo "DONE";
