<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div style="background:#343a40 ; color:#fff; min-height:80px;" class="mb-3">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col">
                        <img src="{{ asset('logo.png') }}" alt="Logo" height="100" 
                            style="float:left; margin:20px 20px 20px 0;">
                        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" 
                                data-target="#navbarNav" aria-controls="navbarNav" 
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </nav>
                    </div>
                    
                    <div class="col col-lg-3 col-md-3 p-3">
                        @if (auth()->guest())
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <p>
                                <input type="text" name="email" class="form-control" 
                                    placeholder="E-mail" required 
                                    style="background:#343a40 ; border:1px solid #666; color:#aaa;">
                            </p>
                            <p>
                                <input type="password" name="password" class="form-control" 
                                    placeholder="Senha" required 
                                    style="background:#343a40 ; border:1px solid #666; color:#aaa;">
                            </p>
                            <p>
                                <span class="float-left">
                                    <a href="{{ route('password.request') }}" style="color:#aaa;">Esqueci a senha</a>
                                </span>
                                <span class="float-right">
                                    <button type="submit" class="btn btn-secondary">Entrar</button>
                                </span>
                            </p>
                        </form>
                        @else
                        <div class="text-right">
                            <p>Olá <b>{{ auth()->user()->name }}</b></p>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <p>
                                    <button type="submit" class="btn btn-secondary btn-sm">Sair</button>
                                </p>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container">

            <div class="row justify-content-md-center">
                <div class="col col-lg-2 col-md-2 mt-3">
                    
                    <p>
                        <a href="{{ url('/') }}">Inicio</a>
                    </p>
                    <p>
                        <a href="#">Serviços</a>
                    </p>
                    <p>
                        <a href="#">Preços</a>
                    </p>
                    <p>
                        <a href="#">Contato</a>
                    </p>

                    @if (auth()->user())
                    @can ('admin', auth()->user())
                    <hr>
                    <p>
                        <a href="{{ route('users.index') }}">Arquitetos</a>
                    </p>
                    <p>
                        <a href="{{ route('projects.index') }}">Projetos enviados</a>
                    </p>
                    @endcan
                    @can ('architect', auth()->user())
                    <hr>
                    <p>
                        <a href="{{ route('projects.index') }}">Meus projetos</a>
                    </p>
                    <p>
                        <a href="#">Dados comerciais</a>
                    </p>
                    @endcan
                    @endif

                </div>
                <div class="col">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>

            <hr>

            <p class="text-right">
                Texto do rodapé 2018.
            </p>

        </div>

    </div>

    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>

        (function( $ ) {
            $(function() {
                $('.date').mask('11/11/1111');
                $('.time').mask('00:00:00');
                $('.date_time').mask('00/00/0000 00:00:00');
                $('.cep').mask('00000-000');
                $('.phone_with_ddd').mask('(00) 0000-0000');
                $('.cpf').mask('000.000.000-00', {reverse: true});
                $('.money').mask('000.000.000.000.000,00', {reverse: true});
                $('.numbers_only').mask('####000000');
            });
        })(jQuery);

        function deleteImage(id, el) {
            $('#edit_project').append(`
                <input type="hidden" name="deleted_images[]" value="`+ id +`">
            `);
            el.parent().parent().remove();
            $('.warning-message').show();
        }

    </script>
</body>
</html>
