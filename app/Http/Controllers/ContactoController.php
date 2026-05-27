<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactoController extends Controller
{
    public function index(): View
    {
        $databaseReady = true;

        try {
            $this->ensureContactoColumnsExist();
            $contactos = Contacto::orderByRaw('LOWER(nome) ASC')->get();
        } catch (QueryException $exception) {
            $contactos = new Collection();
            $databaseReady = false;
        }

        return view('contactos.index', compact('contactos', 'databaseReady'));
    }

    public function create(): View
    {
        return view('contactos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $this->ensureContactoColumnsExist();

        Contacto::create($this->dataForDatabase($validated));

        return redirect()
            ->route('contactos.index')
            ->with('success', 'Contacto criado com sucesso.');
    }

    public function show(Contacto $contacto): View
    {
        return view('contactos.show', compact('contacto'));
    }

    public function edit(Contacto $contacto): View
    {
        return view('contactos.edit', compact('contacto'));
    }

    public function update(Request $request, Contacto $contacto): RedirectResponse
    {
        $validated = $request->validate($this->rules($contacto));

        $this->ensureContactoColumnsExist();

        $contacto->update($this->dataForDatabase($validated));

        return redirect()
            ->route('contactos.index')
            ->with('success', 'Contacto atualizado com sucesso.');
    }

    public function destroy(Contacto $contacto): RedirectResponse
    {
        $contacto->delete();

        return redirect()
            ->route('contactos.index')
            ->with('success', 'Contacto apagado com sucesso.');
    }

    private function rules(?Contacto $contacto = null): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'alcunha' => ['nullable', 'string', 'max:255'],
            'telemovel' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('contactos', 'email')->ignore($contacto),
            ],
            'localidade' => ['required', 'string', 'max:255'],
            'observacoes' => ['nullable', 'string'],
        ];
    }

    private function dataForDatabase(array $validated): array
    {
        $data = $validated;
        $data['observacoes'] = $validated['observacoes'] ?? '';

        if (Schema::hasColumn('contactos', 'tema')) {
            $data['tema'] = $validated['localidade'];
        }

        if (Schema::hasColumn('contactos', 'mensagem')) {
            $data['mensagem'] = $data['observacoes'];
        }

        return $data;
    }

    private function ensureContactoColumnsExist(): void
    {
        if (! Schema::hasTable('contactos')) {
            return;
        }

        Schema::table('contactos', function (Blueprint $table) {
            if (! Schema::hasColumn('contactos', 'alcunha')) {
                $table->string('alcunha')->nullable();
            }

            if (! Schema::hasColumn('contactos', 'localidade')) {
                $table->string('localidade')->nullable();
            }

            if (! Schema::hasColumn('contactos', 'observacoes')) {
                $table->text('observacoes')->nullable();
            }

            if (! Schema::hasColumn('contactos', 'tema')) {
                $table->string('tema')->nullable();
            }
        });
    }
}
