<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use App\Handler\RequestHandlerInteface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotificationsController extends AbstractController
{
    private readonly RequestHandlerInteface $handler;

    public function __construct(
        #[Autowire(service: 'App\Handler\EmailRequestHandler')]
        RequestHandlerInteface $handler
    ) {
        $this->handler = $handler;
    }

    #[Route('/send', name: 'app_send_notifications')]
    public function send_Notifications(Request $request): Response
    {
        $this->handler->handle($request);
        return new Response();
    }
}