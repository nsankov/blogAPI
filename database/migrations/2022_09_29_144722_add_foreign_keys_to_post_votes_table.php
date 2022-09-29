<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPostVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_votes', function (Blueprint $table) {
            $table->foreign(['post_id'], 'post_votes_posts_id_fk')->references(['id'])->on('posts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'post_votes_users_id_fk')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_votes', function (Blueprint $table) {
            $table->dropForeign('post_votes_posts_id_fk');
            $table->dropForeign('post_votes_users_id_fk');
        });
    }
}
