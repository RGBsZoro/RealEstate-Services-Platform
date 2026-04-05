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
        Schema::create('business_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');

            $table->foreignId('activity_id')->nullable()->constrained();

            $table->string('license_number')->nullable();
            $table->json('name')->nullable();

            $table->text('activities')->nullable();
            $table->text('details')->nullable();

            $table->foreignId('city_id')->nullable()->constrained();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('status')->default('draft');

            $table->integer('current_step')->nullable()->default(1);
            $table->unique(['user_id', 'activity_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_accounts');
    }
};
