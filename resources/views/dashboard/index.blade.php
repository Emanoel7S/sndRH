@extends('default')
@section('content')
    <?php

    use App\Http\Controllers\UtilsController;

    ?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">DashBoard</h1>

            <div class="row">
                @if(UtilsController::getPerm(19))
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Adiantamentos</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{ url('adiantamentos') }}">Ver mais</a>
{{--                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>--}}
                            </div>
                        </div>
                    </div>
                @endif

{{--                    <div class="col-xl-3 col-md-6">--}}
{{--                        <div class="card bg-primary text-white mb-4">--}}
{{--                            <div class="card-body">Primary Card</div>--}}
{{--                            <div class="card-footer d-flex align-items-center justify-content-between">--}}
{{--                                <a class="small text-white stretched-link" href="#">View Details</a>--}}
{{--                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                @if(UtilsController::getPerm(19))
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Férias</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ url('ferias') }}">Ver mais</a>
                                    {{--                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>--}}
                                </div>
                            </div>
                        </div>
                @endif


                    @if(UtilsController::getPerm(19))
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Convênios</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ url('convenios') }}">Ver mais</a>
                                    {{--                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>--}}
                                </div>
                            </div>
                        </div>
                    @endif


            </div>
        </div>
    </main>

@endsection