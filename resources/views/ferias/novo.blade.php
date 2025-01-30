@extends('default')
@section('content')

    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Ferias</h1>

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


                    <form role="form" action="{{ url('ferias/novo')}}" class="form" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>


                        <p>Digite a data que pretender gozar das férias</p>
                        <div class="form-group row">

                            <label for="data_inicio" class="col-sm-1 col-form-label">D.Inicio</label>
                            <div class="col-sm-5">
                                <input type="date" name="data_inicio" id="data_inicio" min="{{ date('Y-m-d') }}"
                                       class="form-control" required
                                       value="{{old('data_inicio')?old('data_requerida'):''}}">
                            </div>


                            <label for="data_fim" class="col-sm-1 col-form-label">D.Fim</label>

                            <div class="col-sm-5">
                                <input type="date" name="data_fim" id="data_fim" min="{{ date('Y-m-d') }}"
                                       class="form-control" required
                                       value="{{old('data_inicio')?old('data_requerida'):''}}">
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
