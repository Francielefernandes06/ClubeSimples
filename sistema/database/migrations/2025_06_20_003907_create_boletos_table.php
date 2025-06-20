<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mensalidade_id')->constrained()->onDelete('cascade');
            $table->string('numero_boleto')->unique();
            $table->string('arquivo_pdf')->nullable();
            $table->text('qr_code_pix')->nullable();
            $table->decimal('valor_total', 10, 2);
            $table->date('data_vencimento');
            $table->timestamp('enviado_em')->nullable();
            $table->integer('tentativas_envio')->default(0);
            $table->enum('status', ['pendente', 'enviado', 'pago', 'vencido'])->default('pendente');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletos');
    }
};
