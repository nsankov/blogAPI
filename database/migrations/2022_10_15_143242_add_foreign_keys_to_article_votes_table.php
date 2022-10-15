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
        Schema::table('article_votes', function (Blueprint $table) {
            $table->foreign(['article_id'], 'article_votes_articles_id_fk')->references(['id'])->on('articles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'article_votes_users_id_fk')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_votes', function (Blueprint $table) {
            $table->dropForeign('article_votes_articles_id_fk');
            $table->dropForeign('article_votes_users_id_fk');
        });
    }
};
