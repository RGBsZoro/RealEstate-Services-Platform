<?php

use App\Enum\StatusEnum;
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

            $table->foreignId('activity_id')->constrained();

            $table->string('license_number');
            $table->json('name');

            $table->text('activities');
            $table->text('details')->nullable();

            $table->foreignId('city_id')->constrained();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->string('status')->default(StatusEnum::PENDING->value);

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
