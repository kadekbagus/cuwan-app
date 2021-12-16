<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>Product List</title>

    </head>
    <body>
        <div id="app">
            <Productlist/>
        </div>
    </body>
    
    <script src="{{ mix('js/app.js') }}"></script> 
</html>