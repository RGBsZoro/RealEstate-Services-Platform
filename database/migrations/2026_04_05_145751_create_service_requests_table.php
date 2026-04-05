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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->foreignId('requester_business_account_id')->constrained('business_accounts')->cascadeOnDelete();

            $table->foreignId('service_id')->constrained()->cascadeOnDelete();

            $table->foreignId('provider_business_account_id')->constrained('business_accounts')->cascadeOnDelete();

            $table->dateTime('required_at');
            $table->integer('quantity');
            $table->text('details')->nullable();

            $table->decimal('price_usd_at_request', 15, 2)->nullable();
            $table->decimal('price_syp_at_request', 15, 2)->nullable();

            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
