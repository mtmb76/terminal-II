<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta name="description" content="">
            <meta name="author" content="Localfrio">
            <title>@yield('title')</title>
            <link href="{{URL::asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
            <link href="{{URL::asset('/css/dashboard.css')}}" rel="stylesheet" type="text/css">
        </head>
        <body style="font-family: Arial, Helvetica, sans-serif">
            <div class="container mt-5">
                <h2 class="text-center mb-3">@yield('titulo')</h2>

                @yield('content')

            </div>
            <script src="{{URL::asset('/js/bootstrap.bundle.min.js')}}"></script>

            <div class="d-flex justify-content-between align-items-center fixed-bottom p-1 shadow" style="background-color:#ffff;">
                <div class="row w-100">
                    <div class="col">
                    </div>
                    <div class="col text-center">
                        <span style="font-size: 12px; color: rgba(7, 42, 76, 0.936);">Grupo Localfrio &copy; - Todos os direitos reservados - 2023</span>
                    </div>
                    <div class="col">
                    </div>
                </div>
            </div>

        </body>
    </html>
