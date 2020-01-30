<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Png</title>
        {{--  --}}
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    
        <style>
            body {
                margin: 0;
                padding: 0;
            }
            .png {
                height: 100vh;
                width: 100vw;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
    </head>
    <body>
        <div class="png">
           <img src="/assets/{{ $id }}.png" alt="png">
        </div>
    </body>
</html>
