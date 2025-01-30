<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Exibe o formulário de criação de usuário com as permissões.
     */
    public function create()
    {
        // Buscar todas as permissões disponíveis (ex.: apenas as ativas)
        $permissions = DB::table('system_mod')
            ->where('idStatusReg', 1) // Opcional: filtra apenas permissões ativas
            ->get();

            return view('users.novo', compact('permissions'));
        }


    public function index()
    {
            $users = User::all(); // Busca todos os usuários do banco
            return view('users.index', compact('users')); // Retorna para a view index.blade.php
        }


    /**
     * Salva o usuário e suas permissões no banco de dados.
     */
    public function store(Request $request)
    {
        // Valida os campos do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'permissions' => 'array', // Permissões opcionais (checkboxes)
        ]);

        // Insere o novo usuário na tabela 'users'
        $userId = DB::table('users')->insertGetId([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insere as permissões na tabela pivot 'users_profile_perm_mod'
        if (!empty($validated['permissions'])) {
            $permissionsData = [];
            foreach ($validated['permissions'] as $idMod) {
                $permissionsData[] = [
                    'idUser' => $userId,
                    'idMod' => $idMod,
                    'idStatusPerm' => '1', // '1' significa "Permitido"
                ];
            }

            DB::table('users_profile_perm_mod')->insert($permissionsData);
        }


        return redirect()->route('users.create')->with('success', 'Usuário cadastrado com sucesso!');
    }
}
