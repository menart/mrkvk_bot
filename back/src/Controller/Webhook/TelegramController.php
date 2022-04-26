<?php

namespace App\Controller\Webhook;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TelegramBot\Api\Types\Update;
use TelegramBot\Api\BotApi;

#[Route('/webhook/telegram')]
class TelegramController extends AbstractController
{
    #[Route('', name: 'bot_telegram')]
    public function index(Request $request)
    {
        file_put_contents('/back/tmp', json_encode($request->getContent()));
        $content = $request->getContent();
        if (empty($content)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        } else {
            $data = BotApi::jsonValidate($content, true);
            $update = Update::fromResponse($data);
            $token = $this->getParameter('bot.telegram.token');
            $bot = new BotApi($token);
            $chatId = $update->getMessage()->getChat()->getId();
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                [
                    [ ['text' => 'one', 'callback_data' => '\/send']]
                ], true); // true for one-time keyboard

            return new Response(json_encode($bot->sendMessage($chatId ?? 0,
                $update->getMessage()->getText(),
                null,
                false,
                null,
                $keyboard)));
        }
    }

}