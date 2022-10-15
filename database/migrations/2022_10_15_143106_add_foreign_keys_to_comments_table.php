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
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign(['parent_id'], 'comments_comments_id_fk')->references(['id'])->on('comments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['article_id'], 'comments_articles_id_fk')->references(['id'])->on('articles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_comments_id_fk');
            $table->dropForeign('comments_articles_id_fk');
        });
    }
};
