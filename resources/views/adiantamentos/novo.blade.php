@extends('default')
@section('content')
@php
    $perfil_adi = App\Http\Controllers\UtilsController::profile();
@endphp
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Adiantamentos</h1>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Novo Cadastros
                </div>


                <div class="card-body">

                    @if (!empty($errors->all()))
                        <div class="alert alert-danger col-lg-12">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form role="form" action="{{ url('adiantamentos/novo')}}" class="form" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                        <div class="form-group row">
                            <strong> Periodo: </strong> {{ $perfil_adi->periodo }}
                           <strong>Acumulado: </strong> R$ {{ number_format($perfil_adi->acumulado, 2, ",", ".")}}
                           <strong>Disponivel: </strong> R$ {{ number_format($perfil_adi->maximo - $perfil_adi->acumulado, 2, ",", ".")}}
                        </div>


                        <div class="form-group row">
                            <label for="valor" class="col-sm-1 col-form-label">Valor</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01" name="valor" id="valor" class="form-control" required
                                       value="{{old('valor')}}">
                            </div>



                            <label for="data_prevista" class="col-sm-1 col-form-label">Data desejada</label>
                            <div class="col-sm-5">
                                <input type="date"  name="data_requerida" id="data_requirida" min="{{ date('Y-m-d') }}" max="{{$perfil_adi->to->format('Y-m-d')}}" class="form-control" required
                                       value="{{old('data_requerida')?old('data_requerida'):''}}">
                            </div>


                        </div>




                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>

                    </form>


                </div>
            </div>
        </div>
    </main>

@endsection
