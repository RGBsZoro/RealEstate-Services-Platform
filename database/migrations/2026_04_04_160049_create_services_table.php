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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_account_id')->constrained();

            $table->foreignId('category_id')->constrained();

            $table->string('title');
            $table->text('description');
            $table->integer('quantity')->nullable();
            $table->enum('type', ['sale', 'rent']);

            $table->decimal('price_syp', 15, 2);
            $table->decimal('price_usd', 15, 2);

            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

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
        Schema::dropIfExists('services');
    }
};
