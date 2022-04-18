<?php

namespace App\Controller\Bot;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/bot/telegram')]
class TelegramController extends AbstractController
{
    #[Route('', name: 'bot_telegram')]
    public function index(): Response
    {
        $token = $this->getParameter('bot.telegram.token');
        return new Response($token);
    }
}