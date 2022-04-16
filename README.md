# Silingan App

## development

1. git clone https://github.com/ufwahua/Silingan.git
2. npm install
3. composer require pusher/pusher-php-server
4. composer require laravel/nexmo-notification-channel nexmo/laravel
5. php artisan vendor:publish
6. choose number that has Nexmo\Laravel\NexmoServiceProvider
7. configure .env of your database
8. php artisan migrate:fresh --seed

### run development

1. npm run watch
2. php artisan serve
