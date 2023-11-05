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
        Schema::create('movies', function (Blueprint $table) {
                $table->id();
                $table->text('genres');
                $table->string('homepage');
                $table->text('keywords');
                $table->string('original_language');
                $table->string('original_title');
                $table->text('overview');
                $table->decimal('popularity', 10, 2);
                $table->text('production_companies');
                $table->text('production_countries');
                $table->date('release_date');
                $table->integer('revenue');
                $table->integer('runtime');
                $table->text('spoken_languages');
                $table->string('status');
                $table->string('tagline');
                $table->string('title');
                $table->decimal('vote_average', 3, 1);
                $table->integer('vote_count');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
