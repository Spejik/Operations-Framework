<?php

const result = 457300;
const vendor = 457301;
const texts = 457302;
const exceptions = 457303;
const json = 457304;
const response = 457305;
const operations = 457306;

$compiler[vendor] = file_get_contents(__DIR__ . "/Vendor.php");
$compiler[texts] = file_get_contents(__DIR__ . "/Texts.php");
$compiler[exceptions] = file_get_contents(__DIR__ . "/Exceptions.php");
$compiler[json] = file_get_contents(__DIR__ . "/JSON.php");
$compiler[response] = file_get_contents(__DIR__ . "/Response.php");
$compiler[operations] = file_get_contents(__DIR__ . "/Operations.php");

$compiler[result] = "<?php \n";

foreach ($compiler as $key => $value) {
    $value = str_replace("<?php", "", $value);
    $compiler[result] .= $value;
}

echo "<!-- DONE: \n\n\n\n\n\n" . $compiler[result] . "\n\n\n\n\n\n-->";
file_put_contents(__DIR__ . "/../dist/OFW.php", $compiler[result]);
