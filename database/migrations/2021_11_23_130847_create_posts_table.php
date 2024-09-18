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
        Schema::create('posts', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('category_id')->nullable();
                $table->string('title');
                $table->string('slug')->unique()->index();

                $table->string('short_description')->nullable();
                $table->text('body')->nullable();

                $table->double('likes')->default(0);

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
        Schema::dropIfExists('posts');
    }
};
