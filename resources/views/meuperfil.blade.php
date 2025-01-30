@extends('default')
@section('content')
    <?php

    use App\Http\Controllers\UtilsController;
    $perfil_adi = App\Http\Controllers\UtilsController::profile();

    ?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Meu Perfil</h1>

            <div class="card-body">
                @if(UtilsController::getPerm(19))


                    <div class="card border-secondary mb-3">
                        <div class="card-header">Adiantamento</div>
                        <div class="card-body text-secondary">
                            <h5 class="card-title">Limites</h5>
                            <p class="card-text"><strong>Valor Minimo: </strong> R$ {{ number_format($perfil_adi->minimo, 2, ",", ".")}}</p>
                            <p class="card-text"><strong>Valor Máximo: </strong> R$ {{ number_format($perfil_adi->maximo, 2, ",", ".")}}</p>
                            <p class="card-text"><strong>Dia Base: </strong> {{ $perfil_adi->diabase }}</p>
                            <p class="card-text"><strong>Periodo: </strong> {{ $perfil_adi->periodo }}</p>
                            <p class="card-text"><strong>Acumulado: </strong> R$ {{ number_format($perfil_adi->acumulado, 2, ",", ".")}}</p>
                            <p class="card-text"><strong>Disponivel: </strong> R$ {{ number_format($perfil_adi->maximo - $perfil_adi->acumulado, 2, ",", ".")}}</p></div>
                    </div>


                @endif

                @if(UtilsController::getPerm(21))
                        <div class="card bg-light mb-3" >
                            <div class="card-header">Header</div>
                            <div class="card-body">
                                <h5 class="card-title">Light card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                @endif


            </div>
        </div>
    </main>

@endsection