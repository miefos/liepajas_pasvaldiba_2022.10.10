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
        Schema::create('entity_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_entity_level_id')->nullable()->references('id')->on('entity_levels');
            $table->boolean('show_to_all')->default(false);
            $table->boolean('employee_level')->default(false);
            $table->boolean('show_to_descendants')->default(false);
            $table->boolean('show_to_direct_descendant')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_levels');
    }
};
