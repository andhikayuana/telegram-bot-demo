# Simple Telegram bot Demo
Slide at [here](http://slides.com/andhikayuana/telegram-bot#/)

## Requirements

1. Telegram
2. LAMPP/XAMPP + Composer
3. Ngrok
4. Postman

## Steps

1. Serve the server, open your terminal and type the command

```
$ git clone https://github.com/andhikayuana/telegram-bot-demo.git
$ cd /path/to/root-project
$ composer install
$ php -S localhost:9090
```

2. Ngrok tunnel

```
$ ngrok http 9090
```

3. Get domain with https from ngrok and register webhook in telegram using postman
url looks like this :
https://api.telegram.org/bot[yourtoken]/setwebhook?url=[yourwebhook]

4. Open your telegram and start give command with the bot [@prediksi_cuaca_bot]

5. Enjoy :D
