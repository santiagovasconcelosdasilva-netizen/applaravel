<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('localidades')) {
            return;
        }

        Schema::table('localidades', function (Blueprint $table) {
            if (! Schema::hasColumn('localidades', 'localidade')) {
                $table->string('localidade')->nullable();
            }
        });

        if (Schema::hasColumn('localidades', 'cidade') && Schema::hasColumn('localidades', 'pais')) {
            DB::table('localidades')
                ->whereNull('localidade')
                ->orderBy('id')
                ->get()
                ->each(function (object $localidade): void {
                    DB::table('localidades')
                        ->where('id', $localidade->id)
                        ->update([
                            'localidade' => trim($localidade->cidade . ', ' . $localidade->pais),
                        ]);
                });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('localidades') || ! Schema::hasColumn('localidades', 'localidade')) {
            return;
        }

        Schema::table('localidades', function (Blueprint $table) {
            $table->dropColumn('localidade');
        });
    }
};
