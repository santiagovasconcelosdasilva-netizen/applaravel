<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contactos')) {
            return;
        }

        Schema::table('contactos', function (Blueprint $table) {
            if (! Schema::hasColumn('contactos', 'localidade_id')) {
                $table->foreignId('localidade_id')
                    ->nullable()
                    ->constrained('localidades')
                    ->nullOnDelete();
            }
        });

        if (! Schema::hasTable('localidades') || ! Schema::hasColumn('contactos', 'localidade')) {
            return;
        }

        DB::table('contactos')
            ->whereNull('localidade_id')
            ->whereNotNull('localidade')
            ->orderBy('id')
            ->get()
            ->each(function (object $contacto): void {
                $localidadeId = DB::table('localidades')
                    ->where('localidade', $contacto->localidade)
                    ->value('id');

                if ($localidadeId !== null) {
                    DB::table('contactos')
                        ->where('id', $contacto->id)
                        ->update(['localidade_id' => $localidadeId]);
                }
            });
    }

    public function down(): void
    {
        if (! Schema::hasTable('contactos') || ! Schema::hasColumn('contactos', 'localidade_id')) {
            return;
        }

        Schema::table('contactos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('localidade_id');
        });
    }
};
