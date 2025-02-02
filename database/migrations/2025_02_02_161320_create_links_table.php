<?php

use App\Models\Domain;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->ulid('id');
            $table->string('key')->unique()->index();
            $table->string('url');
            $table->string('link');
            $table->integer('clicks')->default(0);
            $table->string('password')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_clicked_at')->nullable();

            $table->foreignIdFor(Domain::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
