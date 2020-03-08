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
