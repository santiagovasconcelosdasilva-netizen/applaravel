<?php

use App\Models\Contacto;
use App\Models\Localidade;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function localidadeId(string $localidade): int
{
    return Localidade::create([
        'localidade' => $localidade,
        'ativa' => true,
    ])->id;
}

it('mostra os contactos por ordem alfabetica do nome', function () {
    Contacto::create([
        'nome' => 'Zeus',
        'telemovel' => '910000001',
        'email' => 'zeus@example.com',
        'localidade' => 'Porto',
        'observacoes' => 'Cliente',
    ]);

    Contacto::create([
        'nome' => 'Ana',
        'telemovel' => '910000002',
        'email' => 'ana@example.com',
        'localidade' => 'Lisboa',
        'observacoes' => 'Cliente',
    ]);

    Contacto::create([
        'nome' => 'santiago',
        'telemovel' => '910000003',
        'email' => 'santiago@example.com',
        'localidade' => 'Braga',
        'observacoes' => 'Cliente',
    ]);

    $this->get(route('contactos.index'))
        ->assertOk()
        ->assertSeeInOrder(['Ana', 'santiago', 'Zeus']);
});

it('permite pesquisar contactos pelo nome', function () {
    Contacto::create([
        'nome' => 'Ana Silva',
        'telemovel' => '910000001',
        'email' => 'ana@example.com',
        'localidade' => 'Lisboa',
        'observacoes' => 'Cliente',
    ]);

    Contacto::create([
        'nome' => 'Bruno Costa',
        'telemovel' => '910000002',
        'email' => 'bruno@example.com',
        'localidade' => 'Porto',
        'observacoes' => 'Cliente',
    ]);

    Contacto::create([
        'nome' => 'Carlos Andrade',
        'telemovel' => '910000003',
        'email' => 'carlos.andrade@example.com',
        'localidade' => 'Madrid',
        'observacoes' => 'Cliente',
    ]);

    $this->get(route('contactos.index', ['pesquisa' => 'A']))
        ->assertOk()
        ->assertSee('Ana Silva')
        ->assertDontSee('Bruno Costa')
        ->assertDontSee('Carlos Andrade');
});

it('nao deixa criar dois contactos com o mesmo email', function () {
    Contacto::create([
        'nome' => 'Ana',
        'telemovel' => '910000001',
        'email' => 'ana@example.com',
        'localidade' => 'Lisboa',
        'observacoes' => 'Cliente',
    ]);

    $this->post(route('contactos.store'), [
        'nome' => 'Bruno',
        'alcunha' => null,
        'telemovel' => '910000002',
        'email' => 'ana@example.com',
        'localidade_id' => localidadeId('Porto'),
        'observacoes' => 'Cliente',
    ])
        ->assertSessionHasErrors('email');

    expect(Contacto::count())->toBe(1);
});

it('deixa atualizar um contacto mantendo o proprio email', function () {
    $contacto = Contacto::create([
        'nome' => 'Ana',
        'telemovel' => '910000001',
        'email' => 'ana@example.com',
        'localidade' => 'Lisboa',
        'observacoes' => 'Cliente',
    ]);

    $this->put(route('contactos.update', $contacto), [
        'nome' => 'Ana Silva',
        'alcunha' => null,
        'telemovel' => '910000001',
        'email' => 'ana@example.com',
        'localidade_id' => localidadeId('Lisboa'),
        'observacoes' => 'Cliente regular',
    ])
        ->assertRedirect(route('contactos.index'))
        ->assertSessionHasNoErrors();

    expect($contacto->fresh()->nome)->toBe('Ana Silva');
});

it('deixa criar um contacto sem observacoes', function () {
    $this->post(route('contactos.store'), [
        'nome' => 'Carlos',
        'alcunha' => null,
        'telemovel' => '910000003',
        'email' => 'carlos@example.com',
        'localidade_id' => localidadeId('Coimbra'),
        'observacoes' => null,
    ])
        ->assertRedirect(route('contactos.index'))
        ->assertSessionHasNoErrors();

    expect(Contacto::where('email', 'carlos@example.com')->exists())->toBeTrue();
});
