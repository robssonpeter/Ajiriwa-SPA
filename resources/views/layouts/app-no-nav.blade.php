<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! SEOMeta::generate() !!}
        {!! OpenGraph::generate() !!}
        @if(!JsonLd::isEmpty())
        {!! JsonLd::generate() !!}
        @endif
        @if(!JsonLdMulti::isEmpty())
        {!! JsonLdMulti::generate() !!}
        @endif
        {!! Twitter::generate() !!}

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <style>
            div.description li {
                list-style-type: circle;
                list-style-position: outside;
                margin-left: 20px;

                /*margin-inside: 10px;*/

            }

            div.description li::before {
                color: mediumseagreen;
            }

            div.description h1{
                font-size: xx-large;
                font-weight: bold;
                margin-top: 10px;
            }
            div.description h2{
                font-size: x-large;
                font-weight: bold;
                margin-top: 8px
            }
            div.description h3{
                font-size: large;
                font-weight: bold;
            }
            div.description h4{
                margin-top: 8px;
            }
            div.description h5{
                margin-top: 8px;
            }
            .w-24 {
                width: 6rem !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100" id="app">
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
