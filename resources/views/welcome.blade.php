<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Silingan</title>

       
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
    </body>
</html>
