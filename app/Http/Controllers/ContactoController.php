<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Localidade;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactoController extends Controller
{
    public function index(Request $request): View
    {
        $databaseReady = true;
        $pesquisa = trim((string) $request->query('pesquisa', ''));
        $grupo = trim((string) $request->query('grupo', ''));

        try {
            $this->ensureContactoColumnsExist();
            $contactos = Contacto::query()
                ->with('localidadeRegisto')
                ->when($pesquisa !== '', function ($query) use ($pesquisa) {
                    $query->where('nome', 'like', $pesquisa . '%');
                })
                ->when($grupo !== '', function ($query) use ($grupo) {
                    $query->where('grupo', $grupo);
                })
                ->orderByRaw('LOWER(nome) ASC')
                ->get();
        } catch (QueryException $exception) {
            $contactos = new Collection();
            $databaseReady = false;
        }

        return view('contactos.index', compact('contactos', 'databaseReady', 'pesquisa', 'grupo'));
    }

    public function groups(): View
    {
        $this->ensureContactoColumnsExist();

        $labels = $this->grupoLabels();
        $counts = Contacto::query()
            ->selectRaw('grupo, count(*) as total')
            ->whereNotNull('grupo')
            ->where('grupo', '!=', '')
            ->groupBy('grupo')
            ->pluck('total', 'grupo')
            ->toArray();

        return view('contactos.groups', [
            'grupos' => $labels,
            'counts' => $counts,
        ]);
    }

    private function grupoLabels(): array
    {
        return [
            'amigos' => 'Amigos',
            'trabalho' => 'Trabalho',
            'escola' => 'Escola',
        ];
    }

    public function create(): View
    {
        return view('contactos.create', [
            'localidades' => $this->localidadeOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $this->ensureContactoColumnsExist();

        Contacto::create($this->dataForDatabase($request, $validated));

        return redirect()
            ->route('contactos.index')
            ->with('success', 'Contacto criado com sucesso.');
    }

    public function show(Contacto $contacto): View
    {
        $contacto->load('localidadeRegisto');

        return view('contactos.show', compact('contacto'));
    }

    public function edit(Contacto $contacto): View
    {
        return view('contactos.edit', [
            'contacto' => $contacto,
            'localidades' => $this->localidadeOptions(),
        ]);
    }

    public function update(Request $request, Contacto $contacto): RedirectResponse
    {
        $validated = $request->validate($this->rules($contacto));

        $this->ensureContactoColumnsExist();

        $contacto->update($this->dataForDatabase($request, $validated, $contacto));

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
            'localidade_id' => ['required', 'integer', Rule::exists('localidades', 'id')->where('ativa', true)],
            'grupo' => ['nullable', 'string', Rule::in(['amigos', 'trabalho', 'escola'])],
            'foto_perfil' => ['nullable', 'image', 'max:2048'],
            'observacoes' => ['nullable', 'string'],
        ];
    }

    private function dataForDatabase(Request $request, array $validated, ?Contacto $contacto = null): array
    {
        $data = $validated;
        $data['observacoes'] = $validated['observacoes'] ?? '';
        $localidade = Localidade::findOrFail($validated['localidade_id']);
        $data['localidade'] = $localidade->localidade;

        if ($request->hasFile('foto_perfil') && $request->file('foto_perfil')->isValid()) {
            if ($contacto?->foto_perfil) {
                Storage::disk('public')->delete($contacto->foto_perfil);
            }

            $data['foto_perfil'] = $request->file('foto_perfil')->store('contactos', 'public');
        }

        if (Schema::hasColumn('contactos', 'tema')) {
            $data['tema'] = $localidade->localidade;
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

            if (Schema::hasTable('localidades') && ! Schema::hasColumn('contactos', 'localidade_id')) {
                $table->foreignId('localidade_id')
                    ->nullable()
                    ->constrained('localidades')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('contactos', 'observacoes')) {
                $table->text('observacoes')->nullable();
            }

            if (! Schema::hasColumn('contactos', 'tema')) {
                $table->string('tema')->nullable();
            }

            if (! Schema::hasColumn('contactos', 'grupo')) {
                $table->string('grupo')->nullable();
            }

            if (! Schema::hasColumn('contactos', 'foto_perfil')) {
                $table->string('foto_perfil')->nullable();
            }
        });
    }

    private function localidadeOptions(): Collection
    {
        if (! Schema::hasTable('localidades')) {
            return new Collection();
        }

        if (! Schema::hasColumn('localidades', 'localidade')) {
            return new Collection();
        }

        try {
            return Localidade::query()
                ->where('ativa', true)
                ->orderByRaw('LOWER(localidade) ASC')
                ->get();
        } catch (QueryException $exception) {
            return new Collection();
        }
    }
}
