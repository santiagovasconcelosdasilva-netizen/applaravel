<?php

namespace App\Http\Controllers;

use App\Models\Localidade;
use Illuminate\Http\Request;

class LocalidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pesquisa = $request->query('pesquisa');
        
        $query = Localidade::withCount('contactos');
        
        if ($pesquisa) {
            $query->where('nome', 'like', $pesquisa . '%')
                  ->orWhere('localidade', 'like', $pesquisa . '%');
        }
        
        $localidades = $query->get();

        return view('localidades.index', compact('localidades', 'pesquisa'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return view('localidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         Localidade::create([
        'nome' => $request->nome,
        'localidade' => $request->nome,
        'ativa' => true,
        ]);

        return redirect()->route('localidades.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Localidade $localidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localidade $localidade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Localidade $localidade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localidade $localidade)
    {
        $localidade->delete();
        
        return redirect()->route('localidades.index')->with('success', 'Localidade eliminada com sucesso!');
    }
}
