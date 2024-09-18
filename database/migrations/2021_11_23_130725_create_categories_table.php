<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();

                $table->string('name');
                $table->string('slug')->unique()->index();
                $table->text('description')->nullable();

                $table->boolean('is_active')->default(1)->nullable();
                $table->boolean('show_in_menu')->default(0)->nullable();

                $table->timestamps();

                $table->softDeletes();
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
