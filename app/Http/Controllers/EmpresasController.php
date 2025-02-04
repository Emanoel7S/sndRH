<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa; // Certifique-se de que tem um Model Empresa

class EmpresasController extends Controller
{
    // Listar todas as empresas
    public function index()
    {
        $empresas = Empresa::all(); // Busca todas as empresas do banco
        return view('empresas.index', compact('empresas'));
    }

    // Mostrar o formulário de criação de nova empresa
    public function create()
    {
        return view('empresas.novo');
    }
// app/Http/Controllers/EmpresasController.php

public function destroy($id)
{
    // Encontrar a empresa pelo ID
    $empresa = Empresa::findOrFail($id);

    // Excluir a empresa
    $empresa->delete();

    // Redirecionar de volta com uma mensagem de sucesso
    return redirect()->route('empresas.index')->with('success', 'Empresa excluída com sucesso!');
}

    // Armazenar a nova empresa no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|unique:empresas,cnpj|max:14',
        ]);

        Empresa::create([
            'nome' => $request->nome,
            'cnpj' => $request->cnpj,
        ]);

        return redirect()->route('empresas.index')->with('success', 'Empresa cadastrada com sucesso!');
    }
}
