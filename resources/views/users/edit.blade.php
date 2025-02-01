@extends('default')
@section('content')

    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Editar Usuário</h1>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-edit mr-1"></i>
                    Editar Cadastro
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.edit', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <small class="form-text text-muted">Deixe em branco para manter a senha atual.</small>
                        </div>

                        <div class="form-group">
                            <label for="date_add">Data de Admissão:</label>
                            <input type="date" name="date_add" id="date_add" class="form-control" value="{{ old('date_add', $user->date_add) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="job_title">Cargo:</label>
                            <select name="job_title" id="job_title" class="form-control">
                                <option value="">Selecione um Cargo</option>
                                <!-- As opções de cargo serão preenchidas dinamicamente aqui -->
                            </select>
                        </div><br>

                        <div class="form-group">
                            <h3>Permissões</h3>
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->idMod }}"
                                        class="form-check-input"
                                        {{ in_array($permission->idMod, $userPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $permission->xName }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- View: resources/views/users/edit.blade.php -->
                        <div class="form-group">
                            <h3>Empresas</h3>
                            <select name="comp_id" id="comp_id" class="form-control" required>
                                <option value="">Selecione uma Empresa</option>
                                @foreach ($comps as $comp)
                                    <option value="{{ $comp->idComp }}" {{ old('comp_id', $idComp) == $comp->idComp ? 'selected' : '' }}>
                                        {{ $comp->xName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection
