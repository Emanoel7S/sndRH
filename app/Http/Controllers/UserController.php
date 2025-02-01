<?php

namespace App\Http\Controllers;

use App\Models\Profile;
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
        $comps = DB::table('comp')->where('idStatusReg', 1)->get();
//        dd($comp);
        return view('users.novo', compact('permissions', 'comps'));        }


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
//        dd($request->all());
        // Valida os campos do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'permissions' => 'array', // Permissões opcionais (checkboxes)
            'comp_id' => 'required|integer|exists:comp,idComp', // Adiciona a validação para comp_id

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

        // Preenche a tabela 'users_profile' com o 'idUser' do novo usuário
        $profileId = DB::table('users_profile')->insertGetId([
            'idUser' => $userId,
            'idComp' => $validated['comp_id'], // Defina o valor padrão que deve ser usado, se necessário
            'idManager' => null, // Ou o valor desejado, como 'null' ou um id de manager específico
            'idGroup' => 2, // Ou outro valor dependendo da lógica de grupos
            'themesContentHref' => null, // Ou o valor desejado, se aplicável
            'themesSidebarHref' => null, // Ou o valor desejado, se aplicável
            'idStatusAppearance' => 2, // Exemplo de valor, ajuste conforme necessário
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        return redirect()->route('users.create')->with('success', 'Usuário cadastrado com sucesso!');
    }


    public function edit($id) {
        // Busca o usuário pelo ID e mostra suas informacoes
        $user = User::find($id); // Busca o usuário pelo ID
        $permissions = DB::table('system_mod')->get(); // Busca todas as permissões disponíveis
        $userPermissions = DB::table('users_profile_perm_mod')
            ->where('idUser', $id)
            ->pluck('idMod')
            ->all(); // Busca as permissões do usuário
        $comps = DB::table('comp')->where('idStatusReg', 1)->get();
//        dd($permissions);
        $idComp = Profile::idComp();
//        dd($idComp);
        return view('users.edit', compact('user', 'permissions', 'userPermissions', 'comps', 'idComp'));
    }


}
