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
        Schema::create('recommendation_data', function (Blueprint $table) {
            $table->id('recommendation_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('interest_id');
            $table->string('content_type');
            $table->unsignedBigInteger('content_id');
            $table->dateTime('recommendation_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation_data');
    }
};
