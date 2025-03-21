<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

class WhatsAppRequestHandler implements RequestHandlerInteface
{
    public function handle(Request $request) : void
    {
        dump("Message Whatssap est envoyer correctement!!");
    }
}