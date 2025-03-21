<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

interface RequestHandlerInteface
{
    public function handle(Request $request) : void ;
}