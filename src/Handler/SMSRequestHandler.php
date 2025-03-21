<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

class SMSRequestHandler implements RequestHandlerInteface
{
    public function handle(Request $request) : void
    {
        dump("SMS est envoyer correctement!!");
    }
}