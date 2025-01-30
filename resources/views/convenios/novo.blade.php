@extends('default')
@section('content')
@php
    $convenios = App\Http\Controllers\UtilsController::getListaConvenios();

@endphp
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Convenios</h1>

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


                    <form role="form" action="{{ url('convenios/novo')}}" class="form" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>



                        <div class="form-group row">
                            <label for="idconvenio" class="col-sm-1 col-form-label">Convenio</label>
                            <div class="col-sm-3">
                                <select id="idconvenio" name="idconvenio" class="form-control">
                                    <option >Selecine</option>

                                        @foreach($convenios as $convenio)
                                        <option value="{{ $convenio->id }}" @if(old('idconvenio')==$convenio->id) {{ old('idconvenio', $convenio->id) }} @endif >{{ $convenio->descricao }}</option>
                                        @endforeach


                                </select>
                            </div>



                            <label for="data_prevista" class="col-sm-1 col-form-label">Data desejada</label>
                            <div class="col-sm-3">
                                <input type="date"  name="data_requerida" id="data_requirida" min="{{ date('Y-m-d') }}" class="form-control" required
                                       value="{{old('data_requerida') ?? date('Y-m-d') }}">
                            </div>

                            <label for="qtd" class="col-sm-1 col-form-label">Qtd</label>
                            <div class="col-sm-3">
                                <input type="number" step="0.1"  name="qtd" id="qtd"  class="form-control" required
                                       value="{{old('qtd') ?? 1}}">
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
