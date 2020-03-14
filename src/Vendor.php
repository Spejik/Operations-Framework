<?php

class OFW_Vendor
{
    /**
     * @param string $ofw_language Language which OFW will use (imports file Texts.[LANGUAGE].php)
     */
    public function Load(string $ofw_language = "en")
    {
        $ofw_language = strtoupper($ofw_language);
        require __DIR__ . "/Texts.$ofw_language.php";

        require __DIR__ . "/Exceptions.php";
        require __DIR__ . "/JSON.php";
        require __DIR__ . "/Operations.php";
        require __DIR__ . "/Response.php";
        require __DIR__ . "/Texts.php";
        require __DIR__ . "/Vendor.php";

        new Response;
        new Exceptions;
        new JSON;
    }
}
