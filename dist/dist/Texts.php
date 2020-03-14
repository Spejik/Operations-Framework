<?php

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
