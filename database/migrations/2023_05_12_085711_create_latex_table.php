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
        //if (!Schema::hasTable('latex')) {
        Schema::create('latex', function (Blueprint $table) {
            $table->bigInteger('id', 10)->unsigned()->autoIncrement();
            $table->string('name', 20)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('');
            $table->string('section', 20)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('');
            $table->string('task', 200)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('');
            $table->string('equation', 100)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('');
            $table->string('eq_text', 200)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('');
            $table->string('solution', 200)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('');
            $table->string('eq_conditions', 100)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('');
            $table->string('image_name', 40)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('');
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->integer('points')->default(5);

            $table->timestamps();
        });
        //}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('latex');
    }
};
