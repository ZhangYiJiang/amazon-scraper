<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('url');
            $table->string('asin')->unique();
            $table->string('cover_url', 512)->nullable();
            $table->string('isbn', 13)->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->decimal('rating', 1, 1)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
