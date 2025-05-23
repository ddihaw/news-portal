<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->integer('idMenu')->autoIncrement();
            $table->string('menuName');
            $table->enum('menuType', ['url', 'page']);
            $table->string('menuUrl');
            $table->string('menuTarget');
            $table->integer('menuOrder');
            $table->integer('menuParent')->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
