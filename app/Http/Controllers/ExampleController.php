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
        $bot = new Api($this->api_key);

        $updates = $bot->getWebhookUpdates();

        $update = $bot->commandsHandler(true);

        // Commands handler method returns an Update object.
        // So you can further process $update object
        // to however you want.

        return 'ok';
    }
}
