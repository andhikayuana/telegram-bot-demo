<?php

/**
 * Simple Telegram Bot Webhook Demo
 *
 * @author Yuana <andhikayuana@gmail.com>
 * @since May, 13 2017
 *
 * Requirements :
 *
 * 1. Telegram
 * 2. LAMPP/XAMPP + Composer
 * 3. Ngrok
 * 4. Postman
 *
 * Steps :
 *
 * 1. serve the server, open your terminal and type the command
 *
 * ```
 * $ git clone https://github.com/andhikayuana/telegram-bot-demo.git
 * $ cd /path/to/root-project
 * $ composer install
 * $ php -S localhost:9090
 * ```
 *
 * 2. ngrok tunnel
 * ```
 * $ ngrok http 9090
 * ```
 *
 * 3. get domain with http from ngrok and register webhook in telegram using postman
 *    url looks like this :
 *    https://api.telegram.org/bot311513566:AAHvyO8aAvjxMwmSC4bhGILXL1X6wNHdGZQ/setwebhook?url=https://e1528f0a.ngrok.io
 *
 * 4. open your telegram and start give command with the bot [@prediksi_cuaca_bot]
 *
 */

require_once 'vendor/autoload.php';
require_once 'Curl.php';

use \TelegramBot\Api\Client;
use \TelegramBot\Api\Exception;

const BOT_TOKEN = '311513566:AAHvyO8aAvjxMwmSC4bhGILXL1X6wNHdGZQ';

const WEATHERBIT_KEY = '692c89dfdca745538c8477a4ee1c2c4d';
const WEATHERBIT_ENDPOINT = 'https://api.weatherbit.io/v1.0/current/geosearch';

try {

    $bot = new Client(BOT_TOKEN);
    $curl = new Curl();

    $bot->command('start', function($message) use($bot) {
        $answer = 'Halo! Saya Prediksi cuaca, silakan gunakan perintah /help untuk mendapatkan panduannya :D';
        $bot->sendMessage($message->getChat()->getId(), $answer, null, false, $message->getMessageId());
    });

    $bot->command('help', function($message) use($bot) {
        $answer = 'Untuk mendapatkan cuaca sekarang dengan menggunakan perintah `/cuaca [kota]`, contoh : `/cuaca Yogyakarta`';
        $bot->sendMessage($message->getChat()->getId(), $answer, null, false, $message->getMessageId());
    });

    $bot->command('cuaca', function($message) use($bot, $curl) {

        if (preg_match('/[^\/cuaca\s]\w+/', $message->getText(), $matches) === 1) {

            $city = $matches[0];

            $response = $curl->get(WEATHERBIT_ENDPOINT, [
                'key'       => WEATHERBIT_KEY,
                'city'      => $city,
                'country'   => 'id',
                'lang'      => 'id'
            ]);

            $data = json_decode($response)->data;
            $weather = $data[0]->weather->description;

            $answer = 'Cuaca ' . $city . ' sekarang : ' . $weather;
            $bot->sendMessage($message->getChat()->getId(), $answer, null, false, $message->getMessageId());

        } else {

            $answer = 'perintah /cuaca harus diikuti dengan kota ya, contoh : `/cuaca yogyakarta`';
            $bot->sendMessage($message->getChat()->getId(), $answer, null, false, $message->getMessageId());
        }
    });

    $bot->run();

} catch(Exception $e) {
    $e->getMessage();
}
