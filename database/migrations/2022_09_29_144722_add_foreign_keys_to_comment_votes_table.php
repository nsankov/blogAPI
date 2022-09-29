<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCommentVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment_votes', function (Blueprint $table) {
            $table->foreign(['comment_id'], 'comment_votes_comment_id_fk')->references(['id'])->on('comments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'comment_votes_user_id_fk')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment_votes', function (Blueprint $table) {
            $table->dropForeign('comment_votes_comment_id_fk');
            $table->dropForeign('comment_votes_user_id_fk');
        });
    }
}
