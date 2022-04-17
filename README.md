# Silingan App

## development

1. git clone https://github.com/ufwahua/Silingan.git
2. composer require pusher/pusher-php-server
3. composer require laravel/nexmo-notification-channel nexmo/laravel
4. php artisan vendor:publish
5. choose number that has Nexmo\Laravel\NexmoServiceProvider
6. configure .env of your database
7. php artisan migrate:fresh --seed
8. npm install

### run development

1. npm run watch
2. php artisan serve
