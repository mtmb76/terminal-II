
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Localfrio">
    <link rel="icon" href="{{URL::asset('/favicon.ico')}}">

    <title>@yield('title')</title>

    <!-- Estilos customizados para esse template -->
    <link href="{{URL::asset('/css/dashboard.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('/css/calendar-gc.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow" style="background-color: rgba(7, 42, 76, 0.936);">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-center" style="padding-left: 5px; font-weight: 700; font-size: 16px;" href="{{route('dashboard')}}"> Diálogo Diário de Segurança </a>
        <span id="time" class="p-1" style="font-size: 12px; font-weight: 100; color:azure; margin-right: 1%;"></span>
    </nav>

    @auth
        <div class="container">

            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                <span style="font-size: 10px; font-weight: 800;">Meu Dashboard</span>
                                <a class="d-flex align-items-center text-muted" href="{{route('dashboard')}}">
                                    <span data-feather="home" style="color: rgb(26, 118, 54);"></span>
                                </a>
                            </h6>

                            @if(Auth()->user()->grupo === 'admin')
                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                    <span>Administração</span>
                                    <a class="d-flex align-items-center text-muted" href="#">
                                        <span data-feather="more-horizontal"></span>
                                    </a>
                                </h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.lista') }}">
                                        <span data-feather="key"></span>
                                        Usuários
                                    </a>
                                </li>
                            @endif
                            
                            @if ( Auth()->user()->grupo === 'admin' ||
                                  Auth()->user()->grupo === 'ssma'  ||
                                  Auth()->user()->grupo === 'lider')
                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                    <span>Cadastros</span>
                                    <a class="d-flex align-items-center text-muted" href="#">
                                        <span data-feather="more-horizontal"></span>
                                    </a>
                                </h6>

                                @if ( Auth()->user()->grupo === 'admin' ||
                                      Auth()->user()->grupo === 'ssma'  )
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('tema.lista') }}">
                                            <span data-feather="paperclip"></span>
                                            Temas
                                            </a>
                                        </li>
                                @endif
                                @if ( Auth()->user()->grupo === 'admin' ||
                                      Auth()->user()->grupo === 'ssma'  ||
                                      Auth()->user()->grupo === 'lider')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('participante.lista') }}">
                                            <span data-feather="user-check"></span>
                                            Participantes
                                            </a>
                                        </li>
                                @endif
                                @if ( Auth()->user()->grupo === 'admin' ||
                                      Auth()->user()->grupo === 'ssma'  )
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('evento.lista') }}">
                                        <span data-feather="check-square"></span>
                                        Eventos
                                        </a>
                                    </li>
                                @endif

                            @endif

                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Sessão</span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span> {{Auth()->user()->grupo}}</span>
                            <span data-feather="users"></span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>@yield('user.name')</span>
                            <span data-feather="user"></span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span> @yield('user.unidade')</span>
                            <span data-feather="map-pin"></span>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Sair</span>
                            <a class="d-flex align-items-center text-muted" href="{{route('logout')}}">
                                <span data-feather="log-out" style="color: red;"></span>
                            </a>
                        </h6>
                    </div>
                </nav>
            </div>

            <div class="col col-md-10 d-none d-md-block bg-light">
                <main role="main" class="fixed-top col-md-6 pl-sm-6 col-lg-12 px-2" style="width: 83%; position: absolute; margin-left: 17%;">
                    <div class="flex-md-nowrap pt-3 pb-1 mr-6 mb-3 border-bottom">
                        <h4 class="h2">@yield('form.title')</h4>
                    </div>
                    @yield('auth.content')
                </main>
            </div>

        </div>
        @endauth

        @yield('content')


        @if($errors->any())
            <div id="popup" class="alert alert-danger fade show fixed-bottom" style="text-align: center; vertical-align: middle; font-size: 12px; width:50%; margin-left: 30%; margin-bottom: 60px; height: 50px;" role="alert">
            <strong>Atenção:&nbsp; </strong>
                    @foreach ($errors->all() as $error)
                        {{$error}}
                    @endforeach
            </div>
        @endif

        @if(! empty($sucesso) )
            <div id="popup" class="alert alert-success fade show fixed-bottom"  style="text-align: center; vertical-align: middle; font-size: 12px; width:50%; margin-left: 30%; margin-bottom: 60px; height: 50px;" role="alert">
                <strong>Sucesso:&nbsp;</strong> {{$sucesso}}
            </div>
        @endif

        @if(! empty($alerta) )
            <div id="popup" class="alert alert-warning  fade show fixed-bottom" style="text-align: center; vertical-align: middle; font-size: 12px; width:50%; margin-left: 30%; margin-bottom: 60px; height: 50px;" role="alert">
                <strong>Importante:&nbsp;</strong> {{$alerta}}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center fixed-bottom p-1 shadow" style="background-color:#ffff transparent;">
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

    <!-- Ícones -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @if( !in_array('dashboard', explode( '/', Request::url())) && !in_array('autenticar', explode( '/', Request::url()))  )
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    @endif

    <script>
        feather.replace();
        setTimeout(function() {
            $('#popup').fadeIn('slow');
            $('#popup').fadeOut('slow');
        }, 3000);

        var timeDisplay = document.getElementById("time");

        function refreshTime() {
            var dateString = new Date().toLocaleString("pt-BR", {timeZone: "America/Sao_Paulo"});
            var formattedString = dateString.replace(", ", " - ");
            timeDisplay.innerHTML = formattedString;
        }

        setInterval(refreshTime, 1000);

    </script>

  </body>
</html>
