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
        Schema::create('pix_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bank_account_id')->index();
            $table->string('kind');
            $table->string('key')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_account_id')
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
        Schema::dropIfExists('pix_keys');
    }
};
