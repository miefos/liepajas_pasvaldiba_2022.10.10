<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_entity_id')->nullable()->references('id')->on('entities');
            $table->foreignId('entity_level_id')->references('id')->on('entity_levels');
            $table->foreignId('supervisor_id')->references('id')->on('users');
            $table->boolean('is_root_node')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entities');
    }
};
