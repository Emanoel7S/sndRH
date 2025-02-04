<?php

use App\Http\Controllers\UtilsController;

?>
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>


    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset ('assets/img/favicon.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>SndRH</title>
    <link href="{{ asset ('css/styles.css') }}" rel="stylesheet"/>
    <script src="{{ asset ('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset ('vendor/fontawesome-free-5.13.1-web/js/all.min.js') }}"></script>

    <link rel="icon" type="image/x-icon" href="{{ asset ('assets/img/favicon.png') }}">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
          rel="stylesheet">
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">


    <a class="navbar-brand" href="#">
        <img src="{{ asset ('assets/img/logo_temp5.png') }}" alt="" width="200" height="47"
             class="d-inline-block align-text-top">

    </a>

    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search-->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>


    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">


        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i>
                <span>{{ Auth::user()->name }}</span></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="nav-link" href="{{ url('meuperfil') }}">

                    <i class="fas fa-user"></i>

                    Meu Perfil
                </a>
                <a class="dropdown-item" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu" style="margin-bottom: 10px;">
                <div class="nav">

{{--                    <a class="nav-link mt-3" href="{{ url('find')}}">--}}
{{--                        <div class="sb-nav-link-icon"><i class="bi bi-search" style="font-size: 1.2rem; "></i></div>--}}
{{--                        Pesquisar--}}
{{--                    </a>--}}


                    <div class="sb-sidenav-menu-heading">Menu</div>

                    <a class="nav-link" href="{{ url('/') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"
                                                         style="font-size: 1.2rem;"></i></div>
                        Dashboard</a>


                    @if(UtilsController::getPerm(19))
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCadastros"
                        aria-expanded="false" aria-controls="collapseCadastros">
                            <div class="sb-nav-link-icon">
                                <i class="bi-journal-text" style="font-size: 1.2rem;"></i>
                            </div>
                            Cadastros
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down" style="font-size: 1.2rem;"></i>
                            </div>
                        </a>
                        <div class="collapse" id="collapseCadastros" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">

                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmpresas"
                                aria-expanded="false" aria-controls="collapseEmpresas">
                                    <div class="sb-nav-link-icon">
                                        <i class="bi bi-building" style="font-size: 1.2rem;"></i>
                                    </div>
                                    Empresas
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down" style="font-size: 1.2rem;"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseEmpresas" aria-labelledby="headingOne" data-parent="#collapseCadastros">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub-nav-link" href="{{ url('empresas/novo') }}">
                                            <div class="sb-nav-link-icon">
                                                <i class="bi bi-plus-circle" style="font-size: 1.2rem;"></i>
                                            </div>
                                            Nova Empresa
                                        </a>
                                        <a class="nav-link sub-nav-link" href="{{ url('empresas') }}">
                                            <div class="sb-nav-link-icon">
                                                <i class="bi bi-list-ul" style="font-size: 1.2rem;"></i>
                                            </div>
                                            Lista de Empresas
                                        </a>
                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
                                aria-expanded="false" aria-controls="collapseUsuarios">
                                    <div class="sb-nav-link-icon">
                                        <i class="bi bi-people" style="font-size: 1.2rem;"></i>
                                    </div>
                                    Usuários
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down" style="font-size: 1.2rem;"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseUsuarios" aria-labelledby="headingOne" data-parent="#collapseCadastros">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub-nav-link" href="{{ url('users/novo')}}">
                                            <div class="sb-nav-link-icon">
                                                <i class="b-nav-link-icon bi bi-person-plus-fill" style="font-size: 1.2rem;"></i>
                                            </div>
                                            Novo Usuário
                                        </a>
                                        <a class="nav-link sub-nav-link" href="{{ url('users')}}">
                                            <div class="sb-nav-link-icon">
                                                <i class="b-nav-link-icon bi bi-person-lines-fill" style="font-size: 1.2rem;"></i>
                                            </div>
                                            Lista de Usuários
                                        </a>
                                    </nav>
                                </div>


                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCargos"
                                aria-expanded="false" aria-controls="collapseCargos">
                                    <div class="sb-nav-link-icon">
                                        <i class="bi bi-briefcase-fill" style="font-size: 1.2rem;"></i>
                                    </div>
                                    Cargos
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down" style="font-size: 1.2rem;"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="collapseCargos" aria-labelledby="headingOne" data-parent="#collapseCadastros">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub-nav-link" href="{{ url('cargos/novo')}}">
                                            <div class="sb-nav-link-icon">
                                                <i class="b-nav-link-icon bi bi-plus-square-fill" style="font-size: 1.2rem;"></i>
                                            </div>
                                            Novo Cargo
                                        </a>
                                        <a class="nav-link sub-nav-link" href="{{ url('cargos')}}">
                                            <div class="sb-nav-link-icon">
                                                <i class="b-nav-link-icon bi bi-list-task" style="font-size: 1.2rem;"></i>
                                            </div>
                                            Lista de Cargos
                                        </a>
                                    </nav>
                                </div>

                            </nav>
                        </div>
                    @endif


                    @if(UtilsController::getPerm(19))
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMyCall"
                            aria-expanded="false" aria-controls="collapseMyCall">
                                <div class="sb-nav-link-icon">
                                    <i class="bi bi-bookmark-heart" style="font-size: 1.2rem;"></i>
                                </div>
                                Adiantamentos
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down" style="font-size: 1.2rem;"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseMyCall" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link sub-nav-link" href="{{ url('adiantamentos/novo')}}">
                                        <div class="sb-nav-link-icon">
                                            <i class="b-nav-link-icon bi bi-bookmark-heart-fill" style="font-size: 1.2rem;"></i>
                                        </div>
                                        Novo
                                    </a>
                                    <a class="nav-link sub-nav-link" href="{{ url('adiantamentos')}}">
                                        <div class="sb-nav-link-icon">
                                            <i class="b-nav-link-icon bi bi-bookmark-check-fill" style="font-size: 1.2rem;"></i>
                                        </div>
                                        Lista
                                    </a>
                                </nav>
                            </div>
                    @endif


                    @if(UtilsController::getPerm(19))
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMyCall2"
                           aria-expanded="false"
                           aria-controls="collapseMyCall2">
                            <div class="sb-nav-link-icon"><i class="bi bi-bookmark-heart"
                                                             style="font-size: 1.2rem;"></i>
                            </div>
                            Ferias
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"
                                                                      style="font-size: 1.2rem;"></i></div>
                        </a>
                        <div class="collapse" id="collapseMyCall2" aria-labelledby="headingOne"
                             data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link sub-nav-link" href="{{ url('ferias/novo')}}">
                                    <div class="sb-nav-link-icon"><i class="b-nav-link-icon bi bi-bookmark-heart-fill"
                                                                     style="font-size: 1.2rem;"></i>
                                    </div>
                                    Novo</a>
                                <a class="nav-link sub-nav-link" href="{{ url('ferias')}}">
                                    <div class="sb-nav-link-icon"><i class="b-nav-link-icon bi bi-bookmark-check-fill"
                                                                     style="font-size: 1.2rem;"></i>
                                    </div>
                                    Lista</a>
                            </nav>
                        </div>

                    @endif

                    @if(UtilsController::getPerm(19))
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTicket"
                           aria-expanded="false"
                           aria-controls="collapseTicket">
                            <div class="sb-nav-link-icon"><i class="bi bi-bookmark-heart"
                                                             style="font-size: 1.2rem;"></i>
                            </div>
                            Convênios
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"
                                                                      style="font-size: 1.2rem;"></i></div>
                        </a>
                        <div class="collapse" id="collapseTicket" aria-labelledby="headingOne"
                             data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link sub-nav-link" href="{{ url('convenios/novo')}}">
                                    <div class="sb-nav-link-icon"><i class="b-nav-link-icon bi bi-bookmark-heart-fill"
                                                                     style="font-size: 1.2rem;"></i>
                                    </div>
                                    Novo</a>
                                <a class="nav-link sub-nav-link" href="{{ url('convenios')}}">
                                    <div class="sb-nav-link-icon"><i class="b-nav-link-icon bi bi-bookmark-check-fill"
                                                                     style="font-size: 1.2rem;"></i>
                                    </div>
                                    Lista</a>
                            </nav>
                        </div>
                    @endif


                    <a class="nav-link" href="{{ url('meuperfil') }}">

                        <div class="sb-nav-link-icon"><i class="fas fa-user" style="font-size: 1.2rem;"></i>
                        </div>
                        Meu Perfil
                    </a>

                    <a class="nav-link" href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt" style="font-size: 1.2rem;"></i>
                        </div>
                        Logout
                    </a>


                </div>
            </div>


            <div class="sb-sidenav-footer">
                <a style="cursor: pointer" data-toggle="modal" data-target="#modalResponsive"> <i class="bi bi-git"></i>
                    Versão 0.4.1a</a>
                <!--  <div class="small">Logado como: {{ Auth::user()->username }}</div>-->
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        @yield('content')
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SNDesk - Feito com <i class="bi bi-heart-fill"></i> em
                        Itapetininga.
                    </div>
                    <div>
                        <a href="https://sonodaponto.com.br/politica-de-privacidade-sonoda-ponto/">Política de
                            Privacidade</a>
                        &middot;
                        <a href="https://sonodaponto.com.br/politica-de-privacidade-sonoda-ponto/">Termos e
                            Condições</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="{{ asset ('vendor/bootstrap-4.5.0-dist/js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset ('js/scripts.js') }}"></script>


<!-- MODAL -------------------------------------------------------------------------------------------------- -->


<!-- MODAL PADRÃO -->
<!-- Modelo: MODAL RESPONSIVE  -->
<!-- data-toggle="modal" data-target="#modalResponsive" -->
<!-- id content ajax: "#modalResponsive .modal-content" -->
<div id="modalResponsive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Content  -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="bi bi-git"></i> Atualizações do Sistema  <!-- title  --> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-res">
                <div class="modal-body">
                    <!--------------------------------------------------------------------------------------------- LINHA VERSÃO -->
                    <div class="col-dm-12">
                        <div class="row header-chamado" style="justify-content: center;">
                            <span class="titulochamado" style="padding-left: 0; "><i class="bi bi-arrow-clockwise"></i>Versão 0.4.1-alpha</span>
                        </div>
                        <div class="form-group row optionchamado" style="display:flex; align-items: center;">
                            <label class="statuschamadotexto" style="text-align:right; margin-top: 5px"> O que há de
                                novo</label>
                            <label class="form-chamado">Aumentado máximo de caracter para descrição de chamado e
                                interação.</label>
                            <label class="form-chamado">Corrigido bug que entruncava a lista de técnicos na edição do
                                chamado.</label>

                        </div>
                        <!---------------------------------------------------------------------------------------------  -->
                        <!--------------------------------------------------------------------------------------------- LINHA VERSÃO -->
                        <div class="col-dm-12">
                            <div class="row header-chamado" style="justify-content: center;">
                                <span class="titulochamado" style="padding-left: 0; "><i
                                            class="bi bi-arrow-clockwise"></i>Versão 0.4-alpha</span>
                            </div>
                            <div class="form-group row optionchamado" style="display:flex; align-items: center;">
                                <label class="statuschamadotexto" style="text-align:right; margin-top: 5px"> O que há de
                                    novo</label>
                                <label class="form-chamado">Adicionado controle de Versão.</label>
                                <label class="form-chamado">Adicionado status de contrato e situação financeira no
                                    chamado e
                                    na criação.</label>
                                <label class="form-chamado">Melhora visual na página de edição e iteração do chamado
                                    entre
                                    outros.</label>
                                <label class="form-chamado">Adicionado logo da empresa no topo superior
                                    esquerdo.</label>
                                <label class="form-chamado">Removido Breadcrumb.</label>
                                <label class="form-chamado">Removido bug criação de agenda alertar sobre ja ter agenda,
                                    sem
                                    ter agenda alguma.</label>
                                <label class="form-chamado">Ao cancelar agenda, o registro ficará em vermelho no
                                    chamado.</label>

                            </div>
                            <!---------------------------------------------------------------------------------------------  -->

                            <div class="small">Laravel: {{ App::VERSION() }} PHP: {{  phpversion() }}</div>
                        </div>
                    </div>

                    <!-- END Content  -->
                </div>
            </div>
        </div>
    </div>

    <script>
        //data-dismiss="modal"
        $(function () {
            $('#modalResponsive').on('hide.bs.modal', function () {
                setTimeout(function () {
                    var cache = $('#modalcache').html();
                    $('#modalExtraLarge .modal-content').html(cache);
                }, 400);
            });
        });
    </script>

    <script src="{{ asset('/sw.js') }}"></script>
    <script>

        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            deferredPrompt = e;
        });

        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
</body>

</html>
