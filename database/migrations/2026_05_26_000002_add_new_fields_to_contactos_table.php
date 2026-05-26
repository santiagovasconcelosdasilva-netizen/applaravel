<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
        });
    }

    public function down(): void
    {
        Schema::table('contactos', function (Blueprint $table) {
            if (Schema::hasColumn('contactos', 'alcunha')) {
                $table->dropColumn('alcunha');
            }

            if (Schema::hasColumn('contactos', 'localidade')) {
                $table->dropColumn('localidade');
            }

            if (Schema::hasColumn('contactos', 'observacoes')) {
                $table->dropColumn('observacoes');
            }
        });
    }
};
