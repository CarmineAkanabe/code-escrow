<?php

use App\Models\Gig;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Gig::class)->constrained()->cascadeOnDelete();
            $table->decimal('amount_usd', 10, 2);
            $table->decimal('payout_xaf', 14, 2)->nullable(true);
            $table->string('gateway_reference')->nullable(true);
            $table->string('status');   // 'held' or 'released'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
