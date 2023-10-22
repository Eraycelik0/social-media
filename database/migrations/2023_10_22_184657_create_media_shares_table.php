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
        Schema::create('media_shares', function (Blueprint $table) {
            $table->id('media_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('media_type', ['Photo', 'Video']);
            $table->string('media_url');
            $table->dateTime('share_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_shares');
    }
};
