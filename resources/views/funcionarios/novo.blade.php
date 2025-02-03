@extends('default')
@section('content')
    <main>
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header">
                    <h1 class="mt-4">Cadastrar Novo Funcionário</h1>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('funcionarios/novo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cargo">Cargo</label>
                            <input type="text" name="cargo" id="cargo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ativo">Ativo</label>
                            <select name="ativo" id="ativo" class="form-control">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
