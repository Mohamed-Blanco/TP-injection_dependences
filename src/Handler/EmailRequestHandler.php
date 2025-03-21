<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

final class EmailRequestHandler implements RequestHandlerInteface
{
    public function handle(Request $request) : void
    {
        dump("l'email est envoyer correctement!!");
    }

}