<?php

namespace Database\Seeders;

use App\Models\Localidade;
use Illuminate\Database\Seeder;

class LocalidadeSeeder extends Seeder
{
    public function run(): void
    {
        $localidades = [
            ['localidade' => 'Lisboa, Portugal'],
            ['localidade' => 'Brasilia, Brasil'],
            ['localidade' => 'Madrid, Espanha'],
            ['localidade' => 'Paris, Franca'],
            ['localidade' => 'Toquio, Japao'],
            ['localidade' => 'Cidade de Pallet, Kanto'],
            ['localidade' => 'Littleroot, Hoenn'],
            ['localidade' => 'Pendragon, Britania'],
            ['localidade' => 'Capital das Flores, Wano'],
            ['localidade' => 'Poseidonia, Atlantis'],
            ['localidade' => 'Aurora, Eldoria'],
            ['localidade' => 'Porto Lunar, Lunaris'],
        ];

        foreach ($localidades as $localidade) {
            Localidade::updateOrCreate(
                [
                    'localidade' => $localidade['localidade'],
                ],
                $localidade + ['ativa' => true],
            );
        }
    }
}
