<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->constrained('veiculos')->cascadeOnDelete();
            $table->string('cliente');
            $table->date('data_retirada');
            $table->date('data_devolucao');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locacoes');
    }
};
