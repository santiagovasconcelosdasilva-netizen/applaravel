<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LocalidadeSeeder extends Seeder
{
    public function run(): void
    {
        $localidades = [
            ['localidade' => 'Lisboa, Portugal'],
            ['localidade' => 'Porto, Portugal'],
            ['localidade' => 'Brasília, Brasil'],
            ['localidade' => 'Madrid, Espanha'],
            ['localidade' => 'Paris, França'],
            ['localidade' => 'Londres, Inglaterra'],
            ['localidade' => 'Roma, Itália'],
            ['localidade' => 'Berlim, Alemanha'],
            ['localidade' => 'Luanda, Angola'],
            ['localidade' => 'Tokyo, Japão'],
        ];

        $columns = collect(Schema::getColumnListing('localidades'));
        $nomes = collect($localidades)->pluck('localidade')->all();

        DB::table('localidades')
            ->whereNull('localidade')
            ->orWhere('localidade', '')
            ->update(['ativa' => false]);

        DB::table('localidades')
            ->whereNotIn('localidade', $nomes)
            ->update(['ativa' => false]);

        foreach ($localidades as $localidade) {
            [$nome, $distrito] = array_pad(explode(', ', $localidade['localidade'], 2), 2, null);

            $values = [
                'localidade' => $localidade['localidade'],
                'ativa' => true,
                'updated_at' => now(),
            ];

            if ($columns->contains('nome')) {
                $values['nome'] = $nome;
            }

            if ($columns->contains('concelho')) {
                $values['concelho'] = $nome;
            }

            if ($columns->contains('distrito')) {
                $values['distrito'] = $distrito;
            }

            if ($columns->contains('created_at')) {
                $values['created_at'] = now();
            }

            DB::table('localidades')->updateOrInsert(
                ['localidade' => $localidade['localidade']],
                $values,
            );
        }
    }
}
