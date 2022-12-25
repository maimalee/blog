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
        Schema::create('tags', function (Blueprint $table) {
            $table->bigInteger('tags_id')
                ->unsigned()
                ->autoIncrement();
            $table->foreignId('blog_owner')
                ->constrained('users', 'id')
                ->cascadeOnDelete();
            $table->foreignId('blog_id')
                ->constrained('blogs', 'id')
                ->cascadeOnDelete();

            $table->foreignId('tagged_friend')
                ->constrained('users', 'id')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('tags');
    }
};
