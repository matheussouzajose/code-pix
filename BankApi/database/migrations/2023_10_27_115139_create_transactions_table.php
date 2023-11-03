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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('external_id');
            $table->uuid('bank_account_from_id')->index();
            $table->string('pix_key_key')->index();
            $table->string('pix_key_kind');
            $table->float('amount', 10, 2);
            $table->string('description');
            $table->string('status');
            $table->string('operation');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_account_from_id')
                ->references('id')
                ->on('bank_accounts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
