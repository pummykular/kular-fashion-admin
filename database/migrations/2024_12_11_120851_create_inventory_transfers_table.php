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
        Schema::create('inventory_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sent_from')->index();
            $table->unsignedBigInteger('sent_to')->index();
            $table->unsignedBigInteger('sent_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('sent_from')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('sent_to')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('sent_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transfers');
    }
};
