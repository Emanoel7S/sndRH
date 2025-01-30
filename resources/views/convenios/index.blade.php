@extends('default')
@section('content')
    @include('modalremover')

    <style>
        td {
            white-space: nowrap;
        }
    </style>

    <main>
        <div class="container-fluid">


            @if (!empty($errors->all()))
                <div class="card bg-danger text-white mb-4 card mb-4" id="msg" style="padding: 5px">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif





            @if(session('acao'))
                @if(session('id'))
                    <div class="card bg-warning text-white mb-4 card mb-4" id="msg" style="padding: 5px">
                        <div class="card-body">
                            <strong>Sucesso!</strong>
                            O registro {{ session('id')  }} foi cancelado.
                        </div>

                    </div>
                @endif
            @else
                @if(session('id'))
                    <div class="card bg-success text-white mb-4 card mb-4" id="msg" style="padding: 5px">
                        <div class="card-body">
                            <strong>Sucesso! </strong>
                            O registro {{ session('id')  }} {{ session('desc')  }} foi gravado.
                        </div>
                    </div>

                @endif
            @endif
            <div class="card mb-4">
                <div class="card-header">
                    <h1 class="mt-4">Convenios</h1>

                </div>
                <div class="card-body">
                    <a href="{{ url('convenios/novo') }}" class="btn btn-primary">Novo Pedido</a>
                    <div class="table-responsive">




                        @foreach($t as $r)


                            <div class="card border-{{ $r->classcss }} mb-3">
                                <div class="card-header bg-transparent border-{{ $r->classcss }}">Pedido de convenio</div>
                                <div class="card-body text-{{ $r->classcss }}">
                                    <h5 class="card-title">Numero do pedido: {{$r->id}}</h5>
                                    <p class="card-text">
                                        <strong>Convenio: </strong> {{ $r->descricao ?? '' }}
                                        <strong> Data do pedido: </strong>{{date('d/m/Y', strtotime($r->created_at))}}
                                        <strong> Data requerida: </strong>{{date('d/m/Y', strtotime($r->data_requerida))}} </p>
                                        <p><strong> Status: </strong>{{$r->status}}</p>
                                        @if($r->aviso)<p><strong> Aviso: </strong>{{$r->aviso}}</p>@endif
                                    @if($r->idstatus=='A')
                                        <a href="#" onclick="modal('{{ url('convenios/cancel/' . $r->id) }}')" class="btn btn-warning"><i
                                                    class="fas fa-times-circle mr-1 red"></i> Cancelar Pedido</a>
                                    @endif
                                </div>
                                <div class="card-footer bg-transparent border-{{ $r->classcss }}">




                                </div>
                            </div>

                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">


        setInterval(function () {
            $('#msg').hide(); // show next div
        }, 5 * 1000); // do this every 10 seconds


    </script>
@endsection
