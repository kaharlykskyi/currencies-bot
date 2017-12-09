<?php
namespace App\Http\Controllers;

use Telegram\Bot\Api;

class ExampleController extends Controller
{

    public $api_key = '447961361:AAFkN6W28gWZrqbqwIk1JNjDawqfC4UU4zg';//getenv('TG_TOKEN');
    public $bot_username = 'currenciesTestBot';
    public $hook_url = 'https://currencies-tgbot.herokuapp.com/hook';


    public function hook()
    {
        $telegram = new Api($this->api_key);

        $result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

        $text = $result["message"]["text"]; //Текст сообщения
        $chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
        $name = $result["message"]["from"]["username"]; //Юзернейм пользователя
        $keyboard = [["Котик"], ["Гифка с котиком"]]; //Клавиатура

        if($text){
            $reply = '';
            if ($text == "/start") {
                $reply = "Привет, $name! Вот список доступных команд:";
                $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
            }elseif ($text == "/help") {
                $reply = "Список доступных команд:";
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);
            }elseif ($text == "Котик") {
                $url = "https://68.media.tumblr.com/6d830b4f2c455f9cb6cd4ebe5011d2b8/tumblr_oj49kevkUz1v4bb1no1_500.jpg";
                $telegram->sendPhoto([ 'chat_id' => $chat_id, 'photo' => $url, 'caption' => "Описание." ]);
            }elseif ($text == "Гифка с котиком") {
                $url = "https://68.media.tumblr.com/bd08f2aa85a6eb8b7a9f4b07c0807d71/tumblr_ofrc94sG1e1sjmm5ao1_400.gif";
                $telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "Описание." ]);
            }else{
                $reply = "Команды \"<b>".$text."</b>\" не существует.";
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode' => 'HTML', 'text' => $reply ]);
            }
        }else {
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение." ]);
        }
    }
}
