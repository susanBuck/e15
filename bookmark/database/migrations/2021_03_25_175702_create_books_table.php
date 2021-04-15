<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->timestamps();

            // slug VARCHAR
            $table->string('slug');

            // title VARCHAR
            $table->string('title');

            // published_year SMALLINT
            $table->smallInteger('published_year');

            // cover_url VARCHAR
            $table->string('cover_url');

            // info_url VARCHAR
            $table->string('info_url');

            // purchase_url VARCHAR
            $table->string('purchase_url');

            // description TEXT
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}