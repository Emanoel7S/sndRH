<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Importando o modelo User
use Validator;

class FuncionarioController extends Controller
{
    /**
     * Exibe a lista de usuários ativos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtém todos os usuários ativos (idStatusReg = 1)
        $usuarios = User::where('idStatusReg', 1)->get(); // 1 = ativo

        // Passa os dados para a view
        return view('funcionarios.index', compact('usuarios'));
    }


    /**
     * Exibe o formulário para criar um novo funcionário.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('funcionarios.novo');
    }

    /**
     * Armazena um novo usuário no banco de dados.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'idStatusReg' => 'required|boolean', // idStatusReg será 1 para ativo, 2 para inativo
        ]);

        // Cria o novo usuário
        $usuario = new User();
        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->password = bcrypt($validated['password']);
        $usuario->idStatusReg = $validated['idStatusReg'];
        $usuario->save();

        // Redireciona com sucesso
        return redirect()->route('funcionarios.index')->with('id', $usuario->id)->with('desc', 'gravado')->with('acao', 'sucesso');
    }

    /**
     * Cancela a ativação de um usuário (desativa o usuário).
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelar($id)
    {
        // Busca o usuário pelo ID
        $usuario = User::findOrFail($id);

        // Marca o usuário como inativo
        $usuario->idStatusReg = 2; // 2 = inativo
        $usuario->save();

        // Redireciona com sucesso
        return redirect()->route('funcionarios.index')->with('id', $usuario->id)->with('desc', 'desativado')->with('acao', 'sucesso');
    }
}
