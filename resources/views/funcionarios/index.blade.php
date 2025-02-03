@extends('default')

@section('content')
    <main>
        <div class="container-fluid">
            @if(session('acao'))
                <div class="alert alert-success">
                    O registro {{ session('id') }} foi {{ session('desc') }} com sucesso!
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h1 class="mt-4">Lista de Funcionários</h1>
                </div>
                <div class="card-body">
                    <a href="{{ route('funcionarios.create') }}" class="btn btn-primary mb-3">Novo Funcionário</a>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Ativo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($funcionarios as $funcionario)
                                    <tr>
                                        <td>{{ $funcionario->id }}</td>
                                        <td>{{ $funcionario->nome }}</td>
                                        <td>{{ $funcionario->email }}</td>
                                        <td>{{ $funcionario->ativo ? 'Sim' : 'Não' }}</td>
                                        <td>
                                            <!-- Botão de desativar -->
                                            @if($funcionario->ativo)
                                                <a href="{{ url('funcionarios/cancel/' . $funcionario->id) }}" class="btn btn-warning btn-sm">
                                                    Desativar
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
