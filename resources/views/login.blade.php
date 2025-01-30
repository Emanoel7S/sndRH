<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SNDesk - Gerenciador de Atendimento ao Cliente</title>
         <link href="{{ asset ('css/styles.css') }}" rel="stylesheet" />
         <link rel="icon" type="image/x-icon" href="{{ asset ('assets/img/favicon.png') }}">

        <script src="{{ asset ('/vendor/fontawesome-free-5.13.1-web/js/all.min.js') }}" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark ">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                
                                <a class="navbar-brand" href="https://sndesk.com.br/">
                                    <img src="{{ asset ('assets/img/logo_temp5.png') }}" alt="" width="200" height="47" class="logo_login"> </a>
                                    <div class="card-header"></div>
                                    <div class="card-body">
                                    <h3 class="text-center font-weight-light my-4">Acesso ao Sistema</h3>
                                        <form  method="POST" action="{{ route('login') }}">
                        					{{ csrf_field() }}
                                            <div class="form-group">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control box_login"  name="email" id="email" type="email" placeholder="" />
                                                   @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Senha</label>
                                                <input class="form-control box_login" name="password" id="password" type="password" placeholder="" />
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Lembrar senha</label>

                                                </div>
                                            </div>
                                            <div class="text-center form-group">
                                            <button type="submit" class="btn btn-login"  style="margin-bottom: 20px">
                                                    ENTRAR
                                                </button>
                                                </br>

                                            <a class="esqueceu_senha" href="{{ route('password.request') }}">Esqueceu a senha?</a>

                                            </div>


                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; SNDesk 2022.</div>
                            <div>
                                <a href="#">Politica de Privacidade</a>
                                &middot;
                                <a href="#">Termos &amp; e Condições</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
 
        
         <script src="{{ asset ('js/jquery-3.5.1.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset ('vendor/bootstrap-4.5.0-dist/js/bootstrap.bundle.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset ('js/scripts.js') }}"></script>
      
    </body>
</html>
