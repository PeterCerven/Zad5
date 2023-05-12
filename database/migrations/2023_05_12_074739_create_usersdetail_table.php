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
        Schema::create('usersdetail', function (Blueprint $table) {
            //$table->id();
            $table->bigInteger('id', 10)->unsigned()->autoIncrement();
            $table->unsignedBigInteger('user_id'); // definujeme cudzí kľúč
            $table->string('position', 1)->charset('utf8mb4')->collation('utf8mb4_slovak_ci')->default('3');  // position 1-teacher, 2-student, 3-other
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usersdetail');
    }
};
