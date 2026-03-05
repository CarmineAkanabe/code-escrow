<?php

use App\Models\Freelancer;
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
        Schema::create('gigs', function (Blueprint $table) {
            $table->id();
            // A more modern approach which automatically creates 'developer_id' in freelancer model while referencing it
            $table->foreignIdFor(Freelancer::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->decimal('budget_usd', 10, 2);
            $table->string('status');   // 'open', 'in_progress', 'completed'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gigs');
    }
};
