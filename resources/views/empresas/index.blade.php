@extends('default')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Lista de Empresas</h1>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-building mr-1"></i>
                Empresas Cadastradas
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('empresas.novo') }}" class="btn btn-primary mb-3">Nova Empresa</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td>{{ $empresa->xName }}</td>
                                <td>{{ $empresa->cnpj }}</td>
                                <td>
                                    <a href="{{ route('empresas.edit', $empresa->idComp) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('empresas.destroy', $empresa->idComp) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta empresa?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection
